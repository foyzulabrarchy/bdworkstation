<?php
if (!isset($_SESSION)) session_start();


function calculateAvgUserRating($user_id)
{
    require "dbConnection.php";
    // Review Calculation Section
    $review_job_check = $mysqli->query("SELECT * FROM user_review_table WHERE user_id = '$user_id' ");
    $total_review_job_count = $review_job_check->num_rows; // Used For Avg Calculation
    $total_review_job_count = $total_review_job_count . 0;
    $total_review = 0;
    while ($row = $review_job_check->fetch_assoc()) {
        $one_review = $row['from_worker_review'];
        $total_review = $total_review + $one_review;
    }
    $avg_review = ($total_review / $total_review_job_count);
    $length_of_rating = strlen($avg_review);

    if ($length_of_rating > 1) {
        $avg_review = number_format((float) $avg_review, 1, '.', ''); // Take one decimal Value
        $value_for_star = str_replace(".", "", $avg_review); // Remove dot for Star CSS Value

        if ($value_for_star[1] > 5) { // If 2.6 then It's 3. 
            $value_for_star[0] = $value_for_star[0] + 1;
            $value_for_star[1] = 0;

            $avg_review[0] = $avg_review[0] + 1;
            $avg_review[2] = 0;
        } elseif ($value_for_star[1] < 5) { //If 2.4 then it's 2.
            $value_for_star[1] = 0;
            $avg_review[2] = 0;
        }
    }
     else {
        $value_for_star = $avg_review . 0; // Add Extra zero for Star CSS value. If rating 5 then it's 50.
    }

    return $value_for_star;
    // return $avg_review;
}

function calculateAvgWorkerRating($worker_id)
{
    require "dbConnection.php";
    // Review Calculation Section
    $review_job_check = $mysqli->query("SELECT * FROM worker_review_table WHERE worker_id = '$worker_id' ");
    $total_review_job_count = $review_job_check->num_rows; // Used For Avg Calculation
    $total_review_job_count = $total_review_job_count . 0; 

    $total_review = 0;
    while ($row = $review_job_check->fetch_assoc()) {
        $one_review = $row['from_user_review'];     
        $total_review = $total_review + $one_review; 
    }

    $avg_review = ($total_review / $total_review_job_count); 
    $length_of_rating = strlen($avg_review); 

    if ($length_of_rating > 1) {
        $avg_review = number_format((float) $avg_review, 1, '.', ''); // Take one decimal Value
        $value_for_star = str_replace(".", "", $avg_review); // Remove dot for Star CSS Value

        if ($value_for_star[1] > 5) { // If 2.6 then It's 3. 
            $value_for_star[0] = $value_for_star[0] + 1;
            $value_for_star[1] = 0;
            $avg_review[0] = $avg_review[0] + 1;
            $avg_review[2] = 0;
        } elseif ($value_for_star[1] < 5) { //If 2.4 then it's 2.
            $value_for_star[1] = 0;
            $avg_review[2] = 0;
        }
    } 
    else {
        $value_for_star = $avg_review . 0; // Add Extra zero for Star CSS value. If rating 5 then it's 50.
    }
    return $value_for_star;
    // return $avg_review;
}

?>
