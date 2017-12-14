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
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Document</title>
    <style>
        table{width:500px;border-collapse:collapse;}
    </style>
</head>
<body
    <table border="1">
        <tr>
            <td>商品ID</td>
            <td>名称</td>
            <td>价格</td>
            <td>数量</td>
            <td>操作</td>
        </tr>
        <?php
            while($rst = $state->fetch(PDO::FETCH_ASSOC)){
                echo "<tr>";
                echo "<td>".$rst['goods_id']."</td>";
                echo "<td>".$rst['goods_name']."</td>";
                echo "<td>".$rst['goods_price']."</td>";
                echo "<td>".$rst['goods_number']."</td>";
                echo "<td><a href='./goods/".$rst['goods_id']."_show.html' target='_blank'>查看详情</a>&nbsp;&nbsp;<a href='makehtml.php'>生成静态页面</a></td>";
                echo "</tr>";
            }
        ?>
    </table>
</body>
</html>