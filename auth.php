<?php
session_start();
if (!isset($_SESSION["username"])) {
    header("Location: ./pages/login/login.php");
    session_set_cookie_params(10);
    exit();
}