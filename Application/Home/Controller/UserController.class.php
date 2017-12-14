<?php

namespace Home\Controller;

use Think\Controller;
use Common\Common\oAuth;
use Common\Common\SaeTClientV2;
class UserController extends Controller
{
    public function login()
    {
        if (IS_POST) {
            $code = I('post.checkcode');
            if ($this->verify($code)) {
                //收集form表单过来的用户名和密码信息
                $name = I('post.username');
                $pwd = md5(I('post.password'));//加密处理
                //判断使用用户名查找信息
                $userinfo = D('User')->getUserByName($name);

                //当查到数据并且该人不是删除状态时
                if ($userinfo && $userinfo[0]['user_status'] != 0) {
                    if($userinfo[0]['is_active']=='激活'){

                        $password = $userinfo[0]['password'];
                        $status = $userinfo[0]['user_status'];//获取当前用户的账户状态
                        if ($pwd == $password) {
                            //密码正确
                            $frozen_time = $userinfo[0]['frozen_time'];//获取冻结时间
                            if($status=='2'){
                                //自定义冻结时
                                if ($frozen_time <= time()) {
                                    //时间已过，解冻
                                    D('Admin/User')->unblocked($userinfo[0]['user_id']);
                                } else {
                                    //时间未到，显示相关信息
                                    $errorinfo = "账户已被冻结至" . date('Y-m-d H:i:s', $frozen_time);
                                    $this->assign('errorinfo', $errorinfo);
                                    $this->display();
                                    die;
                                }
                            }else if($status=='3'){
                                $errorinfo = "账户被永久冻结，请尽快联系管理员！";
                                $this->assign('errorinfo', $errorinfo);
                                $this->display();
                                die;
                            }
                            //全部通过，则正常登录
                            $user_id = $userinfo[0]['user_id'];
                            //持久化用户名和id
                            session('username', $name);
                            session('user_id', $user_id);
                            //判断是否有定义回跳地址，并做跳转
                            $back_url = session('back_url');
                            if(!empty($back_url)){
                                session('back_url',null);//清除回跳地址
                                $this->redirect($back_url);
                            }
                            //登录跳转
                            $this->redirect('Index/index');
                        } else {
                            $errorinfo = "密码输入错误！";
                        }
                    }else{
                        $errorinfo = '该用户尚未激活！请查看邮件并激活！';
                    }
                } else {
                    $errorinfo = '用户名不存在，请重新输入！';
                }
            }else{
                $errorinfo = '验证码错误！';
            }
        }
        $this->assign('errorinfo', $errorinfo);
        $this->display();
    }

    //退出登录
    public function logout()
    {
        session(null);
        $this->redirect('User/login');
    }

    //ajax请求查看用户名是否已经注册
    public function checkNames()
    {
        $username = I('post.username');
        $preg = "/^(\d{3,20}|.*[%\*\+=]+)$/";
        if(preg_match($preg,$username)||empty($username)){
            $info['infos'] = '用户名不合法';
            $info['status'] = 0;
        }else{
            //检验用户名长度是否合法
            if(strlen($username)>20||strlen($username)<3){
                $info['infos'] = '用户长度在3到20位之间';
                $info['status'] = 0;
            }else{
                $user = D('User')->getUserByName($username);
                if ($user) {
                    $info['infos'] = '用户名已经注册';
                    $info['status'] = 0;
                } else {
                    $info['infos'] = '用户名未被占用';
                    $info['status'] = 1;
                }
            }
        }
        echo json_encode($info);
    }

    public function regist()
    {
        $User = D('User');
        //或者使用layout(false)来关闭使用默认布局
        if (IS_POST) {
            //dump($_POST);die;
            $code = I('post.checkcode');
            $data = session('data');
            $limittime = $data['limittime']*60;
            $nowtime = time();
            if($nowtime-$limittime>$data['nowtime']){
                $this->assign('infoerror','短信验证码已经过期');
            }else if($code!=$data['code']){
                $this->assign('infoerror','验证码输入错误');
            }else{
                $info=$User->create();
                $info['password'] = md5($info['password']);
                $info['user_email'] =I('post.user_email');
                $info['user_time'] = $info['last_time'] = time();
                if($newId = $User->add($info)){
                    $emailaddr = $info['user_email'];
                    $active_code = substr(md5($info['user_email'].time()),-15);
                    $User->save(array('user_id'=>$newId,'active_code'=>$active_code));
                    $url="http://www.jx.com/index.php/Home/User/Active/user_id/".$newId."/active_code/".$active_code;
                    $cont = "<p>请点击以下超链接激活账号</p>";
                    $cont.="<p><a href='".$url."'>".$url."</a></p>";
                    sendMail($emailaddr,'激活账号邮件',$cont);
                    $this->success('请登录邮箱激活账号',U('User/login'),5);
                }
            }
        }
        $this->display();
    }

