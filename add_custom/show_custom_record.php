<?php 
include ("../conn.php");
include ("../util.php");
utf8();
m2_login();

if (! isset($_GET['id']))
    die ("请输入学号");
$id = remove_unsafe_char ($_GET['id']);
if (! is_numeric($id))
    die ("学号一定要是数字");

$sql = "select * from add_custom_record where cid='$id'";
$result = mysql_query($sql,$db);
if (! $result)
    die ("查询消费记录失败<br/>" . mysql_error());
if (is_admin()): include ("../template/template.html"); 
else :
?>

<html>
    <head>
        <title>查询消费记录</title>
        <style type="text/css" media="screen">
            body{margin:0px; padding:0px; background:#f3f3f3; text-align:center;}
            #main {width:600px; background:white; margin:0 auto; margin-top:30px; padding:10px; text-align:center;}
            #main {-moz-border-radius: 10px; -webkit-border-radius: 10px; border-radius:10px; }
            td {border-bottom:1px dashed #ccc; padding:5px 25px; text-align:center;}
            ul {margin:0px; padding:0px;}
            ul li {float:left; list-style:none; margin-left:20px;}
            #nav {height: 20px; margin-top:20px;}
        </style>
    </head>
    <body>
    <div id="nav">
        <ul>
            <li>你好 <?php echo $_SESSION['user']; ?>!</li>
            <li><a href="showall_custom_record.php">管理</a></li>
            <li><a href="/update_password.php">修改密码</a></li>
            <li><a href="/logout.php">注销</a></li>
        </ul>
    </div>
<?php endif; ?>
        <div id="main">
        <h3>消费记录列表</h3>
        <p>消费者: <a href="../custom/search_custom.php?id=<?php echo $id; ?>"><?php $aa = mysql_fetch_row(mysql_query("select name from student where sid='$id'")); echo $aa[0];  ?></a></p>
        <table>
            <tr><th>序号</th><th>消费类型</th><th>金额</th><th>时间</th></tr>

<?php
    $n = 1;
    while ($row = mysql_fetch_array($result)){
        $temp = $row['operator']==1? "消费" : "充值";
        printf("<tr><td>%d</td><td>%s</td><td>%s</td><td>%s</td></tr>",$n,$temp,$row['money'],$row['add_time']);
        $n = $n + 1;
    }
    mysql_close($db);
?>
</table>
</div>
<?php include ("../template/tail.html"); ?>
