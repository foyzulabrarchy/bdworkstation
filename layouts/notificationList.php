<?php
require "../backEnds/dbConnection.php";
if (!isset($_SESSION)) session_start();

$account_type = $_SESSION['account_type'];

if ($account_type == 'worker') {

    $worker_id = $_SESSION['worker_id'];

    $not_check = $mysqli->query("SELECT * FROM worker_notification_table WHERE for_worker = '$worker_id' AND not_read = 0 ORDER BY not_time DESC");

    $not_check_mbl = $mysqli->query("SELECT * FROM worker_notification_table WHERE for_worker = '$worker_id' AND not_read = 0 ORDER BY not_time DESC");


    ?>

    <div class="notification-contents">
        <?php
            $i = 0;
            if ($not_check->num_rows > 0) {
                while ($notif = mysqli_fetch_array($not_check)) {
                    $i++;
                    $not_id = $notif['id'];
                    $not_type = $notif['not_type'];
                    $job_id = $notif['job_id'];
                    $not_time = strtotime($notif['not_time']);

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

                        <p><?php echo date('d-M-y', $not_time); ?></p></a>
                </li>
            <?php
                    }
                } else { ?>
            <li class="notification-item">There are no notification to see</li>
        <?php
            }

            ?>
    </div>


<?php
} elseif ($account_type == 'user') {
    $user_id = $_SESSION['user_id'];

    //Notification Check
    $not_check = $mysqli->query("SELECT * FROM user_notification_table WHERE for_user = '$user_id' AND not_read = 0 ORDER BY not_time DESC");

    $not_check_mbl = $mysqli->query("SELECT * FROM user_notification_table WHERE for_user = '$user_id' AND not_read = 0 ORDER BY not_time DESC");
    ?>

    <div class="notification-contents">
        <?php
            $i = 0;
            if ($not_check->num_rows > 0) {
                while ($notif = mysqli_fetch_array($not_check)) {
                    $i++;
                    $not_id = $notif['id'];
                    $not_type = $notif['not_type'];
                    $job_id = $notif['job_id'];
                    $not_time = strtotime($notif['not_time']);

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

                        <p><?php echo date('d-M-y', $not_time); ?></p></a>
                </li>
            <?php
                    }
                } else { ?>
            <li class="notification-item">There are no notification to see</li>
        <?php
            }

            ?>
    </div>

<?php
}

?>

<script>
    let a = document.querySelectorAll('.notification-item');
    let badge = a.length / 2;
    var x = document.getElementsByClassName("badge");
    x[0].innerHTML = badge;
    x[1].innerHTML = badge;
</script>