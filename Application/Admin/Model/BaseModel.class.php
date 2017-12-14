<?php
namespace Admin\Model;
use Think\Model;
class  BaseModel extends  Model{
    //获取一条数据公共方法
    protected function getOneData($param){
        if (!is_array($param)){
            return $this->find($param);
        }else{
            return $this->where($param)->find();
        }

    }
}




