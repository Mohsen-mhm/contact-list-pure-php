<?php
session_start();
if(!isset($_SESSION["username"])){
header("Location: ./pages/login/login.php");
exit(); }
?>