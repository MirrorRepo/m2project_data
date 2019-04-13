<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>SB Admin - Register</title>

        <!-- Custom fonts for this template-->
        <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

        <!-- Custom styles for this template-->
        <link href="css/sb-admin.css" rel="stylesheet">

    </head>


    <?php
    include_once 'config.php';
    ?>

    <?php
    if (isset($_POST['username'])) {


        $username = mysqli_real_escape_string($db, $_POST['username']);

        $email = mysqli_real_escape_string($db, $_POST['email']);

        $password_1 = mysqli_real_escape_string($db, $_POST['password_1']);

        $password_2 = mysqli_real_escape_string($db, $_POST['password_2']);


// form validation: ensure that the form is correctly filled ...
// by adding (array_push()) corresponding error unto $errors array

        if (empty($username)) {
            array_push($errors, "Username is required");
        }


        if (empty($email)) {
            array_push($errors, "Email is required");
        }

        if (empty($password_1)) {
            array_push($errors, "Password is required");
        }

        if ($password_1 != $password_2) {

            array_push($errors, "The two passwords do not match");
        }

// first check the database to make sure
// a user does not already exist with the same username and/or email

        $user_check_query = "SELECT * FROM users WHERE username='$username' OR email='$email' LIMIT 1";

        $result = mysqli_query($db, $user_check_query);

        $user = mysqli_fetch_assoc($result);

        if ($user) { // if user exists
            if ($user['username'] === $username) {
              
                array_push($errors, "Username already exists");
            }

            if ($user['email'] === $email) {

                array_push($errors, "email already exists");
            }
        }

// Finally, register user if there are no errors in the form

        if (count($errors) == 0) {
            $password = md5($password_1); //encrypt the password before saving in the database


            $query = "INSERT INTO users(username, email, password)

VALUES('$username', '$email', '$password')";

            mysqli_query($db, $query);

            //$_SESSION['username'] = $username;

            //$_SESSION['success'] = "You are now logged in";

             header('location: login.php');
        }
    }
    ?>

    <body class="bg-dark">

        <div class="container">
        
            <div class="card card-register mx-auto mt-5">
                    <?php  include 'error.php';?>
                <div class="card-header">Register an Account</div>
                <div class="card-body">
                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                        <div class="form-group">
                            <div class="form-row">
                                <div class="col-md-12">
                                    <div class="form-label-group">
                                        <input type="text" id="firstName" name="username" class="form-control" placeholder="User name" required="required" autofocus="autofocus">
                                        <label for="firstName">User name</label>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-label-group">
                                <input type="email" id="inputEmail" name="email" class="form-control" placeholder="Email address" required="required">
                                <label for="inputEmail">Email address</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-row">
                                <div class="col-md-6">
                                    <div class="form-label-group">
                                        <input type="password" name="password_1" id="inputPassword" class="form-control" placeholder="Password" required="required">
                                        <label for="inputPassword">Password</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-label-group">
                                        <input type="password"  name="password_2" id="confirmPassword" class="form-control" placeholder="Confirm password" required="required">
                                        <label for="confirmPassword">Confirm password</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block"   name="Register"><span>Register</span></button>
                        <!--<a class="btn btn-primary btn-block" href="login.html">Register</a>-->
                    </form>
                    <div class="text-center">
                        <a class="d-block small mt-3" href="login.php">Login Page</a>
                        <a class="d-block small" href="forgot-password.php">Forgot Password?</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bootstrap core JavaScript-->
        <script src="vendor/jquery/jquery.min.js"></script>
        <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

        <!-- Core plugin JavaScript-->
        <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    </body>

</html>
