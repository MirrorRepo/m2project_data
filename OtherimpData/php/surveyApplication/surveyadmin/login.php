<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>SB Admin - Login</title>

        <!-- Custom fonts for this template-->
        <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

        <!-- Custom styles for this template-->
        <link href="css/sb-admin.css" rel="stylesheet">

    </head>
    
    
    <?php
    include_once 'config.php';
    ?>
    
    <?php if (count($errors) > 0) : ?>
        <div class="error">
            <?php foreach ($errors as $error) : ?>
                <p><?php echo $error ?></p>
            <?php endforeach ?>
        </div>
    <?php endif ?>
    <body class="bg-dark">
        <?php
        if (isset($_POST['username'])) {
           $username = mysqli_real_escape_string($db, $_POST['username']);
           $password = mysqli_real_escape_string($db, $_POST['password']);
            if (empty($username)) {
                array_push($errors, "Username is required");
            }
            if (empty($password)) {
                array_push($errors, "Password is required");
            }
            if (count($errors) == 0) {
                $password = md5($password);
                $query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
                $results = mysqli_query($db, $query);
                if (mysqli_num_rows($results) == 1) {
                    $_SESSION['username'] = $username;
                    $_SESSION['success'] = "You are now logged in";
                    header('location: index.php');
                } else {
                    array_push($errors, "Wrong username/password combination");
                }
            }
        }
        ?>

        <div class="container">
            <div class="card card-login mx-auto mt-5">
                <?php  include 'error.php';?>
                <div class="card-header">Login</div>
                <div class="card-body">
                      <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                        <div class="form-group">
                            <div class="form-label-group">
                                <input name="username" type="email" id="inputEmail" class="form-control" placeholder="Email address" required="required" autofocus="autofocus">
                                <label for="inputEmail">Email address</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-label-group">
                                <input name="password" type="password" id="inputPassword" class="form-control" placeholder="Password" required="required">
                                <label for="inputPassword">Password</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" value="remember-me">
                                    Remember Password
                                </label>
                            </div>
                        </div>
                       <button type="submit" class="btn btn-primary btn-block"   name="Register"><span>Login</span></button>

                    </form>
                    <div class="text-center">
                        <a class="d-block small mt-3" href="register.php">Register an Account</a>
                        <a class="d-block small" href="forgot-password.html">Forgot Password?</a>
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
