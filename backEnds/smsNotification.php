<?php
if (!isset($_SESSION)) session_start();

use Carbon\Carbon;

require '../vendor/autoload.php';

function smsSend($category, $job_id)
{
  require "dbConnection.php";

  $worker_check = $mysqli->query("SELECT * FROM worker_table WHERE category_id= $category AND is_verified=1 AND is_activated=0 AND is_deleted=0");
  $send_sms = 0;
  $diff = -1;
  if ($worker_check->num_rows > 0) {
    while ($row = $worker_check->fetch_assoc()) {
      $worker_id = $row['worker_id'];
      $name = $row['first_name'];
      $recipient_no = $row['phone_number'];
      $is_sms_on = $row['is_sms_on'];

      $is_worker_buy = $mysqli->query("SELECT id FROM worker_sms_credit WHERE worker_id = '$worker_id'");
      if ($is_worker_buy->num_rows > 0) {

        $sms_st_check =  $mysqli->query("SELECT end_date FROM worker_sms_credit WHERE worker_id = '$worker_id'");

        $time_end = $sms_st_check->fetch_assoc()['end_date'];
        $end_date = Carbon::parse($time_end, 'Asia/Dhaka');
        // $diff = var_dump($end_date->lessThanOrEqualTo($time_end));
        // $diff = $end_date->diffInDays();

        $current_date = date_create(date('Y-m-d'));
        $diff = date_diff($current_date, $end_date);
        $diff = $diff->format("%R%a");

        if ($diff >= 0) {
          $send_sms = 1;
        } else {
          $send_sms = 0;
        }

        if ($send_sms == 1) {
          // $message = 'Dear ' . $name . ', a job is waiting for your response. Thanks BdWorkStation. https://bdworkstation.daanguli.com/jobDetails.php?jId=' . $job_id . '&jobStatus';

            $url = "https://bdworkstation.daanguli.com/jobDetails.php?jId='.$job_id.'&jobStatus";

            $message = 'Dear ' . $name . ', a job is waiting for your response. Thanks WorkStation. '. $url;
          $send = msgNotification($recipient_no, $message);
        }
      }
  }
}
}


function msgNotification($recipient_no, $message)
{
  
	try{
    $soapClient = new SoapClient("https://api2.onnorokomSMS.com/sendSMS.asmx?wsdl");
    
    $paramArray = array(
    'userName' => "01718339135",
    'userPassword' => "sifat207",
    'mobileNumber' => $recipient_no,
    'smsText' => $message,
    'type' => "TEXT",
    'maskName' => '',
    'campaignName' => '',
    );
    $value = $soapClient->__call("OneToOne", array($paramArray));
    // echo $value->OneToOneResult;
  
    echo "<script> console.log('$value->OneToOneResult') </script>";
   } catch (Exception $e) {
    echo $e->getMessage();
   }
}
