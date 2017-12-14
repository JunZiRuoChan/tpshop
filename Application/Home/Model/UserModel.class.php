<?php

namespace Home\Model;

use Think\Model;
class UserModel extends Model
{
    //开启批处理验证
    protected $patchValidate = true;
    //自定义验证规则
    protected $_validate=array(
        array('username','require','用户名不能为空',1),
        array('username','','用户名已经注册',1,'unique',1),
        array('username','checkUser','用户名必须为字母数字和下划线或汉字的组合',1,'callback'),
        array('password','require','密码不能为空！',1),
        array('password2','require','确认密码必须填写！',1),
        array('password2','password','两次密码输入必须一致！',1,'confirm')
    );

    function checkUser($username){
        $preg = "/^(\d{3,20}|.*[%\*\+=]+)$/";
        if(preg_match($preg,$username)){
            return false;
        }else{
            return true;
        }
    }
    public function  getOneData($param){
        if (is_array($param)){
            return $this->where($param)->find();
        }
        return $this->find($param);
    }
    public function getUserByName($name){
        $userinfo = $this->field('password,user_id,user_status,frozen_time,is_active')->where(array('username'=>$name))->select();
        return $userinfo;
    }
}