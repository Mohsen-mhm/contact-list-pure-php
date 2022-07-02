<?php
require('db.php');
include("auth.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="vendor/bootstrap/bootstrap-css/bootstrap.min.css">
    <link rel="stylesheet" href="font/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="font/fontawesome/css/fontawesome.min.css">
    <link rel="stylesheet" href="styles/main.css">
    <title>Contact List</title>
</head>

<body>
    <header class="container-fluid d-flex justify-content-between align-items-center bg-light shadow p-3">
        <h3 class="m-2">Contact List</h3>
        <div class="form d-flex flex-column justify-content-between align-items-center">
            <p>Welcome <?php echo $_SESSION['username']; ?>!</p>
            <a href="./pages/login/login.php">Logout</a>
        </div>
    </header>
    <main class="container-fluid">
        <h4 class="text-center mt-4">All Contacts</h4>
        <div class="row mt-3 d-flex justify-content-center align-items-center responsive-header">
            <div class="col-7 d-flex justify-content-between align-items-center responsive-header-one">
                <div class="row d-flex justify-content-evenly align-items-center w-100 p-3">
                    <div class="col-sm-9 col-lg-10 col-xl-9 d-flex justify-content-center align-items-center w-50">
                        <label class="form-label w-50 text-center" for="sort-select">Sort by:</label>
                        <select class="form-select w-50 border-0 mb-2" name="sort-select" id="sort-select">
                            <option value="name">Name</option>
                            <option value="time">Time</option>
                            <option value="type">Type</option>
                        </select>
                    </div>
                    <?php
                    $count_contact_query = "SELECT COUNT(`submittedby`) FROM `records` WHERE `submittedby` = '$_SESSION[username]';";
                    $result_number = mysqli_query($con, $count_contact_query);
                    $num = mysqli_fetch_assoc($result_number);
                    ?>
                    <p class="col-sm-3 col-lg-2 col-xl-3 text-center mt-2 w-50">Contacts Number: <b class="contact-number"><?php echo $num['COUNT(`submittedby`)'] ?></b></p>
                </div>
            </div>
            <div class="col-5 d-flex justify-content-evenly align-items-center responsive-header-two">
                <input type="search" class="form-control w-50 filter-search" placeholder="Search...">
                <a href="./pages/add-contact/add-contact.php" class="d-flex align-items-center btn btn-success add-contact-btn">Add Contact <i class="fas fa-plus ms-2"></i></a>
            </div>
        </div>
        <table class="table table-bordered table-striped table-responsive-stack" id="tableOne">
            <thead class="thead-dark">
                <tr>
                    <th class="text-center">Number</th>
                    <th class="text-center">Avatar</th>
                    <th class="text-center">Name</th>
                    <th class="text-center">Email</th>
                    <th class="text-center">Phone Number</th>
                    <th class="text-center">Options</th>
                </tr>
            </thead>
            <tbody class="contact-list-body list-wrapper">
                <?php

                $count = 1;
                $sel_query = "Select * from records WHERE submittedby = '$_SESSION[username]';";
                $result = mysqli_query($con, $sel_query);

                $results_per_page = 10;
                $number_of_result = mysqli_num_rows($result);
                $number_of_page = (int) ceil($number_of_result / $results_per_page);
                if (!isset($_GET['page'])) {
                    $page = 1;
                } else {
                    $page = $_GET['page'];
                }

                $page_first_result = ($page - 1) * $results_per_page;
                $query = "SELECT * FROM records WHERE submittedby = '$_SESSION[username]' LIMIT " . $page_first_result . ',' . $results_per_page;
                $result = mysqli_query($con, $query);

                while ($row = mysqli_fetch_assoc($result)) {
                    $image = $row['avatar'];
                    $image_src = "img/" . $image;
                ?>
                    <tr class="list-item">
                        <td class="text-center"><b><?php echo $count; ?></b></td>
                        <td class="text-center">
                            <div class="w-100">
                                <img src="<?php echo $image_src; ?>" alt="" class="rounded-circle" style="width: 45px;">
                            </div>
                        </td>
                        <td class="text-center"><?php echo $row["name"]; ?></td>
                        <td class="text-center table-responsive"><?php echo $row["email"]; ?></td>
                        <td class="text-center table-responsive"><?php echo $row["phone"]; ?></td>
                        <td class="text-center">
                            <a href="./pages/edit-contact/edit-contact.php?id=<?php echo $row["id"]; ?>"><i class="far fa-edit p-2 btn btn-primary"></i></a>
                            <a href="./pages/delete/delete.php?id=<?php echo $row["id"]; ?>"><i class="far fa-trash p-2 btn btn-danger"></i></a>
                        </td>
                    </tr>
                <?php
                    $count++;
                } ?>
            </tbody>
        </table>
        <nav class="d-flex justify-content-center align-items-center">
            <ul class="pagination justify-content-center">
                <?php
                if ($page >= 2) {
                    echo '
                        <li class="page-item">
                            <a class="page-link" href="index.php?page=1">1</a>
                        </li>';
                }
                if ($page >= 3) {
                    echo '
                        <li class="page-item" disabled>
                            <a class="page-link">...</a>
                        </li>';
                }
                echo '
                        <li class="page-item">
                            <a class="page-link" href="index.php?page=' . $page . '">' . $page . ' </a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="index.php?page=' . $page + 1 . '">' . $page + 1 . ' </a>
                        </li>
                        <li class="page-item" disabled>
                            <a class="page-link">...</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="index.php?page=' . $number_of_page - 2 . '">' . $number_of_page - 2 . ' </a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="index.php?page=' . $number_of_page - 1 . '">' . $number_of_page - 1 . ' </a>
                        </li>';
                ?>
            </ul>
        </nav>
    </main>

    <script src="vendor/bootstrap/bootstrap-js/bootstrap.bundle.min.js"></script>
    <script src="vendor/jquery/jquery-3.6.0.min.js"></script>
    <script src="functions/app.js"></script>
</body>

</html>