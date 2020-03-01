<!DOCTYPE html>
<html>

<head>

	<script src="js/validation.js"></script>

	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title>BdWorkStation | Complete Profile</title>
	<meta name="description" content="It is human resource management project in Bangladesh">
	<meta name="keywords" content="human resource management, work, daily work, homework, earn money" />
	<meta name="author" content="M Irfanul Kalam Chowdhury, Foyzul Abrar Chowdhury, Yamin Sobhan">

	<!-- Mobile Metas -->
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<link rel="shortcut icon" href="img/site_logo/favicon.ico" />

	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

	<!-- Theme CSS -->

	<link rel="stylesheet" href="css/reset.css">
	<link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" href="css/mobile.css">

	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</head>

<body class="completeProfileBody">






	<?php
	require 'backEnds/dbConnection.php';
	if (!isset($_SESSION)) session_start();

	$area = $mysqli->query("SELECT * FROM area_table");
	$area2 = $mysqli->query("SELECT * FROM area_table");
	$categories = $mysqli->query("SELECT * FROM category");


	if (isset($_SESSION['account_type'])) {
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
	} elseif (!isset($_SESSION['phone'])) {
		?>
		<script>
			swal({
				title: "Error!",
				text: "You are not allowed!",
				icon: "error",
				button: "OK",
				closeOnClickOutside: false
			}).then(function() {
				window.location = "index.php";
			});
		</script>
	<?php
	} else {
		$name = $_SESSION['first_name'];
		$phoneNumber = $_SESSION['phone'];
	}

	?>


	<!--Facebook chat plugin-->


	<?php

	include "layouts/facebookContact.php"

	?>


	<!--facebook chat plugin ends-->

	<!--========== BEGIN HEADER ==========-->

	<?php

	include "layouts/nav.php"

	?>
	<!-- ========= END HEADER =========-->


	<div class="container completeProfile">
		<h2 class="header text-danger">Do you want to join us?</h2>
		<div class="completeProfileTopMenu">
			<div class="row container">
				<p onclick="displayUser()" id="userOption" class="col-md-6 col-xs-6 optionStyle1 optionStyle2 optionActive">User</p>
				<p onclick="displayWorker()" id="workerOption" class="col-md-6 col-xs-6 optionStyle1 optionStyle2 ">Worker</p>
				<!-- <p onclick="displayBoth()" id="bothOption" class="col-md-4 optionStyle1 ">Both</p> -->
			</div>
		</div>

		<div class="col-md-8 userForm" id="userForm">
			<center>
				<h4>User Account</h4>
			</center>
			<form method="POST" action="backEnds/userReg.php" enctype="multipart/form-data">
				<div class="row">
					<div class="col-md-6">
						<label>First Name * </label><br>
						<input id="userfirstName" class="form-control" onkeyup="nameValidation(1)" type="text" name="first_name" placeholder="First Name" required>
						<span id="userfirstNameMsg"></span><br><br>

						<label>Last Name * </label><br>
						<input id="userlastName" class="form-control" onkeyup="nameValidation(1)" type="text" name="last_name" placeholder="Last Name" required>
						<span id="userlastNameMsg"></span><br><br>

						<label>Street Address * </label><br>
						<input class="form-control" type="text" name="address" placeholder="Street Address" required>
						<br>
						<label>Area * </label>
						<br>
						<select name="area" class="completeProfileArea form-control" id="area" required>
							<option disabled selected value> -- select an area -- </option>
							<?php while ($row = mysqli_fetch_array($area)) : ?>
								<option name="itemFor" value="<?= $row['area_name']; ?>"><?= $row['area_name']; ?></option>
							<?php endwhile; ?>
						</select>
						<br><br>
						<label>Phone Number</label><br>
						<input class="form-control" type="text" name="Phone" placeholder="<?php echo $phoneNumber; ?>" disabled="true">
						<br>
					</div>
					<div class="col-md-6">
						<!-- image section -->
						<label>Profile Image * </label><br>
						<input class="form-control" type="file" accept="image/*" name="image_name" required>

						<label>Set a Password *</label>
						<input id="userpass1" class="form-control" type="Password" name="password" onkeyup="passValidation(1)" pattern=".{6,}" title="Password should be at least 6 Character long" required>
						<span id="userpassLengthErrorMsg"></span><br><br>

						<label>ReType Password * </label>
						<input id="userpass2" class="form-control" type="Password" name="rptPassword" onkeyup="passValidation(1)" required>
						<span id="userpassMatchErrorMsg"></span><br><br>
					</div>
				</div>
				<center><button type="submit" class="btn btn-danger" name="userSubmit" value="userSubmit">Submit</button></center>
			</form>
		</div>

		<div class="col-md-8 workerForm" id="workerForm">
			<center>
				<h4>Worker Account</h4>
			</center>
			<form method="POST" action="backEnds/workerReg.php" enctype="multipart/form-data">
				<div class="row">

					<div class="col-md-6">
						<label>First Name * </label> <br>
						<input id="workerfirstName" onkeyup="nameValidation(2)" class="form-control" type="text" name="first_name" placeholder="First Name" required>
						<span id="workerfirstNameMsg"></span><br><br>

						<label>Last Name * </label> <br>
						<input id="workerlastName" onkeyup="nameValidation(2)" class="form-control" type="text" name="last_name" placeholder="Last Name" required>
						<span id="workerlastNameMsg"></span> <br><br>

						<label>Street Address * </label><br>
						<input class="form-control" type="text" name="address" placeholder="Street Address" required>
						<br>
						<label>Area * </label>
						<br>
						<select class="form-control" name="area" id="area" required>
							<option disabled selected value> -- select an area -- </option>
							<?php while ($row = mysqli_fetch_array($area2)) : ?>
								<option name="itemFor" value="<?= $row['area_name']; ?>"><?= $row['area_name']; ?></option>
							<?php endwhile; ?>
						</select>
						<br><br>
						<label>Set a Password * </label>
						<input id="workerpass1" onkeyup="passValidation(2)" class="form-control" type="Password" pattern=".{6,}" title="Password should be at least 6 Character long" name="password" required>
						<span id="workerpassLengthErrorMsg"></span> <br><br>

						<label>ReType Password * </label>
						<input id="workerpass2" onkeyup="passValidation(2)" class="form-control" type="Password" name="rptPassword" required>
						<span id="workerpassMatchErrorMsg"></span><br><br>
					</div>
					<div class="col-md-6">
						<!-- Image section -->
						<label>Profile Image * </label><br>
						<input class="form-control" type="file" accept="image/*" name="image_name" required><br>

						<label>Phone Number</label><br>
						<input class="form-control" type="text" name="Phone" placeholder="<?php echo $phoneNumber; ?>" disabled="true">
						<br>
						<label>Category * </label>
						<select class="form-control" id="formCategory" name="Category" onchange="formSubCategoryShow()" required>
							<option disabled selected value> -- select a category -- </option>
							<?php while ($row = mysqli_fetch_array($categories)) : ?>
								<option name="itemFor" value="<?= $row['category_id']; ?>"><?= $row['category_name']; ?></option>
							<?php endwhile; ?>
							<button class="btn-save btn btn-primary btn-sm">Save</button>
						</select>
						<br>
						<label>Sub Category</label>
						<?php
						$categories2 = $mysqli->query("SELECT category_id FROM category");
						while ($row = $categories2->fetch_assoc()) {
							$cat_id = $row['category_id'];
							?>
							<div id="<?= $cat_id; ?>" style="display:none;height:200px;overflow-y:scroll;border:1px solid gray;padding:10px;">
								<?php
									$sub_category_search = $mysqli->query("SELECT * FROM sub_category_table where category_id='$cat_id'");
									while ($row2 = $sub_category_search->fetch_assoc()) {
										?>
									<input type='checkbox' name="sub[]" value="<?= $row2['sub_category_id']; ?>"> <?= $row2['sub_category_name']; ?>
									<br>

								<?php
									}
									?>
							</div>
						<?php
						}
						?>
					</div>

				</div>
				<center><button class="btn btn-danger" name="workerSubmit">Submit</button></center>
			</form>
		</div>



	</div>


	<!-- Theme JS -->
	<script src="js/theme.js"></script>
	<script src="js/validation.js"></script>
	<script type="text/javascript" src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

</body>

</html>