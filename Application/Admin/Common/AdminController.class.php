<?php

namespace Admin\Common;

use Think\Controller;

class AdminController extends Controller
{
    //构造方法
    function __construct()
    {
        parent::__construct();//避免覆盖父类构造方法.先执行
//        echo 'I see you!';
        //控制管理员越权访问
        //缓存初始化
        //S(array('type'=>'redis','host'=>'localhost','port'=>'6379'));
        $admin_id = session('admin_id');
        $admin_name = session('admin_name');
        //当前访问的控制器-操作方法
        //CONTROLLER_NAME当前控制器的名称
        //ACTION_NAME当前操作的名称
        $nowAC = CONTROLLER_NAME . '-' . ACTION_NAME;

        //判断用户是否有登录系统
        if (empty($admin_name)) {
            //没有登录系统
            $allow_auth = "Manager-login,Manager-verifyImg,Manager-logout";
            if (stripos($allow_auth, $nowAC) === false) {
                //使用js的方式跳转，防止只有一部分页面跳转
                $js = <<<eof
            <script>
            window.top.location.href="/index.php/Admin/Manager/login";
</script>
eof;
            echo $js;
            }
        }else{
            //获取当前管理员的角色的权限信息
            $have_auth = D('Manager')->getAuthinfos($admin_id)['role_auth_ac'];
            //系统默认允许访问的权限，无需分配的
            $allow_auth = "Manager-login,Manager-logout,Manager-verifyImg,Index-index,Index-left,Index-center,Index-top,Index-down,Index-right";
            //检查当前访问的权限是否在默认允许的操作中
            if (stripos($have_auth, $nowAC) === false && stripos($allow_auth, $nowAC) === false && $admin_name !== 'admin') {
                $this->error('没有权限访问', U('Admin/Index/index'), 2);
                die;
            }
        }

    }
}