<?php
if(isset($_GET["row"])){
    $row=$_GET["row"];
}
if(isset($_GET["column"])){
    $column=$_GET["column"];
}
session_start();
$currentUser = $_SESSION["username"];
$conn=new mysqli("127.0.0.1","root","","mysql");
if(!$conn)
{
    die('connection_error'.mysqli_error());
}
//查找座位状态
$result=$conn->query("select * from ticket_status");
$status=null;
if($result) {
    $data = array();
    while($row=mysqli_fetch_array($result))
    {
        $data[] = $row["status"];
    }
}
//user_id若为null,则改变成-1
$user_id_result=$conn->query("select case when user_id is NULL then -1 else user_id end AS user_id_no_null from ticket_status");
if($user_id_result) {
    $user_id_array=array();
    while($row=mysqli_fetch_array($user_id_result))
    {
        $user_id_array[] = $row["user_id_no_null"];
    }
}

//获得currentUser的user_id
$currentUserIdResult = $conn -> query("SELECT *  FROM user_name_pwd WHERE user_name='$currentUser'");
if($currentUserIdResult) {
    $UserId = mysqli_fetch_array($currentUserIdResult);
    $countResult["currentUserId"]=$UserId['id'];
}

//各种状态的座位的count
$purchaseResult = $conn -> query("SELECT COUNT(*) AS total FROM ticket_status WHERE status=\"purchased\"");
$reservedResult = $conn -> query("SELECT COUNT(*) AS total FROM ticket_status WHERE status=\"reserved\"");
$freeResult = $conn -> query("SELECT COUNT(*) AS total FROM ticket_status WHERE status=\"free\"");

if($purchaseResult){
    $purchaseCount = mysqli_fetch_array($purchaseResult);
    $countResult["purchase"] = $purchaseCount['total'];
}
if($reservedResult){
    $reservedCount = mysqli_fetch_array($reservedResult);
    $countResult["reserved"] = $reservedCount['total'];
}
if($freeResult){
    $freeCount = mysqli_fetch_array($freeResult);
    $countResult["free"] = $freeCount['total'];
}
$countResult["results"] = json_encode($data);
$countResult["user_id"]=json_encode($user_id_array);
$countResult["currentUser"] = $currentUser;
echo json_encode($countResult);

$conn->close();
?>

