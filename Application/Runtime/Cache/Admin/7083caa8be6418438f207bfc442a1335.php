<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>无标题文档</title>
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
        .STYLE6 {color: #000000; font-size: 12px; }
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
                                <td width="94%" valign="bottom"><span class="STYLE1"> 角色管理 -> 角色列表</span></td>
                            </tr>
                        </table></td>
                        <td><div align="right"><span class="STYLE1">
              <a href="<?php echo U('tianjia');?>"><img src="<?php echo C('AD_IMG_URL');?>add.gif" width="10" height="10" /> 添加</a>   &nbsp;
              </span>
                            <span class="STYLE1"> &nbsp;</span></div></td>
                    </tr>
                </table></td>
            </tr>
        </table></td>
    </tr>
    <tr>
        <td><table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#a8c7ce">
            <tr>
                <td width="4%" height="20" bgcolor="d3eaef" class="STYLE10"><div align="center">
                    <input type="checkbox" name="checkbox" id="checkbox" />
                </div></td>
                <td width="5%" height="20" bgcolor="d3eaef" class="STYLE6"><div align="center"><span class="STYLE10">角色id</span></div></td>
                <td width="10%" height="20" bgcolor="d3eaef" class="STYLE6"><div align="center"><span class="STYLE10">名称</span></div></td>
                <td width="10%" height="20" bgcolor="d3eaef" class="STYLE6"><div align="center"><span class="STYLE10">权限ids</span></div></td>
                <td width="30%" height="20" bgcolor="d3eaef" class="STYLE6"><div align="center"><span class="STYLE10">权限ac</span></div></td>
                <td width="*" height="20" bgcolor="d3eaef" class="STYLE6"><div align="center"><span class="STYLE10">基本操作</span></div></td>
            </tr>
            <?php if(is_array($info["list"])): foreach($info["list"] as $key=>$v): ?><tr>
                    <td height="20" bgcolor="#FFFFFF"><div align="center">
                        <input type="checkbox" name="checkbox2" id="checkbox2" />
                    </div></td>
                    <td height="20" bgcolor="#FFFFFF" class="STYLE6"><div align="center"><span class="STYLE19"><?php echo ($v["role_id"]); ?></span></div></td>
                    <td height="20" bgcolor="#FFFFFF" class="STYLE19"><div align="center"><?php echo ($v["role_name"]); ?></div></td>
                    <td height="20" bgcolor="#FFFFFF" class="STYLE19"><div align="center"><?php echo ($v["role_auth_ids"]); ?></div></td>
                    <td height="20" bgcolor="#FFFFFF" class="STYLE19"><div align="center"><?php echo ($v["role_auth_ac"]); ?></div></td>
                    <td height="20" bgcolor="#FFFFFF"><div align="center" class="STYLE21">
                        <a href="<?php echo U('distribute',array('role_id'=>$v['role_id']));?>" style="color:rgb(59,99,117)">分配权限 |</a>
                        <img src="<?php echo C('AD_IMG_URL');?>del.gif" width="10" height="10" /> <a href="<?php echo U('delete',array('role_id'=>$v['role_id']));?>" style="color:rgb(59,99,117)">删除</a> | 查看 | <a href="<?php echo U('upd',array('role_id'=>$v['role_id']));?>" style="color:rgb(59,99,117)"><img src="<?php echo C('AD_IMG_URL');?>edit.gif" width="10" height="10" /> 编辑</a></div></td>
                </tr><?php endforeach; endif; ?>
        </table></td>
    </tr>
    <tr>
        <td height="30"><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td width="33%"><div align="left"><span class="STYLE22">&nbsp;&nbsp;&nbsp;&nbsp;共有<strong><?php echo ($info['page']->totalRows); ?></strong> 条记录，当前第<strong> <?php echo ($info['page']->nowPage); ?></strong> 页，共 <strong><?php echo ($info['page']->totalPages); ?></strong> 页</span></div></td>
                <td width="67%"><table width="312" border="0" align="right" cellpadding="0" cellspacing="0">
                    <tr>
                        <?php echo ($data["show"]); ?>
                    </tr>
                </table></td>
            </tr>
        </table></td>
    </tr>
</table>
</body>
</html>