<html>

<head>
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</head>


<body>


	<?php

	$flag = 0;
	if (!isset($_SESSION)) session_start();
	require "dbConnection.php";
	require "smsNotification.php";
	require "workerNotificationEntry.php";

	if ($_SESSION['logged_in'] != 1) {
		header("Location: ../index.php?not_logged_in");
	} else {
		#when logged in
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$category = $_POST['category'];
			if ($category == 'other') {
				$category = '0';
				$sub_category = '0';
			} else {


				$sub_category = $_POST['sub_category']; // First Service Id of that sub category.
				if (is_numeric($sub_category)) {
					// Find Sub Category ID From Service Table.
					$sub_category_id_check = $mysqli->query("SELECT sub_category_id FROM service_table WHERE service_id = '$sub_category'") or die($mysqli->error);
					while ($row = $sub_category_id_check->fetch_assoc()) {
						$sub_category = $row['sub_category_id'];
					}
				} else {
					$sub_category_id_check = $mysqli->query("SELECT sub_category_id FROM sub_category_table WHERE sub_category_name = '$sub_category'") or die($mysqli->error);
					while ($row = $sub_category_id_check->fetch_assoc()) {
						$sub_category = $row['sub_category_id'];
					}
				}
			}

			if (isset($_POST['service'])) { // If there is a Service present 
				$service = $_POST['service'];
			} else { // If there is no service
				$service = 0;
			}
			$job_title = $_POST['job_title'];
			$description = $_POST['job_description'];
			$job_address = $_POST['street_address'];
			$area = $_POST['area'];
			$time = $_POST['time'];
			$phone = $_SESSION['phone'];
			//image handle
			$image_name = $_FILES['image_name']['name'];
			$image_tmp_name = $_FILES['image_name']['tmp_name'];
			$image_size = $_FILES['image_name']['size'];
			$image_error = $_FILES['image_name']['error'];
			$image_type = $_FILES['image_name']['type'];
			if (!empty($image_name)) {


				$image_file_ext = explode('.', $image_name);
				$image_actual_ext = strtolower(end($image_file_ext));

				$allowed = array('jpg', 'jpeg', 'png');

				if (in_array($image_actual_ext, $allowed)) {
					# code...
					if ($image_error === 0) {
						if ($image_size < 5000000) {
							$image_file_name = uniqid('', true) . "." . $image_actual_ext;
							$file_destination = '../image/job/' . $image_file_name;
							if (move_uploaded_file($image_tmp_name, $file_destination)) { }
						} else {
							$flag = 1;
							?>
							<script>
								swal({
									title: "Error!",
									text: "File should be less than or equal 4mb!",
									icon: "error",
									button: "OK",
									closeOnClickOutside: false
								}).then(function() {
									window.location = "../postjob.php";
								});
							</script>
						<?php
											}
										} else {
											$flag = 1;
											?>
						<script>
							swal({
								title: "Error!",
								text: "Error uploading a file!",
								icon: "error",
								button: "OK",
								closeOnClickOutside: false
							}).then(function() {
								window.location = "../postjob.php";
							});
						</script>
					<?php

									}
								} else {
									$flag = 1;
									?>
					<script>
						swal({
							title: "Error!",
							text: "wrong image type!",
							icon: "error",
							button: "OK",
							closeOnClickOutside: false
						}).then(function() {
							window.location = "../postjob.php";
						});
					</script>
					<?php
								}
							} else {
								$flag = 1;
							}


							$user_id_check = $mysqli->query("SELECT user_id from user_table where phone_number='$phone'") or die($mysqli->error);
							while ($row = $user_id_check->fetch_assoc()) {
								$user_id = $row['user_id'];
							}
						}
						if ($flag != 1) {
							$sql = "INSERT INTO job_table(job_image, category_id, sub_category_id, service_id, job_title, job_description, job_address, job_area, job_time, user_id)"
								. " VALUES ('$image_file_name', '$category', '$sub_category', '$service', '$job_title', '$description', '$job_address','$area', '$time', '$user_id')";

							if ($mysqli->query($sql) === TRUE) {

								// Job Status Insertion
								$job_id_check = $mysqli->query("SELECT job_id FROM job_table WHERE user_id = '$user_id' ORDER BY job_id DESC LIMIT 1");
								while ($row = $job_id_check->fetch_assoc()) {
									$job_id = $row['job_id'];
									$status = "INSERT INTO job_status (job_id)" . "VALUES ('$job_id')";
									if ($mysqli->query($status)) {
										$category_id = $category;
										smsSend($category_id, $job_id);
										notifyJob($job_id, $category_id);

										?>
						<script>
							swal({
								title: "Complete!",
								text: "Your Job is Posted. Thank You!",
								icon: "success",
								button: "OK",
								closeOnClickOutside: false
							}).then(function() {
								window.location = "../Dashboard.php";
							});
						</script>
				<?php
								} else {
									$delete = $mysqli->query("DELETE * FROM job_table WHERE job_id = $job_id");
								}
							}
						} else {
							?>
				<script>
					swal({
						title: "Error!",
						text: "Your Job Failed to Post. Try Again!",
						icon: "error",
						button: "OK",
						closeOnClickOutside: false
					}).then(function() {
						window.location = "../Dashboard.php";
					});
				</script>
				<?php
						}
					} else {
						$sql = "INSERT INTO job_table(category_id, sub_category_id, service_id, job_title, job_description, job_address, job_area, job_time, user_id)"
							. " VALUES ('$category', '$sub_category', '$service', '$job_title', '$description', '$job_address','$area', '$time', '$user_id')";

						if ($mysqli->query($sql) === TRUE) {

							// Job Status Insertion
							$job_id_check = $mysqli->query("SELECT job_id FROM job_table WHERE user_id = '$user_id' ORDER BY job_id DESC LIMIT 1");
							while ($row = $job_id_check->fetch_assoc()) {
								$job_id = $row['job_id'];
								$status = "INSERT INTO job_status (job_id)" . "VALUES ('$job_id')";
								if ($mysqli->query($status)) {
									$category_id = $category;
									smsSend($category_id, $job_id);
									notifyJob($job_id, $category_id);
									?>
						<script>
							swal({
								title: "Complete!",
								text: "Your Job is Posted. Thank You!",
								icon: "success",
								button: "OK",
								closeOnClickOutside: false
							}).then(function() {
								window.location = "../Dashboard.php";
							});
						</script>
				<?php
								} else {
									$delete = $mysqli->query("DELETE * FROM job_table WHERE job_id = $job_id");
								}
							}
						} else {

							?>
				<script>
					swal({
						title: "Error!",
						text: "Your Job Failed to Post. Try Again!",
						icon: "error",
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