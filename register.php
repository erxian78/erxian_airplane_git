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
if($_SERVER["HTTPS"] != "on")
{
    header("Location: https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]);
    exit();
}
$conn = new mysqli("localhost", "s261423", "subgreds", "s261423");
if(!$conn)
{
    die('connection_error'.mysqli_error());
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
    $conn->close();
    ?>
<script type="text/javascript">
    alert("user has already exist ");
    window.location.href="register.html";
</script>
<?php
}
else {
    $conn->query("insert into user_name_pwd values('$user_name','$password',NULL)") or die("insert into db error" . mysqli_error());
    $_SESSION["username"]=$user_name;
}
$conn->close();
?>
<script type="text/javascript">
    alert("register success!");
    window.location.href="index.php";
    </script>
</body>
    </html>
