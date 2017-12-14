<?php

namespace Admin\Controller;

use Admin\Common\AdminController;

class GoodsController extends AdminController
{
    //根据类型获得属性信息
    public function getAttrByType()
    {
        //获取客户端传递过来的type_id
        $type_id = I('get.type_id');
        //根据$type_id获得对应的属性
        $attrinfo = D('Attribute')
            ->where(array('type_id' => $type_id))
            ->select();
        echo json_encode($attrinfo);

    }

    //根据类型获取属性信息[修改商品]
    public function getAttrByType2()
    {
        //获取客户端传过来的goods_id和type_id
        $goods_id = I('get.goods_id');
        $type_id = I('get.type_id');
        //获取属性列表信息(实体、空壳)
        //sp_attribute与sp_goods_attr做联表查询 通过attr_id关联
        $attrinfo = D('Attribute')
            ->alias('a')
            ->field('a.attr_id,a.attr_name,a.attr_vals,a.attr_sel,(select group_concat(ga.attr_value) from sp_goods_attr ga where ga.attr_id = a.attr_id and ga.goods_id='.$goods_id.') attr_value')
            ->where(array('a.type_id'=>$type_id))
            ->select();
        echo json_encode($attrinfo);
    }

    //商品列表展示页面
    public function showlist()
    {
        $data = D('Goods')->getGoods(5);
        $this->assign('data', $data);
        $this->display();
    }

    //商品添加页面
    public function tianjia()
    {
        $goods = D('goods');
        if (IS_POST) {
            $this->deal_logo();
            $info = I('post.');
            $info['add_time'] = $info['upd_time'] = time();
            $info['goods_introduce'] = \fangXSS($_POST['goods_introduce']);
            $num = $goods->add($info);
            if ($num) {
                $this->deal_pics($num);
                //属性信息维护
                $this->deal_attr($num);
                $this->success('添加成功！', U('showlist'), 2);
            } else {
                $this->error('添加失败！', U('tianjia'), 2);
            }
        } else {
            //获取类型信息
            $typeinfo = D('Type')->select();
            $this->assign('typeinfo', $typeinfo);
            $memberInfo = D('memberLevel')->select();
            $this->assign('memberInfo',$memberInfo);
            $this->display();
        }
    }

    //添加商品实现属性信息的维护(sp_goods_attr表)
    private function deal_attr($goods_id)
    {
        D('GoodsAttr')->where(array('goods_id'=>$goods_id))->delete();
        foreach ($_POST['attr_info'] as $k => $v) {
            //$k是属性ID值
            foreach ($v as $vv) {
                if (!empty($vv)) {
                    $arr['goods_id'] = $goods_id;
                    $arr['attr_id'] = $k;
                    $arr['attr_value'] = $vv;
                    //给关联表sp_goods_attr填充数据
                    //D('GoodsAttr')对应数据表sp_goods_attr
                    //D('Goodsattr')对应数据表sp_goodsattr
                    D('GoodsAttr')->add($arr);
                }
            }
        }
    }

    //删除商品
    public function delete()
    {
        //接收删除的商品id
        $goods_id = I('get.goods_id');
        $goodsPics = D('Goods')->getAllPicsById($goods_id);
    }

    //logo上传方法

