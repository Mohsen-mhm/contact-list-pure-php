<?php
require('../../db.php');
include("../../auth.php");

if (isset($_POST['new']) && $_POST['new'] == 1) {
    $name = $_REQUEST['name'];
    $email = $_REQUEST['email'];
    $phone = $_REQUEST['phone'];
    $submittedby = $_SESSION["username"];
    $ins_query = "insert into new_record
    (`name`,`email`,`phone`,`submittedby`)values
    ('$name','$email','$phone','$submittedby')";
    mysqli_query($con, $ins_query) or die();
    header("Location: ../../index.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../vendor/bootstrap/bootstrap-css/bootstrap.min.css">
    <link rel="stylesheet" href="../../font/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="../../font/fontawesome/css/fontawesome.min.css">
    <title>Add Contact</title>
</head>

<body>
    <header class="container-fluid d-flex justify-content-center bg-light shadow p-3">
        <h3 class="m-2">Add Contact</h3>
    </header>
    <div class="container mt-5">
        <form action="" method="post" id="add-contact-form">
            <input type="hidden" name="new" value="1" />

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group mt-3">
                        <label for="first-name">Name</label>
                        <input type="text" class="form-control" placeholder="Mohsen" name="name" id="first-name">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group mt-3">
                        <label for="email">Email address</label>
                        <input type="email" class="form-control" placeholder="example@gmail.com" name="email" id="email">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group mt-3">
                        <label for="phone-number">Phone Number</label>
                        <input type="tel" class="form-control" placeholder="+989123456789" name="phone" id="phone-number">
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-success mt-3 mb-5">Add to list</button>
            <a href="../../index.php" class="btn btn-secondary mt-3 mb-5">Back</a>
        </form>
    </div>

    <script src="../../vendor/bootstrap/bootstrap-js/bootstrap.bundle.min.js"></script>
    <script src="../../vendor/jquery/jquery-3.6.0.min.js"></script>
</body>

</html>