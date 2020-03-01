<!DOCTYPE html>
<html>

<head>
    <title>BdWorkStation | Browse Worker</title>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

    <meta name="description" content="It is human resource management project in Bangladesh">
    <meta name="keywords" content="human resource management, work, daily work, homework, earn money" />
    <meta name="author" content="M Irfanul Kalam Chowdhury, Foyzul Abrar Chowdhury, Yamin Sobhan">

    <!-- Mobile Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="shortcut icon" href="img/site_logo/favicon.ico" />

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">


    <!-- Theme CSS -->
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/mobile.css">

    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

</head>

<body class="browse-job-page-body">









    <?php
    if (!isset($_SESSION)) session_start();
    require 'vendor/autoload.php';
    require 'class/classForFunctions.php';
    require "backEnds/dbConnection.php";

    use Carbon\Carbon;

    if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == 1) {
        $account_type = $_SESSION['account_type'];
        $phone = $_SESSION['phone'];
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

    $account_type = $_SESSION['account_type'];
    if ($account_type == 'user') {
        $user_id = $_SESSION['user_id'];

        //Open Job Search For Invite
        $invite_job_list = $mysqli->query("SELECT * FROM job_table WHERE user_id = $user_id AND (SELECT job_status.job_id FROM job_status WHERE is_done='0' AND is_canceled='0' AND in_progress='0' AND job_table.job_id = job_status.job_id) ORDER BY post_time DESC");
    }


    $worker_status = $mysqli->query("SELECT * FROM worker_table INNER JOIN avg_worker_rating ON worker_table.worker_id = avg_worker_rating.worker_id WHERE worker_table.is_activated=0 AND worker_table.is_deleted=0 AND worker_table.profile_live_date IS NULL ORDER BY avg_worker_rating.worker_rating DESC");

    $area = $mysqli->query("SELECT * FROM area_table");
    $categories = $mysqli->query("SELECT * FROM category");

    if (isset($_GET['searchQuery'])) {
        $key = $_GET['searchQuery'];

        $worker_status = $mysqli->query("SELECT * FROM worker_table INNER JOIN avg_worker_rating ON worker_table.worker_id = avg_worker_rating.worker_id WHERE (worker_table.first_name LIKE '%" . $key . "%' OR worker_table.last_name LIKE '%" . $key . "%')  AND worker_table.is_activated=0 AND worker_table.is_deleted=0 AND worker_table.profile_live_date IS NULL ORDER BY avg_worker_rating.worker_rating DESC");
    }

    if (isset($_GET['cId']) || isset($_GET['aId'])) {

        $link = $_SERVER['REQUEST_URI'];
        if (parse_url($link, PHP_URL_QUERY)) {
            $parts = parse_url($link);
            parse_str($parts['query'], $qq);

            if (!empty($qq['cId']) && !empty($qq['aId'])) {
                $cId = $qq['cId'];
                $aId = $qq['aId'];
                // Search job both aId and cId
                $worker_status = $mysqli->query("SELECT * FROM worker_table INNER JOIN avg_worker_rating ON worker_table.worker_id = avg_worker_rating.worker_id WHERE worker_table.area='$aId' AND worker_table.category_id='$cId'  AND worker_table.is_activated=0 AND worker_table.is_deleted=0 AND worker_table.profile_live_date IS NULL ORDER BY avg_worker_rating.worker_rating DESC");
            } elseif (!empty($qq['cId']) && empty($qq['aId'])) {
                $cId = $qq['cId'];
                // Search job with cId
                $worker_status = $mysqli->query("SELECT * FROM worker_table INNER JOIN avg_worker_rating ON worker_table.worker_id = avg_worker_rating.worker_id WHERE worker_table.category_id='$cId'  AND worker_table.is_activated=0 AND worker_table.is_deleted=0 AND worker_table.profile_live_date IS NULL ORDER BY avg_worker_rating.worker_rating DESC");
            } elseif (empty($qq['cId']) && !empty($qq['aId'])) {
                $aId = $qq['aId'];
                // Search job with aId
                $worker_status = $mysqli->query("SELECT * FROM worker_table INNER JOIN avg_worker_rating ON worker_table.worker_id = avg_worker_rating.worker_id WHERE worker_table.area='$aId'  AND worker_table.is_activated=0 AND worker_table.is_deleted=0 AND worker_table.profile_live_date IS NULL ORDER BY avg_worker_rating.worker_rating DESC");
            }
        }
    }

    if (isset($_GET['cId'])) {
        $cId = $_GET['cId'];
        $category_name = $mysqli->query("SELECT * FROM category WHERE category_id = '$cId'");
        $category_name_show = mysqli_fetch_assoc($category_name);
    }
    if (isset($_GET['aId'])) {
        $aId = $_GET['aId'];
        $area_name = $mysqli->query("SELECT * FROM area_table WHERE area_id = '$aId'");
        $area_name_show = mysqli_fetch_assoc($area_name);
    }
    if ($account_type == 'worker') {
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
    }

    ?>


    <!--Facebook chat plugin-->


    <?php

    include "layouts/facebookContact.php"

    ?>


    <!--facebook chat plugin ends-->

    <?php

    include "layouts/nav.php"

    ?>

    <div class="container browse-job-page">
        <div class="row">
            <div class="col-md-12">
                <a href="browseWorker.php" class="heading">
                    <h3>Browse&nbsp;<span>Worker</span></h3>
                </a>
                <hr>

                <!-- Search start -->
                <form class="search-box" action="browseWorker.php" method="GET">
                    <div class="input-group">
                        <input type="text" class="form-control" <?php if (isset($_GET['searchQuery'])) { ?> placeholder="<?= $key; ?>" <?php } ?> placeholder="Search" name="searchQuery" id="searchQuery">
                        <div class="input-group-btn">
                            <button class="btn btn-danger" type="submit">
                                <i class="fa fa-search"></i>
                            </button>
                        </div>
                    </div>
                </form>
                <!-- Search End -->
                <div class="row container">
                    <div class="col-md-2">
                        <h4 class="h4">Sort By</h4>
                    </div>
                    <div class="col-md-10">
                        <div class="dropdown">
                            <button class="btn btn-active dropdown-toggle" type="button" data-toggle="dropdown"><i class="fas fa-map-marker-alt"></i><?php if (isset($_GET['aId'])) {
                                                                                                                                                            echo $area_name_show['area_name'];
                                                                                                                                                        } else { ?> Location <?php } ?>
                                <span class="caret"></span></button>
                            <ul class="dropdown-menu">
                                <?php
                                $link = $_SERVER['REQUEST_URI'];

                                if (parse_url($link, PHP_URL_QUERY)) {
                                    $parts = parse_url($link);
                                    parse_str($parts['query'], $qq);

                                    if (!empty($qq['cId'])) {
                                        $cId = $qq['cId'];

                                        while ($row = mysqli_fetch_array($area)) {
                                            ?>
                                            <li><a href="browseWorker.php?cId=<?= $cId; ?>&aId=<?= $row['area_id'] ?>"><?= $row['area_name']; ?></a></li>
                                        <?php
                                                }
                                            } else {
                                                while ($row = mysqli_fetch_array($area)) {
                                                    ?>
                                            <li><a href="browseWorker.php?aId=<?= $row['area_id'] ?>"><?= $row['area_name']; ?></a></li>
                                        <?php
                                                }
                                            }
                                        } else {
                                            while ($row = mysqli_fetch_array($area)) { ?>
                                        <li><a href="browseWorker.php?aId=<?= $row['area_id'] ?>"><?= $row['area_name']; ?></a></li>
                                <?php
                                    }
                                }
                                ?>

                            </ul>
                        </div>

                        <div class="dropdown">
                            <button class="btn btn-active dropdown-toggle" type="button" data-toggle="dropdown"><i class="fas fa-align-justify"></i> <?php if (isset($_GET['cId'])) {
                                                                                                                                                            echo $category_name_show['category_name'];
                                                                                                                                                        } else { ?> Category <?php } ?>
                                <span class="caret"></span></button>
                            <ul class="dropdown-menu">

                                <?php
                                $link = $_SERVER['REQUEST_URI'];

                                if (parse_url($link, PHP_URL_QUERY)) {

                                    $parts = parse_url($link);
                                    parse_str($parts['query'], $qq);

                                    if (!empty($qq['aId'])) {
                                        $aId = $qq['aId'];

                                        while ($row = mysqli_fetch_array($categories)) {
                                            ?>
                                            <li><a href="browseWorker.php?cId=<?= $row['category_id'] ?>&aId=<?= $aId ?>"><?= $row['category_name']; ?></a></li>
                                        <?php
                                                }
                                            } else {
                                                while ($row = mysqli_fetch_array($categories)) {
                                                    ?>
                                            <li><a href="browseWorker.php?cId=<?= $row['category_id'] ?>"><?= $row['category_name']; ?></a></li>
                                        <?php
                                                }
                                            }
                                        } else {
                                            while ($row = mysqli_fetch_array($categories)) { ?>
                                        <li><a href="browseWorker.php?cId=<?= $row['category_id'] ?>"><?= $row['category_name']; ?></a></li>
                                <?php

                                    }
                                }
                                ?>


                            </ul>
                        </div>
                    </div>
                </div>
                <hr>
                <?php
                $cc = 0;
                while ($row = $worker_status->fetch_assoc()) {
                    $cc++; // For Pagination
                    $is_verified = $row['is_verified'];
                    $is_promoted = $row['is_promoted'];
                    $worker_id = $row['worker_id'];
                    $worker_firstName = $row['first_name'];
                    $worker_lastName = $row['last_name'];
                    $worker_fullName = $worker_firstName . " " . $worker_lastName;
                    $worker_area = $row['area'];
                    $worker_category = $row['category_id'];
                    $area_id_check = $mysqli->query("SELECT area_name FROM area_table WHERE area_id = '$worker_area'");
                    $area_name = mysqli_fetch_array($area_id_check)['area_name'];
                    $category_id_check = $mysqli->query("SELECT category_name FROM category WHERE category_id = '$worker_category'");
                    $category_name = mysqli_fetch_array($category_id_check)['category_name'];

                    $avg_user_rating = $mysqli->query("SELECT worker_rating FROM avg_worker_rating WHERE worker_id = '$worker_id' ");
                    if ($avg_user_rating->num_rows > 0) {
                        # code...
                        $avg_rating = $avg_user_rating->fetch_assoc()['worker_rating'];
                        if ($avg_rating == 0) {
                            $avg_rating = "00";
                        }
                    } else {
                        $avg_rating = "00";
                    }
                    ?>
                    <div class="jobs row line-content">
                        <a target="_blank" href="browseProfile.php?wId=<?= $worker_id; ?>">
                            <div class="col-md-12 row">
                                <div class="col-md-4">
                                    <h5><?= $worker_fullName; ?>
                                        <?php
                                            if ($is_verified == 1) {
                                                ?>
                                            <img src="img/verifed_badge.svg" title="Verified By Team WorkStation" />
                                        <?php
                                            }
                                            if ($is_promoted == 1) {
                                                ?>
                                            <img src="img/recommand.svg" title="Recommandated worker By Team WorkStation" />
                                        <?php
                                            }
                                            ?>
                                    </h5>
                                </div>
                                <div class="col-md-1 col-xs-6">
                                    <span class="rating-static rating-<?= $avg_rating; ?>"></span>
                                </div>
                                <?php
                                    $avg_rating = $avg_rating[0] . "." . $avg_rating[1];
                                    ?>
                                <div class="col-md-1 col-xs-6">
                                    <h5><?= $avg_rating; ?></h5>
                                </div>

                                <p class="browseJobDetailsInfo col-md-3"><b>Category:</b> <?= $category_name; ?></p>
                                <p class="browseJobDetailsInfo col-md-2"><i class="fas fa-map-marker-alt"></i> <?= $area_name; ?></p>
                            </div>
                        </a>

                        <!-- <div class="col-md-3">
                            <button onclick="viewInviteJobList(1)" class="btn btn-danger">Invite</button>
                        </div> -->

                        <!-- Modal View Job List For Invite -->
                        <!-- <div id="viewInviteJobList" class="modal">
                        <div class="modal-content animate">
                            <span class="close" title="Close" onclick="viewInviteJobList(0)">&times;</span>
                            <br> <br><br>
                            <h6>In which job you want to invite?</h6>
                            <?php
                                if ($invite_job_list->num_rows > 0) { ?>
                            <div class="viewInviteJobList">
                                <?php
                                        while ($row = $invite_job_list->fetch_assoc()) {
                                            $job_post_time = $row['post_time'];
                                            $job_post_time = check_job_stable($job_post_time);
                                            if ($job_post_time[0] >= 0) {
                                                ?>
                                <input type="radio" name="inviteJobs">
                                <h5><a class="title" href="jobDetails.php?jId=<?= $row['job_id'] ?>&jobStatus"><?= $row['job_title'] ?></a></h5>
                                <hr>
                                <?php
                                            }
                                        } ?>

                            </div>
                            <center>
                                <button class="btn btn-warning inviteModalBtn">Invite</button>
                            </center>
                            <?php
                                }
                                ?>
                        </div>
                    </div> -->
                    </div>
                <?php
                }

                if ($cc > 0) {
                    ?>
                    <!-- Pagination Number Start -->
                    <center>
                        <?php include "layouts/pagination.php" ?>
                    </center>
                    <!-- Pagination Number End -->
                <?php } else { ?>
                    <img src='https://img.icons8.com/color/48/000000/sad.png'>
                    <!-- <i class="fas fa-sad-tear" style="font-size:55px;"></i> -->
                    <h3 class='h3'>There are no Workers.</h3>
                <?php
                } ?>
            </div>
        </div>

    </div>


    <?php

    include "layouts/footer.php"

    ?>

    <!-- Theme JS -->
    <script src="js/theme.js"></script>
    <script type="text/javascript" src="js/pagination.js"> </script>

    <script type="text/javascript" src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    
</body>

</html>