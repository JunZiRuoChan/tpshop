<?php

namespace Admin\Model;

use Think\Model;

class GoodsModel extends Model
{
    public function getGoods($num)
    {
        //获取总记录数
        $count = $this->count();
        $page = new \Think\Page($count, $num);
        //输出分页排版
        $show = $page->show();
        //设置分页栏每页显示的页数
//        $page->setConfig('rollPage ',10);
        //获取每页的数据
        $list = $this->order('upd_time desc')->limit($page->firstRow . "," . $page->listRows)->select();
        return ['page' => $page, 'list' => $list, 'show' => $show];
    }

    //获取，所有与指定商品id有关的图片信息
    public function getAllPicsById($goods_id)
    {
//        $pics = $this->alias('g')->field('g.goods_id,g.goods_big_logo,g.goods_small_logo,gs.pics_big,gs.pics_mid,gs.pics_sma')->join('RIGHT JOIN __GOODS_PICS__ as gs on g.goods_id = gs.goods_id')->where(array('g.goods_id'=>$goods_id))->select();
        $logo = $this->field('goods_big_logo,goods_small_logo')->where(array('goods_id'=>$goods_id))->select();
        dump($logo[0]);
        $pics = D('goods_pics')->field('pics_big,pics_mid,pics_sma')->where(array('goods_id'=>$goods_id))->select();
        dump($pics);
        return $pics[0];
    }

    //调用添加后置钩子函数
    public function _after_insert($data,$options){
        //获取到会员价格数组
        $memberInfo = I('post.member_price');
        if($memberInfo){
            //实例化会员价格模型
            $mpModel = M('memberPrice');
            //循环将会员价格写入会员表中
            foreach($memberInfo as $k => $v){
                $price = (float)$v;
                if($price==0){
                    continue;
                    $mpModel->add(array(
                        'goods_id'  => $data['goods_id'],
                        'price'     => $v,
                        'level_id'  => $k
                    ));
                }
            }
        }
    }
}
