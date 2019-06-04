<?php
if(isset($_GET["row"])){
    $row=$_GET["row"];
}
if(isset($_GET["column"])){
    $column=$_GET["column"];
}
$conn=new mysqli("127.0.0.1","root","123456","airplane");
if(!$conn)
{
    die('connection_error'.mysql_error());
}
//查找座位状态
$result=$conn->query("select * from ticket_status");
$status=null;
if($result) {
    $data = array();
    while($row=mysqli_fetch_array($result))
    {
        $data[] = $row["C1"];
    }
}

//各种状态的座位的count
$purchaseResult = $conn -> query("SELECT COUNT(*) AS total FROM ticket_status WHERE C1=\"purchase\"");
$reservedResult = $conn -> query("SELECT COUNT(*) AS total FROM ticket_status WHERE C1=\"reserved\"");
$freeResult = $conn -> query("SELECT COUNT(*) AS total FROM ticket_status WHERE C1=\"free\"");

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
echo json_encode($countResult);

$conn->close();
?>

