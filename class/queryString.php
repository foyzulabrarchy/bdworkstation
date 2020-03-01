<?php
require "backEnds/dbConnection.php";
function hire_status_show_($jID){
    $hire_table_checking_jID = "SELECT *FROM hire_table WHERE job_ID= $jID";
    return $hire_table_checking_jID;
}


?>