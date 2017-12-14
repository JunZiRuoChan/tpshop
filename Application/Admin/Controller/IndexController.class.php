<?php

namespace Admin\Controller;

use Admin\Common\AdminController;
class IndexController extends AdminController
{
    public function index()
    {
        C('SHOW_PAGE_TRACE', false);
        $this->display();
    }

    public function left()
    {
        C('SHOW_PAGE_TRACE', false);
        //获取当前管理员的session会话信息
        $admin_name = session('admin_name');
        $admin_id = session('admin_id');

        //首先，排除用户为超级管理员admin的情况
        if($admin_name!=='admin'){
            //1、代表当前用户为不同管理员
            //2、调用Manager中的getAuthIds方法联表sp_manager和sp_role表，查询出sp_role中的role_auth_ids信息
            $authids = D('Manager')->getAuthinfos($admin_id)['role_auth_ids'];
            //调用Auth模型中的getAuths方法
            $authinfo = D('Auth')->getAuths($authids);
        }else{
            //超级管理员权限信息
            $authinfo = D('Auth')->getAuths();
        }
        $authinfoA =$authinfo['authinfoA'];
        $authinfoB =$authinfo['authinfoB'];
        //分配模板变量
        $this->assign('authinfoA',$authinfoA);
        $this->assign('authinfoB',$authinfoB);
        $this->display();
    }

    public function right()
    {
        $this->display();
    }

    public function center()
    {
        C('SHOW_PAGE_TRACE', false);
        $this->display();
    }

    public function top()
    {
        C('SHOW_PAGE_TRACE', false);
        $this->display();
    }

    public function down()
    {
        C('SHOW_PAGE_TRACE', false);
        $this->display();
    }
}