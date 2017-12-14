<?php

namespace Admin\Controller;

use Admin\Common\AdminController;

class RoleController extends AdminController
{
    //列表展示
    public function showlist()
    {
        //获得角色列表信息
        $info = D('Role')->getRoles();
        $this->assign('info', $info);
        $this->display();
    }

    //分配权限列表
    public function distribute()
    {
        $role = D('Role');
        if(IS_POST){
            //验证session中的id与post中的ID是否一致
            $role_dis_id = session('role_dis_id');
            if($role_dis_id ===$_POST['role_id']){
                //接收表单信息
                $z = $role->saveAuth($_POST['role_id'],$_POST['auth_id']);
                if($z){
                    $this->success('分配权限成功！',U('showlist'),2);
                }else{
                    $this->error('分配权限失败！',U('distribute',array('role_id'=>$_POST['role_id'])),2);
                }
            }else{
                $this->error('相关参数出现问题，请及时联系管理员',U('showlist'),2);
            }
        }else{
            //获取角色id,进一步获取该角色的所有详细信息
            $role_id = I('get.role_id');
            //防止用户篡改ID，先存入session中
            session('role_dis_id',$role_id);
            $roleinfo = D('Role')->find($role_id);
            $this->assign('roleinfo',$roleinfo);

            //获取所有可分配的权限信息，可以调用auth模型中的getAuths中的管理员权限分支
            $authinfo = D('Auth')->getAuths();//不传参代表超级管理员权限，可通过此获取所有权限列表
            $authinfoA = $authinfo['authinfoA'];
            $authinfoB = $authinfo['authinfoB'];
            //父级权限
            $this->assign('authinfoA',$authinfoA);
            //子级权限
            $this->assign('authinfoB',$authinfoB);

            $this->display();
        }

    }
}