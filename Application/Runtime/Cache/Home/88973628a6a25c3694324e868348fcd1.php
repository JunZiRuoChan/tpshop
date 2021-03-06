<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <title><?php if(CONTROLLER_NAME== 'User' and ACTION_NAME== 'regist'): ?>用户注册<?php elseif(ACTION_NAME== 'flow1'): ?>我的购物车<?php elseif(ACTION_NAME== 'flow2'): ?>填写核对订单信息<?php elseif(ACTION_NAME== 'flow3'): ?>成功提交订单<?php endif; ?></title>
    <link rel="stylesheet" href="<?php echo C('CSS_URL');?>base.css" type="text/css">
    <link rel="stylesheet" href="<?php echo C('CSS_URL');?>global.css" type="text/css">
    <link rel="stylesheet" href="<?php echo C('CSS_URL');?>header.css" type="text/css">
    <link rel="stylesheet" href="<?php echo C('CSS_URL');?>login.css" type="text/css">
    <link rel="stylesheet" href="<?php echo C('CSS_URL');?>footer.css" type="text/css">
    <script src="<?php echo C('JS_URL');?>jquery-1.8.3.min.js"></script>
</head>
<body>
<!-- 顶部导航 start -->
<div class="topnav">
    <div class="topnav_bd w990 bc">
        <div class="topnav_left">

        </div>
        <div class="topnav_right fr">
            <?php if(!empty($_SESSION['username'])): ?><ul>
                    <li>您好，<span style="font-size:20px;color:blue;"><?php echo (session('username')); ?></span> 欢迎来到京西！[<a href="<?php echo U('User/logout');?>" onclick="return confirm('是否退出登录？')">退出系统</a>]</li>
                    <li class="line">|</li>
                    <li><a href="<?php echo U('Order/orderList');?>">我的订单</a></li>
                    <li class="line">|</li>
                    <li>客户服务</li>
                </ul>
                <?php else: ?>
                <ul>
                    <li>您好，欢迎来到京西！[<a href="<?php echo U('User/login');?>">登录</a>] [<a href="<?php echo U('User/regist');?>">免费注册</a>] </li>
                    <li class="line">|</li>
                    <li>我的订单</li>
                    <li class="line">|</li>
                    <li>客户服务</li>
                </ul><?php endif; ?>
        </div>
    </div>
</div>
<!-- 顶部导航 end -->

<div style="clear:both;"></div>

<!-- 页面头部 start -->
<div class="header w990 bc mt15">
    <div class="logo w990">
        <h2 class="fl"><a href="index.html"><img src="<?php echo C('IMG_URL');?>logo.png" alt="京西商城"></a></h2>
        <!--控制器为Shop时就显示下边的div-->
        <?php if((CONTROLLER_NAME) == "Shop"): ?><div class="flow fr <?php echo (ACTION_NAME); ?>">
                <ul>
                    <li <?php if((ACTION_NAME) == "flow1"): ?>class="cur"<?php endif; ?>>1.我的购物车</li>
                    <li <?php if((ACTION_NAME) == "flow2"): ?>class="cur"<?php endif; ?>>2.填写核对订单信息</li>
                    <li <?php if((ACTION_NAME) == "flow3"): ?>class="cur"<?php endif; ?>>3.成功提交订单</li>
                </ul>
            </div><?php endif; ?>
    </div>
</div>
<!-- 页面头部 end -->



<script>
	function actions(){
	    if(!arguments[0]){
	        var checkcodes = $('input[name=checkcode]').val();
	        if(!checkcodes){
                $('#error').empty().text('请填写验证码！');
				return false;
			}else{
                var val1 = $('#username').val();
                var val2 = $('#pwd').val();
                if(val1!=''&&val2!=''){
                    return true;
                }else{
                    $('#error').empty().text('用户名或密码不能为空！');
                    return false;
                }
			}

		}else{
	        var obj = arguments[0];
            var val = $(obj).val();
            var name  =$(obj).attr('id');
            if(val==''){
                if(name == 'username'){
                    var txt = '用户名不能为空！';
                }else{
                    var txt = '密码不能为空！';
                }
                $('#error').empty().text(txt);
            }
		}

	}
