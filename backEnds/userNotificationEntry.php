<?php


// IF Proposal received from any worker to a job
function userNotifyProposal($job_id, $user_id){
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

    $not_type = 'proposal';

        $insert_not = "INSERT INTO user_notification_table (not_type, for_user, job_id) VALUES ('$not_type', '$user_id', '$job_id')";

        if ($mysqli->query($insert_not) === TRUE) {
            $data['message'] = '';  // FROM API
            $pusher->trigger('my-channel', 'my-event', $data); // FROM API
        }
}


// IF Cancel Hire. Notify
function userNotifyHireCancel($job_id, $user_id)
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

        $insert_not = "INSERT INTO user_notification_table (not_type, for_user, job_id) VALUES ('$not_type', '$user_id', '$job_id')";

        if ($mysqli->query($insert_not) === TRUE) {
            $data['message'] = '';  // FROM API
            $pusher->trigger('my-channel', 'my-event', $data); // FROM API
        }
}

// IF Any  Question Ask. Notify
function userAskQuestion($job_id, $user_id)
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

    $not_type = 'askQuestion';

        $insert_not = "INSERT INTO user_notification_table (not_type, for_user, job_id) VALUES ('$not_type', '$user_id', '$job_id')";

        if ($mysqli->query($insert_not) === TRUE) {
            $data['message'] = '';  // FROM API
            $pusher->trigger('my-channel', 'my-event', $data); // FROM API
        }
}

function userMinusNotification($not_id){
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

    $not_search = $mysqli->query("SELECT * FROM user_notification_table WHERE id = '$not_id'");
    if($not_search->num_rows > 0){
        $read_done = "UPDATE user_notification_table SET not_read = 1 WHERE id = '$not_id'";
        if($mysqli->query($read_done) === TRUE){
            $data['message'] = '';  // FROM API
            $pusher->trigger('my-channel', 'my-event', $data); // FROM API
        }
    }
}

?>