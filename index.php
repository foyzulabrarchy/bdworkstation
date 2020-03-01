<?php
if (!isset($_SESSION)) session_start();

require "backEnds/dbConnection.php";
if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == 1) {
    header("Location:Dashboard.php");
}

$result = $mysqli->query("SELECT * FROM user_table");
$result2 = $mysqli->query("SELECT * FROM worker_table");

$complete_project_search = $mysqli->query("SELECT job_id FROM job_status WHERE  is_canceled = 0 AND is_done = 1");
$open_project = $mysqli->query("SELECT * FROM job_table WHERE (SELECT job_status.job_id FROM job_status WHERE is_done='0' AND is_canceled='0' AND in_progress='0' AND job_table.job_id = job_status.job_id) ORDER BY post_time DESC");

// Total Earn By Worker
$total_paid = 0;
while ($row = $complete_project_search->fetch_assoc()) {
    $jId = $row['job_id'];
    $check_price_job = $mysqli->query("SELECT proposal_price FROM proposal_table WHERE job_id = '$jId'");
    $price = $check_price_job->fetch_assoc()['proposal_price'];

    $total_paid = $total_paid + $price;
}

// $total_paid=$mysqli->query("SELECT SUM(salary) FROM worker_table where got_paid>0");

$num_rows_user = mysqli_num_rows($result);
$num_rows_worker = mysqli_num_rows($result2);
$num_rows_open_project = mysqli_num_rows($open_project);
$complete_project = mysqli_num_rows($complete_project_search);

?>


<!doctype html>

<html lang="en-US">

<head>
    
        <title>BdWorkStation | Solution for Instant Problem</title>
        <!-- preview image when paste the url  -->
        <meta property="og:url" content="https://bdworkstation.daanguli.com/" />
        <meta property="og:type" content="website" />
        <meta property="og:title" content="BdWorkStation | Solution for Instant Problem" />
        <meta property="og:description" content="It is human resource management project in Bangladesh" />
        <meta property="og:image" content="img/site_logo/pre_workstation.jpg" />

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="description" content="It is human resource management project in Bangladesh" />
    <meta name="keywords" content="human resource management, work, daily work, homework, earn money" />
    <meta name="author" content="M Irfanul Kalam Chowdhury, Foyzul Abrar Chowdhury, Yamin Sobhan">
    
    
     <link rel="shortcut icon" href="img/site_logo/favicon.ico" />

    <!-- Mobile Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <!-- Libs and Plugins CSS -->
    <link rel="stylesheet" href="inc/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="inc/animations/css/animate.min.css">
    <link rel="stylesheet" href="inc/font-awesome/css/font-awesome.min.css"> <!-- Font Icons -->
    <link rel="stylesheet" href="inc/owl-carousel/css/owl.carousel.css">
    <link rel="stylesheet" href="inc/owl-carousel/css/owl.theme.css">

    <!-- Theme CSS -->

    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/mobile.css">



</head>

