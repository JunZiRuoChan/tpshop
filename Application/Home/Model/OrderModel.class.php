<?php
/**
 * @Author: Marte
 * @Date:   2017-07-15 19:29:00
 * @Last Modified by:   Marte
 * @Last Modified time: 2017-07-16 01:18:12
 */
namespace Home\Model;
use Think\Model;
class OrderModel extends Model{
    public function getOrderInfo($userId){
        $orderInfo = $this
        ->field('order_id,order_number,add_time,order_pay,order_price,order_status')
        ->where(array('user_id'=>$userId))
        ->select();
        foreach ($orderInfo as $k => $val){
            //订单状态
            if ($val['order_status']=='0'){
                $orderInfo[$k]['order_status']='未付款';
                unset($orderInfo[$k]['order_pay']);
            }else if($val['order_status']=='1') {
                $orderInfo[$k]['order_status']='已付款';
                //支付方式
                if ($val['order_pay']=='0'){
                    $orderInfo[$k]['order_pay']='支付宝';
                }else if($val['order_pay']=='1') {
                    $orderInfo[$k]['order_pay']='微信';
                }else if ($val['order_pay']=='2'){
                    $orderInfo[$k]['order_pay']='银联';
                }
            }else if ($val['order_status']=='2'){
                $orderInfo[$k]['order_status']='已取消';
                unset($orderInfo[$k]['order_pay']);
            }
            $orderInfo[$k]['orderDetails']=$orderDetails[$val['order_id']];
        }
        return $orderInfo;
    }
    public function  getorderDeatil($order_id){
          $orderData=[];
            //查看快递信息
          $backage = M('backage')->where(['order_id'=>$order_id])
           ->find();
          if ($backage){
              $orderData['backage']['backageInfo']=  explode('#', str_replace('++','&nbsp;&nbsp;',$backage['backage_state']));
          }
          //获取订单信息
          $orderData['order'] =  $this->where(['order_id'=>$order_id])
            ->find();
        //订单状态
        if ($orderData['order']['order_status']=='0'){
            $orderData['order']['order_status']='未付款';
            unset($orderData['order']['order_pay']);
        }else if($orderData['order']['order_status']=='1') {
            $orderData['order']['order_status']='已付款';
            //支付方式
            if ($orderData['order']['order_pay']=='0'){
                $orderData['order']['order_pay']='支付宝';
            }else if($orderData['order']['order_pay']=='1') {
                $orderData['order']['order_pay']='微信';
            }else if ($orderData['order']['order_pay']=='2'){
                $orderData['order']['order_pay']='银联';
            }
        }else if ($orderData['order']['order_status']=='2'){
            $orderData['order']['order_status']='已取消';
            unset($orderData['order']['order_pay']);
        }
            //商品详情
          $orderData['detail'] =M('orderGoods')
            ->alias('og')
            ->where(["og.order_id"=>$order_id])
            ->join('sp_goods as goods on og.goods_id = goods.goods_id')
            ->select();
            $order_goods_number = M('orderGoods')
            ->field('goods_number')
            ->where(array('order_id'=>$order_id))
            ->find();
            $orderData['order_goods_number']=$order_goods_number['goods_number'];
        $orderData['memberPrice'] =  D('goods')->getMemberPrice($orderData['detail'][0]['goods_id']);
         return $orderData;


    }
}
