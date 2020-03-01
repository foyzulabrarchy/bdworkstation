<?php

// IF Job Posted. Notify by Category
function notifyJob($job_id, $category_id)
{
    require "dbConnection.php";
    require "../vendor/autoload.php";


    // PUSHER API
    $options = array(
        'cluster' => 'ap2',
        'useTLS' => true
    );
    $pusher = new Pusher\Pusher(
        '9674b4b0258572271d2c',
        'a5f47e8819efbe81b860',
        '834246',
        $options
    );

    // END API


    $not_type = 'job';
    // $not_time = date("Y-m-d H:i:s");

    $worker_search = $mysqli->query("SELECT worker_id FROM worker_table WHERE category_id = '$category_id' AND is_verified=1 AND is_activated=0 AND is_deleted=0");

    while ($row = $row = $worker_search->fetch_assoc()) {
        $worker_id = $row['worker_id'];

        $insert_not = "INSERT INTO worker_notification_table (not_type, for_worker, job_id) VALUES ('$not_type', '$worker_id', '$job_id')";

        if ($mysqli->query($insert_not) === TRUE) {
            $data['message'] = '';  // FROM API
            $pusher->trigger('my-channel', 'my-event', $data); // FROM API
        }
    }
}


// IF Hired. Notify
function notifyHire($job_id, $worker_id)
{
    require "dbConnection.php";
    require "../vendor/autoload.php";


    // PUSHER API
    $options = array(
        'cluster' => 'ap2',
        'useTLS' => true
    );
    $pusher = new Pusher\Pusher(
        '9674b4b0258572271d2c',
        'a5f47e8819efbe81b860',
        '834246',
        $options
    );

    // END API

    $not_type = 'hire';

        $insert_not = "INSERT INTO worker_notification_table (not_type, for_worker, job_id) VALUES ('$not_type', '$worker_id', '$job_id')";

        if ($mysqli->query($insert_not) === TRUE) {
            $data['message'] = '';  // FROM API
            $pusher->trigger('my-channel', 'my-event', $data); // FROM API
        }
}

// IF Cancel Hire. Notify
function notifyHireCancel($job_id, $worker_id)
{
    require "dbConnection.php";
    // require "../vendor/autoload.php"; this already required in JobDetails.php


    // PUSHER API
    $options = array(
        'cluster' => 'ap2',
        'useTLS' => true
    );
    $pusher = new Pusher\Pusher(
        '9674b4b0258572271d2c',
        'a5f47e8819efbe81b860',
        '834246',
        $options
    );

    // END API

    $not_type = 'hireCancel';

        $insert_not = "INSERT INTO worker_notification_table (not_type, for_worker, job_id) VALUES ('$not_type', '$worker_id', '$job_id')";

        if ($mysqli->query($insert_not) === TRUE) {
            $data['message'] = '';  // FROM API
            $pusher->trigger('my-channel', 'my-event', $data); // FROM API
        }
}

function minusNotification($not_id){
    require "dbConnection.php";
    // require "../vendor/autoload.php";  this already required in JobDetails.php

    // PUSHER API
    $options = array(
        'cluster' => 'ap2',
        'useTLS' => true
    );
    $pusher = new Pusher\Pusher(
        '9674b4b0258572271d2c',
        'a5f47e8819efbe81b860',
        '834246',
        $options
    );

    // END API

    $not_search = $mysqli->query("SELECT * FROM worker_notification_table WHERE id = '$not_id'");
    if($not_search->num_rows > 0){
        $read_done = "UPDATE worker_notification_table SET not_read = 1 WHERE id = '$not_id'";
        if($mysqli->query($read_done) === TRUE){
            $data['message'] = '';  // FROM API
            $pusher->trigger('my-channel', 'my-event', $data); // FROM API
        }
    }
}
?>