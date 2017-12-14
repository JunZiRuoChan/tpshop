<?php
namespace Home\Controller;
use Think\Controller;
class OrderController extends Controller{
    //订单列表页
    public function orderList(){
        if(empty(session('user_id'))){
            session('callBack','Order/showlist');
            $this->redirect('User/login');
        }
        $order = D('Order');
        $user_id = session('user_id');
        $showlistInfo = $order->getOrderInfo($user_id);
        $this->assign('showlistInfo',$showlistInfo);
        $this->display();
    }
    //订单详情页
    public function OrderDetail($order_id){
       $orderData =  D('order')->getorderDeatil($order_id);
       foreach($orderData['detail'] as $k => $v){
            $orderData['detail'][$k]['goods_small_logo'] = ltrim($v['goods_small_logo'],'.');
       }
       $this->assign('orderData',$orderData);
       $this->assign('order_goods_number',$orderData["order_goods_number"]);
       $this->assign('backageInfo',$orderData['backage']);
       $this->display();

    }
}