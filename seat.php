<?php

if(isset($_GET["row"])){
    $row=$_GET["row"];
}
if(isset($_GET["column"])){
    $column=$_GET["column"];
}
session_start();
if(isset($_SESSION['username'])) {
//    if($_SERVER["HTTPS"] != "on")
//    {
//        header("Location: https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]);
//        //exit();
//    }
    $currentUser = $_SESSION["username"];
    if (isset($_SESSION['expiretime'])) {
        if ($_SESSION['expiretime'] < time()) {
            unset($_SESSION['expiretime']);
            echo json_encode(["timeout" => true]);
            session_destroy();
            exit;
        } else {
            $_SESSION['expiretime'] = time() + 120;
        }
    } else {
        $_SESSION['expiretime'] = time() + 120;
    }
}

$conn=new mysqli("127.0.0.1","root","","mysql");
if(!$conn)
{
    die('connection_error'.mysqli_error());
}
//查找座位状态
$result=$conn->query("select status,case when user_id is NULL then -1 else user_id end AS user_id_no_null from ticket_status");
$status=null;
if($result) {
    $data = array();
    $user_id_array=array();
    while($row=mysqli_fetch_array($result))
    {
        $data[] = $row["status"];
        $user_id_array[] = $row["user_id_no_null"];
    }
}


//获得currentUser的user_id
if(isset($_SESSION['username'])) {
    $currentUserIdResult = $conn->query("SELECT *  FROM user_name_pwd WHERE user_name='$currentUser'");
    if ($currentUserIdResult) {
        $UserId = mysqli_fetch_array($currentUserIdResult);
        $countResult["currentUserId"] = $UserId['id'];
    }
}

//各种状态的座位的count
$purchaseResult = $conn -> query("SELECT COUNT(*) AS total FROM ticket_status WHERE status=\"purchase\"");
$reservedResult = $conn -> query("SELECT COUNT(*) AS total FROM ticket_status WHERE status=\"reserved\"");
$freeResult = $conn -> query("SELECT COUNT(*) AS total FROM ticket_status WHERE status=\"free\"");
$conn->close();

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
$countResult["results"] = $data;
$countResult["user_id"]= $user_id_array;
if(isset($_SESSION['username'])) {
    $countResult["currentUser"] = $currentUser;
}
echo json_encode($countResult);
?>

