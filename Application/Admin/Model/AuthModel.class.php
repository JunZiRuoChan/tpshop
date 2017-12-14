<?php

namespace Admin\Model;

use Think\Model;

class AuthModel extends Model
{
    /**
     * @param string $authids =‘0’ 用户权限id 表示超级管理员
     */
    public function getAuths($authids = 0)
    {
        //authinfoA顶级菜单，authinfoB次级菜单
        if ($authids != 0) {
            //普通管理员
            $authinfoA = $this->where(array('auth_level' => '0', 'auth_id' => array('in', $authids)))->select();
            $authinfoB = $this->where(array('auth_level' => '1', 'auth_id' => array('in', $authids)))->select();
        } else {
            //超级管理员
            $authinfoA = $this->where(array('auth_level' => '0'))->select();
            $authinfoB = $this->where(array('auth_level' => '1'))->select();
        }
        return array("authinfoA" => $authinfoA, "authinfoB" => $authinfoB);
    }
}