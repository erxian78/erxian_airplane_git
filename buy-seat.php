<?php
if($_SERVER["HTTPS"] != "on")
{
    header("Location: https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]);
    exit();
}
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
if ('POST' == $_SERVER['REQUEST_METHOD']) {
    parse_str(file_get_contents('php://input'), $_POST);
}
$user_id=check_input($_POST["user_id"]);
$reserved_num=check_input((int)$_POST["reserved_num"]);
//$user_id=$_POST["user_id"];
//$reserved_num=(int)$_POST["reserved_num"];
global $conn;
$conn= new mysqli("localhost", "s261423", "subgreds", "s261423");
//$conn = new mysqli("127.0.0.1", "root", "", "airplane");

if(!$conn)
{
    die('connection_error'.mysqli_error());
}
//
try{
    $conn->autocommit(false);
    $result=$conn->query("select * from ticket_status where user_id='$user_id' and status='reserved' for update ");
    if($result) {
        $row=mysqli_fetch_array($result);
        $cnt = mysqli_num_rows($result);
    }
    if($cnt!=$reserved_num)
    {
        $result=$conn->query("UPDATE ticket_status SET status='free',user_id=NULL where status='reserved' and user_id='$user_id'");
        echo "buying_by_other";
        $conn->commit();
        $conn->close();
        return;
    }
    $result=$conn->query("UPDATE ticket_status SET status='purchase' where user_id='$user_id' and status='reserved'");
    if($result)
    {
        echo "success";
    }
    else echo"error";
    $conn->commit();
    $conn->close();
}catch (Exception $e){
    $conn->rollback();
    $conn->close();
    echo "error";
}
function check_input($value)
{
    //$conn= new mysqli("localhost", "s261423", "subgreds", "s261423");
    $value = strip_tags($value);
    $value = htmlentities($value);
    // remove slash
    if (get_magic_quotes_gpc())
    {
        $value = stripslashes($value);
    }
// add '' on string
    if (!is_numeric($value))
    {
        $value =mysqli_real_escape_string($GLOBALS['conn'],$value);
    }
    return $value;
}
?>

