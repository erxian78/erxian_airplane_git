<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title>seat_php</title>
</head>
<body>
<?php
$row=$_REQUEST["row"];
$column=$_REQUEST["column"];
$conn=new mysqli("127.0.0.1","root","","mysql");
if(!$conn)
{
    die('connection_error'.$mysql_error());
}
//查找座位状态
$result=$conn->query("select * from ticket_status where row='$row' and column ='$column'");
$status=null;
while($row=mysqli_fetch_array($result))
{
    $status=$row["status"];
}
$conn->close();

//改变座位状态 如果是free，则变成reserved，如果不是free，则提示失败
$user_id=$_REQUEST["user_id"];
$row=$_REQUEST["row"];
$column=$_REQUEST["column"];
$conn=new mysqli("127.0.0.1","root","","mysql");
$result=$conn->query("select * from ticket_status where row='$row' and column ='$column'");
$status=null;
while($row=mysqli_fetch_array($result))
{
    $status=$row["status"];
}
if($status=='purchase')//如果座位已被别人购买，则不能预定
{?>
<script type="text/javascript">
    alert("the seat has been purchased!choose another one!");
    window.location.href="main.html";
</script>
<?php
}
else{
    $sql='UPDATE ticket_status SET status="purchased",user_id=$user_id where row=$row and column=$column ';
    $result=$conn->query($sql);
    $conn->close();
    if(! $result )
    {?>
<script type="text/javascript">
    alert("change status failed!");
    window.location.href="main.html";
</script>
<?php
    }?>
<script type="text/javascript">
    alert("change status success!");
    window.location.href="main.html";
</script>
<?php
}
?>
</body>
</html>
