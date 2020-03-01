
<!DOCTYPE html>
<html>

<head>
	<title>BdWorkStation | Dashboard</title>
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

	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</head>

<body class="dashBoardBody">


<?php
require 'vendor/autoload.php';


use Carbon\Carbon;

$current_time = Carbon::now('Asia/Dhaka')->format('H');
require "class/classForFunctions.php";
if (!isset($_SESSION)) session_start();

if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == 1) {
	$first_name = $_SESSION['first_name'];
	$phone = $_SESSION['phone'];
	$account_type = $_SESSION['account_type'];
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
#---greetings---
if ($current_time < 12) {
	$msg = "Good Morning";
}
if ($current_time >= 12 and $current_time < 18) {
	$msg = "Good Afternoon";
}
if ($current_time >= 18) {
	$msg = "Good Evening";
}
if ($account_type == 'user') {
	$user_check = $mysqli->query("SELECT * FROM user_table WHERE phone_number=$phone");
	$user = $user_check->fetch_assoc();
	$uId = $user['user_id'];

	// OPEN Job
	$job_check = $mysqli->query("SELECT * FROM job_table WHERE user_id = $uId AND (SELECT job_status.job_id FROM job_status WHERE is_done='0' AND is_canceled='0' AND in_progress='0' AND job_table.job_id = job_status.job_id) ORDER BY post_time DESC");
	$open_job_count = $job_check->num_rows;

	// In Progress Job
	$job_in_progress = $mysqli->query("SELECT * FROM job_table WHERE user_id = $uId AND (SELECT job_status.job_id FROM job_status WHERE is_done='0' AND is_canceled='0' AND in_progress='1' AND job_table.job_id = job_status.job_id) ORDER BY post_time DESC");
	$job_in_progress_count = $job_in_progress->num_rows;

	// Complete Job
	$job_is_done = $mysqli->query("SELECT * FROM job_table WHERE user_id = $uId AND (SELECT job_status.job_id FROM job_status WHERE is_done='1' AND is_canceled='0' AND in_progress='1' AND is_started='1' AND job_table.job_id = job_status.job_id) ORDER BY post_time DESC");
	$job_is_done_count = $job_is_done->num_rows;
} elseif ($account_type == 'worker') {
	$worker_check = $mysqli->query("SELECT * FROM worker_table WHERE phone_number=$phone");
	$worker = $worker_check->fetch_assoc();
	$wId = $worker['worker_id'];

	// Number Of Proposal Send
	$proposal_number_check = $mysqli->query("SELECT * FROM proposal_table WHERE worker_id = '$wId'");
	$total_propsal = $proposal_number_check->num_rows;

	//Show Proposal List
	//First Seacrh All the Job_id FROM Proposal Table
	$proposal_check = $mysqli->query("SELECT job_id FROM proposal_table where worker_id='$wId' AND (SELECT job_status.job_id FROM job_status WHERE is_done='0' AND is_canceled='0' AND in_progress='0' AND is_started='0' AND proposal_table.job_id = job_status.job_id)");

	//Number Of Job In Progress
	$progress_number_check = $mysqli->query("SELECT job_id FROM proposal_table where worker_id='$wId' AND (SELECT job_status.job_id FROM job_status WHERE is_done='0' AND is_canceled='0' AND in_progress='1' AND proposal_table.job_id = job_status.job_id)");
	$total_progress = $progress_number_check->num_rows;
}

?>

	<!--Facebook chat plugin-->


	<?php

	include "layouts/facebookContact.php"

	?>


	<!--facebook chat plugin ends-->

	<?php
	include "layouts/nav.php";
	?>
	<div class="container dashBoardFullPage">
		<div class="row">
			<div class="col-md-12 dashBoardWelcomeSection">

				<div class="col-md-6 dashBoardWelcomeSectionGreeting">
					<p><b><?= $msg ?> </b></p>
					<span><b><?= $first_name ?></b></span>
				</div>
				<?php
				if ($account_type == 'worker') {
					?>
					<div class="col-md-2 col-xs-6 dashBoardWorkerCredits"><a href="#">

							<h1><?= $total_propsal; ?></h1>
							<p>TOTAL PROPOSAL SENT</p>

						</a></div>

					<div class="col-md-2 col-xs-6 dashBoardWorkerJobInPr"><a href="#job_in_progress">

							<h1><?= $total_progress; ?></h1>
							<p>JOB IN PROGRESS</p>

						</a></div>


				<?php } else {
					?>
					<div class="col-md-2 col-xs-4 dashBoardUserOpenJob"><a href="#open_job">

							<h1><?= $open_job_count; ?></h1>
							<p>OPEN JOB</p>

						</a></div>

					<div class="col-md-2 col-xs-4 dashBoardUserJobInPr"><a href="#job_in_progress">

							<h1><?= $job_in_progress_count; ?></h1>
							<p>JOB IN PROGRESS</p>

						</a></div>

					<div class="col-md-2 col-xs-4 dashBoardUserComJob"><a href="#">

							<h1><?= $job_is_done_count; ?></h1>
							<p>COMPLETED JOB</p>

						</a>
					</div>
				<?php } ?>
			</div>

			<?php
			if ($account_type == 'worker') {
				?>

				<!-- JOB Proposal List -->
				<div id="job_proposal_send">
					<div class="col-md-6" id="job_proposal_send">
						<div class="dashBoardSubSections">
							<h3 class="dashBoardSectionTitle">Proposal List <i class="far fa-question-circle" title="Proposal(s) that you've sent and still buyer didn't hire anyone"></i></h3>
							<hr>

							<div class="dashBoardSubSectionsContent ">
								<?php
									if ($proposal_check->num_rows > 0) {
										while ($row = $proposal_check->fetch_assoc()) {
											$job_id = $row['job_id'];
											$job_search = $mysqli->query("SELECT * FROM job_table WHERE job_id = '$job_id'");
											while ($jobs = $job_search->fetch_assoc()) {
												$job_title = $jobs['job_title'];
												$job_post_time = $jobs['post_time'];
												$job_post_time = check_job_stable($job_post_time);
												$cId = $jobs['category_id'];
												$category_name_check = $mysqli->query("SELECT category_name FROM category WHERE category_id = $cId");
												$category_name = $category_name_check->fetch_assoc()['category_name'];
												?>
											<a class="title" href="jobDetails.php?jId=<?= $job_id; ?>&jobStatus">
												<div class="dashboardJobInProgress">
													<h5><?= $job_title; ?></h5>
													<p><i class="far fa-hand-point-right"></i> <?= $category_name; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?= $job_post_time[1] ?></p><br>
												</div>
											</a>
											<hr>
									<?php
												}
											}
										} else { ?>
									<h4 class="title">You currently have no Proposal List.</h4>
								<?php
									}
									?>
							</div>
						</div>
					</div>
				</div>

				<!-- JOB IN PROGRESS 	 -->
				<div id="job_in_progress">
					<div class="col-md-6" id="job_in_progress">
						<div class="dashBoardSubSections">
							<h3 class="dashBoardSectionTitle">Job In Progress <i class="far fa-question-circle" title="Jobs that you were hired and not completed yet"></i></h3>
							<hr>

							<div class="dashBoardSubSectionsContent ">
								<?php
									$job_check = $mysqli->query("SELECT * FROM job_table WHERE (SELECT job_status.job_id FROM job_status WHERE is_done='0' AND is_canceled='0' AND in_progress='1' AND job_table.job_id = job_status.job_id) ORDER BY post_time DESC");

									$no_job_progress = 1;
									$in_pro_check = 0;
									if ($job_check->num_rows > 0) {
										while ($row = $job_check->fetch_assoc()) {
											$job_id = $row['job_id'];
											$job_post_time = $row['post_time'];
											$job_post_time = check_job_stable($job_post_time);
											$hire_job_title = $row['job_title'];
											$cId = $row['category_id'];

											$job_hire_check = $mysqli->query("SELECT * FROM hire_table WHERE job_id = '$job_id'");

											if ($job_hire_check->num_rows > 0) {
												while ($hire_check = $job_hire_check->fetch_assoc()) {
													$proposal_id = $hire_check['proposal_id'];
													$proposal_check = $mysqli->query("SELECT * FROM proposal_table WHERE proposal_id='$proposal_id'");
													while ($proposal_info = $proposal_check->fetch_assoc()) {
														$worker_id = $proposal_info['worker_id'];
														if ($worker_id == $wId) {
															$in_pro_check  = 1;
															$no_job_progress = 0;

															$hire_category_name_check = $mysqli->query("SELECT category_name FROM category WHERE category_id = $cId");
															$hire_category_name = $hire_category_name_check->fetch_assoc()['category_name'];
															?>
														<a class="title" href="jobDetails.php?jId=<?= $job_id; ?>&jobStatus">
															<div class="dashboardJobInProgress">
																<h5><?= $hire_job_title; ?></h5>

																<p><i class="far fa-hand-point-right"></i> <?= $hire_category_name; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?= $job_post_time[1] ?></p><br>
															</div>
														</a>
														<hr>
									<?php
															} else {
																if ($in_pro_check == 0) {
																	$no_job_progress = 1;
																}
															}
														}
													}
												} else {

													$no_job_progress = 1;
												}
											}
										}
										if ($no_job_progress == 1) {
											?>
									<h4 class="title">You currently have no running job</h4>
								<?php
									}
									?>
							</div>
						</div>

					</div>
				</div>

				<!-- JOB INVITATIONS 	 -->
				<!-- <div id="project_invite">
				<div class="col-md-6" id="project_invite">
					<div class="dashBoardSubSections">
						<p>JOB INVITATIONS</p>
						<div class="dashBoardSubSectionsContent ">
							<h4 class="title">You currently have no project invitations.</h4>
						</div>
					</div>
				</div>
			</div> -->

			<?php } else {
				?>
				<!-- Open Job 	 -->
				<div id="open_job">
					<div class="col-md-6">
						<div class="dashBoardSubSections">

							<!-- <p>Open Job</p> -->
							<h3 class="dashBoardSectionTitle">Open Job</h3>
							<hr>

							<div class="dashBoardSubSectionsContent">
								<?php
									if ($job_check->num_rows > 0) {
										while ($row = $job_check->fetch_assoc()) {
											$job_post_time = $row['post_time'];
											$job_post_time = check_job_stable($job_post_time);
											if ($job_post_time[0] >= 0) {
												$cId = $row['category_id'];
												$category_check = $mysqli->query("SELECT category_name FROM category WHERE category_id = $cId");
												$category_name = $category_check->fetch_assoc();
												?>
											<a class="title" href="jobDetails.php?jId=<?= $row['job_id'] ?>&jobStatus">
												<div class="dashboardJobInProgress">
													<h5><?= $row['job_title'] ?></h5>
													<p><i class="far fa-hand-point-right"></i> <?= $category_name['category_name']; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?= $job_post_time[1] ?></p><br>
												</div>
											</a>
											<hr>
									<?php
												}
											}
										} else {
											?>
									<h4 class="title">You currently have no open job.</h4>
								<?php } ?>
							</div>
						</div>
					</div>
				</div>
				<!-- JOB IN PROGRESS 	 -->
				<div id="job_in_progress">
					<div class="col-md-6">
						<div class="dashBoardSubSections">
							<!-- <p>JOB IN PROGRESS</p> -->
							<h3 class="dashBoardSectionTitle">Job In Progress</h3>
							<hr>
							<div class="dashBoardSubSectionsContent">
								<?php
									// new Code start
									if ($job_in_progress->num_rows > 0) {
										while ($row = $job_in_progress->fetch_assoc()) {
											$job_id = $row['job_id'];
											$hire_job_title = $row['job_title'];
											$cId = $row['category_id'];
											$job_post_time = $row['post_time'];
											$job_post_time = check_job_stable($job_post_time);


											$hire_category_name_check = $mysqli->query("SELECT category_name FROM category WHERE category_id = $cId");
											$hire_category_name = $hire_category_name_check->fetch_assoc()['category_name'];
											?>
										<a class="title" href="jobDetails.php?jId=<?= $job_id; ?>&jobStatus">
											<div class="dashboardJobInProgress">
												<h5><?= $hire_job_title; ?></h5>

												<p><i class="far fa-hand-point-right"></i> <?= $hire_category_name; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?= $job_post_time[1] ?></p><br>
											</div>
										</a>
										<hr>
									<?php
											}
										} else {
											?>
									<h4 class="title">You currently have no running job</h4>
								<?php
									}

									// new code End
									?>
							</div>
						</div>

					</div>
				</div>
			<?php } ?>
			<!-- </div>
			</div> -->
		</div>
	</div>
	<br><br><br><br>

	<!-- Begin footer -->
	<?php include "layouts/footer.php" ?>
	<!-- End footer -->


</body>

</html>