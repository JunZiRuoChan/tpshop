<?php
namespace Admin\Controller;
use Think\Controller;
class MembersController extends Controller{
    //会员级别列表
    public function showlist(){
        $memberLevelInfo = M('memberLevel')->where(['flag'=>1])->select();
        $this->assign('memberLevelInfo',$memberLevelInfo);
        $this->display();
    }
    //会员级别添加
    public function add(){
        if(IS_POST){
            $memberLevel = D('memberLevel');
            if($memberLevel->create()){
                if($memberLevel->add()){
                    $this->success('添加成功',U('showlist'),2);
                }else{
                    $this->error('添加失败',U('add'),2);
                }
                exit();
            }else{
                $this->assign('errorInfo',$memberLevel->getError());
            }
        }
        $this->display();
    }
    //会员列表编辑
    public function upd(){
        if(IS_POST){
            //dump(I('post.'));die;
            $level_id = I('get.level_id');
            $memberLevel = D('memberLevel');
            if($memberLevel->where(['id'=>$level_id])->save(I('post.'))){
                $this->success('修改成功',U('showlist'),2);
            }else{
                $this->error('修改失败',U('upd'),2);
            }
        }else{
            $level_id = I('get.level_id');
            //dump($level_id);die;
            $memberLevelInfo = M('memberLevel')->where(['id'=>$level_id])->find();
            $this->assign('memberLevelInfo',$memberLevelInfo); 
        }
        $this->display();
    }
    //会员列表删除  软删除 flag:0 删除 1 正常
    public function del(){
        $level_id = I('get.level_id');
        $memberLevel = D('memberLevel');
        if($memberLevel->where(['id'=>$level_id])->save(['flag'=>'0'])){
            $this->success('删除成功',U('showlist'),2);
        }else{
            $this->error('删除失败',U('upd'),2);
        }
    }
}