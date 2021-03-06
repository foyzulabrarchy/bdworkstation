<?php

if (!isset($_SESSION)) session_start();

require "dbConnection.php";
require "vendor/autoload.php";

use Carbon\Carbon;

error_reporting(0);

define("FB_ACCOUNT_KIT_APP_ID", "282804475720913");
define("FB_ACCOUNT_KIT_APP_SECRET", "c74975692bbd5632c39ffa6750bc3623");

$code = $_POST['code'];
$csrf = $_POST['csrf'];

$auth = file_get_contents('https://graph.accountkit.com/v1.1/access_token?grant_type=authorization_code&code=' .  $code . '&access_token=AA|' . FB_ACCOUNT_KIT_APP_ID . '|' . FB_ACCOUNT_KIT_APP_SECRET);

$access = json_decode($auth, true);

if (empty($access) || !isset($access['access_token'])) {
    return array("status" => 2, "message" => "Unable to verify the phone number.");
}

//App scret proof key Ref : https://developers.facebook.com/docs/graph-api/securing-requests
$appsecret_proof = hash_hmac('sha256', $access['access_token'], FB_ACCOUNT_KIT_APP_SECRET);

//echo 'https://graph.accountkit.com/v1.1/me/?access_token='. $access['access_token'];
$ch = curl_init();

// Set query data here with the URL
curl_setopt($ch, CURLOPT_URL, 'https://graph.accountkit.com/v1.1/me/?access_token=' . $access['access_token'] . '&appsecret_proof=' . $appsecret_proof);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_TIMEOUT, '4');
$resp = trim(curl_exec($ch));

curl_close($ch);

$info = json_decode($resp, true);

if (empty($info) || !isset($info['phone']) || isset($info['error'])) {
    return array("status" => 2, "message" => "Unable to verify the phone number.");
}

$phoneNumber = $info['phone']['national_number'];

$phoneNumber = "+880" . $phoneNumber;
$result = $mysqli->query("SELECT * FROM user_table WHERE phone_number='$phoneNumber'");
$result2 = $mysqli->query("SELECT * FROM worker_table WHERE phone_number='$phoneNumber'");


if ($result->num_rows > 0) {

    $user = $result->fetch_assoc();
    $_SESSION['account_type'] = 'user';
    $_SESSION['user_id'] = $user['user_id'];
    $num = '1';

} elseif ($result2->num_rows > 0) {

    $worker = $result2->fetch_assoc();
    $_SESSION['account_type'] = 'worker';
    $_SESSION['worker_id'] = $worker['worker_id'];
    $num = '1';

} else {
    $num = '1';
    $_SESSION['account_type'] = 'null';
}


$num = json_decode($num);
echo json_encode($num);
