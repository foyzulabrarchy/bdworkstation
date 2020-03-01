<html>

<head>
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</head>

<body>
	<?php
	require "dbConnection.php";

	if ($_SERVER['REQUEST_METHOD'] == 'POST') {

		if (isset($_GET['wId'])) {
			$worker_id = $_GET['wId'];
		}

		if (!empty($_POST['sub'])) {
			$data = $_POST['sub'];
			// $data = array_values($data);

			{ // Check database ->is there any subcategory before?
				$sub_category_check = $mysqli->query("SELECT sub_category_id FROM worker_table WHERE worker_id = '$worker_id'");
				$sub_category_id = $sub_category_check->fetch_assoc()['sub_category_id'];
				$sub_category_id = unserialize($sub_category_id); // convert to Unserialized array
				// $sub_category_id = array_unique($sub_category_id);
				$count = sizeof($sub_category_id); // How many values in the array
			}
			if ($count > 0) { // if Yes merge two array
				$serialized_array = array_merge($data, $sub_category_id);
				// $serialized_array = array_unique($serialized_array);
				$serialized_array = serialize($serialized_array);
			} else {
				$serialized_array = serialize($data);
			}

			$sql = "UPDATE worker_table SET sub_category_id = '$serialized_array' WHERE worker_id = '$worker_id'";

			if ($mysqli->query($sql) === TRUE) {
				?>
				<script>
					swal({
						title: "Done!",
						text: "Your Subcategory is Updated!",
						icon: "success",
						button: "OK",
						closeOnClickOutside: false
					}).then(function() {
						window.location = "../setting.php";
					});
				</script>
			<?php
					}
				} else {
					?>
			<script>
				swal({
					title: "Error!",
					text: "Your Selection is Empty!",
					icon: "error",
					button: "OK",
					closeOnClickOutside: false
				}).then(function() {
					window.location = "../setting.php";
				});
			</script>
	<?php
		}
	}
	?>
</body>

</html>