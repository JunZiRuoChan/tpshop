<?php

namespace Admin\Controller;

use Admin\Common\AdminController;

class ManagerController extends AdminController
{
    public function login()
    {
        if (IS_POST) {
            //验证码校验
            $code = I('post.manager_verify');//获取用户输入的验证码
            $vry = new \Think\Verify();
            if ($vry->check($code)) {
                $name = I('post.manager_name');
                $pwd = md5(I('post.manager_pwd'));
                //根据$name为条件去数据库查询
                $info = D('Manager')->getDataByName($name);
                if ($info) {
                    if ($info['mg_pwd'] != $pwd) {
                        $errorlogin = '密码输入错误！';
                    } else {
                        //持久化管理员信息
                        session('admin_id', $info['mg_id']);
                        session('admin_name', $info['mg_name']);
                        //成功跳转
                        $this->redirect('Index/index');
                    }
                } else {
                    $errorlogin = '用户名不存在！';
                }
            } else {
                $errorlogin = "验证码输入错误！";
            }
            $this->assign('errorlogin', $errorlogin);
        }
        $this->display();
    }

    //退出登录功能
    public function logout(){
        session(null);
        $this->redirect('Manager/login');
    }

    //生成验证码
    public function verifyImg()
    {
        $cfg = array(
            'fontSize' => 20,              // 验证码字体大小(px)
            'useCurve' => true,            // 是否画混淆曲线
            'useNoise' => true,            // 是否添加杂点
            'imageH' => 42,               // 验证码图片高度
            'imageW' => 150,               // 验证码图片宽度
            'length' => 4,               // 验证码位数
            'fontttf' => '4.ttf',
        );
        $vry = new \Think\Verify($cfg);
        $vry->entry();
    }
}