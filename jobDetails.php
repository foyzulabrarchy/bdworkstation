<!DOCTYPE html>
<html lang="en-US">

<head>
  <title>BdWorkStation | Job Details</title>


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

<body class="jobDetailsBody">






  <?php
  if (!isset($_SESSION)) session_start();
  require 'vendor/autoload.php';
  require 'class/classForFunctions.php';
  require 'class/queryString.php';
  require "backEnds/dbConnection.php";
  require "backEnds/workerNotificationEntry.php";
  require "backEnds/userNotificationEntry.php";

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

    if (isset($_GET['notmin'])) {
      $not_id = $_GET['notmin'];
      if ($account_type == 'user') {
        userMinusNotification($not_id);
      } elseif ($account_type == 'worker') {
        minusNotification($not_id);
      }
    }

    if (isset($_GET['delete'])) {
      $jId = $_GET['jId'];
      $job_id_delete = "UPDATE job_status SET is_canceled='1' WHERE job_id='$jId'";
      if ($mysqli->query($job_id_delete) === TRUE) {
        ?>
      <script>
        swal({
          title: "Done!",
          text: "Your Job is deleted!",
          icon: "success",
          button: "OK",
          closeOnClickOutside: false
        }).then(function() {
          window.location = "Dashboard.php";
        });
      </script>
      <?php
        }
      }

      if (isset($_GET['hire_cancel'])) { // Remove From Hire Table And make Job Status => in_progress = 0
        $jId = $_GET['jId'];
        if ($account_type == 'user') {
          $wId = $_GET['wId']; // Notify Worker
        } elseif ($account_type == 'worker') {
          $uId = $_GET['uId']; // Notify User
        }
        if ($account_type == 'user') {
          $proposal_cancel_by = $mysqli->query("UPDATE proposal_table SET user_cancel = '1' WHERE job_id='$jId'");
        } elseif ($account_type == 'worker') {
          $proposal_cancel_by = $mysqli->query("UPDATE proposal_table SET worker_cancel = '1'WHERE job_id='$jId' ");
        }
        $job_in_progress_zero = "UPDATE job_status SET in_progress='0' WHERE job_id='$jId' AND is_started='0'";
        if ($mysqli->query($job_in_progress_zero) === TRUE) {
          $delete_hire_table = "DELETE FROM hire_table WHERE job_id = '$jId'";
          if ($mysqli->query($delete_hire_table) === TRUE) {

            if ($account_type == 'user') {
              notifyHireCancel($jId, $wId); // Notify Worker
            } elseif ($account_type == 'worker') {
              userNotifyHireCancel($jId, $uId); // Notify User
            }
            ?>
        <script>
          swal({
            title: "Done!",
            text: "Your hire is canceled!",
            icon: "success",
            button: "OK",
            closeOnClickOutside: false
          }).then(function() {
            window.location = "jobDetails.php?jId=<?= $jId ?>&hired=cancel&jobStatus";
          });
        </script>
      <?php
          } else {
            $job_in_progress_zero = $mysqli->query("UPDATE job_status SET in_progress='1' WHERE job_id='$jId'");
            ?>
        <script>
          swal({
            title: "Error!",
            text: "Something is wrong!",
            icon: "error",
            button: "OK",
            closeOnClickOutside: false
          }).then(function() {
            window.location = "jobDetails.php?jId=<?= $jId ?>&jobStatus";
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
          window.location = "jobDetails.php?jId=<?= $jId ?>&jobStatus";
        });
      </script>
      <?php
        }
      }

      if (isset($_GET['start_job'])) {
        $jId = $_GET['jId'];
        // Need to check the job status that user cancel or not.
        $job_status_check = $mysqli->query("SELECT in_progress, is_started FROM job_status WHERE job_id='$jId'");
        $in_pro = $job_status_check->fetch_assoc()['in_progress'];
        $is_start = $job_status_check->fetch_assoc()['is_started'];
        if ($in_pro == 1 && $is_start == 0) {
          $job_is_started = "UPDATE job_status SET is_started='1' WHERE job_id='$jId'";
          if ($mysqli->query($job_is_started) === TRUE) {
            $job_start_status = 1;
            $job_progress_status = 1;
            ?>
        <script>
          swal({
            title: "Started!",
            text: "Your Job is started!",
            icon: "success",
            button: "OK",
            closeOnClickOutside: false
          }).then(function() {
            window.location = "jobDetails.php?jId=<?= $jId ?>&jobStatus";
          });
        </script>
      <?php
          } else {
            $job_start_status = 0;
            $job_progress_status = 1;
          }
        } else {
          ?>
      <script>
        swal({
          title: "Done!",
          text: "Job is Canceled!",
          icon: "success",
          button: "OK",
          closeOnClickOutside: false
        }).then(function() {
          window.location = "jobDetails.php?jId=<?= $jId ?>&jobStatus";
        });
      </script>
    <?php
      }
    }

    $account_details = $mysqli->query("SELECT * FROM user_table WHERE phone_number = $phone");
    $account_details_check = $account_details->fetch_assoc();
    $account_id = $account_details_check['user_id'];


    if (isset($_GET['cat_alert'])) {
      $job_category_alert = 1;
    } else {
      $job_category_alert = 0;
    }



    if (isset($_GET['jobStatus'])) { // Check Job Status When Job shows from Dash
      $jId = $_GET['jId'];
      $job_status_check = $mysqli->query("SELECT * FROM job_status WHERE job_id='$jId'");
      while ($status_check = $job_status_check->fetch_assoc()) {
        if ($status_check['is_started'] == 1) {
          $job_start_status = 1;
        } else {
          $job_start_status = 0;
        }
        if ($status_check['in_progress'] == 1) {
          $job_progress_status = 1;
        } else {
          $job_progress_status = 0;
        }
        if ($status_check['user_complete'] == 1) {
          $job_user_complete = 1;
        } else {
          $job_user_complete = 0;
        }
        if ($status_check['worker_complete'] == 1) {
          $job_worker_complete = 1;
        } else {
          $job_worker_complete = 0;
        }
      }
    }
    if (isset($_GET['jId'])) {
      $jId = $_GET['jId'];
      $_SESSION['job_id'] = $jId;
      $job_id_check = $mysqli->query("SELECT * FROM job_table WHERE job_id='$jId'");
      $row = $job_id_check->fetch_assoc();
      $job_category = $row['category_id'];
      $job_sub_category = $row['sub_category_id'];
      $job_service = $row['service_id'];
      $job_time = $row['job_time'];
      $job_image = $row['job_image'];
      $category_name_find = $mysqli->query("SELECT category_name FROM category WHERE category_id = $job_category");
      $job_category_ = $category_name_find->fetch_assoc();
      $sub_category_name_find = $mysqli->query("SELECT sub_category_name FROM sub_category_table WHERE sub_category_id = $job_sub_category");
      $job_sub_category_ = $sub_category_name_find->fetch_assoc();
      $service_name_find = $mysqli->query("SELECT service_name FROM service_table WHERE service_id = $job_service");
      $job_service_ = $service_name_find->fetch_assoc();





      $area_id_check = $row['job_area'];
      $area_id_check = $mysqli->query("SELECT area_name FROM area_table WHERE area_id='$area_id_check'");
      $area_show = $area_id_check->fetch_assoc();

      $post_time = $row['post_time'];
      $arr = check_job_stable($post_time);

      $user_id = $row['user_id'];
      // fetching user data
      $user_check = $mysqli->query("SELECT *FROM user_table WHERE user_id='$user_id'");
      $user_show = $user_check->fetch_assoc();
      $user_show_id = $user_show['user_id'];
      // User Rating
      $avg_user_rating = $mysqli->query("SELECT user_rating FROM avg_user_rating WHERE user_id = '$user_show_id' ");
      if ($avg_user_rating->num_rows > 0) {
        # code...
        $avg_rating = $avg_user_rating->fetch_assoc()['user_rating'];
      } else {
        $avg_rating = "00";
      }



      // fetching worker data
      $worker = $mysqli->query("SELECT * FROM worker_table WHERE phone_number='$phone'");
      if ($worker->num_rows > 0) {
        $worker_fetch = $worker->fetch_assoc();
        $worker_id = $worker_fetch['worker_id'];
        $worker_is_verified = $worker_fetch['is_verified'];
        $worker_category_id = $worker_fetch['category_id'];

        if ($worker_category_id ==  $job_category) {
          $job_category_alert = 0;
        } else {
          $job_category_alert = 1;
        }

        $proposal_check = $mysqli->query("SELECT * FROM proposal_table where worker_id=$worker_id and job_id=$jId");
        $proposal_arr = check_proposal_status($proposal_check);
      }
      $job_owner_status = 0;
      $proposals = $mysqli->query("SELECT * FROM proposal_table where job_id=$jId");
      if ($account_id == $user_id) {
        $job_owner_status = 1;
      }
      #checking hire status
      $hire_status = 0;
      $got_hired_status = 0;
      $hire_status_check = $mysqli->query("SELECT * FROM hire_table WHERE job_id= $jId");
      $hire_id = $hire_status_check->fetch_assoc()['hire_id'];
      if ($hire_status_check->num_rows > 0) {
        $hire_status = 1;
        $hire_status_show = $mysqli->query("SELECT worker_table.worker_id, worker_table.is_verified, worker_table.is_promoted, worker_table.first_name, worker_table.address, area_table.area_name, worker_table.phone_number,worker_table.image, proposal_table.proposal_price FROM worker_table INNER JOIN area_table ON area_table.area_id = worker_table.area INNER JOIN proposal_table ON worker_table.worker_id = proposal_table.worker_id INNER JOIN hire_table on hire_table.proposal_id = proposal_table.proposal_id WHERE hire_table.job_id = $jId");

        if ($account_type == 'worker') {
          $hired_worker_id = $hire_status_show->fetch_assoc()['worker_id'];
          if ($hired_worker_id == $_SESSION['worker_id']) {
            $got_hired_status = 1;
          }
        }
      }

      $edit_state = 0;
    }

    if (isset($_GET['edit'])) {
      $edit_state = 1;
    }

    if (isset($_GET['report'])) {
      $uId = $user_id;
      $wId = $worker_id;
      $report_type = $_POST['profileReportType'];
      $report_desc = $_POST['reportDesc'];

      $insert_report = "INSERT INTO user_report_table (user_id, report_type, report_description, from_worker) VALUES ('$uId', '$report_type', '$report_desc', '$wId')";
      if ($mysqli->query($insert_report) === TRUE) {
        ?>
      <script>
        swal({
          title: "Done!",
          text: "Your report is submitted!",
          icon: "success",
          button: "OK",
          closeOnClickOutside: false
        }).then(function() {
          window.location = "jobDetails.php?jId=<?= $jId ?>&jobStatus";
        });
      </script>
    <?php
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
          window.location = "jobDetails.php?jId=<?= $jId ?>&jobStatus";
        });
      </script>
  <?php
    }
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



  <?php
  if (isset($_GET['jobStatus'])) {
    if ($job_progress_status == 1) {
      $arr[0] = 'Job In Progress';
    }
  }
  if ($arr[0] >= 0) {
    ?>

    <div class="container">
      <div class="row">
        <div class="col-md-8">

          <div class="jobDetailsLeftAllContent">
            <div>
              <?php
                if ($edit_state == 1) {
                  ?>
                <form method="POST" action="backEnds/updatingJob.php?jId=<?= $jId ?>">
                  <textarea name="update_job_title"><?= $row['job_title']; ?></textarea> <br>
                <?php
                  } else {
                    ?>
                  <h1><?= $row['job_title']; ?>&nbsp;&nbsp;&nbsp;
                    <?php
                        if ($job_category_alert) {
                          if (empty($job_category_['category_name'])) {
                            ?>
                        <label style="font-size:14px" class="label label-info" title="Other Category">other</label>
                      <?php
                            } else {
                              ?>
                        <label style="font-size:14px" class="label label-warning" title="Category not match">alert</label>
                      <?php
                            }
                            ?>


                    <?php
                        } ?></h1>
                <?php
                  }
                  ?>
                <?php
                  if ($job_owner_status != 0) {
                    if (empty($job_category_['category_name'])) {
                      ?>
                    <p class="jobDetailsCategory">Other</p>
                  <?php
                      } else {
                        ?>
                    <p class="jobDetailsCategory"><?= $job_category_['category_name'] ?></p>
                    <p class="jobDetailsCategory"><?= $job_sub_category_['sub_category_name'] ?></p>
                  <?php
                      }
                      ?>

                  <?php
                      if (!empty($job_service_['service_name'])) {
                        ?>
                    <p class="jobDetailsCategory"><?= $job_service_['service_name'] ?></p>

                  <?php
                      }
                      ?>

                  <?php
                      if ($proposals->num_rows == 0) {
                        ?>
                    <p> <a class="jobDetailsCategory" href="jobDetails.php?jId=<?= $jId ?>&edit=1"><i class="far fa-edit"></i>Edit</a>
                    <?php
                        }
                        ?>

                    <?php if ($edit_state == 1) {
                          ?>
                      <a class="jobDetailsCategory" href="jobDetails.php?jId=<?= $jId ?>"><i class="far fa-window-close"></i>Cancel</a>
                    <?php
                        }
                        ?>
                    <?php if ($hire_status == 0) : ?>
                      <a class="jobDetailsCategory" href="jobDetails.php?jId=<?= $jId ?>&delete=1"><i class="fas fa-trash"></i> Delete</a></p>
                  <?php endif; ?>

                  <?php
                    } else {
                      if (empty($job_category_['category_name'])) {
                        ?>
                    <p class="jobDetailsCategory">Other</p>
                  <?php
                      } else {
                        ?>
                    <p class="jobDetailsCategory"><?= $job_category_['category_name'] ?>
                      <p class="jobDetailsCategory"><?= $job_sub_category_['sub_category_name'] ?>
                        <p class="jobDetailsCategory"><?= $job_service_['service_name'] ?>
                        <?php
                            }
                            ?>

                      <?php } ?>
                      <hr>

                      <p class="jobDetailsInfo"><i class="far fa-clock"></i> Posted <?= $arr[1]; ?></p>
                      <p class="jobDetailsInfo"><i class="fas fa-map-marker-alt"></i> <?= $area_show['area_name']; ?></p>
                      <p class="jobDetailsInfo"><i class="fas fa-business-time"></i> <?= $job_time ?> </p>
                      <br>

                      <h4 class="h4">Description</h4>
                      <br>
                      <?php
                        if ($edit_state == 1) {
                          ?>
                        <textarea class="textarea" name="update_description"><?= $row['job_description']; ?></textarea>
                        <button type="submit" class="btn btn-danger">Update</button>
                </form>
              <?php
                } else {
                  ?>
                <p><?= $row['job_description']; ?></p>
              <?php
                }
                ?> <br>
              <?php
                if (!empty($job_image)) {
                  ?>
                <div class="jobDetailsFile">
                  <label>Uploaded Files</label> <br><br>
                  <i class="fas fa-image" onclick="jobImgHand(1)"></i>

                  <div id="jobImage" class="modal">
                    <div class="modal-content animate">
                      <span class="close" title="Close" onclick="jobImgHand(0)">&times;</span><br>
                      <img src="image/job/<?= $job_image; ?>" alt="Job Image" class="img-responsive jobImage">
                    </div>
                  </div>
                </div>
              <?php } ?>
              <br>
              <?php
                if ($account_type == 'worker') {
                  if ($got_hired_status == 1) {
                    $find_user = $mysqli->query("SELECT user_table.user_id, user_table.is_verified, user_table.first_name, user_table.phone_number, user_table.address, area_table.area_name, user_table.image, proposal_table.proposal_price from user_table INNER JOIN proposal_table ON proposal_table.job_id = '$jId' INNER JOIN area_table ON area_table.area_id = user_table.area INNER JOIN job_table ON job_table.user_id = user_table.user_id WHERE job_table.job_id='$jId'");
                    while ($row = $find_user->fetch_assoc()) {
                      $hired_user_name = $row['first_name'];
                      $hired_user_phone = $row['phone_number'];
                      $hired_user_address = $row['address'];
                      $hired_user_area = $row['area_name'];
                      $hired_user_is_verified = $row['is_verified'];
                      $hired_user_id = $row['user_id'];
                      $hired_user_image = $row['image'];
                      $hired_user_proposal_price = $row['proposal_price'];
                    }

                    ?>
                  <!-- for worker to show user info -->
                  <div class="row">
                    <div class="col-md-1">
                      <img class="img-responsive img-circle" src="image/user/<?= $hired_user_image; ?>">
                    </div>
                    <div class="col-md-3">
                      <h5> <?= $hired_user_name ?>
                        <?php if ($hired_user_is_verified == 1) {
                                ?>
                          <img src="img/verifed_badge.svg" title="Verified By Team WorkStation" /></h5>
                    <?php
                          } ?>
                    </div>
                    <div class="col-md-3 col-xs-7">
                      <a href="tel:<?= $hired_user_phone ?>">
                        <p><i class="fas fa-phone"></i><?= $hired_user_phone ?></p>
                      </a>
                    </div>
                    <div class="col-md-2 col-xs-5">
                      <h5>৳ <?= $hired_user_proposal_price ?></h5>
                    </div>
                    <div class="col-md-3">
                      <?php
                            if ($job_start_status == 1) {
                              if ($job_worker_complete == 1) { ?>
                          <p><b>The job is Completed.</b></p>
                        <?php
                                } else { ?>
                          <a onclick="reviewModelHandle(1)"><button class="btn btn-success btn-sm">Complete</button></a>
                          <br> <br>
                        <?php
                                } ?>
                        <div id="userReview" class="modal">
                          <div class="modal-content animate">
                            <span class="close" title="Close" onclick="reviewModelHandle(0)">&times;</span>
                            <br><br>
                            <?php
                                    // User Information For Review
                                    while ($row = $find_user->fetch_assoc()) {
                                      $hired_user_name = $row['first_name'];
                                      $hired_user_image = $row['image'];
                                      $hired_user_id = $row['user_id'];
                                    }
                                    ?>
                            <h6>Review Section</h6>
                            <div class="row">
                              <div class="col-md-2">
                                <img class="img-responsive img-circle" src="image/user/<?= $hired_user_image ?>" alt="Worker Image">
                              </div>
                              <div class="col-md-5">
                                <h5><?= $hired_user_name ?></h5>
                              </div>
                              <form action="backEnds/reviewStar.php" method="POST">
                                <div class="col-md-5">
                                  <i id='1' onclick="clicked(1)" class="fas fa-star"></i>
                                  <i id='2' onclick="clicked(2)" class="fas fa-star"></i>
                                  <i id='3' onclick="clicked(3)" class="fas fa-star"></i>
                                  <i id='4' onclick="clicked(4)" class="fas fa-star"></i>
                                  <i id='5' onclick="clicked(5)" class="fas fa-star"></i>
                                </div>
                            </div><br>
                            <input type="hidden" id="giveRating" name="star_id">
                            <input type="hidden" name="star_job_id" value="<?= $jId; ?>">
                            <input type="hidden" name="star_user_id" value="<?= $hired_user_id; ?>">
                            <input type="hidden" name="star_worker_id" value="<?= $worker_id; ?>">
                            <label>Write something (optional)</label><br>
                            <textarea name="star_desc" id="review_des" cols="35" rows="2" class="form-control"></textarea>
                            <center>
                              <button type="submit" class="btn btn-success">Submit</button>
                            </center>
                            </form>
                            <p><b>Note:</b> Job is not complete until you do not give a review to the user.</p>
                            <!-- Worker NAme -->
                          </div>
                        </div>
                      <?php
                            } else { ?>
                        <div class="row">
                          <div class="col-md-6 col-xs-6">
                            <a href="jobDetails.php?jId=<?= $jId ?>&start_job=1&jobStatus"><button class="btn btn-success btn-sm">Start</button></a>
                          </div>
                          <div class="col-md-6 col-xs-6">
                            <a href="jobDetails.php?jId=<?= $jId ?>&hire_cancel=1&uId=<?= $hired_user_id; ?>&jobStatus"><button class="btn btn-danger btn-sm">Cancel</button></a>
                          </div>
                        </div>
                      <?php
                            }
                            ?>
                    </div>
                  </div>
                  <div>
                    <p><i class="fas fa-map-marker-alt"></i>&nbsp;&nbsp;<?= $hired_user_address ?> , <?= $hired_user_area ?></p>
                  </div>
                  <?php
                      } else {
                        if ($proposal_arr[0] == 1) { ?>
                    <div class="jobDetailsLeftForm">
                      <?php
                              if ($proposal_arr[2] == 1) { ?>
                        <p><b>Shit!!!!! You canceled your proposal.</b></p>
                      <?php
                              } else { ?>
                        <p><b>You have already sent a proposal</b></p>
                        <p>
                          <?= $proposal_arr[1] ?> TK
                        </p>
                      <?php
                              }
                              ?>

                    </div>
                  <?php

                        } else {
                          ?>
                    <h4 class="h4">New Proposal</h4>
                    <br>

                    <div class="jobDetailsLeftForm">
                      <form class="form-group" method="POST" action="backEnds/proposal.php">


                        <?php
                                if ($worker_is_verified == 0) {
                                  if ($job_category_alert) {
                                    ?>
                            <p><b>Please Enter your price</b></p>
                            <input class="form-control" rows="5" type="number" id="proposal_price" alt="Please Enter your price" name="proposal_price" title="Job category doesn't match with yours" min="100" max="50000" disabled />
                            <button class="btn btn-danger" title="Job category doesn't match with yours" disabled>Send</button>
                            <br><br>
                            <center>
                              <p class="text-danger"><b><i class="fas fa-exclamation-triangle"></i> You are not a verified worker and the category don't match. Click <a href="setting.php"><span>here</span></a> to verify your account.</b></p>
                            </center>
                          <?php } else { ?>
                            <p><b>Please Enter your price</b></p>
                            <input class="form-control" rows="5" type="number" id="proposal_price" alt="Please Enter your price" name="proposal_price" title="You are not a verified worker" min="100" max="50000" disabled />
                            <button class="btn btn-danger" title="You are not a verified worker." disabled>Send</button>
                            <br><br>
                            <center>
                              <p class="text-danger"><b><i class="fas fa-exclamation-triangle"></i> You are not a verified worker. Click <a href="setting.php"><span>here</span></a> to verify your account.</b></p>
                            </center>
                            <?php }
                                    } else {


                                      if ($job_category_alert) {
                                        if (empty($job_category_['category_name'])) {
                                          ?>
                              <p><b>Please Enter your price</b></p>
                              <input class="form-control" rows="5" type="number" id="proposal_price" alt="Please Enter your price" name="proposal_price" title="You are not a verified worker" min="100" max="50000" />
                              <button class="btn btn-danger" title="submit your proposal">Send</button>
                            <?php
                                        } else {
                                          ?>
                              <p><b>Please Enter your price</b></p>
                              <input class="form-control" rows="5" type="number" id="proposal_price" alt="Please Enter your price" name="proposal_price" title="Job category doesn't match with yours" min="100" max="50000" disabled />
                              <button class="btn btn-danger" title="Job category doesn't match with yours" disabled>Send</button>
                              <br><br>
                              <center>
                                <p class="text-danger"><b><i class="fas fa-exclamation-triangle"></i> Your category don't match.</b></p>
                              </center> 
                            <?php
                                        }
                                        ?>

                          <?php } else { ?>
                            <p><b>Please Enter your price</b></p>
                            <input class="form-control" rows="5" type="number" id="proposal_price" alt="Please Enter your price" name="proposal_price" title="You are not a verified worker" min="100" max="50000" />
                            <button class="btn btn-danger" title="submit your proposal">Send</button>
                        <?php }
                                } ?>
                      </form>
                    </div>
                    <br><br>


                  <?php
                        }
                      }
                    } elseif ($job_owner_status) {
                      if ($hire_status != 0) {
                        ?>
                  <center>
                    <p class="jobDetailsLeftAlert">Congratulation on your hire. You can check the worker's contact details below.</p>
                  </center>
                  <?php

                        while ($hire_check = $hire_status_show->fetch_assoc()) {
                          $hired_worker_id = $hire_check['worker_id'];
                          $hired_worker_first_name = $hire_check['first_name'];
                          $hired_worker_image = $hire_check['image'];
                          $hired_worker_address = $hire_check['address'];
                          $hired_worker_is_verified = $hire_check['is_verified'];
                          $hired_worker_is_promoted = $hire_check['is_promoted'];
                          $hired_worker_area = $hire_check['area_name'];
                          $hired_worker_phone_number = $hire_check['phone_number'];
                          $hired_worker_proposal_price = $hire_check['proposal_price'];
                        }
                        ?>

                  <div class="row">
                    <div class="col-md-1">
                      <img class="img-responsive img-circle" src="image/worker/<?= $hired_worker_image; ?>">
                    </div>
                    <div class="col-md-3 col-xs-12">
                      <h5> <?= $hired_worker_first_name ?>
                        <?php if ($hired_worker_is_verified == 1) {
                                ?>
                          <img src="img/verifed_badge.svg" title="Verified By Team WorkStation" />
                        <?php
                              }
                              if ($hired_worker_is_promoted == 1) {
                                ?>
                          <img src="img/recommand.svg" title="Recommandated worker By Team WorkStation" /></h5>
                    <?php
                          } ?>


                    </div>
                    <div class="col-md-3 col-xs-7">
                      <a href="tel:<?= $hired_worker_phone_number ?>">
                        <p><i class="fas fa-phone"></i><?= $hired_worker_phone_number ?></p>
                      </a>
                    </div>
                    <div class="col-md-2 col-xs-5">
                      <h5>৳ <?= $hired_worker_proposal_price ?></h5>
                    </div>
                    <div class="col-md-3">
                      <?php
                            if ($job_start_status == 1) {
                              if ($job_user_complete == 1) { ?>
                          <p><b>The job is completed.</b></p>
                        <?php
                                } else { ?>
                          <a onclick="reviewModelHandle(1)"><button class="btn btn-success btn-sm">Complete</button></a>
                        <?php
                                } ?>

                        <div id="userReview" class="modal">
                          <div class="modal-content animate">
                            <span class="close" title="Close" onclick="reviewModelHandle(0)">&times;</span>
                            <br><br>
                            <?php
                                    // Worker Information For Review
                                    while ($hire_check = $hire_status_show->fetch_assoc()) {
                                      $hired_worker_first_name = $hire_check['first_name'];
                                      $hired_worker_image = $hire_check['image'];
                                    }
                                    ?>
                            <h6>Review Section</h6>
                            <div class="row">
                              <div class="col-md-2">
                                <img class="img-responsive img-circle" src="image/worker/<?= $hired_worker_image; ?>" alt="Worker Image">
                              </div>
                              <div class="col-md-5">
                                <h5><?= $hired_worker_first_name; ?></h5>
                              </div>
                              <form action="backEnds/reviewStar.php" method="POST">
                                <div class="col-md-5">
                                  <i id='1' onclick="clicked(1)" class="fas fa-star"></i>
                                  <i id='2' onclick="clicked(2)" class="fas fa-star"></i>
                                  <i id='3' onclick="clicked(3)" class="fas fa-star"></i>
                                  <i id='4' onclick="clicked(4)" class="fas fa-star"></i>
                                  <i id='5' onclick="clicked(5)" class="fas fa-star"></i>
                                </div>
                            </div><br>
                            <input type="hidden" id="giveRating" name="star_id">
                            <input type="hidden" name="star_job_id" value="<?= $jId; ?>">
                            <input type="hidden" name="star_user_id" value="<?= $user_id; ?>">
                            <input type="hidden" name="star_worker_id" value="<?= $hired_worker_id; ?>">
                            <label>Write something (optional)</label><br>
                            <textarea name="star_desc" id="review_des" cols="35" rows="2" class="form-control"></textarea>
                            <center>
                              <button type="submit" class="btn btn-success">Submit</button>
                            </center>
                            </form>
                            <p><b>Note:</b> Job is not complete until you do not give a review to the worker.</p>
                            <!-- Worker NAme -->
                          </div>
                        </div>
                      <?php
                            } else { ?>
                        <a class="col-xs-6" href="jobDetails.php?jId=<?= $jId ?>&hire_cancel=1&wId=<?= $hired_worker_id ?>&jobStatus"><button class="btn btn-danger btn-sm">Cancel</button></a>
                      <?php
                            }
                            ?>

                    </div>
                  </div>
                  <div>
                    <!-- <br><br> -->
                    <p><i class="fas fa-map-marker-alt"></i>&nbsp;&nbsp;<?= $hired_worker_address ?> , <?= $hired_worker_area ?></p>
                  </div>


                  <?php
                      } else {
                        if ($proposals->num_rows > 0) {
                          ?>
                    <center>
                      <p class="jobDetailsLeftAlert" onclick="propLiHand(1)">Check proposals the proposals below</p>
                    </center>
                    <div id="proposalLists" class="modal">
                      <div class="modal-content animate">
                        <span class="close" title="Close" onclick="propLiHand(0)">&times;</span>
                        <br>
                        <?php
                                while ($propose = $proposals->fetch_assoc()) {
                                  $is_user_cancel = $propose['user_cancel'];
                                  $is_worker_cancel = $propose['worker_cancel'];
                                  $sender_id = $propose['worker_id'];
                                  $_SESSION['sender_id'] = $sender_id;
                                  $_SESSION['job_id'] = $jId;
                                  $_SESSION['user_show_id'] = $user_show_id;
                                  $proposal_id = $propose['proposal_id'];
                                  $sender_id_fetch = $mysqli->query("SELECT * FROM worker_table WHERE worker_id='$sender_id'");
                                  $sender_id_fetch_ = $sender_id_fetch->fetch_assoc();
                                  $sender_first_name = $sender_id_fetch_['first_name'];
                                  $sender_last_name = $sender_id_fetch_['last_name'];
                                  $sender_name = $sender_first_name . "  " . $sender_last_name;
                                  $sender_image = $sender_id_fetch_['image'];
                                  $sender_is_verified = $sender_id_fetch_['is_verified'];
                                  $sender_is_promoted = $sender_id_fetch_['is_promoted'];
                                  $proposed_price = $propose['proposal_price'];

                                  $sender_review = $mysqli->query("SELECT worker_rating FROM avg_worker_rating WHERE worker_id = '$sender_id'");
                                  if ($sender_review->num_rows > 0) {
                                    while ($rating = $sender_review->fetch_assoc()) {
                                      $rating_value = $rating['worker_rating'];

                                      if ($rating_value == 0) {
                                        $rating_value = "00";
                                      }
                                    }
                                  } else {
                                    $rating_value = "00";
                                  }
                                  ?>
                          <form action="backEnds/hire.php" method="POST">
                            <div class="row JobProposalLists">
                              <div class="col-md-2 col-xs-4">
                                <img class="img-responsive img-circle" src="image/worker/<?= $sender_image; ?>">
                              </div>
                              <div class="col-md-5 col-xs-4">
                                <p><input type="hidden" name="proposal_id" value="<?php echo $proposal_id; ?>" /></p>
                                <p><input type="hidden" name="sender_id" value="<?php echo $sender_id; ?>" /></p>
                                <h4> <?= $sender_first_name; ?></h4>
                                <?php
                                          if ($sender_is_verified == 1) { ?>
                                  <img src="img/verifed_badge.svg" title="Verified By Team WorkStation" />
                                <?php
                                          }
                                          if ($sender_is_promoted == 1) {
                                            ?>
                                  <img src="img/recommand.svg" title="Recommandated worker By Team WorkStation" />
                                <?php
                                          } ?>
                              </div>
                              <div class="col-md-4 col-xs-4">
                                <h5>৳ <?= $proposed_price ?></h5>
                              </div>
                            </div>
                            <br>
                            <div class="row">
                              <p class="col-md-6 col-xs-6">Worker Rating: </p>
                              <span class="col-md-4 col-xs-4 rating-static rating-<?= $rating_value; ?>"></span>
                              <?php
                                        $rating_value = $rating_value[0] . "." . $rating_value[1];
                                        ?>
                              <p class="col-md-2 col-xs-2"><?= $rating_value; ?></p>
                            </div>
                            <?php
                                      if ($is_worker_cancel == 1) { ?>
                              <button class="btn btn-danger hireBtn" style="width:100%" disabled>Withdraw Proposal</button>
                            <?php
                                      } else { ?>
                              <button class="btn btn-danger hireBtn" style="width:100%">Hire</button>
                            <?php
                                      }
                                      ?>
                            <hr>
                          </form>



                        <?php } ?>
                      </div>
                    </div>


                  <?php
                        } else { ?>
                    <center>
                      <p class="jobDetailsLeftAlert">There is no active proposal for this job</p>
                    </center>
                <?php
                      }
                    }
                  } else {
                    ?>
                <center>
                  <p class="jobDetailsLeftAlert">This section is only for worker. To post a job please <a href="postjob.php" class="alert-link" target="blank">click here</a></p>
                </center>
              <?php
                }
                ?>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="jobDetailsRightAllContent">
            <center>
              <p>ENDS IN (DAYS)</p>
              <h4><?php echo $arr[0]; ?></h4>
              <br>
              <?php
                if ($account_type == 'worker') {
                  $loc = "browsejob.php?cId=" . $job_category;
                  ?>
                <a href="<?= $loc; ?>"><button class="btn btn-success">Browse jobs like this</button></a>
              <?php
                } else {
                  ?>

                <a href="postjob.php"><button class="btn btn-success">POST A JOB LIKE THIS</button></a>
              <?php
                } ?>
              <br><br>

              <img class="img-responsive img-circle Jobuser-image" src="image/user/<?= $user_show['image']; ?>"><br>
              <h5><?= $user_show['first_name']; ?>
                <?php if ($user_show['is_verified'] == 1) { ?>
                  <img src="img/verifed_badge.svg" title="Verified By Team WorkStation" />
              </h5><br>
            <?php } ?>
            <div class="row">
              <p class="col-md-6 col-xs-6">User Rating</p>
              <div class="col-md-2 col-xs-4">
                <span class="rating-static rating-<?= $avg_rating; ?>"></span>
              </div>
              <?php
                $avg_rating = $avg_rating[0] . "." . $avg_rating[1];
                ?>
              <p class="col-md-3 col-xs-2"><?= $avg_rating; ?></p>
            </div>
            <br>
            <div>
              <?php
                if ($job_owner_status) {
                  ?>
                <hr>
                <h5 class="h5">Proposals: <?= $proposals->num_rows ?></h5>
                <?php
                  } else {
                    if ($account_type == 'worker') {
                      if ($job_start_status == 1) { ?>
                    <!-- Report Section -->
                    <p class="browseProfileReport" onclick="viewUserReport(1)"><i class="fas fa-flag-checkered"></i> Report this profile</button></p>
              <?php
                    }
                  }
                }

                ?>
            </div>
            </center>
          </div>
          <?php
            if ($account_type == 'worker') {
              ?>

            <!-- Report Modal Section -->
            <div id="viewUserReport" class="modal">
              <div class="modal-content animate">
                <span class="close" title="Close" onclick="viewUserReport(0)">&times;</span>
                <br> <br><br>
                <h6>Why are you reportig this profile?</h6>
                <form action="jobDetails.php?jId=<?= $jId ?>&jobStatus&report" method="POST" enctype="multipart/form-data">
                  <div class="form-group reportModal">
                    <label>Select Report Type</label><br>
                    <select name="profileReportType" class="reportTypeSelect" required>
                      <option disabled selected value>---Select One---</option>
                      <option name="itemFor" value="contactDetails">Contact details are revealed</option>
                      <option name="itemFor" value="promotingSelf"> Promoting Self</option>
                      <option name="itemFor" value="offensiveContent">Offensive Content</option>
                      <option name="itemFor" value="spamContent">Spam Content</option>
                      <option name="itemFor" value="other">Other</option>
                    </select>
                    <br><br>
                    <label>Please explain us</label><br>
                    <!-- <input type="text" class="form-group"> -->
                    <textarea name="reportDesc" cols="30" rows="5" required></textarea>
                    <br>
                    <center>
                      <button type="submit" class="btn btn-warning">Submit</button>
                    </center>
                  </div>
                </form>
              </div>
            </div>

            <!-- Ask Question Section -->
            <p class="askQues" onclick="askQuesHand(1)">ASK QUESTION <i class="fas fa-question-circle"></i></p>
            <div id="askQues" class="modal">
              <div class="modal-content animate">
                <span class="close" title="Close" onclick="askQuesHand(0)">&times;</span><br>
                <center>
                  <form action="backEnds/jobQuestion.php?uId=<?= $user_id; ?>" method="POST">
                    <div class="askQuesInput">
                      <h5>Ask Your Question</h5>
                      <?php
                          if ($worker_is_verified == 1) {
                            ?>
                        <textarea name="job_question" cols="40" rows="5" required></textarea><br>
                        <button type="submit" class="btn">ASK</button>
                      <?php } else { ?>

                        <textarea name="job_question" cols="40" rows="5" title="You are not a verified worker" disabled></textarea><br>
                        <button type="submit" class="btn" title="You are not a verified worker" disabled>ASK</button>
                      <?php } ?>
                    </div>
                  </form>
                </center>
              </div>
            </div>
          <?php
            }
            ?>
          <!-- View Question Section -->
          <p class="askQues" onclick="viewQuesHand(1)">View Question <i class="fas fa-eye"></i></p>
          <div id="viewQues" class="modal">
            <div class="modal-content animate">
              <span class="close" title="Close" onclick="viewQuesHand(0)">&times;</span><br>
              <div class="viewQues">
                <?php
                  $question_search = $mysqli->query("SELECT * FROM question_table WHERE job_id = '$jId' AND is_active = 1");
                  if ($question_search->num_rows > 0) {
                    $ques_count = 1;
                    while ($row = mysqli_fetch_array($question_search)) {
                      $question_id = $row['id'];
                      $question = $row['question'];
                      ?>
                    <h5>Q<?= $ques_count; ?>. <?= $question; ?></h5>
                    <?php
                          $answer_check = $mysqli->query("SELECT * FROM answer_table WHERE question_id = '$question_id' AND is_active = 1");
                          if ($answer_check->num_rows > 0) {
                            while ($row = mysqli_fetch_array($answer_check)) {
                              $answer_id = $row['id'];
                              $answer = $row['answer'];
                              ?>
                        <label class="giveAnsLabel" onclick="viewAns('ownerAnswerShow<?= $answer_id; ?>')"><i class="far fa-comment-alt"></i> View Answre</label>

                        <!-- Answre Show for Both USER and Worker -->
                        <div id="ownerAnswerShow<?= $answer_id; ?>" class="modal">
                          <div class="modal-content animate">
                            <a href="jobDetails.php?jId=<?= $jId ?>&jobStatus" class="close" title="Close">&times;</a><br><br>
                            <h6>Answer is</h6>
                            <p class="showAnswer"><?= $answer; ?></p>
                          </div>
                        </div>
                      <?php
                              }
                            } else {
                              ?>
                      <?php if ($job_owner_status == 1) { ?>
                        <label class="giveAnsLabel" onclick="viewAnsBox('ownerAnswer<?= $question_id; ?>')"><i class="far fa-comment-alt"></i> Answre</label>

                        <!-- Answre Section for Owner -->
                        <div id="ownerAnswer<?= $question_id; ?>" class="modal">
                          <div class="modal-content animate">
                            <a href="jobDetails.php?jId=<?= $jId ?>&jobStatus" class="close" title="Close">&times;</a><br>
                            <center>
                              <form action="backEnds/jobAnswer.php?qId=<?= $question_id; ?>" method="POST">
                                <div class="askQuesInput">
                                  <h6>ID is <?= $question_id; ?></h6><br>
                                  <textarea name="job_answer" cols="40" rows="5" required></textarea><br>
                                  <button type="submit" class="btn">POST</button>
                                </div>
                              </form>
                            </center>
                          </div>
                        </div>

                    <?php }
                          } ?>

                    <hr>
                  <?php
                        $ques_count++;
                      }
                    } else {
                      ?>
                  <h5>There are no questions.</h5>
                <?php
                  }
                  ?>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>

  <?php
  } else {
    ?>
    <div class="container">
      <div class="row">
        <div class="col-md-8">

          <div class="jobDetailsLeftAllContent">
            <div>
              <center>
                <h1>This project is no longer available due to no response</h1>
                <hr>

                <br>
                <p>Why not search for other jobs that may interest you!</p>
                <li><a href="browsejob.php"><button class="btn btn-danger btn-md">Browse job</button></a></li>
              </center>


            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="jobDetailsRightAllContent">
            <center>
              <br><br>
              <img class="img-responsive img-circle Jobuser-image" src="image/user/<?= $user_show['image']; ?>">
              <h5><?= $user_show['first_name']; ?></h5>
              <div class="row">
                <p class="col-md-8">User Rating</p>
                <div class="col-md-2">
                  <span class="rating-static rating-<?= $avg_rating; ?>"></span>
                </div>
                <?php
                  $avg_rating = $avg_rating[0] . "." . $avg_rating[1];
                  ?>
                <p class="col-md-2"><?= $avg_rating; ?></p>
              </div>
              <br><br>

            </center>
          </div>
        </div>
      </div>
    </div>
  <?php }
  include 'layouts/footer.php';
  ?>


  <script type="text/javascript" src="js/theme.js"></script>

  <script type="text/javascript" src="js/reviewStar.js"></script>


</body>

</html>