<?php
if (!isset($_SESSION)) session_start();
require "dbConnection.php";
require "workerNotificationEntry.php";

if ($_SESSION['logged_in'] != 1) {
    #when not loggedin
    header("Location: ../index.php?not_logged_in");
} else {
    #when logged in
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $jId = $_SESSION['job_id'];
        $proposal_id = $_POST['proposal_id'];
        $sender_id = $_POST['sender_id']; // Send to notification function
        $hire_sql = "INSERT INTO hire_table (job_id, proposal_id) values ( $jId,  $proposal_id)";
        $in_progress = "UPDATE job_status SET in_progress = '1' WHERE job_id = '$jId'";
        $mysqli->query($in_progress);

        if ($mysqli->query($hire_sql) === TRUE) {
            header("Refresh:0; url=../jobDetails.php?jId=$jId&hired=success&jobStatus");
            notifyHire($jId, $sender_id);
        } else {

            header("Refresh:0; url=../jobDetails.php?jId=$jId&hired=error&jobStatus");
        }
    } else {
        header("Refresh:0; url=../jobDetails.php?jId=$jId&hired=error&jobStatus");
    }
}
?>