<body id="body" data-spy="scroll" data-target="#main-navbar">
    <!--<div class="page-loader"></div>   Display loading image while page loads -->


    <!--Facebook chat plugin-->


    <?php

    include "layouts/facebookContact.php"

    ?>


    <!--facebook chat plugin ends-->


    <div class="body">

        <!--========== BEGIN HEADER ==========-->

        <?php

        include "layouts/nav.php"

        ?>

        <!-- ========= END HEADER =========-->




        <!-- Begin text carousel intro section -->
        <section id="text-carousel-intro-section" class="parallax" data-stellar-background-ratio="0.5">
            <div class="cover"></div>

            <div class="container">
                <div class="caption text-center text-white" data-stellar-ratio="0.7">

                    <div id="owl-intro-text" class="owl-carousel">
                        <div class="item">
                            <h1>I'm WorkStation</h1>
                            <p>One Site For All Solution</p>
                            <!-- <p>One Page Responsive Theme</p> -->
                            <div class="extra-space-l"></div>

                        </div>
                        <div class="item">
                            <h1>We have Awesome things</h1>
                            <p>Let's make the work beautiful together</p>
                            <div class="extra-space-l"></div>

                        </div>
                        <div class="item">
                            <h1>Join with us</h1>
                            <p>To the greatest Journey</p>
                            <div class="extra-space-l"></div>
                        </div>
                    </div>

                </div> <!-- /.caption -->
            </div> <!-- /.container -->

        </section>
        <!-- End text carousel intro section -->




        <!-- Begin about section -->
        <section id="about-section" class="page bg-style1">
            <!-- Begin page header-->
            <div class="page-header-wrapper">
                <div class="container">
                    <div class="page-header text-center wow fadeInUp" data-wow-delay="0.3s">
                        <h2>About</h2>
                        <div class="devider"></div>
                        <p class="subtitle">little information</p>
                    </div>
                </div>
            </div>
            <!-- End page header-->

            <!-- Begin rotate box-1 -->
            <div class="rotate-box-1-wrapper">
                <div class="container">
                    <div class="row">
                        <div class="col-md-3 col-sm-6">
                            <a href="#" class="rotate-box-1 square-icon wow zoomIn" data-wow-delay="0">
                                <span class="rotate-box-icon"><i class="fa fa-users"></i></span>
                                <div class="rotate-box-info">
                                    <h4>Who We Are?</h4>
                                    <p>Lorem ipsum dolor sit amet set, consectetur utes anet adipisicing elit, sed do eiusmod tempor incidist.</p>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-3 col-sm-6">
                            <a href="#" class="rotate-box-1 square-icon wow zoomIn" data-wow-delay="0.2s">
                                <span class="rotate-box-icon"><i class="fa fa-diamond"></i></span>
                                <div class="rotate-box-info">
                                    <h4>What We Do?</h4>
                                    <p>Lorem ipsum dolor sit amet set, consectetur utes anet adipisicing elit, sed do eiusmod tempor incidist.</p>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-3 col-sm-6">
                            <a href="#" class="rotate-box-1 square-icon wow zoomIn" data-wow-delay="0.4s">
                                <span class="rotate-box-icon"><i class="fa fa-heart"></i></span>
                                <div class="rotate-box-info">
                                    <h4>Why We Do It?</h4>
                                    <p>Lorem ipsum dolor sit amet set, consectetur utes anet adipisicing elit, sed do eiusmod tempor incidist.</p>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-3 col-sm-6">
                            <a href="#" class="rotate-box-1 square-icon wow zoomIn" data-wow-delay="0.6s">
                                <span class="rotate-box-icon"><i class="fa fa-clock-o"></i></span>
                                <div class="rotate-box-info">
                                    <h4>Since When?</h4>
                                    <p>Lorem ipsum dolor sit amet set, consectetur utes anet adipisicing elit, sed do eiusmod tempor incidist.</p>
                                </div>
                            </a>
                        </div>

                    </div> <!-- /.row -->
                </div> <!-- /.container -->
            </div>
            <!-- End rotate box-1 -->

            <div class="extra-space-l"></div>
        </section>
        <!-- End about section -->









        <!-- Begin Services -->
        <section id="services-section" class="page text-center">
            <!-- Begin page header-->
            <div class="page-header-wrapper">
                <div class="container">
                    <div class="page-header text-center wow fadeInDown" data-wow-delay="0.4s">
                        <h2>Services</h2>
                        <div class="devider"></div>
                        <p class="subtitle">what we really know how</p>
                    </div>
                </div>
            </div>
            <!-- End page header-->

            <!-- Begin roatet box-2 -->
            <div class="rotate-box-2-wrapper">
                <div class="container">
                    <div class="row">
                        <!-- Services First Row Start -->
                        <div class="col-md-3 col-sm-6">
                            <a href="#" class="rotate-box-2 square-icon text-center wow zoomIn" data-wow-delay="0">
                                <span class="rotate-box-icon"><i class="fa fa-plug"></i></span>
                                <div class="rotate-box-info">
                                    <h4>Electrician</h4>
                                    <p>Lorem ipsum dolor sit amet set, consectetur utes anet adipisicing elit, sed do eiusmod tempor incidist.</p>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-3 col-sm-6">
                            <a href="#" class="rotate-box-2 square-icon text-center wow zoomIn" data-wow-delay="0.2s">
                                <span class="rotate-box-icon"><i class="fa fa-car"></i></span>
                                <div class="rotate-box-info">
                                    <h4>Driver</h4>
                                    <p>Lorem ipsum dolor sit amet set, consectetur utes anet adipisicing elit, sed do eiusmod tempor incidist.</p>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-3 col-sm-6">
                            <a href="#" class="rotate-box-2 square-icon text-center wow zoomIn" data-wow-delay="0.4s">
                                <span class="rotate-box-icon"><i class="fa fa-home"></i></span>
                                <div class="rotate-box-info">
                                    <h4>Home Appliance Service</h4>
                                    <p>Lorem ipsum dolor sit amet set, consectetur utes anet adipisicing elit, sed do eiusmod tempor incidist.</p>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-3 col-sm-6">
                            <a href="#" class="rotate-box-2 square-icon text-center wow zoomIn" data-wow-delay="0.6s">
                                <span class="rotate-box-icon"><i class="fa fa-pencil"></i></span>
                                <div class="rotate-box-info">
                                    <h4>Teacher</h4>
                                    <p>Lorem ipsum dolor sit amet set, consectetur utes anet adipisicing elit, sed do eiusmod tempor incidist.</p>
                                </div>
                            </a>
                        </div>

                    </div> <!-- Services First Row End -->


                    <div class="row">
                        <!-- Services Second Row Start -->
                        <div class="col-md-3 col-sm-6">
                            <a href="#" class="rotate-box-2 square-icon text-center wow zoomIn" data-wow-delay="0">
                                <span class="rotate-box-icon"><i class="fa fa-desktop"></i></span>
                                <div class="rotate-box-info">
                                    <h4>Computer Servicing</h4>
                                    <p>Lorem ipsum dolor sit amet set, consectetur utes anet adipisicing elit, sed do eiusmod tempor incidist.</p>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-3 col-sm-6">
                            <a href="#" class="rotate-box-2 square-icon text-center wow zoomIn" data-wow-delay="0.2s">
                                <span class="rotate-box-icon"><i class="fa fa-italic"></i></span>
                                <div class="rotate-box-info">
                                    <h4>Interior Design</h4>
                                    <p>Lorem ipsum dolor sit amet set, consectetur utes anet adipisicing elit, sed do eiusmod tempor incidist.</p>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-3 col-sm-6">
                            <a href="#" class="rotate-box-2 square-icon text-center wow zoomIn" data-wow-delay="0.4s">
                                <span class="rotate-box-icon"><i class="fa fa-male"></i></span>
                                <div class="rotate-box-info">
                                    <h4>Delivery Man</h4>
                                    <p>Lorem ipsum dolor sit amet set, consectetur utes anet adipisicing elit, sed do eiusmod tempor incidist.</p>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-3 col-sm-6">
                            <a href="#" class="rotate-box-2 square-icon text-center wow zoomIn" data-wow-delay="0.6s">
                                <span class="rotate-box-icon"><i class="fa fa-wrench"></i></span>
                                <div class="rotate-box-info">
                                    <h4>Plumber</h4>
                                    <p>Lorem ipsum dolor sit amet set, consectetur utes anet adipisicing elit, sed do eiusmod tempor incidist.</p>
                                </div>
                            </a>
                        </div>

                    </div> <!-- Services Second Row End -->
                </div> <!-- /.container -->

                <div class="container">
                    <!-- Cta Button -->
                    <div class="extra-space-l"></div>

                </div> <!-- /.container -->
            </div>
            <!-- End rotate-box-2 -->
        </section>
        <!-- End Services -->




        <!-- Begin testimonials -->
        <section id="testimonial-section">
            <div id="testimonial-trigger" class="testimonial text-white parallax" data-stellar-background-ratio="0.5" style="background-image: url(img/testimonial-bg.jpg);">
                <div class="cover"></div>
                <!-- Begin page header-->
                <div class="page-header-wrapper">
                    <div class="container">
                        <div class="page-header text-center wow fadeInDown" data-wow-delay="0.4s">
                            <h2>Reviews</h2>
                            <div class="devider"></div>
                            <p class="subtitle">What people say about us</p>
                        </div>
                    </div>
                </div>
                <!-- End page header-->
                <div class="container">
                    <div class="testimonial-inner center-block text-center">
                        <div id="owl-testimonial" class="owl-carousel">
                            <div class="item">
                                <blockquote>
                                    <p>"This was my first experience with that team and outperformed my expectation! They know there stuff and I highly recommend them! A+++".</p>
                                    <footer><cite title="Source Title">Daryl Hodgeman</cite></footer>
                                </blockquote>
                            </div>
                            <div class="item">
                                <blockquote>
                                    <p>"Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                                        tempor incididunt ut labore et dolore magna aliqua."</p>
                                    <footer><cite title="Source Title">John Doe</cite></footer>
                                </blockquote>
                            </div>
                            <div class="item">
                                <blockquote>
                                    <p>"Quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                                        consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                                        cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                                        proident, sunt in culpa qui officia deserunt mollit".</p>
                                    <footer><cite title="Source Title">John Doe</cite></footer>
                                </blockquote>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- End testimonials -->




        <!-- Begin Portfolio -->
        <div class="container" style="height: 50px;">

        </div>
        <!-- End portfolio -->




        <!-- Begin counter up -->
        <section id="counter-section">
            <div id="counter-up-trigger" class="counter-up text-white parallax" data-stellar-background-ratio="0.5" style="background-image: url(img/Happy-Hands.jpg);">
                <div class="cover"></div>
                <!-- Begin page header-->
                <div class="page-header-wrapper">
                    <div class="container">
                        <div class="page-header text-center wow fadeInDown" data-wow-delay="0.4s">
                            <h2>With Us</h2>
                            <div class="devider"></div>
                            <p class="subtitle">Before anyone is not told</p>
                        </div>
                    </div>
                </div>
                <!-- End page header-->
                <!--  <div class="container"> -->

                <div class="row">

                    <div class="fact text-center col-md-2 col-sm-6 col-md-offset-1">
                        <div class="fact-inner">
                            <i class="fa fa-users fa-3x"></i>
                            <div class="extra-space-l"></div>
                            <span class="counter"><?php echo $num_rows_user; ?></span>
                            <p class="lead">Clients</p>
                        </div>
                    </div>

                    <div class="fact text-center col-md-2 col-sm-6">
                        <div class="fact-inner">
                            <i class="fa fa-leaf fa-3x"></i>
                            <div class="extra-space-l"></div>
                            <span class="counter"><?php echo $num_rows_worker; ?></span>
                            <p class="lead">Workers</p>
                        </div>
                    </div>

                    <div class="fact text-center col-md-2 col-sm-6">
                        <div class="fact-inner">
                            <i class="fa fa-trophy fa-3x"></i>
                            <div class="extra-space-l"></div>
                            <span class="counter"><?php echo $num_rows_open_project ?></span>
                            <p class="lead">Open Works</p>
                        </div>
                    </div>

                    <div class="fact text-center col-md-2 col-sm-6">
                        <div class="fact-inner">
                            <i class="fa fa-trophy fa-3x"></i>
                            <div class="extra-space-l"></div>
                            <span class="counter"><?php echo $complete_project ?></span>
                            <p class="lead">Complete Works</p>
                        </div>
                    </div>

                    <div class="fact last text-center col-md-2 col-sm-6">
                        <div class="fact-inner">
                            <i class="fa fa-coffee fa-3x"></i>
                            <div class="extra-space-l"></div>
                            <span class="counter"><?= $total_paid; ?></span>
                            <p class="lead">Earned by workers</p>
                        </div>
                    </div>

                </div> <!-- /.row -->
                <!-- </div> -->
                <!-- /.container -->
            </div>
        </section>
        <!-- End counter up -->




        <!-- Begin team-->

        <!-- End team-->





        <!-- Begin prices section -->

        <!-- End prices section -->




        <!-- Begin social section -->
        <section id="social-section">

            <!-- Begin page header-->
            <div class="page-header-wrapper">
                <div class="container">
                    <div class="page-header text-center wow fadeInDown" data-wow-delay="0.4s">
                        <h2>Join Us</h2>
                        <div class="devider"></div>
                        <p class="subtitle">Follow us on social networks</p>
                    </div>
                </div>
            </div>
            <!-- End page header-->

            <div class="container">
                <ul class="social-list">
                    <li> <a href="https://www.facebook.com/WorkStation-100996911286297/" class="rotate-box-1 square-icon text-center wow zoomIn" data-wow-delay="0.3s" target="_blank"><span class="rotate-box-icon"><i class="fa fa-facebook"></i></span></a></li>
                </ul>
            </div>

        </section>
        <!-- End social section -->


        <!-- Begin footer -->
        <?php

        include "layouts/footer.php"

        ?>
        <!-- End footer -->

        <a href="#" class="scrolltotop"><i class="fa fa-arrow-up"></i></a> <!-- Scroll to top button -->

    </div><!-- body ends -->



    <!-- Plugins JS -->
    <script src="inc/owl-carousel/js/owl.carousel.min.js"></script>
    <script src="inc/animations/js/wow.min.js"></script>
    <script src="inc/isotope.pkgd.min.js"></script>
    <script src="inc/classie.js"></script>
    <script src="inc/jquery.easing.min.js"></script>
    <script src="inc/smoothscroll.js"></script>

    <!-- Theme JS -->
    <script type="text/javascript" src="js/theme.js"></script>




</body>


</html>