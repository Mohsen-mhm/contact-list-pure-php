<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../vendor/bootstrap/bootstrap-css/bootstrap.min.css">
    <link rel="stylesheet" href="../../font/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="../../font/fontawesome/css/fontawesome.min.css">
    <title>login page</title>
</head>

<body>
    <?php
    require('../../db.php');
    session_start();
    // If form submitted, insert values into the database.
    if (isset($_POST['username'])) {
        // removes backslashes
        $username = stripslashes($_REQUEST['username']);
        //escapes special characters in a string
        $username = mysqli_real_escape_string($con, $username);
        $password = stripslashes($_REQUEST['password']);
        $password = mysqli_real_escape_string($con, $password);
        //Checking is user existing in the database or not
        $query = "SELECT * FROM `users` WHERE username='$username'
and password='" . md5($password) . "'";
        $result = mysqli_query($con, $query);
        $rows = mysqli_num_rows($result);
        if ($rows == 1) {
            $_SESSION['username'] = $username;
            // Redirect user to index.php
            header("Location: ../../index.php");
        } else {
            echo "<div class='form'>
<h3>Username/password is incorrect.</h3>
<br/>Click here to <a href='login.php'>Login</a></div>";
        }
    } else {
    ?>
        <section class="container">
            <h1 class="text-center m-5">login page</h1>
            <form action="" method="post">
                <div class="form-outline mb-4">
                    <label class="form-label" for="username">Username</label>
                    <input type="username" id="username" class="form-control" name="username" />
                </div>

                <div class="form-outline mb-4">
                    <label class="form-label" for="password">Password</label>
                    <input type="password" id="password" class="form-control" name="password" />
                </div>

                <button type="submit" class="btn btn-primary btn-block mb-4 mt-2">Sign in</button>
            </form>
            <p>Not registered yet? <a href='../registration/registration.php'>Register Here</a></p>
        </section>

        <script src="../../vendor/bootstrap/bootstrap-js/bootstrap.bundle.min.js"></script>
        <script src="../../vendor/jquery/jquery-3.6.0.min.js"></script>
    <?php } ?>
</body>

</html>