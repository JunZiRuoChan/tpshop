<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <script src="<?php echo C('LAY_URL');?>jquery-1.8.2.min.js"></script>
    <script src="<?php echo C('LAY_URL');?>layer.js"></script>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>权限列表</title>
    <style type="text/css">
        <!--
        body {
            margin-left: 3px;
            margin-top: 0px;
            margin-right: 3px;
            margin-bottom: 0px;
        }
        .STYLE1 {
            color: #e1e2e3;
            font-size: 12px;
        }
        .STYLE6 {color: #000000; font-size: 12; }
        .STYLE10 {color: #000000; font-size: 12px; }
        .STYLE19 {
            color: #344b50;
            font-size: 12px;
        }
        .STYLE21 {
            font-size: 12px;
            color: #3b6375;
        }
        .STYLE22 {
            font-size: 12px;
            color: #295568;
        }
        a:link{
            color:#e1e2e3; text-decoration:none;
        }
        a:visited{
            color:#e1e2e3; text-decoration:none;
        }
        -->
        /*分页样式*/
         .Pagination a:hover,.current{
             background-color: #f54281;
             border: 1px solid #f54281;
             color: #ffffff;
         }
        .Pagination{
            float: right;
            height: auto;
            _height: 45px;
            line-height: 20px;
            margin-right: 15px;
            _margin-right: 5px;
            color:#565656;
            margin-top: 10px;
            _margin-top: 20px;
            clear:both;
        }
        .Pagination a,.Pagination span{
            font-size: 5px;
            text-decoration: none;
            display: block;float: left;
            color: #565656;
            border: 1px solid #ccc;
            height: 34px;
            line-height: 34px;
            margin: 0 2px;
            width: 40px;
            text-align: center;
        }
    </style>
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
        <td height="30"><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td height="24" bgcolor="#353c44"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                                <td width="6%" height="19" valign="bottom"><div align="center"><img src="<?php echo C('AD_IMG_URL');?>tb.gif" width="14" height="14" /></div></td>
                                <td width="94%" valign="bottom"><span class="STYLE1"> 用户管理 -> 用户列表</span></td>
                            </tr>
                        </table></td>
                        <td><div align="right"><span class="STYLE1">
             <input type="button" id="exportUser" value="导出">   &nbsp;
              </span>
                            <span class="STYLE1"> &nbsp;</span></div></td>
                    </tr>
                </table></td>
            </tr>
        </table></td>
    </tr>
    <tr>
        <td><table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#a8c7ce">
            </td>
            <td width="10%" height="20" bgcolor="d3eaef" class="STYLE6"><div align="center"><span class="STYLE10">用户ID</span></div></td>
            <td width="15%" height="20" bgcolor="d3eaef" class="STYLE6"><div align="center"><span class="STYLE10">用户名</span></div></td>
            <td width="10%" height="20" bgcolor="d3eaef" class="STYLE6"><div align="center"><span class="STYLE10">用户邮箱</span></div></td>
            <td width="10%" height="20" bgcolor="d3eaef" class="STYLE6"><div align="center"><span class="STYLE10">性别</span></div></td>
            <td width="10%" height="20" bgcolor="d3eaef" class="STYLE6"><div align="center"><span class="STYLE10">账户状态</span></div></td>
            <td width="15%" height="20" bgcolor="d3eaef" class="STYLE6"><div align="center"><span class="STYLE10">手机号</span></div></td>
            <td width="20%" height="20" bgcolor="d3eaef" class="STYLE6"><div align="center"><span class="STYLE10">操作</span></div></td>
            </tr>
            <?php if(is_array($user)): foreach($user as $key=>$v): ?><tr>
                    <td height="20" bgcolor="#FFFFFF" class="STYLE6"><div align="center"><span class="STYLE19" id="id"><?php echo ($v["user_id"]); ?></span></div></td>

                    <td height="20" bgcolor="#FFFFFF" class="STYLE19"><div align="center"><?php echo ($v["username"]); ?></div></td>
                    <td height="20" bgcolor="#FFFFFF" class="STYLE19"><div align="center"><?php echo ($v["user_email"]); ?></div></td>
                    <td height="20" bgcolor="#FFFFFF" class="STYLE19"><div align="center"><?php echo ($v["user_sex"]); ?></div></td>
                    <td height="20" bgcolor="#FFFFFF" class="STYLE19"><div align="center"><?php echo ($v["user_status"]); ?></div></td>
                    <td height="20" bgcolor="#FFFFFF" class="STYLE19"><div align="center"><?php echo ($v["user_tel"]); ?></div></td>
                    <td height="20" bgcolor="#FFFFFF">
                        <div align="center" class="STYLE21">

                            <a class="delAuth"> <img src="<?php echo C('AD_IMG_URL');?>del.gif" width="10" height="10" />删除</a>  | <a class="blocked">冻结</a>  |  <a class="unblocked">解冻</a></div></td>
                </tr><?php endforeach; endif; ?>
        </table></td>
    </tr>
    <tr>
        <td><div class="Pagination"><?php echo ($page); ?></div></td>
    </tr>
    </tr>
</table>
</body>
<script type="text/javascript">
    $(function () {
        $('.delAuth').click(function () {
            var authId = $(this).parent().parent().parent().find("td:first span").html();
            layer.confirm('确定要删除该权限吗？', {
                btn: ['确定删除','容我想想'] //按钮
            }, function(){
                $.ajax({
                    url:"<?php echo U('delAuth');?>",
                    data:{'auth_id':authId},
                    dataType:'json',
                    type:'post',
                    success:function (msg) {
                        if(msg.status == 200){
                            layer.msg('删除成功');
                            location.reload();
                        }else if(msg.status == 202){
                            layer.msg('删除失败');
                        }
                    }
                })

            }, function(){
                layer.msg( {
                    time: 1000,
                });
            });
        })

        $('.unblocked').click(function(){
            var authId = $(this).parent().parent().parent().find("td:first span").html();
            layer.confirm('确认要解冻吗？',{
                btn:['确定解冻','不能绕过他！']
            },function(){
                $.ajax({
                    url:"<?php echo U('unblocked');?>",
                    data:{'user_id':authId},
                    type:'post',
                    dataType:'json',
                    success:function(msg){
                        var state = msg.state;
                        if(state==200){
                            layer.msg(msg.massage);
                            location.reload()
                        }else{
                            layer.msg(msg.massage);
                        }
                    }
                })
            })
        })
        //冻结账户
        $('.blocked').click(function (){

            var authId = $(this).parent().parent().parent().find("td:first span").html();
//            console.log(authId);
            layer.confirm('确定要冻结该账户吗？', {
                btn: ['确定冻结','容我想想'] //按钮
            }, function(){
                layer.confirm('请选择冻结状态？', {
                    btn: ['自定义冻结','永久冻结']
                    //按钮
                },function(index){
                    layer.prompt({title: '请输入冻结天数'},function(val, index){
//                      layer.msg("该账户将冻结"+val+"天");
//                        console.log(val);
                        layer.close(index);
                        blocked(authId,val);
                    });
                    layer.close(index);

                },function () {
                    blocked(authId);
                })
            }, function(){
                layer.msg( {
                    time: 1000,
                });
            });
        })

        //冻结函数
        function  blocked( user_id,time='long'){
            $.ajax({
                url:"<?php echo U('blocked');?>",
                data:{'user_id':user_id,'time':time},
                dataType:'json',
                type:'post',
                success:function (msg) {
                    if(msg.state == 200){
                        layer.msg(msg.message);
                        location.reload();
                    }else if(msg.state == 202){
                        layer.msg(msg.message);
                    }
                }
            })
        }
        //用户导出
        $('#exportUser').click(function (){
//            console.log(111);
            $.ajax({
                url:"<?php echo U('exportUser');?>",
                data:'',
                type:'post',
                dataType:'json',
                success:function(msg){
//                    console.log(msg);
                    if(msg.state==200){
                        layer.msg(msg.message);
                    }else if(msg.state == 202){
                        layer.msg(msg.message);
                    }
                }
            })
        })
    })
</script>
</html>