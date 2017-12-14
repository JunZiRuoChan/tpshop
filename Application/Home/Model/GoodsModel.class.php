<?php
namespace Home\Model;
use Think\Model;
class GoodsModel extends Model{
    function getMemberPrice($id){
        //先取出基本价格和促销价格
        $price = $this->field('goods_price,goods_member_price')->find($id);
        //判断用户是否已经登录
        $id = session('user_id');
        if($id){
            //计算会员价格
            //从用户表中取出积分值
            $credit = D('User')->field('jifen')->find($id);
            //再通过member_level查询折扣信息
            $memberLev = D('memberLevel')
            ->field('id,level_rate')
            ->where(array('jifen_bottom'=>array('elt',$credit['jifen']),'jifen_top'=>array('egt',$credit['jifen'])))
            ->find();
            //再通过member_price查询是否为该会员设置了会员价格
            $memberPri = D('memberPrice');
            $memberPrice = $memberPri->field('price')->where(array('goods_id'=>array('eq',$id),'level_id'=>array('eq',$memberLev['id'])))->find();
            if($memberPrice){
                //如果设置了会员价格，则直接使用这个价格展示
                $mprice = $memberPrice['price'];
            }else{
                //使用折扣率
                $mprice = $price['goods_price']*$memberLev['level_rate']/100;
            }
            return $mprice;
        }else{
            //未登录显示促销价
            return $price['goods_member_price'];
        }
    }
}
