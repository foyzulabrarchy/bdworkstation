<html>

<head>
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</head>

<body>



	<?php

	if (!isset($_SESSION)) session_start();
	require "dbConnection.php";

	if ($_SESSION['logged_in'] != 1) {
		header("Location: ../index.php?not_logged_in");
	} else {
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {

			if (isset($_GET['jId'])) {
				$job_id = $_GET['jId'];
			}

			$update_job_title = $_POST['update_job_title'];
			$update_description = $_POST['update_description'];

			if (empty($update_job_title) || empty($update_description)) {
				?>

				<script>
					swal({
						title: "Error!",
						text: "Your field is empty!",
						icon: "error",
						button: "OK",
						closeOnClickOutside: false
					}).then(function() {
						window.location = "../jobDetails.php?jId=<?= $job_id ?>&jobStatus";
					});
				</script>
				<?php
						} else {
							$query = $mysqli->query("SELECT job_id from job_table WHERE job_id = '$job_id'");

							if ($query->num_rows > 0) {
								$sql = "UPDATE job_table SET job_title='$update_job_title', job_description='$update_description' WHERE job_id = '$job_id'";

								if ($mysqli->query($sql) === TRUE) {
									?>

						<script>
							swal({
								title: "Success!",
								text: "Your Job is Updated!",
								icon: "success",
								button: "OK",
								closeOnClickOutside: false
							}).then(function() {
								window.location = "../jobDetails.php?jId=<?= $job_id ?>&jobStatus";
							});
						</script>
	<?php
					}
				}
			}
		}
	}

	?>


</body>

</html>