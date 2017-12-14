<?php

namespace Admin\Controller;

use Admin\Common\AdminController;

class TypeController extends AdminController
{
    //列表展示
    public function showlist()
    {
        //获取类型列表信息
        $info = D('Type')->select();
        $this->assign('info',$info);

        $this->display();
    }
    //商品类型添加
    public function tianjia()
    {
       if(IS_POST){
           $type = D('Type');
           //接受数据
           $shuju = I('post.');
           if($type->add($shuju)){
               $this->success("添加类型：".$shuju['type_name']."&nbsp;成功！",U('showlist'),2);
           }else{
               $this->error('添加类型失败！',U('showlist'),2);
           }
       }else{
           $this->display();
       }

    }
    //属性修改
    public function upd()
    {
        $this->display();
    }
    //删除商品属性
    public function del()
    {
        $this->display();
    }
}