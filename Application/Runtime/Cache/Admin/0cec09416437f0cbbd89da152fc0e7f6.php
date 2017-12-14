<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>无标题文档</title>
    <script src="<?php echo C('AD_JS_URL');?>jquery-1.8.3.min.js"></script>
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

        .STYLE6 {
            color: #000000;
            font-size: 12px;
        }

        .STYLE10 {
            color: #000000;
            font-size: 12px;
        }

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

        a:link {
            color: #e1e2e3;
            text-decoration: none;
        }

        a:visited {
            color: #e1e2e3;
            text-decoration: none;
        }

        -->
    </style>
    <style>
        .Pagination a:hover, .current {
            background-color: #f54281;
            border: 1px solid #f54281;
            color: #ffffff;
        }

        .Pagination {
            float: right;
            height: auto;
            _height: 45px;
            line-height: 20px;
            margin-right: 15px;
            _margin-right: 5px;
            color: #565656;
            margin-top: 10px;
            _margin-top: 20px;
            clear: both;
        }

        .Pagination a, .Pagination span {
            font-size: 5px;
            text-decoration: none;
            display: block;
            float: left;
            color: #565656;
            border: 1px solid #ccc;
            height: 34px;
            line-height: 34px;
            margin: 0 2px;
            width: 40px;
            text-align: center;
        }
    </style>
    <script>
        //声明变量，用于缓存ajax缓存信息
        var attr_info_cache = new Array();
        function show_attr_info() {
            var type_id = $('#type_id').val();
            //判断缓存变量是否有需要的缓存信息
            if (typeof attr_info_cache[type_id] === 'undefined') {
                //使用ajax去服务端获得指定type_id类型所对应的属性列表信息
                $.ajax({
                    url: '/Admin/Attribute/getAttrInfoByType',
                    data: {'type_id': type_id},
                    dataType: 'json',
                    cache: '',
                    type: 'get',
                    async: false,
                    success: function (msg) {
                        var s = "";
                        $.each(msg, function (n, v) {
                            s += '<tr><td height="20" bgcolor="#FFFFFF"><div align="center"><input type="checkbox" name="checkbox2" id="checkbox2" /></div></td><td height="20" bgcolor="#FFFFFF" class="STYLE6"><div align="center"><span class="STYLE19">';
                            s += v.attr_id;
                            s += '</span></div></td><td height="20" bgcolor="#FFFFFF" class="STYLE6"><div align="center"><span class="STYLE10">';
                            s += v.attr_name;
                            s += '</span></div></td><td height="20" bgcolor="#FFFFFF" class="STYLE6"><div align="center"><span class="STYLE10">';
                            s += v.type_name;
                            s += '</span></div></td><td height="20" bgcolor="#FFFFFF" class="STYLE6"><div align="center"><span class="STYLE10">';
                            s += v.attr_sel == 'only' ? "唯一属性" : '单选属性';
                            s += '</span></div></td><td height="20" bgcolor="#FFFFFF" class="STYLE6"><div align="center"><span class="STYLE10">';
                            s += v.attr_write == 'manual' ? '手工' : '列表选取';
                            s += '</span></div></td><td height="20" bgcolor="#FFFFFF" class="STYLE6"><div align="center"><span class="STYLE10">';
                            s += v.attr_vals;
                            s += '</span></div></td><td height="20" bgcolor="#FFFFFF"><div align="center" class="STYLE21"><img src="<?php echo C('AD_IMG_URL');?>del.gif" width="10" height="10" /> <a href="<?php echo U('del',array('attr_id'=>$v['attr_id']));?>" style="color:rgb(59,99,117)" onclick="return confirm(\'确认删除？\')">删除</a> | 查看 | <a href="<?php echo U('upd',array('attr_id'=>$v['attr_id']));?>" style="color:rgb(59,99,117)"><img src="<?php echo C('AD_IMG_URL');?>edit.gif" width="10" height="10" /> 编辑</a></div></td></tr>';
                            attr_info_cache[type_id] = s;
                        })

                    }
                })

            }
            $('#attr_show tr:gt(1)').remove();
            $('#attr_show').append(attr_info_cache[type_id]);
        }
    </script>