    public function sendCont(){
        if(IS_AJAX){
            $tel = I('get.tel');
            $data['code'] = mt_rand(1000,9999);
            $data['limittime'] = 3;
            $data['nowtime'] = time();
            session('data',$data);
            $z = sendTemplateSMS($tel,array($data['code'],$data['limittime']));
            if($z){
                echo json_encode(array('status'=>0));
            }else{
                echo json_encode(array('status'=>1));
            }
        }
    }
    public function Active(){
        //获取邮件激活信息
        $active_code = I('get.active_code');
        $user_id = I('get.user_id');
        $user = D('User');
        //根据特定的信息查询是否存在这样的一条记录
        $info = $user->where(array('user_id'=>$user_id,'active_code'=>$active_code))->find();
        if($info){
            $mess['user_id']=$user_id;
            $mess['active_code']='';
            $mess['is_active'] = '激活';
            if($user->save($mess)){
                $this->success('账号已经激活',U('User/login'),2);
            }
        }else{
            $this->error('传递参数有问题，请联系管理员',U('User/regist'),2);
        }
    }
    //验证码的生成

    /**
     * @param int $code =0 默认为0指用于生成验证码，如果不是0的话，代表用于验证验证码
     */
    public function verify($code = 0)
    {

        if ($code === 0) {
            $cfg = array(
                'fontSize' => 18,              // 验证码字体大小(px)
                'useCurve' => true,            // 是否画混淆曲线
                'useNoise' => true,            // 是否添加杂点
                'imageH' => 36,               // 验证码图片高度
                'imageW' => 150,               // 验证码图片宽度
                'length' => 4,               // 验证码位数
                'fontttf' => '4.ttf',
            );
            $vry = new \Think\Verify($cfg);
            $vry->entry();
        } else {
            $vry = new \Think\Verify();
            return $vry->check($code);
        }
    }

    public function weibologin(){
        //实例化微博oauth类，获取授权窗口
        $oAuth = new oAuth(C('WB_AKEY'),C('WB_SKEY'));
        $code_url = $oAuth->getAuthorizeURL(C('SITE')."/index.php/home/user/sinaLoginCallback");
        echo <<<EOF
        <script type="text/javascript">
        window.location.href="$code_url";
        </script>
EOF;
    }
    public function sinaLoginCallback(){
        //实例化微博oAuth类
        $oAuth = new oAuth( C('WB_AKEY') , C('WB_SKEY') );
        //直接使用微博aouth dome代码
        if (isset($_REQUEST['code'])) {
            $keys = array();
            $keys['code'] = $_REQUEST['code'];
            $keys['redirect_uri'] = C('SITE')."/index.php/home/user/sinaLoginCallback";
            try {
                $token = $oAuth->getAccessToken( 'code', $keys ) ;
            } catch (OAuthException $e) {
            }
        }
        //获取到assoc_token
        if ($token) {
            setcookie( 'weibojs_'.$oAuth->client_id, http_build_query($token) );
            //实例化SaeTClientV2类获取到用户信息 注意:该类在oauth类中下半部分 注意修改构造方法中实例化的oauth类
            $oAuthResult = new SaeTClientV2( C('WB_AKEY') , C('WB_SKEY'), $token['access_token'] );
            //获取用户uid
            $uid_get = $oAuthResult->get_uid();
            //根据uid获取微博用户信息
            $user_message = $oAuthResult->show_user_by_id($uid_get['uid']);
            //事例话user模型  将用户信息写入数据库
            $user=D('user');
            //以下部分与qq授权相同
            $returnUserInfo = $user->getOneData(['wb_id'=>$user_message['id']]);
            if ($returnUserInfo){
                if ($returnUserInfo['username']!=$user_message['name']){
                    $user->where(['user_id'=>$returnUserInfo['user_id']])->save(['username'=>$user_message['name']]);

                }
                session('user_id',$returnUserInfo['user_id']);
                session('username', $user_message['name']);
                $this->success('登录成功,即将跳转',U('index/index'),2);
            }else{
                //如果获取到微博用户信息
                $userInfo['username']  = $user_message['name'];
                $userInfo['is_active'] = '激活';
                $userInfo['wb_id']    = $user_message['id'];
                $userInfo['user_time'] = time();
                if ($newId =M('user')->add($userInfo)) {
                    session('user_id', $newId);
                    session('username', $userInfo['username']);
                    $this->success('登录成功,即将跳转', U('index/index'), 2);
                }
            }

        } else {
            $this->success('授权失败,请与管理员联系','', 2);
        }

    }
}