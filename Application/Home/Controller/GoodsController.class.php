<?php
namespace Home\Controller;
use Think\Controller;
class GoodsController extends Controller {
    public function showlist(){
        //获取商品列表信息
        $goodsinfo = D('Goods')
            ->order('goods_id desc')
            ->field('goods_id,goods_name,goods_price,goods_small_logo')
            ->select();
        $this->assign('goodsinfo',$goodsinfo);
        $secgoodsId = D('Secbuy')->field('goods_id')->select();
        foreach($secgoodsId as $v){
            $secId = $v['goods_id'];
        }
        $this->assign('secId',$secId);
        $this->display();
    }

    public function detail(){
        $goods_id = I('get.goods_id');
        //生成的静态文件名  静态路径/静态文件
        $staticPage = HTML_PATH . '/details/'.$goods_id."_detail.html";
        $res = D('Goods')->where(array('goods_id'=>$goods_id))->field('cached,lastvisittime')->select();
        $cached = $res[0]['cached'];
        $lastTime = $res[0]['lastvisittime'];
        $now = time();
        $secgoodsId = D('Secbuy')->select();
        foreach($secgoodsId as $v){
            $secId = $v;
        }
        $secTime = $secId['end_buy_time']-time();
        //$secTime=$secTime/(24*60*60);
        $this->assign('secTime',$secTime);
        $this->assign('secId',$secId);
        if(!is_file($staticPage) && $cached=='0'){
            //查询基本商品信息
            $goodsinfo = D('Goods')->find($goods_id);

            $this->assign('goodsinfo',$goodsinfo);

            //获取商品的唯一属性(sp_goods_attr和sp_attribute联表)
            $onlyinfo = D('GoodsAttr')
                ->alias('ga')
                ->join('__ATTRIBUTE__ a on ga.attr_id = a.attr_id')
                ->where(array('ga.goods_id'=>$goods_id,'a.attr_sel'=>'only'))
                ->field('a.attr_id,a.attr_name,ga.attr_value')
                ->select();

            //获取商品的单选属性
            $manyinfo = D('GoodsAttr')
                ->alias('ga')
                ->join('__ATTRIBUTE__ a on ga.attr_id = a.attr_id')
                ->where(array('ga.goods_id'=>$goods_id,'a.attr_sel'=>'many'))
                ->field('a.attr_id,a.attr_name,group_concat(ga.attr_value) attr_values')
                ->group('a.attr_id')
                ->select();

            //对$manyinfo数组进行整理，以方便模板的使用
            foreach($manyinfo as $k=>$v){
                $manyinfo[$k]['values'] = explode(',',$v['attr_values']);//string->array
            }
            $this->assign('onlyinfo',$onlyinfo);
            $this->assign('manyinfo',$manyinfo);

            //获取商品的相册图片信息
            $picsinfo =D('GoodsPics')->where(array('goods_id'=>$goods_id))->select();
            $this->assign('picsinfo',$picsinfo);
            //获取会员价格
            $goodsPrice = D('Goods')->getMemberPrice($goods_id);
            $this->assign('goodsPrice',$goodsPrice);
            //生成静态文件
            $this->buildHtml($goods_id."_detail",HTML_PATH.'/details/','detail','utf8');
            $cached = D('Goods')->where(array('goods_id'=>$goods_id))->save(array('cached'=>'1'));
            $now = time();
            $timeres = D('Goods')->where(array('goods_id'=>$goods_id))->save(array('lastvisitTime'=>$now));
            if(!$cached || !$timeres){
                $this->error('网站正在维护中...','/Index/index');
            }
            $this->display();
            //如果已缓存并且数据未超过一天
        }elseif($cached=='1' && $now-$lastTime>86400){
            layout(false);
            $this->show($staticPage);
        }else{
            //将过期的缓存文件删除
            if(is_file($staticPage)){
                unlink($staticPage);
            }
            //查询基本商品信息
            $goodsinfo = D('Goods')->find($goods_id);

            $this->assign('goodsinfo',$goodsinfo);

            //获取商品的唯一属性(sp_goods_attr和sp_attribute联表)
            $onlyinfo = D('GoodsAttr')
                ->alias('ga')
                ->join('__ATTRIBUTE__ a on ga.attr_id = a.attr_id')
                ->where(array('ga.goods_id'=>$goods_id,'a.attr_sel'=>'only'))
                ->field('a.attr_id,a.attr_name,ga.attr_value')
                ->select();

            //获取商品的单选属性
            $manyinfo = D('GoodsAttr')
                ->alias('ga')
                ->join('__ATTRIBUTE__ a on ga.attr_id = a.attr_id')
                ->where(array('ga.goods_id'=>$goods_id,'a.attr_sel'=>'many'))
                ->field('a.attr_id,a.attr_name,group_concat(ga.attr_value) attr_values')
                ->group('a.attr_id')
                ->select();

            //对$manyinfo数组进行整理，以方便模板的使用
            foreach($manyinfo as $k=>$v){
                $manyinfo[$k]['values'] = explode(',',$v['attr_values']);//string->array
            }
            $this->assign('onlyinfo',$onlyinfo);
            $this->assign('manyinfo',$manyinfo);

            //获取商品的相册图片信息
            $picsinfo =D('GoodsPics')->where(array('goods_id'=>$goods_id))->select();
            $this->assign('picsinfo',$picsinfo);
            //获取会员价格
            $goodsPrice = D('Goods')->getMemberPrice($goods_id);
            $this->assign('goodsPrice',$goodsPrice);
            //生成静态文件
            $this->buildHtml($goods_id."_detail",HTML_PATH.'/details/','detail','utf8');
            $this->display();
        }
    }
}