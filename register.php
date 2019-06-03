<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title>register_back</title>
</head>
<body>
<?php
session_start();
$user_name=$_REQUEST["user_name"];
$password=md5($_REQUEST["password"]);

$conn=new mysqli("127.0.0.1","root","","mysql");
if(!$conn)
{
    die('connection_error'.$mysql_error());
}
$dbuser_name=null;
$dbpwd=null;
$result=$conn->query("select * from user_name_pwd where user_name='$user_name'");
while($row=mysqli_fetch_array($result))
{
    $dbuser_name=$row["user_name"];
    $dbpwd=$row["password"];
}
if(!is_null($dbuser_name)){
    ?>
<script type="text/javascript">
    alert("user has already exist ");
    window.location.href="register.html";
</script>
<?php
}
else {
    $conn->query("insert into user_name_pwd values('$user_name','$password',NULL)") or die("insert into db error" . mysqli_error());
}
$conn->close();
?>
<script type="text/javascript">
    alert("register success!");
    window.location.href="add_user.html";
    </script>
</body>
    </html>
