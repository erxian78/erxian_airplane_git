<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>login-add</title>
</head>
<body>
<?php

$user_name=$_REQUEST["user_name"];
$password=md5($_REQUEST["password"]);
$conn=new mysqli("127.0.0.1","root","","mysql");
if(!$conn)
{
    die('connection_error'.mysql_error());
}
$dbusername=null;
$dbpassword=null;
$result=$conn->query("select * from user_name_pwd where user_name='$user_name';");//查出对应用户名的信息
 while ($row=mysqli_fetch_array($result)) {//while循环将$result中的结果找出来
 $dbusername=$row["user_name"];
 $dbpassword=$row["password"];
 }
 if (mysqli_num_rows($result)==0) {//用户名在数据库中不存在时跳回add_user.html界面
 ?>
 <script type="text/javascript">
 alert("user does not exist");
 window.location.href="add_user.html";
 </script>
 <?php
 }
 else {
 if ($dbpassword!=$password){//当对应密码不对时跳回add_user.html界面
 ?>
 <script type="text/javascript">
 alert("password error");
 window.location.href="add_user.html";
 </script>
 <?php
 }
 else {
 $lifeTime = 2 * 60;
 session_set_cookie_params($lifeTime);
 session_start();
 $_SESSION["username"]=$dbusername;
 $_SESSION["code"]=mt_rand(0, 100000);//给session附一个随机值，防止用户直接通过调用界面访问welcome.php

 ?>
 <script type="text/javascript">
 window.location.href="main.html";
 </script>
 <?php
 }
 }
 $conn->close();//关闭数据库连接，如不关闭，下次连接时会出错
 ?>
</body>
</html>