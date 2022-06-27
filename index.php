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
    <link rel="stylesheet" href="styles/simplePagination.css">
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
                    <p class="col-sm-3 col-lg-2 col-xl-3 text-center mt-2 w-50">Contacts Number: <b class="contact-number"></b></p>
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
                $sel_query = "Select * from new_record ORDER BY id desc;";
                $result = mysqli_query($con, $sel_query);
                while ($row = mysqli_fetch_assoc($result)) { ?>
                    <tr class="list-item">
                        <td class="text-center"><b><?php echo $count; ?></b></td>
                        <td class="text-center">
                            <div class="w-100">
                                <img src="<?php echo 'img/' . $row["email"] . '.png' ?>" alt="" class="rounded-circle" style="width: 45px;">
                            </div>
                        </td>
                        <td class="text-center"><?php echo $row["name"]; ?></td>
                        <td class="text-center"><?php echo $row["email"]; ?></td>
                        <td class="text-center"><?php echo $row["phone"]; ?></td>
                        <td class="text-center">
                            <a href="./pages/edit-contact/edit-contact.php?id=<?php echo $row["id"]; ?>"><i class="far fa-edit p-2 btn btn-primary"></i></a>
                            <a href="./pages/delete/delete.php?id=<?php echo $row["id"]; ?>"><i class="far fa-trash p-2 btn btn-danger"></i></a>
                        </td>
                    </tr>
                <?php $count++;
                } ?>
            </tbody>
        </table>
        <div id="pagination-container" style="display: flex; justify-content: center;" class="m-4"></div>
    </main>

    <script src="vendor/bootstrap/bootstrap-js/bootstrap.bundle.min.js"></script>
    <script src="vendor/jquery/jquery-3.6.0.min.js"></script>
    <script src="vendor/jquery/jquery.simplePagination.js"></script>
    <script src="functions/app.js"></script>
    <script>
        var items = $(".list-wrapper .list-item");
        var numItems = items.length;
        var perPage = 5;

        items.slice(perPage).hide();

        $('#pagination-container').pagination({
            items: numItems,
            itemsOnPage: perPage,
            prevText: "Prev",
            nextText: "Next",
            onPageClick: function(pageNumber) {
                var showFrom = perPage * (pageNumber - 1);
                var showTo = showFrom + perPage;
                items.hide().slice(showFrom, showTo).show();
            }
        });
    </script>
</body>

</html>