<?php
//将作为预定，改变座位状态 如果是free，则变成reserved,如果被其他user reserved，则被此操作用户提示reserved
$_POST = array();

$user_id=$_POST["user_id"];
$row_no=(int)$_POST["row"];
$column_no=(int)$_POST["column"];
//获得参数
session_start();
$currentUser = $_SESSION["username"];
if(isset($_SESSION['expiretime'])) {
    if($_SESSION['expiretime'] < time()) {
        unset($_SESSION['expiretime']);
        //header('Location: logout.php?TIMEOUT');
        echo "timeout";
        exit;
    }
    else {
        $_SESSION['expiretime'] = time() + 120;
    }
}
else {
    $_SESSION['expiretime'] = time() + 120;
}
$conn=new mysqli("127.0.0.1","root","","mysql");
$result=$conn->query("select * from ticket_status where row='$row_no' and `column`='$column_no'");
$status=null;
$query_userid = null;
if($result){
    while($row=mysqli_fetch_array($result))
    {
        $status=$row["status"];
        $query_userid=$row["user_id"];
    }
}
if($status =='purchase')//如果座位已被别人购买，则不能预定
{
    echo "error";
    return;
}
//如果座位被其他用户预订，或者之前没有被预订过，则更新为此reserved状态为此用户
if($user_id!=$query_userid){
    $sql="UPDATE ticket_status SET status='reserved',user_id='$user_id' where row='$row_no' and `column`='$column_no'";
    $result=$conn->query($sql);
    $conn->close();
    if($result)
    {
        echo "success";
    }
    else echo "error";
}
//如果座位已经被当前用户预定，则释放座位，状态改为free
//如果座位被其他用户预订，或者之前没有被预订过，则更新为此reserved状态为此用户
else if($user_id==$query_userid && $status=='reserved'){
    $sql="UPDATE ticket_status SET status='free',user_id=NULL where row='$row_no' and `column`='$column_no'";
    $result=$conn->query($sql);
    $conn->close();
    if($result)
    {
        echo "success";
    }
    else echo"error";
}
?>