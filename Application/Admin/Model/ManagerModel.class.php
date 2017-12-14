<?php

namespace Admin\Model;

use Think\Model;

class ManagerModel extends Model
{
    public function getDataByName($name)
    {
        $info = $this->where(array('mg_name' => $name))->find();
        return $info;
    }

    //使用联表查询查询管理员role_auth_ids以及role_auth_ac的信息
    public function getAuthinfos($admin_id)
    {
        $roleinfo = $this->alias('m')
        ->join('__ROLE__ as r on m.role_id=r.role_id')
        ->where(array('m.mg_id' => $admin_id))
        ->field('r.role_auth_ids,r.role_auth_ac')
        ->find();
        //获取用户菜单显示权限id
//        $authids = $roleinfo['role_auth_ids'];//为'111,111,111'之类的字符串
        return $roleinfo;
    }
}
