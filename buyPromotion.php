<!DOCTYPE html>
<html>

<head>
    <title>BdWorkStation | Promote your profile</title>

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

<body class="buyCreditsBody">

    <!--Facebook chat plugin-->


    <?php

    include "layouts/facebookContact.php"

    ?>


    <!--facebook chat plugin ends-->


    <?php

    require 'vendor/autoload.php';
    require "class/classForFunctions.php";

    use Carbon\Carbon;

    require "backEnds/dbConnection.php";
    if (!isset($_SESSION)) session_start();


    if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == 1) {
        $account_type = $_SESSION['account_type'];
        $phone = $_SESSION['phone'];

        //transaction validation
        if (isset($_GET['success'])) {
            $trans_details = transaction_validation_check();
            $status = $trans_details[0];
            if ($status == "VALID") {
                $transaction_id = $trans_details[1];
                $transaction_method = $trans_details[2];
                $transaction_date = $trans_details[3];
                $worker_id = $_SESSION['worker_id'];
                $package_id = $_SESSION['package_id'];
                $type = "PROMOTION_CREDIT";

                $package_details = $mysqli->query("SELECT package_validation_in_days FROM promotion_package WHERE id='$package_id'");
                $package_validation_in_days = $package_details->fetch_assoc()['package_validation_in_days'];
                $transaction_dates = Carbon::parse($transaction_date, 'Asia/Dhaka');
                $end_datess = $transaction_dates->addDays($package_validation_in_days);


                $transaction_sql = "INSERT INTO `transactions`(`transaction_id`,transaction_type, `worker_id`, `package_id`, `payment_method`, `is_approved`, `transaction_time`) VALUES ('$transaction_id', '$type','$worker_id','$package_id','$transaction_method',1, '$transaction_date' )";

                if ($mysqli->query($transaction_sql) == true) {

                    // Set is_promoted to 1
                    $set_is_promoted = $mysqli->query("UPDATE `worker_table` SET `is_promoted`= 1 WHERE worker_id = '$worker_id'");

                    $check_worker = $mysqli->query("SELECT worker_id FROM worker_promotion WHERE worker_id = '$worker_id'");
                    if ($check_worker->num_rows > 0) {
                        $mysqli->query("UPDATE `worker_promotion` SET `package_id`='$package_id',`buy_date`='$transaction_date',`end_date`= '$end_datess' WHERE worker_id='$worker_id'");
                    } else {
                        $mysqli->query("INSERT INTO `worker_promotion`(`worker_id`, `package_id`, `buy_date`, `end_date`) VALUES ('$worker_id','$package_id','$transaction_date','$end_datess')");
                    }

                    ?>
                    <script>
                        swal({
                            title: "Complete!",
                            text: "Your payment is recieved. Thank You!",
                            icon: "success",
                            button: "OK",
                            closeOnClickOutside: false
                        }).then(function() {
                            window.location = "buyPromotion.php";
                        });
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
    // $account_type = $_SESSION['account_type'];

    if ($account_type == 'user') {
        ?>
        <script>
            swal({
                title: "Error!",
                text: "You are not allowed!",
                icon: "error",
                button: "OK",
                closeOnClickOutside: false
            }).then(function() {
                window.location = "Dashboard.php";
            });
        </script>
    <?php
    } else {
        $worker_id = $_SESSION['worker_id'];

        //Check the worker verified or not
        $ver_check = $mysqli->query("SELECT is_verified FROM worker_table WHERE worker_id = '$worker_id'");
        $is_verified = $ver_check->fetch_assoc()['is_verified'];
        if ($is_verified == 1) {
            $next_btn = 1;
        } else {
            $next_btn = 0;
        }
    }

    $promotion_package_sql = $mysqli->query("SELECT * FROM promotion_package");
    $worker_promotion_sql = $mysqli->query("SELECT * FROM worker_promotion WHERE worker_id = '$worker_id'");

    if ($worker_promotion_sql->num_rows > 0) {
        $worker_promotion_sql_fetch = $worker_promotion_sql->fetch_assoc();
        $end_date = $worker_promotion_sql_fetch['end_date'];
        $end_date = Carbon::parse($end_date);
        $end_dates = $end_date->toFormattedDateString();
    }

    $trx_check = $mysqli->query("SELECT id FROM transaction_profile_promotion WHERE worker_id = '$worker_id' AND is_approved='0'");


    ?>



    <?php
    include "layouts/nav.php";
    ?>

    <div class="buyCreditsFullPage">
        <div class="row">
            <div class="col-md-8">
                <h1 class="heading">Get your profile noticed!</h1>
                <p>This will help you to get noticed by any user who posted a job. Work Station will show them your profile with a recommandation tag.</p>
                <br><br>
                <?php
                if ($next_btn == 0) {
                    ?>
                    <h4><strong class="text-danger">You can not promote your profile. Because you are not a verified worker. Click <a href="setting.php">here</a> to get verified</strong></h4><br>
                <?php
                }
                ?>
                <div class="row availableCredits">
                    <?php
                    if (isset($end_dates)) { ?>
                        <h4 class="col-md-8">Your profile promotion will be ended on:</h4>
                        <span class="col-md-4"><?= $end_dates; ?></span>
                    <?php
                    }
                    ?>

                </div>
                <br>
                <br>
                <form action="backEnds/transactionpromo.php" method="POST">
                    <div class="row needCredits">
                        <h4 class="col-md-8">Choose your sms package:</h4>
                        <select class="col-md-3" id="smsPackageSelect" name="smsPackageSelect" onclick="showSelectPack()" required>
                            <option value="" selected disabled>--Select one--</option>
                            <?php
                            while ($row = $promotion_package_sql->fetch_assoc()) {
                                $package_id = $row['id'];
                                $package_name = $row['package_name'];
                                $package_price = $row['package_price'];
                                ?>
                                <option value=<?= $package_id; ?>><?php echo $package_name . " " . $package_price . " BDT" ?></option>
                            <?php } ?>
                        </select>

                    </div>
                    <br><br>
                    <h5 class="heading">Press Next to process your pay</h5>
                    <br><br>
                    <center>
                        <?php
                        if ($next_btn == 0) {
                            ?>
                            <button type="submit" class="btn btn-warning" disabled>Next</button>
                        <?php
                        } else {
                            ?>
                            <button type="submit" class="btn btn-warning">Next</button>
                        <?php
                        }
                        ?>
                    </center>
                </form>

            </div>

            <div class="col-md-3 terms-conditions-section">
                <h5>Why SMS?</h5>
                <div class="terms-conditions">
                    <ul>
                        <li><b>1. </b>Describe your project in as much detail as you can comfortably reveal - it will increase the quality of proposals you receive and shorten the selection process.</li>
                        <br>
                        <li><b>2. </b>Upload as much relevant information (pictures, documents, specifications, links, etc) as possible to get a realistic quote.</li>
                        <br>
                        <li><b>3. </b>Match the experience level to your requirements – remember, you’re looking for the best you can afford, not the cheapest you can get.</li>
                    </ul>
                </div>
            </div>


        </div>

    </div>

    <br>
    <?php
    include "layouts/footer.php";
    ?>

    <script type="text/javascript" src="js/validation.js"></script>

</body>

</html>