<?php

namespace Admin\Controller;

use Admin\Common\AdminController;

class AttributeController extends AdminController
{
    //列表展示
    public function showlist()
    {
        //获取指定类型的所有属性
        $info = D('Attribute')
            ->alias('a')
            ->join('__TYPE__ t on a.type_id = t.type_id')
            ->field('a.*,t.type_name')
            ->select();
        $this->assign('info', $info);

        //获取所有下拉列表展示的‘商品类型’信息
        $typeinfo = D('type')->select();
        $this->assign('typeinfo', $typeinfo);
        $this->display();
    }

    //根据类型type_id获得对应的属性列表信息
    function getAttrInfoByType()
    {
        if (IS_AJAX) {
            $type_id = I('get.type_id');
            if ($type_id > 0) {
                $info = D('Attribute')->alias('a')
                    ->join('__TYPE__ t on a.type_id = t.type_id')
                    ->field('a.*,t.type_name')
                    ->where(array('a.type_id' => $type_id))
                    ->select();
            } else {
                $info = D('Attribute')
                    ->alias('a')
                    ->join('__TYPE__ t on a.type_id = t.type_id')
                    ->field('a.*,t.type_name')
                    ->select();
            }
            echo json_encode($info);
        }
    }

    //添加属性
    public function tianjia()
    {
        $Attribute = D('Attribute');
        if (IS_POST) {
//            $shuju = I('post.');
            $shuju = $Attribute->create();
            if ($shuju !== false) {
                //将可选值中的中文逗号，转换为英文逗号
                $shuju['attr_vals'] = str_replace('，', ',', $shuju['attr_vals']);
                if ($Attribute->add($shuju)) {
                    $this->success('添加类型属性成功！', U('showlist'), 2);
                } else {
                    $this->error('添加类型属性失败！', U('showlist'), 2);
                }
            } else {
                $this->assign('errorinfo', $Attribute->getError());
            }

        } else {
            $typeinfo = D('Type')->select();
            $this->assign('typeinfo', $typeinfo);
            $this->display();
        }
    }
}