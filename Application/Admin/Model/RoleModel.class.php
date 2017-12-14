<?php

namespace Admin\Model;

use Think\Model;
class RoleModel extends Model
{
    /**
     * @param $num =5 每页显示条数，默认为5条
     */
    public function getRoles($num = 5)
    {
        $counts = $this->count();//获取用户总个数
        //实例化分页类
        $page = new \Think\Page($counts, $num);
        //组装分页链接
        $show = $page->show();
        //获取每页数据
        $list = $this->limit($page->firstRow . ',' . $page->listRows)->select();
        return array('show' => $show, 'page' => $page, 'list' => $list);
    }

    /**
     * 该方法用于给角色更新权限
     * @param $role_id 角色id
     * @param $auth_id 权限id
     * @return mixed bool false 或者受影响的行数
     */
    public function saveAuth($role_id, $auth_id)
    {
        //制作auth_ids信息
        $auth_ids = implode(',', $auth_id);//arrray->string
        //根据auth表，维护role_auth_ac信息
        //查询出的为$auth_ids类的auth表权限信息（数组）
        $authinfo = D('Auth')->where(array('auth_level' => array('gt', '0'), 'auth_id' => array('in', $auth_ids)))->select();
        //遍历所有非顶级权限信息，组装成auth_ac信息
        $s =array();
        foreach ($authinfo as $v){
            $s[] = $v['auth_c'].'-'.$v['auth_a'];
        }
        $ac = implode(',',$s);//array->string
        //对照role表组建数组
        $arr = array(
          'role_id'=>$role_id,//自动将主键id作为where条件
          'role_auth_ids'=>$auth_ids,
          'role_auth_ac'=>$ac,
        );
        return $this->save($arr);
    }
}