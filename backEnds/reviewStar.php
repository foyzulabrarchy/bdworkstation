<html>

<head>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</head>

<body>

    <?php
    // This file used to every sing job's review and calculate average rating for User/Worker
    if (!isset($_SESSION)) session_start();
    require "dbConnection.php";
    require "avgRatingCalculation.php";

    $account_type = $_SESSION['account_type'];


    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $star_id = $_POST['star_id'];
        $job_id = $_POST['star_job_id'];
        $user_id = $_POST['star_user_id'];
        $worker_id = $_POST['star_worker_id'];
        $description = $_POST['star_desc'];


        // SET Complete BY 
        if ($account_type == 'user') {
            $job_complete_by = $mysqli->query("UPDATE job_status SET user_complete = 1 WHERE job_id = '$job_id' ");

            $user_review_input = $mysqli->query("INSERT INTO worker_review_table (job_id, worker_id, from_user_review, from_user_id, review_description) VALUES ('$job_id', '$worker_id', '$star_id', '$user_id', '$description')");

            //Insert or Update Avg Rating to DB for Worker.
            // $avgRating = calculateAvgWorkerRating($worker_id);
            $check_avg_table = $mysqli->query("SELECT * FROM avg_worker_rating WHERE worker_id = '$worker_id' ");
            if ($check_avg_table->num_rows > 0) {
                $avgRating = calculateAvgWorkerRating($worker_id);
                $update_avg_rating = $mysqli->query("UPDATE avg_worker_rating SET worker_rating = '$avgRating' WHERE worker_id = '$worker_id'");
            } else {
                $insert_avg_rating = $mysqli->query("INSERT INTO avg_worker_rating (worker_id, worker_rating) VALUES ('$worker_id','$star_id')");
            }
        } elseif ($account_type == 'worker') {
            $job_complete_by = $mysqli->query("UPDATE job_status SET worker_complete = 1 WHERE job_id = '$job_id' ");

            $user_review_input = $mysqli->query("INSERT INTO user_review_table (job_id, user_id, from_worker_review, from_worker_id, review_description) VALUES ('$job_id', '$user_id', '$star_id', '$worker_id', '$description')");

            //Insert or Update Avg Rating to DB for User.
            // $avgRating = calculateAvgUserRating($user_id);
            $check_avg_table = $mysqli->query("SELECT * FROM avg_user_rating WHERE user_id = '$user_id' ");
            if ($check_avg_table->num_rows > 0) {
                $avgRating = calculateAvgUserRating($user_id);
                $update_avg_rating = $mysqli->query("UPDATE avg_user_rating SET user_rating = '$avgRating' WHERE user_id = '$user_id'");
            } else {
                $insert_avg_rating = $mysqli->query("INSERT INTO avg_user_rating (user_id, user_rating) VALUES ('$user_id','$star_id')");
            }
        }

        // Check is it done
        $job_status_check = $mysqli->query("SELECT * FROM job_status WHERE job_id = '$job_id' ");
        while ($row = $job_status_check->fetch_assoc()) {
            $user_complete = $row['user_complete'];
            $worker_complete = $row['worker_complete'];

            if ($user_complete == 1 && $worker_complete == 1) {
                $job_is_done = $mysqli->query("UPDATE job_status SET is_done = 1 WHERE job_id = '$job_id' ");
                ?>
                <script>
                    swal({
                        title: "Done!",
                        text: "Your Job is done. Thank You!",
                        icon: "success",
                        button: "OK",
                        closeOnClickOutside: false
                    }).then(function() {
                        window.location = "../Dashboard.php";
                    });
                </script>
            <?php
                    } elseif ($user_complete == 1) {
                        $message = "Your Job is complete.Waiting for worker.\\nThank You.";
                        ?>
                <script>
                    swal({
                        title: "Done!",
                        text: "Your Job is complete. Waiting for worker. Thank You!",
                        icon: "success",
                        button: "OK",
                        closeOnClickOutside: false
                    }).then(function() {
                        window.location = "../Dashboard.php";
                    });
                </script>
            <?php
                    } elseif ($worker_complete == 1) {
                        $message = "Your Job is complete.Waiting for user.\\nThank You.";
                        ?>
                <script>
                    swal({
                        title: "Done!",
                        text: "Your Job is complete. Waiting for user. Thank You!",
                        icon: "success",
                        button: "OK",
                        closeOnClickOutside: false
                    }).then(function() {
                        window.location = "../Dashboard.php";
                    });
                </script>
    <?php
            }
        }
    }
    ?>


</body>

</html>