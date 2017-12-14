<?php
return array(
//    //Alipay
//    'APLIPAY_CONF'=>array(
//        'app_id'=>'2088102125505878',
//        'private_key'=>'6di2oz84nz4n4e7mm3hlb3pxnxfxl9pu',
//    ),
	//'配置项'=>'配置值'
    'URL_MODEL'=>2, //将URL模式改为2

    //配置默认静态文件后缀：
    'HTML_FILE_SUFFIX'  => '.html',

    //开启数据获取时自动处理
    'READ_DATA_MAP'=>true,

    'DEFAULT_MODULE' => 'Home',
    //定义我们当前全部的'分组列表'信息
    'MODULE_ALLOW_LIST' => array('Home', 'Admin'),
    //给页面底部设置跟踪信息trace
    'SHOW_PAGE_TRACE' => true,

    //设置配置环境变量
    'PLUGIN_URL'=>'/Application/Common/Plugin/',
    //HOME前台
    'CSS_URL'=>'/Public/Home/style/',
    'JS_URL'=>'/Public/Home/js/',
    'IMG_URL'=>'/Public/Home/images/',
    //Admin后台
    'AD_CSS_URL'=>'/Public/Admin/css/',
    'AD_JS_URL'=>'/Public/Admin/js/',
    'AD_IMG_URL'=>'/Public/Admin/images/',
    'LAY_URL'=>'/Public/layer/',

    /*数据库配置*/
    'DB_TYPE'=>'mysql',
    'DB_HOST'=>'127.0.0.1',
    'DB_NAME'=>'itshop',
    'DB_USER'=>'root',
    'DB_PWD'=>'root',
    'DB_PORT'=>3306,
    'DB_PREFIX'=>'sp_',


    //短信验证账号和令牌配置
    'ACCOUNT_SID'   =>  '8a216da85d158d1b015d3ebb58ef118a',
    'ACCOUNT_TOKEN' =>  '04f3d7c353164844bcf190bd99b96e58',
    'APP_ID'        =>  '8a216da85d158d1b015d3ebb5a4c1190',

    //微博oAuth配置
    "WB_AKEY"       =>  '146188775',
    "WB_SKEY"       => 'eb875a9abbae98575548ed47090dec98',
    "SITE"          => 'http://www.jx.com',
    //"WB_CALLBACK_URL" => 'http://www.jx.com/index.php/home/user/sinaLoginCallback',
);