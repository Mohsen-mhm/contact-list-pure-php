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

    <?php
    $count = 1;
    function createDOM($count, $image_src, $result)
    {
    ?>
        <tr class="list-item">
            <td class="text-center"><b><?php echo $count; ?></b></td>
            <td class="text-center">
                <div class="w-100">
                    <img src="<?php echo $image_src; ?>" alt="" class="rounded-circle" style="width: 45px;">
                </div>
            </td>
            <td class="text-center"><?php echo $result["name"]; ?></td>
            <td class="text-center table-responsive"><?php echo $result["email"]; ?></td>
            <td class="text-center table-responsive"><?php echo $result["phone"]; ?></td>
            <td class="text-center">
                <a href="./pages/edit-contact/edit-contact.php?id=<?php echo $result["id"]; ?>"><i class="far fa-edit p-2 btn btn-primary"></i></a>
                <a href="./pages/delete/delete.php?id=<?php echo $result["id"]; ?>"><i class="far fa-trash p-2 btn btn-danger"></i></a>
            </td>
        </tr>
    <?php
    }
    ?>

    <main class="container-fluid">
        <h4 class="text-center mt-4">All Contacts</h4>
        <div class="row mt-3 d-flex justify-content-center align-items-center responsive-header">
            <div class="col-7 d-flex justify-content-between align-items-center responsive-header-one">
                <div class="row d-flex justify-content-evenly align-items-center w-100 p-3">
                    <form action="" class="col-sm-9 col-lg-10 col-xl-9 d-flex justify-content-around align-items-center w-50" method="get">
                        <input type="submit" class="btn btn-secondary w-25" value="Sort">
                        <select class="form-select w-50 border-0" name="sort-by" id="sort-select">
                            <option value="choose" disabled selected>Select</option>
                            <option value="name">Name</option>
                            <option value="email">Email</option>
                            <option value="phone">Phone</option>
                        </select>
                    </form>
                    <?php

                    $count_contact_query = "SELECT COUNT(`submittedby`) FROM `records` WHERE `submittedby` = '$_SESSION[username]';";
                    $result_number = mysqli_query($con, $count_contact_query);
                    $num = mysqli_fetch_assoc($result_number);
                    ?>
                    <p class="col-sm-3 col-lg-2 col-xl-3 text-center mt-2 w-50">Contacts Number: <b class="contact-number"><?php echo $num['COUNT(`submittedby`)'] ?></b></p>
                </div>
            </div>
            <div class="col-5 d-flex justify-content-evenly align-items-center responsive-header-two">
                <?php
                $search_str = '';
                ?>
                <form action="" method="get" class="w-50">
                    <?php
                    if (isset($_GET['search'])) {
                        $search_str = $_GET['search'];
                    }
                    ?>
                    <input type="search" class="form-control w-100" value="<?php echo $search_str; ?>" name="search" placeholder="Search name...">
                </form>
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

                if (isset($_GET['search'])) {
                    $search_str = $_GET['search'];
                    $results_per_sPage = 10;
                    $search_query = "SELECT * FROM `records` WHERE `name` LIKE '%$search_str%' OR `email` LIKE '%$search_str%' OR `phone` LIKE '%$search_str%';";
                    $search_result = mysqli_query($con, $search_query);

                    $number_of_result = mysqli_num_rows($search_result);
                    $number_of_sPage = (int) ceil($number_of_result / $results_per_sPage);

                    if (!isset($_GET['sPage'])) {
                        $sPage = 1;
                    } else {
                        $sPage = $_GET['sPage'];
                    }
                    $sPage_first_result = ($sPage - 1) * $results_per_sPage;

                    $search_query = "SELECT * FROM `records` WHERE `name` LIKE '%$search_str%' OR `email` LIKE '%$search_str%' OR `phone` LIKE '%$search_str%' LIMIT " . $sPage_first_result . ',' . $results_per_sPage;
                    $search_result = mysqli_query($con, $search_query);

                    while ($search = mysqli_fetch_assoc($search_result)) {
                        $image = $search['avatar'];
                        $image_src = "img/" . $image;
                        createDOM($count, $image_src, $search);
                        $count++;
                    }
                ?>
            </tbody>
        </table>
        <nav class="d-flex justify-content-center align-items-center mt-4 mb-3">
            <ul class="pagination justify-content-center">
                <?php
                    if ($sPage >= 2) {
                        echo '
                        <li class="page-item">
                            <a class="page-link" href="index.php?search=' . $search_str . '&sPage=1">1</a>
                        </li>';
                    }
                    if ($sPage >= 3) {
                        echo '
                        <li class="page-item" disabled>
                            <a class="page-link">...</a>
                        </li>';
                    }
                    echo '
                        <li class="page-item">
                            <a class="page-link" href="index.php?search=' . $search_str . '&sPage=' . $sPage . '">' . $sPage . ' </a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="index.php?search=' . $search_str . '&sPage=' . $sPage + 1 . '">' . $sPage + 1 . ' </a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="index.php?search=' . $search_str . '&sPage=' . $sPage + 2 . '">' . $sPage + 2 . ' </a>
                        </li>
                        <li class="page-item" disabled>
                            <a class="page-link">...</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="index.php?search=' . $search_str . '&sPage=' . $number_of_sPage - 2 . '">' . $number_of_sPage - 2 . ' </a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="index.php?search=' . $search_str . '&sPage=' . $number_of_sPage - 1 . '">' . $number_of_sPage - 1 . ' </a>
                        </li>';
                ?>
            </ul>
        </nav>
    <?php
                } else if (isset($_GET['sort-by'])) {
                    $sortBy = $_GET['sort-by'];

                    $results_per_sort_page = 10;
                    $sort_query = "SELECT * FROM `records` ORDER BY `name`";
                    $result_sort = mysqli_query($con, $sort_query);
                    $number_of_result = mysqli_num_rows($result_sort);
                    $number_of_sort_page = (int) ceil($number_of_result / $results_per_sort_page);
                    if (!isset($_GET['sortPage'])) {
                        $sort_page = 1;
                    } else {
                        $sort_page = $_GET['sortPage'];
                    }
                    $sort_page_first_result = ($sort_page - 1) * $results_per_sort_page;

                    if ($sortBy == 'name') {
                        $sort_query = "SELECT * FROM `records` ORDER BY `name`  LIMIT " . $sort_page_first_result . ',' . $results_per_sort_page;
                        $result_sort = mysqli_query($con, $sort_query);
                        while ($result = mysqli_fetch_assoc($result_sort)) {
                            $image = $result['avatar'];
                            $image_src = "img/" . $image;
                            createDOM($count, $image_src, $result);
                            $count++;
                        }
                    } else if ($sortBy == 'email') {
                        $sort_query = "SELECT * FROM `records` ORDER BY `email`  LIMIT " . $sort_page_first_result . ',' . $results_per_sort_page;
                        $result_sort = mysqli_query($con, $sort_query);
                        while ($result = mysqli_fetch_assoc($result_sort)) {
                            $image = $result['avatar'];
                            $image_src = "img/" . $image;
                            createDOM($count, $image_src, $result);
                            $count++;
                        }
                    } else if ($sortBy == 'phone') {
                        $sort_query = "SELECT * FROM `records` ORDER BY `phone`  LIMIT " . $sort_page_first_result . ',' . $results_per_sort_page;
                        $result_sort = mysqli_query($con, $sort_query);
                        while ($result = mysqli_fetch_assoc($result_sort)) {
                            $image = $result['avatar'];
                            $image_src = "img/" . $image;
                            createDOM($count, $image_src, $result);
                            $count++;
                        }
                    }
    ?>
        </tbody>
        </table>
        <nav class="d-flex justify-content-center align-items-center mt-4 mb-3">
            <ul class="pagination justify-content-center">
                <?php
                    if ($sort_page >= 2) {
                        echo '
                        <li class="page-item">
                            <a class="page-link" href="index.php?sort-by=' . $sortBy . '&sortPage=1">1</a>
                        </li>';
                    }
                    if ($sort_page >= 3) {
                        echo '
                        <li class="page-item" disabled>
                            <a class="page-link">...</a>
                        </li>';
                    }
                    echo '
                        <li class="page-item">
                            <a class="page-link" href="index.php?sort-by=' . $sortBy . '&sortPage=' . $sort_page . '">' . $sort_page . ' </a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="index.php?sort-by=' . $sortBy . '&sortPage=' . $sort_page + 1 . '">' . $sort_page + 1 . ' </a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="index.php?sort-by=' . $sortBy . '&sortPage=' . $sort_page + 2 . '">' . $sort_page + 2 . ' </a>
                        </li>
                        <li class="page-item" disabled>
                            <a class="page-link">...</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="index.php?sort-by=' . $sortBy . '&sortPage=' . $number_of_sort_page - 2 . '">' . $number_of_sort_page - 2 . ' </a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="index.php?sort-by=' . $sortBy . '&sortPage=' . $number_of_sort_page - 1 . '">' . $number_of_sort_page - 1 . ' </a>
                        </li>';
                ?>
            </ul>
        </nav>
    <?php
                } else {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $image = $row['avatar'];
                        $image_src = "img/" . $image;
                        createDOM($count, $image_src, $row);
                        $count++;
                    }
    ?>
        </tbody>
        </table>
        <nav class="d-flex justify-content-center align-items-center mt-4 mb-3">
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
                        <li class="page-item">
                            <a class="page-link" href="index.php?page=' . $page + 2 . '">' . $page + 2 . ' </a>
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
    <?php
                }
    ?>
    </main>

    <script src="vendor/bootstrap/bootstrap-js/bootstrap.bundle.min.js"></script>
    <script src="vendor/jquery/jquery-3.6.0.min.js"></script>
    <script src="functions/app.js"></script>
</body>

</html>