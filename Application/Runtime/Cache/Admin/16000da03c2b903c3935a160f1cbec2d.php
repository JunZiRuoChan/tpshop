<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>无标题文档</title>
    <script type="text/javascript" charset="utf-8" src="<?php echo C('PLUGIN_URL');?>ueditor/ueditor.config.js"></script>
    <script type="text/javascript" charset="utf-8" src="<?php echo C('PLUGIN_URL');?>ueditor/ueditor.all.min.js"></script>
    <script type="text/javascript" charset="utf-8" src="<?php echo C('PLUGIN_URL');?>ueditor/lang/zh-cn/zh-cn.js"></script>
    <script src="<?php echo C('AD_JS_URL');?>jquery-1.8.3.min.js"></script>
    <script>
        $(function(){
            $('#tabbar-div span').click(function(){
                $(this).attr('class','tab-front').siblings().attr('class','tab-back');
                $('[id$=-tab-show]').hide();
                var idflag = $(this).attr('id');
                $('#'+idflag+'-show').show();
            })
        })
    </script>
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
    </style>
    <style>
        #tabbar-div{
            background: #80bdcb none repeat scroll 0 0;
            height:22px;
            padding-left:10px;
            padding-top:1px;
            margin-bottom:3px;
        }
        #tabbar-div p{
            margin:2px 0 0;font-size: 12px;
        }
        .tab-front{
            background: #bbdde5 none repeat scroll 0 0;
            border-right:2px solid #278296;
            cursor: pointer;
            font-weight: bold;
            line-height: 20px;
            padding:4px 15px 4px 18px;
        }
        .tab-back{
            border-right:1px solid #fff;
            color:#fff;cursor:pointer;line-height: 20px;
            padding:4px 15px 4px 18px;
        }
    </style>
</head>

<body>
<script>
    //[+]号可以增加相册图片
    function add_pics_item(obj) {
        //obj:对应[+]父级span的"dom对象"
        //$(obj):把dom对象转化为jquery对象

        //获得[+]对应的tr
        var addtr = $(obj).parent().parent().parent();
        var futr = addtr.clone();//复制一个tr出来

        //制作一个[-]号的span
        var sp = "<span class='STYLE19' onclick='$(this).parent().parent().parent().remove()'>[-] 商品相册：</span>";
        //删除futr内部的[+]对应的span
        futr.find('span').remove();
        //把[-]的span追加给futr
        futr.find("div[align=right]").append(sp);

        //把futr追加给table完活
        $('#gallery-tab-show').append(futr);
    }
</script>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
        <td height="30"><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td height="24" bgcolor="#353c44"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                                <td width="6%" height="19" valign="bottom"><div align="center"><img src="<?php echo C('AD_IMG_URL');?>tb.gif" width="14" height="14" /></div></td>
                                <td width="94%" valign="bottom"><span class="STYLE1"> 推广管理 -> 添加推广</span></td>
                            </tr>
                        </table></td>
                        <td><div align="right"><span class="STYLE1">
            <a href="<?php echo U('showlist');?>">返回</a>   &nbsp; </span>
                            <span class="STYLE1"> &nbsp;</span></div></td>
                    </tr>
                </table></td>
            </tr>
        </table></td>
    </tr>
    <tr>
        <td>
            <form action="" method="post" enctype="multipart/form-data">
                <table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#a8c7ce" id="general-tab-show">
                    <tr>
                        <td height="20" bgcolor="#FFFFFF" class="STYLE6"><div align="right"><span class="STYLE19">推广标题：</span></div></td>
                        <td height="20" bgcolor="#FFFFFF" class="STYLE19"><div align="left">
                            <input type="text" name="title" />
                        </div></td>
                    </tr>
                    <tr>
                        <td height="20" bgcolor="#FFFFFF" class="STYLE6"><div align="right"><span class="STYLE19">推广链接：</span></div></td>
                        <td height="20" bgcolor="#FFFFFF" class="STYLE19"><div align="left">
                            <input type="text" name="url" />
                        </div></td>
                    </tr>
                    <tr>
                        <td height="20" bgcolor="#FFFFFF" class="STYLE6"><div align="right"><span class="STYLE19">推广条数：</span></div></td>
                        <td height="20" bgcolor="#FFFFFF" class="STYLE19"><div align="left"><input type="text" name="num" /></div></td>
                    </tr>
                    <tr>
                        <td height="20" bgcolor="#FFFFFF" class="STYLE6"><div align="right"><span class="STYLE19">推广内容：</span></div></td>
                        <td height="20" bgcolor="#FFFFFF" class="STYLE19">
                            <div align="left">
                                <!-- <input type="text" name="auth_c" /> -->
                                <textarea name="content" cols="55" rows="10"></textarea>
                            </div>
                        </td>
                    </tr>

                </table>
                <table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#a8c7ce">
                    <tr>
                        <td colspan="100" bgcolor="#FFFFFF" class="STYLE6" style="text-align: center;">
                            <input type="submit" value="添加">
                        </td>
                    </tr>
                </table>
            </form>
        </td>
    </tr>
</table>
</body>
</html>