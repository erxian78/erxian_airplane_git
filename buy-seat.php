<?php
session_start();
if(isset($_SESSION['expiretime'])) {
    if($_SESSION['expiretime'] < time()) {
        unset($_SESSION['expiretime']);
        //header('Location: logout.php?TIMEOUT');
        echo "timeout";
        session_destroy();
        exit;
    } else {
        $_SESSION['expiretime'] = time() + 120;
    }
}
else {
    $_SESSION['expiretime'] = time() + 120;
}
$_POST = array();
$user_id=$_POST["user_id"];
$reserved_num=(int)$_POST["reserved_num"];
$conn=new mysqli("127.0.0.1","root","","mysql");
if(!$conn)
{
    die('connection_error'.mysqli_error());
}
//
$result=$conn->query("select count(*)  as cnt from ticket_status where user_id='$user_id' and status='reserved'");
if($result) {
    $row=mysqli_fetch_array($result);
    $cnt = $row["cnt"];
}

if($cnt!=$reserved_num)
{
    $result=$conn->query("UPDATE ticket_status SET status='free',user_id=NULL where status='reserved' and user_id='$user_id'");
    echo "buying_by_other";
    $conn->close();
    return;
}
$result=$conn->query("UPDATE ticket_status SET status='purchase' where user_id='$user_id' and status='reserved'");
if($result)
{
    echo "success";
}
else echo"error";

$conn->close();
?>