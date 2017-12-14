<?php

namespace Admin\Model;

class UserModel extends BaseModel
{
    /**返回多条数据
     * @param row 每页显示条数
     * @return mixed
     * author Fox
     */
    public function getAllData($param = [])
    {

        $count = $this->count();// 查询满足要求的总记录数
        $Page = new \Think\Page($count, 15);// 实例化分页类 传入总记录数和每页显示的记录数(25)
        $show = $Page->show();// 分页显示输出
// 进行分页数据查询 注意limit方法的参数要使用Page类的属性
        $list = $this->order('user_id DESC')->limit($Page->firstRow . ',' . $Page->listRows)->select();
        foreach ($list as $k => $v) {
            if ($v['user_status'] == 0) {
                $list[$k]['user_status'] = '删除';
            } elseif ($v['user_status'] == 1) {
                $list[$k]['user_status'] = '正常';
            } elseif ($v['user_status'] == 2) {
                $list[$k]['user_status'] = '冻结';
            } else {
                $list[$k]['user_status'] = '永久冻结';
            }
        }

        return ['list' => $list, 'page' => $show];
    }

    /**
     * 用户冻结
     * author Fox
     */
    public function userBlocked(array $param)
    {
        if ($param['time'] == 'long') {
            $blackedState = $this->where(['user_id' => $param['user_id']])->save(['user_status' => 3]);
            if ($blackedState) {
                return json_encode(['state' => 200, 'message' => '冻结成功']);
            }
        } else {
            $user = parent::getOneData($param['user_id']);
            //如果之前处于冻结状态,加上新的冻结时间
            if ($user['user_status'] == 2) {
                //在原来的基础上冻结时间再加整数天倍
                $user['frozen_time'] = $user['frozen_time'] + (86400 * $param['time']);
            } else {
                //以前没有被冻结过，在当前时间戳的基础上在一天的时间戳
                $user['frozen_time'] = time() + 86400 * $param['time'];
            }
            //保存冻结数据到数据库
            $blackedState = $this->where(['user_id' => $param['user_id']])->save(['user_status' => 2, 'frozen_time' => $user['frozen_time']]);
            if ($blackedState) {
                return json_encode(['state' => 200, 'message' => '冻结成功']);
            } else {
                return json_encode(['state' => 202, 'message' => '冻结失败']);
            }

        }

    }

    //解冻
    public function unblocked($user_id)
    {
        $info=array(
          'user_id'=>$user_id,
          'user_status'=>'1',
          'frozen_time'=>'',
        );
        return $this->save($info);
    }


}