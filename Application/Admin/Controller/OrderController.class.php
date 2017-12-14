<?php
namespace Admin\Controller;
use Admin\Common\AdminController;
class OrderController extends AdminController
{
    //订单列表显示
    function showlist(){
        //获得订单列表信息
        $infos = D('Order')->order('order_id desc')->select();
        $this->assign('infos',$infos);
        $this->display();
    }

    //订单详情信息
    function detail(){
        //获得订单信息
        $order_id = I('get.order_id');
        $orderinfo = D('Order')
            ->alias('o')
            ->join('__USER__ u on o.user_id=u.user_id')
            ->join('__CONSIGNEE__ c on o.cgn_id=c.cgn_id')
            ->field('o.*,u.username,c.*')
            ->find($order_id);
        //dump($orderinfo);die;
        $this->assign('orderInfo', $orderinfo);
        //dump($orderinfo);
        //获得订单关联的商品信息
        $goodsinfo = D('OrderGoods')
            ->alias('og')
            ->join('__GOODS__ g on og.goods_id=g.goods_id')
            ->field('og.*,g.goods_name')
            ->where(array('og.order_id' => $order_id))
            ->select();
        $this->assign('goodsinfo', $goodsinfo);

        //支付宝定义
        $this->assign('paymethods', array('0' => '支付宝', '1' => '微信', '2' => '银行卡'));

        $this->display();
    }

    //订单绑定
    public function packageNumber(){
        $package = I('post.package_id');
        $orderId = I('post.order_id');
        //取出快递类型
        preg_match_all('/[\x{4e00}-\x{9fa5}a-zA-Z]/u' , $package, $result);//匹配出韵,达
        $packageType =implode('', $result[0]);//eg:韵达3993821445004 此句执行后变为韵达
        // $res = ltrim($package, $packageType);//韵达3993821445004 此句执行后变为3993821445004
        // exit(json_encode(['res'=>$res]));
        //引入汉字转拼音类
        import("ORG.Util.Pinyin");
        $pinyin = new \PinYin();
        $packageTypePinyin =  $pinyin->getAllPY($packageType); //汉字转为拼音
        $uri='http://www.kuaidi100.com/query?type='.$packageTypePinyin.'&postid='.ltrim($package, $packageType);
        $backageInfo = request($uri);
        //exit(json_encode(['backageInfo'=>$backageInfo]));
        $backage=D('backage');
        $state = $backage->postBackageInfo($orderId,json_decode($backageInfo,true));
        if ($state){
            exit(json_encode(['state'=>200,'message'=>$backage->getError()]));
        }
        exit(json_encode(['state'=>202,'message'=>$backage->getError()]));

    }
}