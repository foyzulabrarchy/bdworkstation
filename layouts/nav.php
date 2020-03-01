<?php

require "backEnds/dbConnection.php";


if (!isset($_SESSION)) session_start();

if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == 1) {
  $phone = $_SESSION['phone'];
  $first_name = $_SESSION['first_name'];
  $image1 = $_SESSION['image_name'];
  $account_type = $_SESSION['account_type'];
  if ($account_type == 'user') {
    $image = 'image/user/' . $image1;
    $user_id_check = $mysqli->query("SELECT user_id FROM user_table WHERE phone_number= '$phone'");
    $user_id = $user_id_check->fetch_assoc()['user_id'];
    $_SESSION['user_id'] = $user_id;

    //Notification Check
    $not_check = $mysqli->query("SELECT * FROM user_notification_table WHERE for_user = '$user_id' AND not_read = 0 ORDER BY not_time DESC");
    $not_check_mbl = $mysqli->query("SELECT * FROM user_notification_table WHERE for_user = '$user_id' AND not_read = 0 ORDER BY not_time DESC");
  } elseif ($account_type == 'worker') {
    $worker_id_check = $mysqli->query("SELECT worker_id FROM worker_table WHERE phone_number= '$phone'");
    $worker_id = $worker_id_check->fetch_assoc()['worker_id'];
    $_SESSION['worker_id'] = $worker_id;
    $image = 'image/worker/' . $image1;
    $account_details = $mysqli->query("SELECT category_id from worker_table where phone_number=$phone");
    $category_show = mysqli_fetch_array($account_details);
    $category_show_id = $category_show['category_id'];

    // $job_check = $mysqli->query("SELECT job_id from job_table where category_id=$category_show_id and is_done='0'");
    //Notification Check
    $not_check = $mysqli->query("SELECT * FROM worker_notification_table WHERE for_worker = '$worker_id' AND not_read = 0 ORDER BY not_time DESC");
    $not_check_mbl = $mysqli->query("SELECT * FROM worker_notification_table WHERE for_worker = '$worker_id' AND not_read = 0 ORDER BY not_time DESC");
  }
} else {
  if (isset($_SESSION['account_type']) == 'null') {
    $image = 'img/default_profile.jpg';
  }
}

if (isset($_GET['logout']) && $_GET['logout'] == 1) {
  session_unset();
  header("location: index.php");
}




?>

<!-- code.jquery Used for OTP  -->
<script type="text/javascript" src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="js/otpHandler.js"></script>
<script src="https://sdk.accountkit.com/en_US/sdk.js"></script>
<script type="text/javascript" src="js/theme.js"></script>

<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script> -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
<?php

