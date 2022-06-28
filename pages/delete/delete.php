<?php
require('../../db.php');

$id = $_REQUEST['id'];
$query = "DELETE FROM records WHERE id = $id";
$result = mysqli_query($con, $query) or die();
header("Location: ../../index.php");