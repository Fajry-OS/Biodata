<?php
include "rute.php";
include "../config/connection.php";

if (isset($_POST['login'])) {
    $email = htmlspecialchars($_POST['email']);
    $pass = sha1($_POST['password']);
    $id_level = $_POST['id_level'];

    $queryLogin = mysqli_query($koneksi, "SELECT * FROM users WHERE email = '$email'");

    if (mysqli_num_rows($queryLogin) > 0) {
        $row = mysqli_fetch_assoc($queryLogin);
        if ($pass == $row['password']) {
            if ($id_level == $row['password'] && $id_level == 2) {
                header("location: index.php?page=dashboard");
                exit;
            } elseif ($id_level == $row['id_level'] && $id_level == 3) {
                header("location: index.php?page=pricing");
                exit;
            } else {
                header("location: login.php");
                exit;
            }
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin 2 - Login</title>

    <!-- Custom fonts for this template-->
    <?php include "inc/css.php" ?>
</head>

<body class="bg-gradient-primary">

    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-10 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Welcome Back!</h1>
                                    </div>
                                    <form class="user" method="POST">
                                        <div class="form-group">
                                            <input type="email" class="form-control form-control-user" id="exampleInputEmail" aria-describedby="emailHelp" placeholder="Enter Email Address...">
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control form-control-user" id="exampleInputPassword" placeholder="Password">
                                        </div>
                                        <div class="form-group">
                                            <select name="" id="" class="form-control form-control-user">
                                                <?php
                                                $selectLevel = mysqli_query($koneksi, "SELECT * FROM levels");
                                                while ($a = mysqli_fetch_assoc($selectLevel)) {
                                                ?>
                                                    <option value="<?= $a['id'] ?>"><?= $a['lvl_name'] ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <button type="submit" name="login" class="btn btn-primary btn-user btn-block">Login</button>
                                    </form>
                                    <hr>
                                    <div class="text-center">
                                        <a class="small" href="forgot-password.html">Forgot Password?</a>
                                    </div>
                                    <div class="text-center">
                                        <a class="small" href="register.html">Create an Account!</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <!-- Bootstrap core JavaScript-->
    <?php include "inc/js.php" ?>

</body>

</html>