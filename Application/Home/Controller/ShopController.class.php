<?php
//购物车功能模块实现：
//(添加)
//1、当点击加入购物车时，定义一个函数并传入当前商品ID
//2、Ajax实现无刷新展示商品价格等信息
//3、在控制器中通过商品ID从数据库中获得相关商品的商品信息，实例化cart类并存于cart类中
//4、通过cart类（购物车）获得商品数量和价格，并以特定的格式将数据返回给Ajax
namespace Home\Controller;

use Think\Controller;

/**
 * Class ShopController 超市控制器
 * @package Home\Controller
 */
class ShopController extends Controller
{
    public function addCart()
    {
        if (IS_AJAX) {
            $goods_id = I('get.goods_id');//被添加商品的goods_id
            $goods_num = I('get.goods_num');
            //获得相关商品信息
            $info = D('Goods')->find($goods_id);
            //获得会员商品价格
            $memberPrice = D('goods')->getMemberPrice($goods_id);
            $shuju['goods_id'] = $info['goods_id'];
            $shuju['goods_name'] = $info['goods_name'];
            $shuju['goods_price'] = $memberPrice;
            $shuju['goods_buy_number'] = $goods_num;
            $shuju['goods_total_price'] = ($memberPrice*$goods_num);
            //给购物车添加商品
            $cart = new \Home\Common\Cart();
            $cart->add($shuju);
            //把更新后的购物车商品数量和价格获取并返回给前端显示
            $number_price = $cart->getNumberPrice();
            echo json_encode($number_price);
        }
    }

    //购物车信息列表显示
    public function flow1()
    {
        //获取购物车商品信息
        $cart = new \Home\Common\Cart();
        $cartinfo = $cart->getCartInfo();
        //获得商品的图片信息（数据表字段：goods_small_logo）
        //获得购物车商品的goods_id信息，并拼装为字符串，用于SQL中查找数据
        $goods_ids = implode(',', array_keys($cartinfo));//array_keys获取数组下标值
        $logoinfo = D('Goods')
            ->field('goods_id,goods_small_logo')
            ->select($goods_ids);
//        dump($cartinfo);
//        dump($logoinfo);
        //整合，使得$logoinfo的图片信息添加进$cartinfo里边去
        foreach ($cartinfo as $k => $v) {
            foreach ($logoinfo as $vv) {
                if ($k == $vv['goods_id']) {
                    //把商品的logo图片信息添加进$cartinfo里边去
                    $cartinfo[$k]['logo'] = $vv['goods_small_logo'];
                }
            }
        }
//        dump($cartinfo);
        $this->assign('cartinfo', $cartinfo);
        //获得购物车商品的总数量和总价格
        $number_price = $cart->getNumberPrice();//array('number'=>???,'price'=>???);
        $this->assign('number_price', $number_price);
        $this->display();
    }

    //生成订单准备页面
    function flow2()
    {
        if (IS_POST) {
            //维护订单信息
            $cart = new \Home\Common\Cart();
            $number_price = $cart->getNumberPrice();
            $shuju = I('post.');
            $shuju['user_id'] = session('user_id');
            $shuju['order_number'] = 'itcast-shop-' . date('YmdHis') . '-' . mt_rand(1000, 9999);
            $shuju['order_price'] = $number_price['price'];
            $shuju['add_time'] = $shuju['upd_time'] = time();
            //形成订单记录
            $order_id = D('Order')->add($shuju);
            //维护订单关联的商品信息
            $cartinfo = $cart->getCartInfo();
            $shuju2 = array();
            foreach ($cartinfo as $k => $v) {
                $shuju2['order_id'] = $order_id;
                $shuju2['goods_id'] = $k;
                $shuju['goods_price'] = $v['goods_price'];
                $shuju2['goods_number'] = $v['goods_buy_number'];
                $shuju2['goods_total_price'] = $v['goods_total_price'];
                //给sp_order_goods表形成记录
                D('OrderGoods')->add($shuju2);
            }
            //购物车信息清除
            $cart->delAll();
            //echo "订单形成中、、、、";
            //跳转至完成订单页面flow3
            $WIDout_trade_no = $shuju['order_number'];
            $WIDsubject = $shuju['order_number'];
            $WIDtotal_fee = $number_price['price'];
            $fm = <<<eof
            <form action="/Application/Common/Plugin/alipay/alipayapi.php" method="post">
                <input type="hidden" name="WIDout_trade_no" value="$WIDout_trade_no" />
                <input type="hidden" name="WIDsubject" value="$WIDsubject" />
                <input type="hidden" name="WIDtotal_fee" value="$WIDtotal_fee" />
                <input type="hidden" name="WIDbody" value="" />
            </form>
            <script type="text/javascript">
                document.getElementsByTagName('form')[0].submit();
            </script>
eof;
            echo $fm;
        } else {
            $username = session('username');
            //判断用户是否有登录系统
            if (empty($username)) {
                //用户没有登录系统
                //定义回跳地址
                session('back_url', 'Shop/flow2');
                $this->redirect('User/login');
            }
            //获得购物车商品列表信息
            $cart = new \Home\Common\Cart();
            //获得购物车商品信息
            $cartinfo = $cart->getCartInfo();
            $goods_ids = implode(',', array_keys($cartinfo));
            $loginfo = D('Goods')->field('goods_id,goods_small_logo')->select($goods_ids);
            //整合，使得$loginfo的图片信息添加进$cartinfo里边去
            foreach ($cartinfo as $k => $v) {
                foreach ($loginfo as $vv) {
                    if ($k == $vv['goods_id']) {
                        $cartinfo[$k]['logo'] = $vv['goods_small_logo'];
                    }
                }
            }
            $this->assign('cartinfo', $cartinfo);
            //获得商品金额数量
            $number_price = $cart->getNumberPrice();
            $this->assign('number_price', $number_price);
            $this->display();
        }
    }

    public function changeNumber()
    {
        if (IS_AJAX) {
            //获得客户端传递过来的goods_id和num
            $goods_id = I('post.goods_id');
            $num = I('post.num');

            //使得购物车商品数量发生变化
            $cart = new \Home\Common\Cart();
            $xiaoji_price = $cart->changeNumber($num, $goods_id);
            //获得目前购物车商品总价格
            $number_price = $cart->getNumberPrice();
            echo json_encode(array('total_price' => $number_price['price'], 'xiaoji_price' => $xiaoji_price));
        }
    }

    //删除购物车里的商品
    public function delGoods()
    {
        $goods_id = I('get.goods_id');

        $cart = new \Home\Common\Cart();
        $cart->del($goods_id);

        //获取删除后的购物车的商品总金额
        $number_price = $cart->getNumberPrice();
        echo json_encode($number_price);
    }
}