    /**
     * 图片上传的步骤为：
     * 1、在确认文件上传无系统错误的情况下，通过实例化Think下的Upload文件上传类时的构造方法设置文件上传路径;
     * 2、调用其中的uploadOne($_FILES['goods_name'])，该方法返回的数据为带有错误信息，文件后缀，重命名后的文件名以及保存目录信息的数组;
     * 3、组装上传后的文件地址$addr = $up->rootPath.$z['savepath'].$z['savename'];
     * 4、将文件路径信息存入数据中，所以下次调用时，其实调用的是路径信息
     * 缩略图的上传步骤为:
     * 1、第一步实例化缩略图类，$im = new \Think\Image();
     * 2、第二步通过实例化后的对象调用open方法，参数为待制作缩略图文件地址：$im->open($addr);
     * 3、第三步设置缩略图基本信息，使用thumb方法，$im->thumb()，其中的几个参数可以设置缩略图的大小尺寸以及制作规格
     * 4、使用变量保存缩略图文件路径的信息，基本上与文件上传类同时使用的，所以我们可以使用$addrs = $up->rootPath.$z['savepath'].'small'.$z['savename']的路径来保存文件信息;
     * 5、使用Image类中的save方法保存文件：$im->save($addrs);//用于保存文件到服务器指定的路径
     * 6、保存路径信息到数据库中
     * @param $goods_id 为0时表示新增，非0表示修改
     */
    private function deal_logo($goods_id = 0)
    {
        if ($_FILES['goods_logo']['error'] === 0) {
            //修改时，需要删除原图和原缩略图
            if ($goods_id != 0) {
                $goodsinfo = D('goods')->find($goods_id);
                if (file_exists($goodsinfo['goods_big_logo'])) {
                    unlink($goodsinfo['goods_big_logo']);
                }
                if (file_exists($goodsinfo['goods_small_logo'])) {
                    unlink($goodsinfo['goods_small_logo']);
                }
            }
            //证明图片上传正确,配置上传路径
            $cfg = array(
                'rootPath' => './Public/Uploads/logo/',//保存根路径
            );
            $up = new \Think\Upload($cfg);
            //uploads返回上传文件的基本信息，包括文件名，保存路径等
            $z = $up->uploadOne($_FILES['goods_logo']);
            //将上传好的附件信息保存到数据库
            $_POST['goods_big_logo'] = $up->rootPath . $z['savepath'] . $z['savename'];
            //制作缩略图
            //1、
            $im = new \Think\Image();//创建对象
            $im->open($_POST['goods_big_logo']);//打开原图
            $im->thumb(130, 130, 6);//设置缩略图处理信息
            $smallPathName = $up->rootPath . $z['savepath'] . 'small_' . $z['savename'];
            $im->save($smallPathName);//保存到服务器路径
            //将上传好的缩略图附件信息保存到数据库
            $_POST['goods_small_logo'] = $smallPathName;
        }
    }

