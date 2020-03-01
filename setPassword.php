<html>

<head>
    <title>BdWorkStation | Reset Password</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="description" content="It is human resource management project in Bangladesh">
    <meta name="keywords" content="human resource management, work, daily work, homework, earn money" />
    <meta name="author" content="M Irfanul Kalam Chowdhury, Foyzul Abrar Chowdhury, Yamin Sobhan">

    <!-- Mobile Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="shortcut icon" href="img/site_logo/favicon.ico" />

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">

    <!-- Theme CSS -->

    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/mobile.css">


    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</head>

<body>
    <?php
    if (!isset($_SESSION)) session_start();

    require "backEnds/dbConnection.php";

    include "layouts/facebookContact.php";
    include "layouts/nav.php";


    $account_type = $_SESSION['account_type'];

    if ($account_type == 'user') {
        $id = $_SESSION['user_id'];
    } elseif ($account_type == 'worker') {
        $id = $_SESSION['worker_id'];
    }


    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_GET['uId'])) {
            $user_id = $_GET['uId'];

            if ($_POST['password'] == $_POST['rptPassword']) {
                $newPass = $_POST['password'];
                $rptNewPass = $_POST['rptPassword'];

                if (strlen($_POST['password']) > 5) {
                    $password = $mysqli->escape_string(password_hash($_POST['password'], PASSWORD_BCRYPT));

                    $sql = "UPDATE user_table SET password = '$password' WHERE user_id = '$user_id'";
                    if ($mysqli->query($sql)) {
                        ?>
                        <script>
                            swal({
                                title: "Success!",
                                text: "Your password is reset!",
                                icon: "success",
                                button: "OK",
                                closeOnClickOutside: false
                            }).then(function() {
                                window.location = "index.php";
                            });
                        </script>
                    <?php
                                    }
                                } else {
                                    ?>
                    <script>
                        swal({
                            title: "Error!",
                            text: "Your Password must be 6 character!",
                            icon: "error",
                            button: "OK",
                            closeOnClickOutside: false
                        }).then(function() {
                            window.location = "setPassword.php";
                        });
                    </script>

                <?php
                            }
                        } else {
                            ?>
                <script>
                    swal({
                        title: "Error!",
                        text: "Password do not match!",
                        icon: "error",
                        button: "OK",
                        closeOnClickOutside: false
                    }).then(function() {
                        window.location = "setPassword.php";
                    });
                </script>

                <?php
                        }
                    } elseif (isset($_GET['wId'])) {
                        $worker_id = $_GET['wId'];

                        if ($_POST['password'] == $_POST['rptPassword']) {
                            $newPass = $_POST['password'];
                            $rptNewPass = $_POST['rptPassword'];

                            if (strlen($_POST['password']) > 5) {
                                $password = $mysqli->escape_string(password_hash($_POST['password'], PASSWORD_BCRYPT));

                                $sql = "UPDATE worker_table SET password = '$password' WHERE worker_id = '$worker_id'";
                                if ($mysqli->query($sql)) {
                                    ?>
                        <script>
                            swal({
                                title: "Success!",
                                text: "Your password is reset!",
                                icon: "success",
                                button: "OK",
                                closeOnClickOutside: false
                            }).then(function() {
                                window.location = "index.php";
                            });
                        </script>
                    <?php
                                    }
                                } else {
                                    ?>
                    <script>
                        swal({
                            title: "Error!",
                            text: "Your Password must be 6 character!",
                            icon: "error",
                            button: "OK",
                            closeOnClickOutside: false
                        }).then(function() {
                            window.location = "setPassword.php";
                        });
                    </script>

                <?php
                            }
                        } else {
                            ?>
                <script>
                    swal({
                        title: "Error!",
                        text: "Password do not match!",
                        icon: "error",
                        button: "OK",
                        closeOnClickOutside: false
                    }).then(function() {
                        window.location = "setPassword.php";
                    });
                </script>

            <?php
                    }
                } else {
                    ?>
            <script>
                swal({
                    title: "Error!",
                    text: "Something is wrong!",
                    icon: "error",
                    button: "OK",
                    closeOnClickOutside: false
                }).then(function() {
                    window.location = "index.php";
                });
            </script>

        <?php
            }
        }



        if ($account_type == 'null') {
            ?>
        <script>
            swal({
                title: "Error!",
                text: "User with this phone number does not exist!",
                icon: "error",
                button: "OK",
                closeOnClickOutside: false
            }).then(function() {
                window.location = "index.php";
            });
        </script>
    <?php
    } else {
        ?>
        <div class="buyCreditsFullPage">
            <h1 class="heading">Reset Password</h1>
            <br><br>
            <div class="resetPasswordForm">
                <?php
                    if ($account_type == 'user') {
                        ?>
                    <form action="setPassword.php?uId=<?= $id ?>" method="POST">
                    <?php
                        } elseif ($account_type == 'worker') {
                            ?>
                        <form action="setPassword.php?wId=<?= $id ?>" method="POST">
                        <?php
                            }
                            ?>
                        <label>New Password</label>
                        <input id="workerpass1" onkeyup="passValidation(2)" class="form-control" type="Password" pattern=".{6,}" title="Password should be at least 6 Character long" name="password" required>
                        <span id="workerpassLengthErrorMsg"></span> <br><br>

                        <label>ReType Password</label>
                        <input id="workerpass2" onkeyup="passValidation(2)" class="form-control" type="Password" name="rptPassword" required>
                        <span id="workerpassMatchErrorMsg"></span><br><br>

                        <?php
                            if ($account_type == 'user') {
                                ?>
                            <center><button class="btn btn-danger">Submit</button></center>
                        <?php
                            } elseif ($account_type == 'worker') {
                                ?>
                            <center><button class="btn btn-danger">Submit</button></center>
                        <?php
                            }
                            ?>
                        </form>
            </div>
        </div>
    <?php
    }

    include "layouts/footer.php";
    ?>


    <script src="js/theme.js"></script>
    <script src="js/validation.js"></script>
</body>

</html>