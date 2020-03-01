<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BdWorkStation | Contact Us</title>

    <link rel="shortcut icon" href="img/site_logo/favicon.ico" />
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

    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/mobile.css">
</head>

<body class="con-us-body">
    <!--Facebook chat plugin-->
<?php
    require "class/classForFunctions.php";

?>

    <?php

    include "layouts/facebookContact.php"

    ?>


    <!--facebook chat plugin ends-->

    <?php
    include "layouts/nav.php";


    ?>
    <div class="con-us-contents">
        <div class="row container">
            <div class="col-md-5 add-all-info">
                <div class="add-info">
                    <center>
                        <i class="fas fa-envelope-open-text en-icon"></i>
                        <h3 class="header">We Would love to hear from you</h3>
                    </center>

                    <div class="add-sub-info">
                        <label><i class="fas fa-map-marker-alt"></i> Address</label><br>
                        <p><span>42/43 Equity Central, Momin Road, Chittagong</span></p>
                        <br>
                        <label><i class="fas fa-headset"></i> Lets Talk</label><br>
                        <a href="tel:+8801718339135">
                            <p><span>+8801718339135</span></p>
                        </a><br>
                        <label><i class="fas fa-paper-plane"></i> Support</label><br>
                        <p><span>support@workstation.com</span></P>
                    </div>
                </div>
            </div>

            <div class="col-md-7 con-us-form">
                <center>
                    <h4 class="header4">Send Us A Message</h4>
                </center>
                <form action="backEnds/contact_us.php" method="POST" class="contact-form">
                    <div class="form-group">
                        <label class="control-label">TELL US YOUR NAME *</label><br><br>
                        <div class="col-sm-11">
                            <input type="text" class="form-control" placeholder="Enter Your Name" name="name" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <!-- <label class="control-label">Email *</label><br><br> -->
                        <div class="col-sm-6">
                            <label class="control-label">Email *</label><br><br>
                            <input type="email" class="form-control" placeholder="Enter Your Email" name="email" required>
                        </div>
                        <div class="col-sm-5">
                            <label class="control-label">Phone *</label><br><br>
                            <input type="tel" class="form-control" pattern="[0]{1}[1]{1}[3-9]{1}[0-9]{8}" placeholder="Format: 01718339135" name="Phone" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label">Subject *</label><br><br>
                        <div class="col-sm-11">
                            <input type="text" class="form-control" placeholder="Enter Your Subject" name="subject" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label">Message *</label><br><br>
                        <div class="col-sm-11">
                            <textarea class="form-control" placeholder="Drop us a line" rows="4" cols="50" name="conMsg" required></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-11">
                            <button class="btn btn-success form-control">SEND</button>
                        </div>
                    </div>
                </form>
            </div>

        </div>

    </div>

    <br>
    <?php
    include "layouts/footer.php";
    ?>

    <!-- <script type="text/javascript" src="js/bootstrap.min.js"></script> -->

</body>

</html>