</script>
	<!-- 登录主体部分start -->
	<div class="login w990 bc mt10">
		<div class="login_hd">
			<h2>用户登录</h2>
			<b></b>
		</div>
		<div class="login_bd">
			<div class="login_form fl">
				<form action="" method="post"  onsubmit="return actions()">
					<ul>
						<li>
							<label for="">用户名：</label>
							<input type="text" class="txt" id="username" name="username" onblur="actions(this)"/>
						</li>
						<li>
							<label for="">密码：</label>
							<input type="password" class="txt" id="pwd" name="password" onblur="actions(this)"/>
							<a href="">忘记密码?</a>
						</li>
						<li style="padding-left: 60px;color:red;font-size: 14px;" id="error"><?php echo ((isset($errorinfo) && ($errorinfo !== ""))?($errorinfo):''); ?></li>
						<li class="checkcode">
							<label for="">验证码：</label>
							<input type="text"  name="checkcode" />
							<img src="<?php echo U('Home/User/verify');?>" alt="" style="vertical-align: middle" onclick="this.src='<?php echo U('Home/User/verify');?>?'+Math.random()"/>
							<span>看不清？<a href="">换一张</a></span>
						</li>
						<li>
							<label for="">&nbsp;</label>
							<input type="checkbox" class="chb"  /> 保存登录信息
						</li>
						<li>
							<label for="">&nbsp;</label>
							<input type="submit" value="" class="login_btn"/>
						</li>
					</ul>
				</form>

				<div class="coagent mt15">
					<dl>
						<dt>使用合作网站登录商城：</dt>
						<dd class="qq"><a href=""><span></span>QQ</a></dd>
						<dd class="weibo"><a href="<?php echo U('weibologin');?>"><span></span>新浪微博</a></dd>
						<dd class="yi"><a href=""><span></span>网易</a></dd>
						<dd class="renren"><a href=""><span></span>人人</a></dd>
						<dd class="qihu"><a href=""><span></span>奇虎360</a></dd>
						<dd class=""><a href=""><span></span>百度</a></dd>
						<dd class="douban"><a href=""><span></span>豆瓣</a></dd>
					</dl>
				</div>
			</div>

			<div class="guide fl">
				<h3>还不是商城用户</h3>
				<p>现在免费注册成为商城用户，便能立刻享受便宜又放心的购物乐趣，心动不如行动，赶紧加入吧!</p>

				<a href="regist.html" class="reg_btn">免费注册 >></a>
			</div>

		</div>
	</div>
	<!-- 登录主体部分end -->

	<div style="clear:both;"></div>


<!-- 底部版权 start -->
<div class="footer w1210 bc mt15">
    <p class="links">
        <a href="">关于我们</a> |
        <a href="">联系我们</a> |
        <a href="">人才招聘</a> |
        <a href="">商家入驻</a> |
        <a href="">千寻网</a> |
        <a href="">奢侈品网</a> |
        <a href="">广告服务</a> |
        <a href="">移动终端</a> |
        <a href="">友情链接</a> |
        <a href="">销售联盟</a> |
        <a href="">京西论坛</a>
    </p>
    <p class="copyright">
        © 2005-2013 京东网上商城 版权所有，并保留所有权利。  ICP备案证书号:京ICP证070359号
    </p>
    <p class="auth">
        <a href=""><img src="<?php echo C('IMG_URL');?>xin.png" alt="" /></a>
        <a href=""><img src="<?php echo C('IMG_URL');?>kexin.jpg" alt="" /></a>
        <a href=""><img src="<?php echo C('IMG_URL');?>police.jpg" alt="" /></a>
        <a href=""><img src="<?php echo C('IMG_URL');?>beian.gif" alt="" /></a>
    </p>
</div>
<!-- 底部版权 end -->

</body>
</html>