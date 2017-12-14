<?php
namespace Admin\Controller;
use Admin\Common\AdminController;
class ExtendController extends AdminController{
    public function showlist(){
        $extend_info = D('Extend')->select();
        $extend_info = D('Extend')->parseFieldsMap($extend_info);
        $this->assign('extend_info',$extend_info);
        $this->display();
    }
    public function addExtend(){
        if(IS_POST){
            $data = D('Extend')->create();
            $res = D('Extend')->add($data);
            if($res){
                $this->success('推广添加成功！',U('showlist'));
            }else{
                $this->error('推广添加失败！',U('showlist'));
            }
        }else{
            $this->display();
        }
    }
    public function sendExtend(){
        $id = I('post.id');

        $redis = new \Redis();
        $redis->connect('localhost','6379');

        //发送给谁？发送什么？如何发送？
        //存redis的目的是什么？由于在短时间内进行高频率数据反复读取，数据库无法承受该压力，所以要交由
        //redis来完成，要不停地读的数据就是该存在redis中的数据了。
        //通过邮件发送技术实现
        $extend_info = D('Extend')->where(array('id'=>$id))->find();          //从数据库中读取指定推广信息
        $info_title = $extend_info['title'];
        //exit(json_encode(array('extend_info'=>$info_title)));
        $info_content = $extend_info['content'];
        $info_id = $entend_info['id'];
        //发送的总条数
        $num = $extend_info['num'];

        //存入redis队列中
        //$redis->rpush('infotitle',$info_title);
        //$redis->rpush('infocontent',,$info_content);
        $userinfo = D('User')->select();
        $num1=$num2=0;
        foreach($userinfo as $i){
            for($a=0;$a<count($i);$a++){    //每遍历一个用户，发一次邮件
                $res = \sendMail($i['user_email'],$info_title,$info_content);
                if($res){
                    //成功 ，将成功的用户ID存入成功集合中
                    $redis->sAdd($info_id.'-success',$i['user_id']);
                    //为给定的键设置一个生存时间
                    $redis->expire($info_id.'-success',86400);      //一天后失效
                    $num1++;
                }else{
                    //exit(json_encode(array('num1'=>$num)));
                    $redis->sAdd($info_id.'-error',$i['user_id']);
                    $redis->expire($info_id.'-error',86400);
                    $num2++;
                }
            }
            echo json_encode(['success'=>$num1,'errror'=>$num2,'total'=>$num]);
        }


    }
}
