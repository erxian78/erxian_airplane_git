<?php
if($_SERVER["HTTPS"] != "on")
{
    header("Location: https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]);
    exit();
}
session_start();
if(isset($_SESSION['username'])) {
    $currentUser = $_SESSION["username"];
    if (isset($_SESSION['expiretime'])) {
        if ($_SESSION['expiretime'] < time()) {
            unset($_SESSION['expiretime']);
            echo "timeout";
            session_destroy();
            exit;
        } else {
            $_SESSION['expiretime'] = time() + 120;
        }
    } else {
        $_SESSION['expiretime'] = time() + 120;
    }
}
echo "success";
?>