<?php

namespace Admin\Controller;

use Admin\Common\AdminController;

class AuthController extends AdminController
{
    function showlist()
    {
        //获取权限信息
        $info = D('Auth')->select();
        //对$info进行递归分排序处理
        $info = \generateTree($info);
//        dump($info);die;
        $this->assign('info', $info);
        $this->display();
    }

    public function tianjia()
    {
        $auth = D('Auth');
        if (IS_POST) {
            //收集信息
            $shuju = I('post.');
            //对auth_level进行特殊维护
            $shuju['auth_level'] = $shuju['auth_pid'] == '0' ? '0' : '1';
            if ($auth->add($shuju)) {
                $this->success('添加权限成功！', U('showlist'), 2);
            } else {
                $this->error('添加权限失败！', U('tianjia'), 2);
            }
        } else {
            //获取可供选择的上级权限，只获取顶级权限即可
            $authinfo = D('Auth')->where(array('auth_level' => '0'))->select();
            $this->assign('authinfo', $authinfo);
            $this->display();
        }
    }

    //权限删除
    public function delete()
    {
        $auth = D('Auth');
        //接受auth_id信息
        $auth_id = I('get.auth_id');
        $res = $auth->delete($auth_id);
        if ($res) {
            $this->success('删除成功！', U('showlist'), 2);
        } else {
            $this->error('删除失败！', U('showlist'), 2);
        }
    }

    //权限修改
    public function upd()
    {
        if (IS_POST) {
            if ($_POST['auth_id'] === session('auth_dis_id')) {
                $shuju = I('post.');
                $res = D('Auth')->save($shuju);
                if($res){
                    $this->success('修改成功！',U('showlist'),2);
                }else{
                    $this->error('修改失败！',U('upd',array('auth_id'=>$shuju['auth_id'])),2);
                }
            }else{
                $this->error('参数出现错误！请联系管理员',U('showlist'),2);
            }
        } else {
            $auth_id = I('get.auth_id');
            //保存auth_id值，防止恶意篡改
            session('auth_dis_id', $auth_id);
            $authinfo = D('Auth')->find($auth_id);
            $authinfos = D('Auth')->where(array('auth_level' => '0'))->select();
            $this->assign('authinfo', $authinfo);
            $this->assign('authinfos', $authinfos);
            $this->display();
        }

    }
}