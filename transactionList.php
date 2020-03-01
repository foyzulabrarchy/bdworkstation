<!DOCTYPE html>
<html>

<head>
    <title>BdWorkStation | Transaction List</title>

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


    require "backEnds/dbConnection.php";

    require "class/classForFunctions.php";
    if (!isset($_SESSION)) session_start();


    if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == 1) {
        $account_type = $_SESSION['account_type'];
        $phone = $_SESSION['phone'];
    } else {

        ?><script>
            swal({
                title: "Error!",
                text: "Please log in First!",
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

    if ($account_type == 'worker') {
        $worker_id = $_SESSION['worker_id'];
    }

    $sql_count = $mysqli->query("SELECT transaction_id FROM transactions WHERE worker_id = '$worker_id'");

    //Total Count Data For Pagination
    $total_records = $sql_count->num_rows;
    $limit = 10;
    $total_pages = ceil($total_records / $limit);
    //First Time Load Data
    if (isset($_GET["page"])) {
        $page  = $_GET["page"];
    } else {
        $page = 1;
    }
    $start_from = ($page - 1) * $limit;

    $worker_transaction = $mysqli->query("SELECT * FROM transactions WHERE worker_id = '$worker_id' AND is_approved = 1 ORDER BY transaction_time DESC LIMIT $start_from, $limit");


    ?>



    <?php
    include "layouts/nav.php";
    ?>

    <div class="buyCreditsFullPage">
        <h1 class="heading">TRASACTION HISTORY</h1>


        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">Sl No</th>
                    <th scope="col">Transaction Id</th>
                    <th scope="col">Transaction Type</th>
                    <th scope="col">Package</th>
                    <th scope="col">Price</th>
                    <th scope="col">Payment Method</th>
                    <th scope="col">Transaction Time</th>
                </tr>
            </thead>
            <tbody>

                <?php
                $slNo = 1; // SL No.
                while ($row = $worker_transaction->fetch_assoc()) {
                    $transaction_id = $row['transaction_id'];
                    $type = $row['transaction_type'];
                    $package_id = $row['package_id'];
                    $payment_method = $row['payment_method'];
                    $transaction_time = date("d-m-Y / h:i:s a", strtotime($row['transaction_time']));


                    if ($type == 'SMS_CREDIT') {
                        $package_search = $mysqli->query("SELECT package_name,package_price FROM sms_package WHERE id = $package_id");
                    }
                    if ($type == 'PROMOTION_CREDIT') {
                        $package_search = $mysqli->query("SELECT package_name,package_price FROM promotion_package WHERE id = $package_id");
                    }

                    while ($package_details = $package_search->fetch_assoc()) {
                        $package_name = $package_details['package_name'];
                        $package_price = $package_details['package_price'];
                    }
                    ?>


                    <tr>
                        <th scope="row"><?= $slNo; ?></th>
                        <td><?= $transaction_id; ?></td>
                        <td><?= $type; ?></td>
                        <td><?= strtoupper($package_name) . " - PACKAGE"; ?></td>
                        <td><?= $package_price . " BDT";  ?></td>
                        <td><?= $payment_method; ?></td>
                        <td><?= $transaction_time; ?></td>
                    </tr>


                <?php
                    $slNo++;
                }

                ?>

            </tbody>
        </table>



        <center>
            <?php
            if ($total_pages > 1) {
                ?>
                <nav>
                    <ul class="pagination">
                        <?php if (!empty($total_pages)) : for ($i = 1; $i <= $total_pages; $i++) :
                                    if ($i == $page) : ?>
                                    <li class="active" id="<?php echo $i; ?>"><a href='transactionList.php?page=<?php echo $i; ?>'><?php echo $i; ?></a></li>
                                <?php else : ?>
                                    <li id="<?php echo $i; ?>"><a href='transactionList.php?page=<?php echo $i; ?>'><?php echo $i; ?></a></li>
                                <?php endif; ?>
                        <?php endfor;
                            endif; ?>
                    </ul>
                </nav>
            <?php
            }
            ?>
        </center>
    </div>

    <br>
    <?php
    include "layouts/footer.php";
    ?>
</body>

</html>