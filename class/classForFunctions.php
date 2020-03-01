<?php 
if(!isset($_SESSION)) session_start();
require 'vendor/autoload.php';
require "backEnds/dbConnection.php";
use Carbon\Carbon;

function display($string){
	echo $string;
}

function is_logged_in(){ 
	if ($_SESSION['logged_in'] !=1) 
		{header("Location: ../login.php");
		die();
	}else{
		return true;
	}
}

function check_job_stable($post_time){
	$current_time=Carbon::parse($post_time,'Asia/Dhaka');
	$time_difference=$current_time->diffForHumans();
	$time_difference_in_days=$current_time->diffIndays();
	$check_time_dif=7-$time_difference_in_days;
	return array($check_time_dif, $time_difference);
}

function check_proposal_status($proposal_check)
{
	$proposal_check_fetch = $proposal_check->fetch_assoc();
	if ($proposal_check->num_rows > 0) {
		$proposal_status = 1;
		$proposal_sent_price = $proposal_check_fetch['proposal_price'];
		$is_worker_cancel = $proposal_check_fetch['worker_cancel'];
		return array($proposal_status, $proposal_sent_price, $is_worker_cancel);
	}
}

function check_settings_change_status($check_time)
{
	$current_time = Carbon::parse($check_time, 'Asia/Dhaka');
	$time_difference_in_days = $current_time->diffIndays();
	return array($time_difference_in_days);
}

function transaction_validation_check(){
	$val_id=urlencode($_POST['val_id']);
$store_id=urlencode("works5d7258b389282");
$store_passwd=urlencode("works5d7258b389282@ssl");
$requested_url = ("https://sandbox.sslcommerz.com/validator/api/validationserverAPI.php?val_id=".$val_id."&store_id=".$store_id."&store_passwd=".$store_passwd."&v=1&format=json");

$handle = curl_init();
curl_setopt($handle, CURLOPT_URL, $requested_url);
curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
curl_setopt($handle, CURLOPT_SSL_VERIFYHOST, false); # IF YOU RUN FROM LOCAL PC
curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false); # IF YOU RUN FROM LOCAL PC

$result = curl_exec($handle);

$code = curl_getinfo($handle, CURLINFO_HTTP_CODE);

if($code == 200 && !( curl_errno($handle)))
{

	# TO CONVERT AS ARRAY
	# $result = json_decode($result, true);
	# $status = $result['status'];

	# TO CONVERT AS OBJECT
	$result = json_decode($result);

	# TRANSACTION INFO
	$status = $result->status;
	$tran_date = $result->tran_date;
	$tran_id = $result->tran_id;
	$val_id = $result->val_id;
	$amount = $result->amount;
	$store_amount = $result->store_amount;
	$bank_tran_id = $result->bank_tran_id;
	$card_type = $result->card_type;

	# EMI INFO
	$emi_instalment = $result->emi_instalment;
	$emi_amount = $result->emi_amount;
	$emi_description = $result->emi_description;
	$emi_issuer = $result->emi_issuer;

	# ISSUER INFO
	$card_no = $result->card_no;
	$card_issuer = $result->card_issuer;
	$card_brand = $result->card_brand;
	$card_issuer_country = $result->card_issuer_country;
	$card_issuer_country_code = $result->card_issuer_country_code;

	# API AUTHENTICATION
	$APIConnect = $result->APIConnect;
	$validated_on = $result->validated_on;
	$gw_version = $result->gw_version;

} else {

	echo "Failed to connect with SSLCOMMERZ";
}

return array($status, $tran_id, $card_type, $tran_date);
}


?>