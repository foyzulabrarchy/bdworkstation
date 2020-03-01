<html>

<head>
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</head>

<body>



	<?php

	if (!isset($_SESSION)) session_start();

	require "dbConnection.php";
	require "vendor/autoload.php";

	use Carbon\Carbon;

	$phone = $mysqli->escape_string($_POST['phoneNumber']);
	$phone = "+88" . $phone;

	if (!empty($_POST["remember"])) {
		setcookie("phone_number", $_POST['phoneNumber'], time() + 3600, '/');
		setcookie("password", $_POST["password"], time() + 3600, '/');
	} else {
		setcookie("phone_number", "");
		setcookie("password", "");
	}


	$result = $mysqli->query("SELECT * FROM user_table WHERE phone_number = '$phone'");
	$result2 = $mysqli->query("SELECT * FROM worker_table WHERE phone_number = '$phone'");



	if ($result->num_rows > 0) {
		$user = $result->fetch_assoc();
		if (password_verify($_POST['password'], $user['password'])) {

			$user_profile_live = $user['profile_live_date'];
			if ($user_profile_live != null) {
				$current_time = Carbon::parse($user_profile_live, 'Asia/Dhaka');
				$day_diff = $current_time->diffInDays();
				if ($day_diff <= 0) {
					$update_profile_live = "Update user_table SET profile_live_date = NULL";
					if ($mysqli->query($update_profile_live)) {
						$user_profile_live = null;
					}
				}
			}

			if ($user_profile_live == null) {
				$_SESSION['user_id'] = $user['user_id'];
				$_SESSION['phone'] = $user['phone_number'];
				$_SESSION['first_name'] = $user['first_name'];
				$_SESSION['last_name'] = $user['last_name'];
				$_SESSION['address'] = $user['address'];
				$_SESSION['area'] = $user['area'];
				$_SESSION['image_name'] = $user['image'];
				$_SESSION['account_type'] = 'user';
				$is_deleted = $user['is_deleted'];

				$_SESSION['verfied_warning_show'] = 0;

				if ($is_deleted == 1) {
					?>
					<script>
						swal({
							title: "Error!",
							text: "Your account is deleted. Please contact with support if you think this is wrong!",
							icon: "error",
							button: "OK",
							closeOnClickOutside: false
						}).then(function() {
							window.location = "../index.php";
						});
					</script>
			<?php
						} else {
							$_SESSION['logged_in'] = 1;
							$user_id = $user['user_id'];
							$sql = $mysqli->query("UPDATE user_table SET is_activated = '0' WHERE user_id = '$user_id'");
							header("Refresh:0; url=../Dashboard.php");
						}
					} else {
						header("Refresh:0; url=../accountSuspend.php");
					}
				} else {
					?>
			<script>
				swal({
					title: "Error!",
					text: "You have entered wrong password!",
					icon: "error",
					button: "OK",
					closeOnClickOutside: false
				}).then(function() {
					window.location = "../index.php";
				});
			</script>
			<?php
				}
			} elseif ($result2->num_rows > 0) {
				$worker = $result2->fetch_assoc();
				if (password_verify($_POST['password'], $worker['password'])) {

					$worker_profile_live = $worker['profile_live_date'];
					$is_promoted = $worker['is_promoted'];
					$worker_id = $worker['worker_id'];
					$is_verified = $worker['is_verified'];

					if ($is_promoted == 1) {
						$end_promotion = $mysqli->query("SELECT `end_date` FROM `worker_promotion` WHERE worker_id = '$worker_id'");
						$end_promotion = $end_promotion->fetch_assoc()['end_date'];
						$end_date = Carbon::parse($end_promotion, 'Asia/Dhaka');

						$current_date = date_create(date('Y-m-d'));
						$day_diff_promo = date_diff($current_date, $end_date);
						$day_diff_promo_value = $day_diff_promo->format("%R%a");

						if ($day_diff_promo_value < 0) {
							$update_is_promo = $mysqli->query("Update worker_table SET is_promoted = 0");
						}
					}

					if ($worker_profile_live != null) {
						$current_time = Carbon::parse($worker_profile_live, 'Asia/Dhaka');
						$day_diff = $current_time->diffInDays();
						if ($day_diff <= 0) {
							$update_profile_live = "Update worker_table SET profile_live_date = NULL";
							if ($mysqli->query($update_profile_live)) {
								$worker_profile_live = null;
							}
						}
					}

					if ($worker_profile_live == null) {
						$_SESSION['worker_id'] = $worker['worker_id'];
						$_SESSION['phone'] = $worker['phone_number'];
						$_SESSION['first_name'] = $worker['first_name'];
						$_SESSION['last_name'] = $worker['last_name'];
						$_SESSION['address'] = $worker['address'];
						$_SESSION['image_name'] = $worker['image'];
						$_SESSION['area'] = $worker['area'];
						$_SESSION['account_type'] = 'worker';
						$is_deleted = $worker['is_deleted'];

						$_SESSION['verfied_warning_show'] = 0;

						if ($is_deleted == 1) {
							?>
					<script>
						swal({
							title: "Error!",
							text: "Your account is deleted. Please contact with support if you think this is wrong!",
							icon: "error",
							button: "OK",
							closeOnClickOutside: false
						}).then(function() {
							window.location = "../index.php";
						});
					</script>
			<?php
						} else {
							$_SESSION['logged_in'] = 1;
							$worker_id = $worker['worker_id'];
							$sql2 = $mysqli->query("UPDATE worker_table SET is_activated = '0' WHERE worker_id = '$worker_id'");


							header("Refresh:0; url=../profile.php");
						}
					} else {
						header("Refresh:0; url=../accountSuspend.php?liveOn=$worker_profile_live");
					}
				} else {
					?>
			<script>
				swal({
					title: "Error!",
					text: "You have entered wrong password!",
					icon: "error",
					button: "OK",
					closeOnClickOutside: false
				}).then(function() {
					window.location = "../index.php";
				});
			</script>
		<?php
			}
		} else {
			?>
		<script>
			swal({
				title: "Error!",
				text: "User with that Phone Number does not exist. First register!",
				icon: "error",
				button: "OK",
				closeOnClickOutside: false
			}).then(function() {
				window.location = "../index.php";
			});
		</script>
	<?php
	}

	?>
</body>

</html>