<?php

session_start();
if(session_destroy()){
// Redirecting To Home Page
header("Location: ../login/login.php");
}

?>