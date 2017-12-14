<?php
try{
    $pdo = new PDO('mysql:host=localhost;dbname=itshop','root','root');
    $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    $pdo->query('set names utf8');
    $sql = "select * from sp_goods order by goods_id desc";
    $state = $pdo->query($sql);
}catch(PDOException $e){
    echo $e->getCode().':'.$e->getMessage();
}
while($row = $state->fetch(PDO::FETCH_ASSOC)){
    $pic = substr($row['goods_small_logo'],1);
    $pic = "http://www.jx.com/".$pic;
    ob_start();
    echo <<<eof
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8" />
        <title>Document</title>
    </head>
    <body>
        <h2>详情展示</h2>
        <p>名称：{$row['goods_name']}</p>
        <p>价格：{$row['goods_price']}</p>
        <p>数量：{$row['goods_number']}</p>
        <p>重量：{$row['goods_weight']}</p>
        <p>图片：<img src="{$pic}" alt="" /></p>
        <p>详情介绍：{$row['goods_introduce']}</p>
    </body>
    </html>
eof;
$content = ob_get_clean();
file_put_contents('./goods/'.$row['goods_id'].'_show.html',$content);
}