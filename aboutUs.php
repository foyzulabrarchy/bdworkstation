<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BdWorkStation | About Us</title>

    <link rel="shortcut icon" href="img/site_logo/favicon.ico" />
    
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="description" content="It is human resource management project in Bangladesh">
    <meta name="keywords" content="human resource management, work, daily work, homework, earn money" />
    <meta name="author" content="M Irfanul Kalam Chowdhury, Foyzul Abrar Chowdhury, Yamin Sobhan">

    <!-- Mobile Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

    <!-- Theme CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">

    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/mobile.css">
</head>

<body class="term-con-body">
    <!--Facebook chat plugin-->


    <?php

    include "layouts/facebookContact.php";
    require "class/classForFunctions.php";

    ?>


    <!--facebook chat plugin ends-->

    <?php
    include "layouts/nav.php";
    ?>
    <div class="container term-con-contents">
        <!-- <h2 class="text-center main-header">ABOUT US</h2> -->

        <div class="container">
            <center>
                <h3 class="h2">
                <small class="text-muted">We are </small>
                  <u>BdWorkStation</u>
                </h3>
            </center>
            <br>
            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum</p>
            <br>
            <p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for 'lorem ipsum' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).</p>

        </div>
    </div>

    <?php
    include "layouts/footer.php";
    ?>

</body>

</html>