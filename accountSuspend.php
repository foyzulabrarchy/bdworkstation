<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BdWorkStation | Account Suspend</title>

    <link rel="shortcut icon" href="img/site_logo/favicon.ico" />
    
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="description" content="It is human resource management project in Bangladesh">
    <meta name="keywords" content="human resource management, work, daily work, homework, earn money" />
    <meta name="author" content="M Irfanul Kalam Chowdhury, Foyzul Abrar Chowdhury, Yamin Sobhan">
   
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">


    <!-- Theme CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">

    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/mobile.css">
</head>

<body class="acc-sus-body">
    <!--Facebook chat plugin-->


    <?php

    include "layouts/facebookContact.php"

    ?>


    <!--facebook chat plugin ends-->

    <?php
    include "layouts/nav.php";
    ?>

    <?php
    if (isset($_GET['liveOn'])) {
        $date = date("d-m-Y", strtotime($_GET['liveOn']));
    } else {
        $date = '';
    }
    ?>

    <div class="container acc-sus-contents">
        <h1 class="text-center"><i class="fas fa-exclamation-triangle"></i> Account Suspended</h1>
        <div class="container-fluid text-center">
            <p class="font-weight-normal">Your Account has been deactivated. Your account will live on <span class="text-primary"><b><?= $date ?></b></span>. <br>If you feel this deactivation is an error, please contact customer support as soon as possible.</p>
        </div>
    </div>

    <?php
    include "layouts/footer.php";
    ?>


</body>

</html>