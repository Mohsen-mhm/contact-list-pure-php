<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../vendor/bootstrap/bootstrap-css/bootstrap.min.css">
    <title>Register page</title>
</head>
<body>
    <?php
    require('../../db.php');
    if (isset($_REQUEST['username'])) {
        $username = stripslashes($_REQUEST['username']);
        $username = mysqli_real_escape_string($con, $username);

        $email = stripslashes($_REQUEST['email']);
        $email = mysqli_real_escape_string($con, $email);

        $checkExist_query = "Select * from users";
        $username_result = mysqli_query($con, $checkExist_query);
        $email_result = mysqli_query($con, $checkExist_query);

        $usernameList = [];
        $emailList = [];
        while ($row = mysqli_fetch_assoc($username_result)) {
            array_push($usernameList, $row['username']);
        }
        while ($row = mysqli_fetch_assoc($email_result)) {
            array_push($emailList, $row['email']);
        }

        if (in_array($username, $usernameList)) {
            echo "<div class='form'>
                    <h3 class='mt-5 text-center'>This username already exists.</h3>
                    <br/><p class='text-center'>Lets <a href='./registration.php'>Try again</a></p>
                  </div>";
        } elseif (in_array($email, $emailList)) {
            echo "<div class='form'>
                    <h3 class='mt-5 text-center'>This email already exists.</h3>
                    <br/><p class='text-center'>Lets <a href='./registration.php'>Try again</a></p>
                  </div>";
        } else {
            $password = stripslashes($_REQUEST['password']);
            $password = mysqli_real_escape_string($con, $password);

            $query = "INSERT into `users` (username, password, email)
            VALUES ('$username', '" . md5($password) . "', '$email')";
            $result = mysqli_query($con, $query);
            if ($result) {
                echo "<div class='form'>
                    <h3 class='mt-5 text-center'>You are registered successfully.</h3>
                    <br/><p class='text-center'>Click here to <a href='../login/login.php'>Login</a></p>
                  </div>";
            }
        }
    } else {
    ?>
        <section class="container">
            <h1 class="text-center m-5">Register page</h1>
            <form action="" method="post">

                <div class="form-outline mb-4">
                    <label class="form-label" for="username">Username</label>
                    <input type="text" id="username" class="form-control" name="username" required />
                </div>
                <div class="form-outline mb-4">
                    <label class="form-label" for="email">Email</label>
                    <input type="text" id="email" class="form-control" name="email" required />
                </div>
                <div class="form-outline mb-4">
                    <label class="form-label" for="password">Password</label>
                    <input type="password" id="password" class="form-control" name="password" required />
                </div>

                <button type="submit" class="btn btn-primary btn-block mb-4 mt-2">Sign up</button>
            </form>
            <p>Already registered? <a href='../login/login.php'>Login Here</a></p>
        </section>
    <?php } ?>
    <script src="../../vendor/bootstrap/bootstrap-js/bootstrap.bundle.min.js"></script>
</body>
</html>