if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == 1) {
  ?>
  <script src="https://js.pusher.com/4.4/pusher.min.js"></script>
  <script>
    // Enable pusher logging - don't include this in production
    Pusher.logToConsole = true;

    var pusher = new Pusher('9674b4b0258572271d2c', {
      cluster: 'ap2',
      forceTLS: true
    });

    var channel = pusher.subscribe('my-channel');
    channel.bind('my-event', function(data) {
          // alert(JSON.stringify(data));

          //jquery Ajax
          $.ajax({
              <?php
                if ($account_type == 'user') { ?>
                url: "layouts/notificationList.php",
                success: function(result) {

                  $("#div2").html(result);
                  $("#div4").html(result);

                  let a = document.querySelectorAll('.notification-item');
                  let badge = a.length / 2;
                  var x = document.getElementsByClassName("badge");
                  x[0].innerHTML = badge;
                  x[1].innerHTML = badge;

                <?php
                  } elseif ($account_type == 'worker') { ?>
                  url: "layouts/notificationList.php",
                    success: function(result) {
                      $("#div1").html(result);
                      $("#div3").html(result);

                      let a = document.querySelectorAll('.notification-item');
                      let badge = a.length / 2;
                      var x = document.getElementsByClassName("badge");
                      x[0].innerHTML = badge;
                      x[1].innerHTML = badge;

                    <?php
                      }
                      ?>

                    }
                });

          });
  </script>
<?php

}

?>


<div id="mySidenav" class="sidenav">
  <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>

  <?php if (!isset($_SESSION['logged_in'])) {
    ?>
    <li><a class="page-scroll" href="#body">HOME</a></li>
    <hr>
    <li><a class="page-scroll" href="#about-section">ABOUT</a></li>
    <hr>
    <li><a class="page-scroll" href="#services-section">SERVICES</a></li>
    <hr>
    <li><a class="page-scroll" onclick="showLogin()">LOG IN</a></li>
    <hr>
    <li><a class="page-scroll" onclick="smsLogin()">JOIN</a></li>
    <hr>
    <li>
      <div>
        <a href="postjob.php" class="sideNavPostButton" aria-haspopup="true" aria-expanded="false">
          Post Job
        </a>
      </div>
    </li>
  <?php
  } elseif ($_SESSION['logged_in'] == 1) {
    ?>
    <li><a href="Dashboard.php"> Dashboard</a></li>
    <hr>
    <li><a href="profile.php"> Profile</a></li>
    <hr>
    <?php
      if ($account_type == 'user') {
        ?>
      <li><a href="setting.php"> Setting</a></li>
      <hr>
      <li><a href="index.php?logout=1"> Log Out</a></li>
      <hr>
      <li>
        <div class="dropdown">
          <a href="#" class="dropdown-toggle sideNavPostButton" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">&nbsp;Search&nbsp;</a>
          <ul class="dropdown-menu">
            <li><a href="browsejob.php">Search Job</a></li>
            <li role="separator" class="divider"></li>
            <li><a href="browseWorker.php">Search Worker</a></li>
          </ul>
        </div>
      </li>
      <hr>
      <li>
        <div>
          <a href="postjob.php" class="sideNavPostButton" aria-haspopup="true" aria-expanded="false">
            Post Job
          </a>
        </div>
      </li>
    <?php
      } elseif ($account_type == 'worker') {
        ?>
      <li><a href="buyPromotion.php"> Enable Profile Promotion</a></li>
      <hr>
      <li><a href="buyCredits.php"> Buy SMS Notification</a></li>
      <hr>
      <li><a href="transactionList.php"> Transaction List</a></li>
      <hr>
      <li><a href="setting.php"> Setting</a></li>
      <hr>
      <li><a href="index.php?logout=1"> Log Out</a></li>
      <hr>
      <li>
        <div>
          <a href="browsejob.php" class="sideNavPostButton" aria-haspopup="true" aria-expanded="false">
            Browse Job
          </a>
        </div>
      </li>
      <br>
  <?php
    }
  } ?>
</div>

<div id="notifySidenav" class="notificationSidenav">
  <a href="javascript:void(0)" class="closebtn" onclick="document.getElementById('notifySidenav').style.width = '0%';">&times;</a>
  <li><a class="page-scroll" href="#body" style="color:#FFFFFF">HOME</a></li>
  <?php

  if ($account_type == 'user') {
    ?>
    <ul class="notification-list">
      <div id="div4">

        <div class="notification-contents">

          <?php
            $i = 0;
            if ($not_check_mbl->num_rows > 0) {
              while ($notif = mysqli_fetch_array($not_check_mbl)) {
                $i++;
                $not_id = $notif['id'];
                $not_type = $notif['not_type'];
                $job_id = $notif['job_id'];
                $not_time = $notif['not_time'];
                $not_time = check_job_stable($not_time);

                // Start
                ?>
              <li class="notification-item"><a href='jobDetails.php?jId=<?= $job_id; ?>&notmin=<?= $not_id; ?>&jobStatus'>

                  <?php if ($not_type == 'proposal') { ?>
                    A worker sends proposal in this job
                  <?php } elseif ($not_type == 'hireCancel') { ?>
                    Worker cancels the hire in this job
                  <?php } elseif ($not_type == 'askQuestion') { ?>
                    A question ask on this job
                  <?php
                        }
                        ?>
                  <p><?= $not_time[1]; ?></p></a>
              </li>
            <?php
                  //End
                }
              } else { ?>
            <li class="notification-item">There are no notification to see.</li>
          <?php
            }

            ?>
        </div>

      </div>
    </ul>

  <?php } elseif ($account_type == 'worker') {
    ?>
    <ul class="notification-list">
      <div id="div3">

        <div class="notification-contents">
          <?php
            $i = 0;
            if ($not_check_mbl->num_rows > 0) {
              while ($notif = mysqli_fetch_array($not_check_mbl)) {
                $i++;
                $not_id = $notif['id'];
                $not_type = $notif['not_type'];
                $job_id = $notif['job_id'];
                $not_time = $notif['not_time'];
                $not_time = check_job_stable($not_time);

                // Start
                ?>
              <li class="notification-item"><a href='jobDetails.php?jId=<?= $job_id; ?>&notmin=<?= $not_id; ?>&jobStatus'>

                  <?php if ($not_type == 'job') { ?>
                    We have found a job for you
                  <?php } elseif ($not_type == 'hire') { ?>
                    You are hired in this job
                  <?php
                        } elseif ($not_type == 'hireCancel') { ?>
                    Your hire is cancel in this job
                  <?php
                        }
                        ?>
                  <p><?= $not_time[1]; ?></p></a>
              </li>
            <?php
                  //End
                }
              } else { ?>
            <li class="notification-item">There are no notification to see</li>
          <?php
            }

            ?>
        </div>

      </div>
    </ul>
  <?php
  } ?>
</div>


<header id="header" class="header-main">
  <!-- Begin Navbar -->
  <nav id="main-navbar" class="navbar navbar-fixed-top" role="navigation">

    <div class="container">

      <!-- Brand and toggle get grouped for better mobile display -->
      <div class="navbar-header">
        <?php if (!isset($_SESSION['logged_in'])) : ?>
          <a class="navbar-brand" href="index.php"><img src="img/site_logo/workstation.svg" alt="WorkStation"></a>


          <a href="index.php" class="mobileNotifyBtn col-xs-6" style="margin-top:5%;margin-left:2%"><img src="img/site_logo/workstation_mbl.svg" alt="WorkStation"></a>

        <?php elseif ($_SESSION['logged_in'] == 1) : ?>
          <a class="navbar-brand" href="Dashboard.php"><img src="img/site_logo/workstation.svg" alt="WorkStation"></a>

          <li class="mobileNotifyBtn col-xs-3" onclick="openNav()" style="float:left">
            <div class="nav_image_div">
              <img class="img-responsive img-circle nav_image" aria-haspopup="true" aria-expanded="false" src="<?= $image ?>" alt="Profile">
            </div>
          </li>
          <center>
            <li class="mobileNotifyBtn col-xs-6" style="margin-top:5%;"><img src="img/site_logo/workstation_mbl.svg" alt="WorkStation"></li>
          </center>
          <?php

            if ($account_type == 'user') {
              ?>
            <li style="float:right" class="mobileNotifyBtn mblViewNotifyBtn" onclick="document.getElementById('notifySidenav').style.width = '100%';">
              <i class="far fa-bell notification"></i>
              <?php
                  // if ($i > 0) { 
                  ?>
              <span class="badge"><?= $i; ?></span>
              <?php
                  // }
                  ?>
            </li>
          <?php
            } elseif ($account_type == 'worker') {
              ?>
            <li style="float:right" class="mobileNotifyBtn mblViewNotifyBtn" onclick="document.getElementById('notifySidenav').style.width = '100%';">
              <i class="far fa-bell notification"></i>
              <?php
                  // if ($i > 0) { 
                  ?>
              <span class="badge"><?= $i; ?></span>
              <?php
                  // }
                  ?>
            </li>

          <?php
            }
            ?>

        <?php
        endif; ?>

        <?php
        if (!isset($_SESSION['logged_in'])) {
          ?>

          <button type="button" class="navbar-toggle collapsed" onclick="openNav()">
            <!-- <span class="sr-only">Toggle navigation</span> -->
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
        <?php
        }
        ?>
      </div>

      <!-- Collect the nav links, forms, and other content for toggling -->
      <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
        <ul class="nav navbar-nav navbar-right">
          <?php if (!isset($_SESSION['logged_in'])) : ?>
            <li><a class="page-scroll" href="#body">HOME</a></li>
            <li><a class="page-scroll" href="#about-section">ABOUT</a></li>
            <li><a class="page-scroll" href="#services-section">SERVICES</a></li>
            <li><a class="page-scroll" onclick="showLogin()">LOG IN</a></li>
            <li><a class="page-scroll" onclick="smsLogin()">JOIN</a></li>
            <li>
              <div>
                <a href="postjob.php" class="navPostButton" aria-haspopup="true" aria-expanded="false">
                  Post Job
                </a>
              </div>
            </li>



          <?php elseif ($_SESSION['logged_in'] == 1) : ?>
            <?php if ($account_type == 'worker') : ?>
              <li>
                <div>
                  <a href="browsejob.php" class="navPostButton" aria-haspopup="true" aria-expanded="false">
                    Browse Job
                  </a>
                </div>
              </li>

              <li class="largeViewNotifyBtn">

                <i class="far fa-bell dropdown notification" data-toggle="dropdown"></i>
                <ul class="dropdown-menu notification-list">
                  <div id="div1">
                    <div class="notification-contents">
                      <?php
                          $i = 0;
                          if ($not_check->num_rows > 0) {
                            while ($notif = mysqli_fetch_array($not_check)) {
                              $i++;
                              $not_id = $notif['id'];
                              $not_type = $notif['not_type'];
                              $job_id = $notif['job_id'];
                              $not_time = $notif['not_time'];
                              $not_time = check_job_stable($not_time);

                              // Start
                              ?>
                          <li class="notification-item"><a href='jobDetails.php?jId=<?= $job_id; ?>&notmin=<?= $not_id; ?>&jobStatus'>

                              <?php if ($not_type == 'job') { ?>
                                We have found a job for you
                              <?php } elseif ($not_type == 'hire') { ?>
                                You are hired in this job
                              <?php
                                      } elseif ($not_type == 'hireCancel') { ?>
                                Your hire is cancel in this job
                              <?php
                                      }
                                      ?>
                              <p><?= $not_time[1]; ?></p></a>
                          </li>
                        <?php
                                //End
                              }
                            } else { ?>
                        <li style="padding: 20px; color: black;">There are no notification to see</li>
                      <?php
                          }

                          ?>
                    </div>
                  </div>
                </ul>
                <?php
                    // if ($i > 0) { 
                    ?>
                <span class="badge"><?= $i; ?></span>
                <?php
                    // }
                    ?>

              </li>
            <?php
              endif; ?>
            <?php if ($account_type == 'worker') : ?>
            <?php else : ?>


              <li>
                <div class="dropdown">
                  <a href="#" class="dropdown-toggle navSearchButton" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">&nbsp;Search&nbsp;</a>
                  <ul class="dropdown-menu">
                    <li><a href="browsejob.php">Search Job</a></li>
                    <li role="separator" class="divider"></li>
                    <li><a href="browseWorker.php">Search Worker</a></li>
                  </ul>
                </div>
              </li>

              <li>
                <div>
                  <a href="postjob.php" class="navPostButton" aria-haspopup="true" aria-expanded="false">
                    Post Job
                  </a>
                </div>
              </li>

              <li class="largeViewNotifyBtn">

                <i class="far fa-bell dropdown notification" data-toggle="dropdown"></i>
                <ul class="dropdown-menu notification-list">
                  <div id="div2">
                    <div class="notification-contents">

                      <?php
                          $i = 0;
                          if ($not_check->num_rows > 0) {
                            while ($notif = mysqli_fetch_array($not_check)) {
                              $i++;
                              $not_id = $notif['id'];
                              $not_type = $notif['not_type'];
                              $job_id = $notif['job_id'];
                              $not_time = $notif['not_time'];
                              $not_time = check_job_stable($not_time);

                              // Start
                              ?>
                          <li class="notification-item"><a href='jobDetails.php?jId=<?= $job_id; ?>&notmin=<?= $not_id; ?>&jobStatus'>

                              <?php if ($not_type == 'proposal') { ?>
                                A worker sends proposal in this job
                              <?php } elseif ($not_type == 'hireCancel') { ?>
                                Worker cancels the hire in this job
                              <?php } elseif ($not_type == 'askQuestion') { ?>
                                A question ask on this job
                              <?php
                                      }
                                      ?>
                              <p><?= $not_time[1]; ?></p></a>
                          </li>
                        <?php
                                //End
                              }
                            } else { ?>
                        <li style="padding: 20px; color: black;">There are no notification to see.</li>
                      <?php
                          }

                          ?>
                    </div>
                  </div>
                </ul>
                <?php
                    // if ($i > 0) { 
                    ?>
                <span class="badge"><?= $i; ?></span>
                <?php
                    // }
                    ?>

              </li>



            <?php endif; ?>

            <li>
              <div class="dropdown nav_image_div">
                <img class="dropdown-toggle img-responsive img-circle nav_image" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" src="<?= $image ?>" alt="Profile">
                <ul class="dropdown-menu navImgList">
                  <li><a href="Dashboard.php"> Dashboard</a></li>
                  <li role="separator" class="divider"></li>
                  <li><a href="profile.php"> Profile</a></li>
                  <li role="separator" class="divider"></li>
                  <?php
                    if ($account_type == 'worker') { ?>
                    <li><a href="buyPromotion.php"> Enable Profile Promotion</a></li>
                    <li role="separator" class="divider"></li>

                  <?php
                    }
                    ?>
                  <?php
                    if ($account_type == 'worker') { ?>
                    <li><a href="buyCredits.php"> Buy SMS Notification</a></li>
                    <li role="separator" class="divider"></li>
                    <li><a href="transactionList.php"> Transaction List</a></li>
                    <li role="separator" class="divider"></li>
                  <?php
                    }
                    ?>
                  <li><a href="setting.php"> Setting</a></li>
                  <li role="separator" class="divider"></li>
                  <li><a href="index.php?logout=1"> Log Out</a></li>
                </ul>
              </div>
            </li>

          <?php endif; ?>



        </ul>
      </div> <!-- End collapse div -->


    </div>
  </nav>
  <!-- End Navbar -->

</header>

<?php

include "layouts/login.php";
?>