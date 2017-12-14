<?php

namespace Home\Common;
/**
 * Class Cart 购物车类文件，用于处理购物车相关的操作
 * @package Home\Common
 */
class Cart
{
    //购物车的一个属性,用于存储商品信息
    private $cartInfo = array();

    public function __construct()
    {
        $this->loadData();
    }

    /**
     * 取得购物车里边已经存放的商品信息
     * 该方法是该类里边第一个被执行的方法
     * 在类的构造函数里调用
     */
    public function loadData()
    {
        if (isset($_COOKIE['cart'])) {
            //将序列化内容里边特殊字符转义的反斜线去掉
            $cart = str_replace('\\', '', $_COOKIE['cart']);
            //取得购物车里已经存放好的商品信息
            $this->cartInfo = unserialize($cart);
        }
    }

    /**
     * @param array $goods
     *array('goods_id'=>'商品id','goods_name'=>'名称',
     * 'goods_price'=>'单价','goods_buy_number'=>'购买数量','goods_total_price'=>数量*单价)
     */
    function add($goods)
    {
        $goods_id = $goods['goods_id'];
        //对重复购买的商品要判断（还要判断当前的购物车是否为空，既是否是第一次添加商品）
        if (!empty($this->cartInfo) && array_key_exists($goods_id, $this->cartInfo)) {
            //1、购买重复商品情况
            //商品数量增加
            $this->cartInfo[$goods_id]['goods_buy_number'] += 1;
            //商品价格增加
            $this->cartInfo[$goods_id]['goods_total_price'] = $this->cartInfo[$goods_id]['goods_price'] * $this->cartInfo[$goods_id]['goods_buy_number'];
        } else {
            //2、购买新商品
            $this->cartInfo[$goods_id] = $goods;//第一次购买时将$goods数组信息存入cartInfo中
        }
        //将刷新的数据重新存入cookie
        $this->saveData();
    }

    /**
     * 删除购物车里边指定的商品
     * @param $goods_id 被删除商品的ID信息
     */
    public function del($goods_id)
    {
        if (array_key_exists($goods_id, $this->cartInfo)) {
            unset($this->cartInfo[$goods_id]);
        }
        //将刷新的数据重新存入cookie中
        $this->saveData();
    }

    /**
     * 清空购物车
     */
    public function delAll()
    {
        unset($this->cartInfo);
        //将刷新的数据重新存入cookie
        $this->saveData();
        //如果购物车已经为空，则返回true
        if(empty($this->cartInfo)){
            return true;
        }
    }

    /**
     * 商品数量发生变化后需要执行的步骤
     * @param $goods_num 商品修改后的数量
     * @param $goods_id 被修改的商品id
     */
    public function changeNumber($goods_num, $goods_id)
    {
        //1、修改商品的数量
        $this->cartInfo[$goods_id]['goods_buy_number'] = $goods_num;
        //2、修改单间商品的小件价格
        $this->cartInfo[$goods_id]['goods_total_price'] = $goods_num * $this->cartInfo[$goods_id]['goods_price'];
        //将刷新的数据重新存入cookie中
        $this->saveData();
        //返回修改后商品的总价格
        return $this->cartInfo[$goods_id]['goods_total_price'];
    }

    /**
     * 用于获得购物车中的商品数量和总价格
     * @return mixed 返回的是包含商品总数量和总价格的数组
     */
    public function getNumberPrice()
    {
        $number = 0;//商品数量
        $price = 0;//商品价格
        foreach ($this->cartInfo as $_k => $_v) {
            $number +=$_v['goods_buy_number'];
            $price += $_v['goods_total_price'];
        }
        $arr['number'] = $number;
        $arr['price'] = $price;
        return $arr;
    }

    //供外界调用cartInfo信息
    function getCartInfo(){
        return $this->cartInfo;
    }

    public function saveData(){
        $data = serialize($this->cartInfo);
        setcookie('cart',$data,time()+3600,'/');
    }
}