    //上传相册图片维护方法
    private function deal_pics($goods_id)
    {
        //判断是否有上传相册（至少有一个）
        $havePics = false;
        foreach ($_FILES['goods_pics']['error'] as $v) {
            if ($v === 0) {
                $havePics = true;
                break;
            }
        }
        //有上传相册才处理
        if ($havePics === true) {
            //判断是否有相册上传
            $cfg = array(
                'rootPath' => './Public/Uploads/pics/',
            );
            $up2 = new \Think\Upload($cfg);
            //相册批量上传处理，upload二维数组
            $z2 = $up2->upload(array($_FILES['goods_pics']));
            //制作缩略图
            $im2 = new \Think\Image();//实例化图片处理类
            foreach ($z2 as $k => $v) {
                //原路径名
                $yuan_pics = $up2->rootPath . $v['savepath'] . $v['savename'];
                $im2->open($yuan_pics);//打开原图资源
                //1、大图缩略图
                $im2->thumb(800, 800, 6);
                $pics_ig = $up2->rootPath . $v['savepath'] . 'big_' . $v['savename'];
                $im2->save($pics_big);
                //2、中图缩略图
                $im2->thumb(350, 350, 6);
                $pics_mid = $up2->rootPath . $v['savepath'] . 'mid_' . $v['savename'];
                $im2->save($pics_mid);
                //3、小图缩略图
                $im2->thumb(50, 50, 6);
                $pics_small = $up2->rootPath . $v['savepath'] . 'small_' . $v['savename'];
                $im2->save($pics_small);

                //删除无用的原图
                unlink($yuan_pics);
，
                //将缩略图相册存储给数据库
                $arr = array(
                    'goods_id' => $goods_id,
                    'pics_big' => $pics_big,
                    'pics_mid' => $pics_mid,
                    'pics_sma' => $pics_small,
                );
                //保存到数据库
                D('GoodsPics')->add($arr);
            }
        }
    }
    //商品修改页面
    public function upd()
    {
        if (IS_POST) {
            //比较隐藏域中的goods_id和session中的goods_id是否相同
            $goods_upd_id = session('goods_upd_id');
            if ($goods_upd_id != $_POST['goods_id']) {
                $this->error('参数有问题，请联系管理员！', U('showlist'), 3);
                die;
            }
            //商品logo修改处理
            $this->deal_logo($_POST['goods_id']);
            //商品相册修改处理
            $this->deal_pics($_POST['goods_id']);
            //实现属性信息收集入库
            $this->deal_attr($_POST['goods_id']);
            $shuju = I('post.');//处理收集form表单信息
            $shuju['upd_time'] = time();
            //防止XSS攻击
            $shuju['goods_introduce'] = \fangXSS($_POST['goods_introduce']);
            if (D('Goods')->save($shuju)) {
                $this->success('修改商品成功！', U('upd', array('goods_id' => $shuju['goods_id'])), 2);
            } else {
                $this->error('修改商品失败！', U('upd', array('goods_id' => $shuju['goods_id'])), 2);
            }
        } else {
            $goods_id = I('get.goods_id');
            session('goods_upd_id', $goods_id);
            $info = D('Goods')->find($goods_id);
            $picsinfo = D('goods_pics')->field('pics_id,goods_id,pics_mid')->where(array('goods_id' => $goods_id))->select();
            $this->assign('info', $info);
            $this->assign('picsinfo', $picsinfo);
            //获的商品类型信息
            $typeinfo = D('Type')->select();
            $this->assign('typeinfo', $typeinfo);
            $this->display();
        }

    }

    //删除商品相册
    public function delPics()
    {
        $pics_id = I('post.pics_id');//接受ID

        //根据pics_id进行条件查询
        $picsinfo = D('goods_pics')->find($pics_id);

        //删除物理相册图片
        if (file_exists($picsinfo['pics_big'])) {
            unlink($picsinfo['pics_big']);
        }
        if (file_exists($picsinfo['pics_mid'])) {
            unlink($picsinfo['pics_mid']);
        }
        if (file_exists($picsinfo['pics_sma'])) {
            unlink($picsinfo['pics_sma']);
        }

        //删除数据记录
        if (D('goods_pics')->delete($pics_id)) {
            echo json_encode(array('status' => 0));//删除成功
        } else {
            echo json_encode(array('status' => 1));//删除失败
        }
    }

    //商品开启秒杀功能
    public function setsecBuy(){
        $goods_id = I('get.goods_id');
        $redis = new \Redis();
        $redis->connect('localhost','6379');
        if(IS_POST){
            //将商品和秒杀信息写入秒杀表
            $data['goods_id'] = $goods_id;
            //时间格式：X年-X月-X日 Y:Y:Y
            $data['start_buy_time'] = strtotime(I('post.start_buy_time'));
            $data['end_buy_time'] = strtotime(I('post.end_buy_time'));
            $data['buy_total'] = I('post.buy_total');
            $time = $data['end_buy_time']-$data['end_start_buy_time'];
            $res = D('secbuy')->add($data);
            if($res){
                //添加秒杀成功
                //将信息通过for循环方式写入队列
                for($i = 0;$i<count($data);$i++){
                    $redis->rpush("goodsinfo",$data[$i]);
                    $redis->expire('goodsinfo',$time);
                }
                //$this->redirect('Goods/showlist');
                $this->success('添加秒杀成功！',U('Goods/showlist'));
            }
        }else{
            $this->display();
        }
    }
}