</head>
<body>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
        <td height="30">
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td height="24" bgcolor="#353c44">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                                <td>
                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                        <tr>
                                            <td width="6%" height="19" valign="bottom">
                                                <div align="center"><img src="<?php echo C('AD_IMG_URL');?>tb.gif" width="14"
                                                                         height="14"/></div>
                                            </td>
                                            <td width="94%" valign="bottom"><span class="STYLE1"> 属性管理 -> 属性列表</span>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                                <td>
                                    <div align="right"><span class="STYLE1">
              <a href="<?php echo U('tianjia');?>"><img src="<?php echo C('AD_IMG_URL');?>add.gif" width="10" height="10"/> 添加</a>   &nbsp;
              </span>
                                        <span class="STYLE1"> &nbsp;</span></div>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td>
            <table id="attr_show" width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#a8c7ce">
                <tr>
                    <td height="20" bgcolor="#FFFFFF">
                        <div align="center"><select id="type_id" onchange="show_attr_info()">
                            <option value="0">-全部显示-</option>
                            <?php if(is_array($typeinfo)): foreach($typeinfo as $key=>$v): ?><option value="<?php echo ($v["type_id"]); ?>"><?php echo ($v["type_name"]); ?></option><?php endforeach; endif; ?>
                        </select>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td width="4%" height="20" bgcolor="d3eaef" class="STYLE10">
                        <div align="center">
                            <input type="checkbox" name="checkbox" id="checkbox"/>
                        </div>
                    </td>
                    <td width="10%" height="20" bgcolor="d3eaef" class="STYLE6">
                        <div align="center"><span class="STYLE10">属性id</span></div>
                    </td>
                    <td width="10%" height="20" bgcolor="d3eaef" class="STYLE6">
                        <div align="center"><span class="STYLE10">名称</span></div>
                    </td>
                    <td width="10%" height="20" bgcolor="d3eaef" class="STYLE6">
                        <div align="center"><span class="STYLE10">商品类型</span></div>
                    </td>
                    <td width="10%" height="20" bgcolor="d3eaef" class="STYLE6">
                        <div align="center"><span class="STYLE10">是否可选</span></div>
                    </td>
                    <td width="10%" height="20" bgcolor="d3eaef" class="STYLE6">
                        <div align="center"><span class="STYLE10">录入方式</span></div>
                    </td>
                    <td width="20%" height="20" bgcolor="d3eaef" class="STYLE6">
                        <div align="center"><span class="STYLE10">可选值列表</span></div>
                    </td>
                    <td width="*" height="20" bgcolor="d3eaef" class="STYLE6">
                        <div align="center"><span class="STYLE10">基本操作</span></div>
                    </td>
                </tr>
                <?php if(is_array($info)): foreach($info as $key=>$v): ?><tr>
                        <td height="20" bgcolor="#FFFFFF">
                            <div align="center">
                                <input type="checkbox" name="checkbox2" id="checkbox2"/>
                            </div>
                        </td>
                        <td height="20" bgcolor="#FFFFFF" class="STYLE6">
                            <div align="center"><span class="STYLE19"><?php echo ($v["attr_id"]); ?></span></div>
                        </td>
                        <td height="20" bgcolor="#FFFFFF" class="STYLE6">
                            <div align="center"><span class="STYLE19"><?php echo ($v["attr_name"]); ?></span></div>
                        </td>
                        <td height="20" bgcolor="#FFFFFF" class="STYLE6">
                            <div align="center"><span class="STYLE19"><?php echo ($v["type_name"]); ?></span></div>
                        </td>
                        <td height="20" bgcolor="#FFFFFF" class="STYLE6">
                            <div align="center"><span class="STYLE19"><?php echo ($v['attr_sel']=='only' ? '唯一属性':'单选属性'); ?></span>
                            </div>
                        </td>
                        <td height="20" bgcolor="#FFFFFF" class="STYLE6">
                            <div align="center"><span class="STYLE19"><?php echo ($v['attr_write']=='manual'?'手工':'列表选取'); ?></span>
                            </div>
                        </td>
                        <td height="20" bgcolor="#FFFFFF" class="STYLE6">
                            <div align="center"><span class="STYLE19"><?php echo ($v["attr_vals"]); ?></span></div>
                        </td>
                        <td height="20" bgcolor="#FFFFFF">
                            <div align="center" class="STYLE21">
                                <img src="<?php echo C('AD_IMG_URL');?>del.gif" width="10" height="10"/> <a
                                    href="<?php echo U('del',array('attr_id'=>$v['attr_id']));?>" style="color:rgb(59,99,117)"
                                    onclick="return confirm('确认删除？')">删除</a> | 查看 | <a
                                    href="<?php echo U('upd',array('attr_id'=>$v['attr_id']));?>" style="color:rgb(59,99,117)"><img
                                    src="<?php echo C('AD_IMG_URL');?>edit.gif" width="10" height="10"/> 编辑</a></div>
                        </td>
                    </tr><?php endforeach; endif; ?>
            </table>
        </td>
    </tr>
</table>
</body>
</html>