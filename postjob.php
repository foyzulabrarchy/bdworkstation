<!DOCTYPE html>
<html>

<head>
	<title name="page_title">BdWorkStation | Post Job</title>

	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

	<meta name="description" content="It is human resource management project in Bangladesh">
	<meta name="keywords" content="human resource management, work, daily work, homework, earn money" />
	<meta name="author" content="M Irfanul Kalam Chowdhury, Foyzul Abrar Chowdhury, Yamin Sobhan">

	<!-- Mobile Metas -->
	<meta name="viewport" content="width=device-width, initial-scale=1">


	<link rel="shortcut icon" href="img/site_logo/favicon.ico" />

	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">

	<!-- Theme CSS -->
	<link rel="stylesheet" href="css/reset.css">
	<link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" href="css/mobile.css">

	<!-- Theme JS -->


	<link href="css/bootstrap-datetimepicker.min.css" rel="stylesheet" media="screen">

	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

</head>

<body class="post-job-page-body">











	<?php

	if (!isset($_SESSION)) session_start();

	require 'backEnds/dbConnection.php';
	require "class/classForFunctions.php";


	if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == 1) {
		$name = $_SESSION['first_name'];
		$account_type = $_SESSION['account_type'];
		if ($account_type != 'user') {
			?>
			<script>
				swal({
					title: "Error!",
					text: "You are not allowed!",
					icon: "error",
					button: "OK",
					closeOnClickOutside: false
				}).then(function() {
					window.location = "Dashboard.php";
				});
			</script>
		<?php
			}
		} else {
			?>
		<script>
			swal({
				title: "Error!",
				text: "Please log in First. Thank You!",
				icon: "error",
				button: "OK",
				closeOnClickOutside: false
			}).then(function() {
				window.location = "index.php";
			});
		</script>
	<?php
	}

	$categories = $mysqli->query("SELECT * FROM category");
	$categories2 = $mysqli->query("SELECT * FROM category");
	$area = $mysqli->query("SELECT * FROM area_table");

	$sub_category_check = $mysqli->query("SELECT * FROM sub_category_table");
	?>




	<!--Facebook chat plugin-->


	<?php

	include "layouts/facebookContact.php"

	?>


	<!--facebook chat plugin ends-->

	<?php

	include "layouts/nav.php"

	?>

	<div class="postJobHeader">
		<h3>Get your work Done!</h3>
	</div>
	<div class="container">
		<div class="row post-job-page">
			<div class="col-md-8 post-job-section">
				<!-- <h2>Get your work Done!</h2> -->
				<form action="backEnds/postingJob.php" method="POST" enctype="multipart/form-data">

					<div class="row">
						<div class="col-md-6">
							<label>Job title <span class="m-1-5 text-danger">*</span></label><br>
							<input class="job-title-input" type="text" name="job_title" placeholder="Ex: Need Electracian" required>
						</div>
						<div class="col-md-6">
							<label>Category <span class="m-1-5 text-danger">*</span></label>
							<br>
							<select id="category" onchange="subcategory()" name="category" required>
								<option disabled selected value> -- select a category -- </option>
								<?php while ($row = mysqli_fetch_array($categories)) : ?>
									<?php
										$parent_id = $row['category_id'];
										$parent_name = $row['category_name'];

										?>
									<option name="itemFor" value="<?= $parent_id; ?>">
										<?= $parent_name; ?>
									</option>
								<?php endwhile; ?>

								<option id="category" name="itemFor" value="other">Other</option>
							</select>

							<br><br>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<label>Sub Category <span class="m-1-5 text-danger">*</span></label>
							<br>
							<select id="zero">
								<option disabled selected value> -- select a Sub Category-- </option>
							</select>
							<?php
							// $i=235;
							while ($row = mysqli_fetch_array($categories2)) {
								$category_id_search = $row['category_id'];
								$sql = $mysqli->query("SELECT * FROM sub_category_table WHERE category_id = $category_id_search");
								?>
								<select style="display: none;" id="<?php echo $category_id_search ?>" name="sub_category" onchange="subcategory()">
									<option disabled selected value>-- select one -- </option>
									<?php
										while ($newRow = mysqli_fetch_array($sql)) {
											$n = $newRow['sub_category_id'];
											$n2 = $mysqli->query("SELECT * FROM service_table WHERE sub_category_id = $n");
											if ($n2->num_rows > 0) {

												while ($n3 = mysqli_fetch_array($n2)) {
													?>
												<option name="itemFor" value="<?php echo $n3['service_id']; ?>"><?= $newRow['sub_category_name'] ?> </option>
											<?php
															break;
														}
													} else {
														?>
											<option name="itemFor" value="<?php echo $newRow['sub_category_name']; ?>"><?= $newRow['sub_category_name'] ?> </option>
									<?php
											}
										}
										?>
								</select>
							<?php
							}
							?>

							<input id="other" type="text" name="itemFor" style="display: none;">

						</div>

						<div class="col-md-6">
							<label>Services <span class="m-1-5 text-danger">*</span></label>
							<select id="zero2">
								<option disabled selected value> -- select a Service-- </option>
							</select>
							<?php
							while ($row = mysqli_fetch_array($sub_category_check)) {
								$sub_category_id_search = $row['sub_category_id'];
								// $service_id_search = $row['service_id'];
								$sql = $mysqli->query("SELECT * FROM service_table WHERE sub_category_id = $sub_category_id_search");
								$num_rows_user = mysqli_num_rows($sql);
								$n5 = mysqli_fetch_assoc($sql);
								// echo $num_rows_user;
								// echo $n5['service_id'];
								?>


								<select style="display: none;" id="<?php echo $n5['service_id'] ?>" name="service">
									<option disabled selected value>-- select one -- </option>
									<option value="<?php echo $n5['service_id'] ?>"><?= $n5['service_name'] ?></option>
									<?php
										if ($num_rows_user > 0) {
											while ($newRow = mysqli_fetch_array($sql)) :
												?>
											<option value="<?php echo $newRow['service_id'] ?>"><?= $newRow['service_name'] ?></option>
									<?php

											endwhile;
										}
										?>
								</select>

							<?php
							}
							?>
							<br><br>
						</div>
						<br><br>
					</div>
					<div class="row">
						<div class="col-md-6">
							<label>Street Address <span class="m-1-5 text-danger">*</span></label>
							<br>
							<input type="text" name="street_address" required>
						</div>

						<div class="col-md-6">
							<label>Area <span class="m-1-5 text-danger">*</span></label>
							<br>
							<select name="area" id="area" required>
								<option disabled selected value> -- select an area -- </option>
								<?php while ($row = mysqli_fetch_array($area)) : ?>
									<option name="itemFor" value="<?= $row['area_id']; ?>"><?= $row['area_name']; ?></option>
								<?php endwhile; ?>
							</select>
							<br><br>
						</div>
					</div>
					<!--  -->
					<!-- <div class="extra-space-m"></div> -->

					<div class="row">
						<div class="col-md-6">
							<label>Image</label><br>
							<input type="file" accept="image/*" name="image_name">
						</div>
						<div class="col-md-6" name="time">
							<label for="dtp_input1" name="time">Date & Time Picking <span class="m-1-5 text-danger">*</span></label>
							<div name="time" onclick="picking()" class="input-group date form_datetime" data-date="1979-09-16T05:25:07Z" data-date-format="dd-MM-yyyy HH:ii:ss" data-link-field="dtp_input1">
								<input name="time" id="time" class="form-control" size="16" type="text" value="" readonly required>
								<span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
								<span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
							</div>
							<input type="hidden" id="dtp_input1" value="" /><br />
						</div>

					</div>

					<label>Job Description <span class="m-1-5 text-danger">*</span></label>
					<textarea placeholder="Write About Your Job" class="job-description-input" name="job_description" id="job_description" required></textarea>
					<center>
						<button type="submit" name="postsubmit" class="btn">Post</button>
					</center>

				</form>
			</div>

			<div class="col-md-3 terms-conditions-section">
				<h5>Terms & Conditions</h5>
				<div class="terms-conditions">
					<ul>
						<li><b>1. </b>Describe your project in as much detail as you can comfortably reveal - it will increase the quality of proposals you receive and shorten the selection process.</li>
						<br>
						<li><b>2. </b>Upload as much relevant information (pictures, documents, specifications, links, etc) as possible to get a realistic quote.</li>
						<br>
						<li><b>3. </b>Match the experience level to your requirements – remember, you’re looking for the best you can afford, not the cheapest you can get.</li>

						<p>For more helpful tips, see our guide <a href="#">“Hiring a freelancer”.</a></p>
					</ul>
				</div>
			</div>
		</div>

	</div>

	<?php

	include "layouts/footer.php";

	?>


	<script src="js/theme.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	<script type="text/javascript" src="js/bootstrap-datetimepicker.js" charset="UTF-8"></script>
	<!-- <script type="text/javascript" src="js/bootstrap-datetimepicker.fr.js" charset="UTF-8"></script> -->

</body>

</html>