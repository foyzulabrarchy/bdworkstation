<!DOCTYPE html>
<html lang="en">

<head>
    <title>BdWorkStation | Setting</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="description" content="It is human resource management project in Bangladesh">
    <meta name="keywords" content="human resource management, work, daily work, homework, earn money" />
    <meta name="author" content="M Irfanul Kalam Chowdhury, Foyzul Abrar Chowdhury, Yamin Sobhan">


    <link rel="shortcut icon" href="img/site_logo/favicon.ico" />

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/mobile.css">



    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</head>

<body class="settingBody">










    <?php
    require "backEnds/dbConnection.php";
    require "class/classForFunctions.php";

    if (!isset($_SESSION)) session_start();


    if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == 1) {
        $account_type = $_SESSION['account_type'];
        $phone = $_SESSION['phone'];
        if (isset($_SESSION['settShow'])) { } else {
            $_SESSION['settShow'] = 0;
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (isset($_GET['verPass'])) {
                if ($account_type == 'user') {
                    $pass =  $_POST['passVer'];
                } elseif ($account_type == 'worker') {
                    $pass =  $_POST['passVer'];
                }
            }
        }

        if ($account_type == 'worker') {
            $phone = $_SESSION['phone'];
            $worker_check = $mysqli->query("SELECT * FROM worker_table WHERE phone_number=$phone");
            $worker = $worker_check->fetch_assoc();
            $worker_pass = $worker['password'];
            $worker_id = $worker['worker_id'];
            $first_name = $worker['first_name'];
            $last_name = $worker['last_name'];
            $full_name = $first_name . " " . $last_name;
            $address = $worker['address'];
            $_SESSION['address'] = $address;
            $category_id = $worker['category_id'];
            $ver_status = $worker['is_verified'];
            $_SESSION['primary_category_id'] = $category_id;

            $category_name = $mysqli->query("SELECT category_name FROM category WHERE category_id = $category_id");
            $category_name = $category_name->fetch_assoc()['category_name'];
            $_SESSION['primary_category'] = $category_name;

            $categories = $mysqli->query("SELECT * FROM category");

            if (isset($_GET['verPass'])) {
                if (password_verify($pass, $worker_pass)) {
                    $_SESSION['settShow'] = 1;
                    ?>
                    <script>
                        document.getElementById('VerPassSet').style.display = "none";
                    </script>
                <?php
                            }
                        }
                    }

                    if ($account_type == 'user') {
                        $phone = $_SESSION['phone'];
                        $user_check = $mysqli->query("SELECT * FROM user_table WHERE phone_number=$phone");
                        $user = $user_check->fetch_assoc();
                        $user_pass = $user['password'];
                        $user_id = $user['user_id'];
                        $first_name = $user['first_name'];
                        $last_name = $user['last_name'];
                        $full_name = $first_name . " " . $last_name;
                        $address = $user['address'];
                        $_SESSION['address'] = $address;
                        $ver_status = $user['is_verified'];

                        if (isset($_GET['verPass'])) {
                            if (password_verify($pass, $user_pass)) {
                                $_SESSION['settShow'] = 1;
                                ?>
                    <script>
                        document.getElementById('VerPassSet').style.display = "none";
                    </script>
        <?php
                    }
                }
            }
        } else {
            ?>
        <script>
            swal({
                title: "Error!",
                text: "Please log in First. Thank You!",
                icon: "error",
                button: "OK",
                closeOnClickOutside: false
            }).then(function() {
                window.location = "index.php";
            });
        </script>
    <?php
    }
    ?>





    <!--Facebook chat plugin-->


    <?php

    include "layouts/facebookContact.php"

    ?>


    <!--facebook chat plugin ends-->

    <?php
    if ($_SESSION['settShow'] == 0) { ?>
        <div id="VerPassSet" class="modal" style="display:block">
            <div class="modal-content animate">
                <span class="close" title="Close" onclick="location='Dashboard.php'">&times;</span>
                <br> <br><br>
                <h6>Please Confirm Your Password to continue.</h6>
                <center>
                    <form action="setting.php?verPass" method="POST">
                        <input type="password" class="form-control" name="passVer" style="margin:10px;width:90%">
                        <button type="submit" class="btn btn-warning">Submit</button>
                    </form>
                    <br><br>
                </center>
            </div>
        </div>
    <?php
    } else {

        ?>
        <?php
            include "layouts/nav.php";
            ?>

        <div class="container settingAll">
            <h1 class="h1">PROFILE SETTINGS</h1>
            <?php
                if ($ver_status == 0) {
                    ?>
                <center>
                    <h5 class="text-danger">You profile is not verified yet!</h5>
                </center>
            <?php
                }
                ?>

            <div class="settingMenuList">
                <ul>
                    <li id="gen" onclick="SetSelect('gen')">General</li>
                </ul>
            </div>

            <div id="" class="settingMenus">
                <?php include "layouts/settings/generalSetting.php"; ?>
            </div>

        </div>

    <?php
    }
    ?>

    <!-- <script type="text/javascript" src="js/bootstrap.min.js"></script> -->
    <script src="js/theme.js"></script>
</body>

</html>