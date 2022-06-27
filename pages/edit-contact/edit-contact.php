<?php
require('../../db.php');
include("../../auth.php");
$id = $_REQUEST['id'];
$query = "SELECT * from new_record where id='" . $id . "'";
$queryImg = "Select * from new_record ORDER BY id desc;";
$result = mysqli_query($con, $query) or die();
$resultImg = mysqli_query($con, $queryImg);
$row = mysqli_fetch_assoc($result);
$rowImg = mysqli_fetch_assoc($resultImg)
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
    <title>Edit Contact</title>
</head>

<body>
    <header class="container-fluid d-flex justify-content-center bg-light shadow p-3">
        <h3 class="m-2">Edit Contact</h3>
    </header>
    <?php
    if (isset($_POST['new']) && $_POST['new'] == 1) {

        $id = $_REQUEST['id'];
        $name = $_REQUEST['name'];
        $email = $_REQUEST['email'];
        $phone = $_REQUEST['phone'];
        $submittedby = $_SESSION["username"];
        $update = "update new_record set name='" . $name . "', email='" . $email . "',
        phone='" . $phone . "', submittedby='" . $submittedby . "' where id='" . $id . "'";
        mysqli_query($con, $update) or die();
        header("Location: ../../index.php");
    } else {
    ?>
        <div class="container mt-5">
            <form action="" method="post" id="edit-contact-form" enctype="multipart/form-data">
                <input type="hidden" name="new" value="1" />
                <input name="id" type="hidden" value="<?php echo $row['id']; ?>" />

                <div class="row">
                    <div class="col-md-12 d-flex justify-content-evenly align-items-center">
                        <div class="w-50 d-flex justify-content-evenly align-items-center">
                            <img src="<?php echo '../../img/' . $rowImg["email"] . '.png' ?>" alt="" class="w-25 rounded-circle">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group mt-3">
                            <label for="first-name">Avatar</label>
                            <input type="file" class="form-control" name="avatar" id="avatar">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group mt-3">
                            <label for="first-name">Name</label>
                            <input type="text" class="form-control" placeholder="Enter name" name="name" id="first-name" value="<?php echo $row['name']; ?>">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mt-3">
                            <label for="email">Email address</label>
                            <input type="email" class="form-control" placeholder="Enter email" name="email" id="email" value="<?php echo $row['email']; ?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mt-3">
                            <label for="phone-number">Phone Number</label>
                            <input type="tel" class="form-control" placeholder="Enter phone number" name="phone" id="phone-number" value="<?php echo $row['phone']; ?>">
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-success mt-3 mb-5">Accept changes</button>
                <a href="../../index.php" class="btn btn-danger mt-3 mb-5">Cancel</a>
            </form>
        <?php } ?>
        </div>

        <script src="../../vendor/bootstrap/bootstrap-js/bootstrap.bundle.min.js"></script>
        <script src="../../vendor/jquery/jquery-3.6.0.min.js"></script>
</body>

</html>