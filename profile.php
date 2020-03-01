<!DOCTYPE html>
<html>

<head>

	<title>BdWorkStation | Profile</title>
	<link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="icon" href="img/favicon.ico" type="image/x-icon">
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

<body class="profileBody">




	<?php
	require "backEnds/dbConnection.php";
	require "class/classForFunctions.php";

	use Carbon\Carbon;

	if (!isset($_SESSION)) session_start();

	if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == 1) {

		$account_type = $_SESSION['account_type'];
		$phone = $_SESSION['phone'];
	} else {
		?>
		<script>
			swal({
				title: "Error!",
				text: "Please log in First. Thank You!",
				icon: "error",
				button: "OK",
				closeOnClickOutside: false,
			}).then(function() {
				window.location = "index.php";
			});
		</script>
		<?php
		}

		if ($account_type == 'user') {
			$profile_check = $mysqli->query("SELECT *FROM user_table WHERE phone_number='$phone'") or die($mysqli->error);
			while ($row = $profile_check->fetch_assoc()) {
				$user_id = $row['user_id'];
				$first_name = $row['first_name'];
				$last_name = $row['last_name'];
				$phone = $row['phone_number'];
				$area = $row['area'];
				$is_verified = $row['is_verified'];
				$address = $row['address'];
				$image = $row['image'];
				$image_des = "image/user/" . $image;
				$is_verified = $row['is_verified'];

				if ($is_verified == 0) {
					if ($_SESSION['verfied_warning_show'] != 1) {
						?>
					<script>
						swal({
							title: "Warning!",
							text: "You are not verified Yet. Please verify your account!",
							icon: "warning",
							buttons: ["Cancel", "Verify"],
							closeOnClickOutside: false
						}).then((willVerify) => {
							if (willVerify) {
								window.location = "setting.php";
							} else {
								window.location = "profile.php";
							}
						});
					</script>
				<?php
								$_SESSION['verfied_warning_show'] = 1;
							}
						}
					}

					// Complete Job
					$job_is_done = $mysqli->query("SELECT job_id FROM job_table WHERE user_id = $user_id AND (SELECT job_status.job_id FROM job_status WHERE is_done='1' AND is_canceled='0' AND in_progress='1' AND is_started='1' AND job_table.job_id = job_status.job_id) ORDER BY post_time DESC");
					$job_is_done_count = $job_is_done->num_rows;

					// Worker worked with
					$worker_number = array();
					while ($row = $job_is_done->fetch_assoc()) {
						$jId = $row['job_id'];

						$search_proposal = $mysqli->query("SELECT proposal_id FROM hire_table WHERE job_id = '$jId'");
						$proposal_id = $search_proposal->fetch_assoc()['proposal_id'];

						$search_worker = $mysqli->query("SELECT worker_id FROM proposal_table WHERE proposal_id = '$proposal_id'");
						$wId = $search_worker->fetch_assoc()['worker_id'];

						$key = array_keys($worker_number, $wId);
						if ($key == null) {
							array_push($worker_number, $wId); // Store workerId in an array
						}
					}
					$total_worker_work = sizeof($worker_number);

					// User Rating
					$avg_user_rating = $mysqli->query("SELECT user_rating FROM avg_user_rating WHERE user_id = '$user_id' ");
					if ($avg_user_rating->num_rows > 0) {
						# code...
						$avg_rating = $avg_user_rating->fetch_assoc()['user_rating'];
					} else {
						$avg_rating = "00";
					}
				} else {
					$profile_check = $mysqli->query("SELECT *FROM worker_table WHERE phone_number='$phone'") or die($mysqli->error);
					while ($row = $profile_check->fetch_assoc()) {
						$first_name = $row['first_name'];
						$last_name = $row['last_name'];
						$phone = $row['phone_number'];
						$area = $row['area'];
						$address = $row['address'];
						$image = $row['image'];
						$category_id = $row['category_id'];
						$image_des = "image/worker/" . $image;
						$is_verified = $row['is_verified'];
						$is_promoted = $row['is_promoted'];

						if ($is_verified == 0) {
							if ($_SESSION['verfied_warning_show'] != 1) {
								?>
					<script>
						swal({
							title: "Warning!",
							text: "You are not verified Yet. Please verify your account!",
							icon: "warning",
							buttons: ["Cancel", "Verify"],
							closeOnClickOutside: false
						}).then((willVerify) => {
							if (willVerify) {
								window.location = "setting.php";
							} else {
								window.location = "profile.php";
							}
						});
					</script>
	<?php
					$_SESSION['verfied_warning_show'] = 1;
				}
			}

			$worker_id = $row['worker_id'];
			$sub_category_id = $row['sub_category_id']; // Serialized array
			$sub_category_id = unserialize($sub_category_id); // convert to Unserialized array
			$count = sizeof($sub_category_id); // How many values in the array
		}

		$avg_user_rating = $mysqli->query("SELECT worker_rating FROM avg_worker_rating WHERE worker_id = '$worker_id' ");
		if ($avg_user_rating->num_rows > 0) {
			$avg_rating = $avg_user_rating->fetch_assoc()['worker_rating'];
			if ($avg_rating == 0) {
				$avg_rating = "00";
			}
		} else {
			$avg_rating = "00";
		}

		$category_check = $mysqli->query("SELECT category_name FROM category where category_id='$category_id'");
		$category_name = $category_check->fetch_assoc()['category_name'];

		$sub_category_check = $mysqli->query("SELECT * FROM sub_category_table where category_id='$category_id'");

		// Complete Job
		//First Find Proposal Id From hire and Worker_id
		$proposal_id_match_hire = $mysqli->query("SELECT `proposal_id` FROM `proposal_table` WHERE worker_id = $worker_id AND (SELECT hire_table.proposal_id FROM hire_table WHERE hire_table.proposal_id = proposal_table.proposal_id)");

		if ($proposal_id_match_hire->num_rows > 0) {
			$job_is_done_count = 0;
			$total_buyer_work = 0;
			while ($row = $proposal_id_match_hire->fetch_assoc()) {
				$pId = $row['proposal_id']; // Macth jod_id with Job_status
				$job_is_done = $mysqli->query("SELECT job_id FROM proposal_table WHERE proposal_id = $pId AND (SELECT job_status.job_id FROM job_status WHERE is_done='1' AND is_canceled='0' AND in_progress='1' AND is_started='1' AND proposal_table.job_id = job_status.job_id)");

				if ($job_is_done->num_rows > 0) {
					// Buyers worked with
					$buyer_number = array();
					$jId = $job_is_done->fetch_assoc()['job_id'];
					if ($jId != null) {
						$job_is_done_count++;
					}
					$buyer_search = $mysqli->query("SELECT user_id FROM job_table WHERE job_id = '$jId'");
					if ($buyer_search) {
						$bId = $buyer_search->fetch_assoc()['user_id'];
						$key = array_keys($buyer_number, $bId);
						if ($key == null) {
							array_push($buyer_number, $bId); // Store workerId in an array
						}
					}
					$total_buyer_work = sizeof($buyer_number);
				}
			}
		} else { // If New Worker OR Don't have any job Done
			$job_is_done_count = 0;
			$total_buyer_work = 0;
		}
	}
	$address_check = $mysqli->query("SELECT area_name FROM area_table WHERE area_id='$area'");

	if ($address_check->num_rows > 0) {
		$area = $address_check->fetch_assoc()['area_name'];
	}
	$full_name = $first_name . " " . $last_name;
	?>



	<!-- Body Start -->

	<!--Facebook chat plugin-->


	<?php

	include "layouts/facebookContact.php"

	?>


	<!--facebook chat plugin ends-->
	<?php
	include "layouts/nav.php";
	?>
	<div class="profileAllContent">

		<div class="profileCoverColor">

		</div>
		<div class="col-md-4 col-xs-12">

			<div class="profileLeftAllContent">
				<div class="profileLeftInfo">
					<?php
					echo "
<img class='profileDisplayImage img-responsive img-rounded'
alt='$full_name' src='" . $image_des . "'>";
					?>


					<div class="profileLeftInfoText">
						<h3><?php echo $full_name; ?>
							<?php
							if ($account_type == 'worker') {
								if ($is_verified == 1) {
									?>
									<img src="img/verifed_badge.svg" title="Verified By Team WorkStation" />
								<?php
									}
									if ($is_promoted == 1) {
										?>
									<img src="img/recommand.svg" title="Recommandated worker By Team WorkStation" />
								<?php
									}
								} else {
									if ($is_verified == 1) {
										?>
									<img src="img/verifed_badge.svg" title="Verified By Team WorkStation" />
							<?php
								}
							}

							?>
						</h3>

						<p class="profileDisplayAddress"><?= $area; ?></p>


						<?php
						if ($account_type == 'worker') : ?>

							<div class="profileDisplayCategory">
								<h4>Category</h4>
								<p><?= $category_name; ?></p>

							</div>

							<div class="profileDisplaySubCategory">
								<h4>Sub Category</h4>
								<?php
									if ($count > 0) {
										for ($i = 0; $i < $count; $i++) {
											$sub_category_name = $mysqli->query("SELECT sub_category_name FROM sub_category_table where sub_category_id='$sub_category_id[$i]'");
											$sub_category_name_show = $sub_category_name->fetch_assoc()['sub_category_name'];
											echo "<p>$sub_category_name_show</p>";
										}
									}
									?>
							</div>
						<?php endif; ?>

						<div class="profileInsights">
							<h4>Insights</h4>
						</div>
						<?php
						if ($account_type != 'worker') { ?>
							<div class="row profileWorkInfo">
								<p class="col-md-10 col-xs-8">Completed job</p>
								<p class="col-md-2 col-xs-4"><?= $job_is_done_count; ?></p>
							</div>
							<br>
							<div class="row">
								<p class="col-md-10 col-xs-8">Worker worked with</p>
								<p class="col-md-2 col-xs-4"><?= $total_worker_work; ?></p>
							</div>
							<br>
							<div class="row">
								<p class="col-md-8 col-xs-6">User Rating</p>
								<div class="col-md-2 col-xs-4">
									<span class="rating-static rating-<?= $avg_rating; ?>"></span>
								</div>
								<?php
									$avg_rating = $avg_rating[0] . "." . $avg_rating[1];
									?>
								<p class="col-md-2 col-xs-2"><?= $avg_rating; ?></p>
							</div>
							<br>
							<br>
						<?php
						} else { ?>
							<div class="row profileWorkInfo">
								<p class="col-md-10 col-xs-8">Completed job</p>
								<p class="col-md-2 col-xs-4"><?= $job_is_done_count; ?></p>
							</div>
							<br>
							<div class="row">
								<p class="col-md-10 col-xs-8">Buyers worked with</p>
								<p class="col-md-2 col-xs-4"><?= $total_buyer_work; ?></p>
							</div>
							<br>
							<div class="row">
								<p class="col-md-8 col-xs-6">User Rating</p>
								<div class="col-md-2 col-xs-4">
									<span class="rating-static rating-<?= $avg_rating; ?>"></span>
								</div>
								<?php
									$avg_rating = $avg_rating[0] . "." . $avg_rating[1];
									?>
								<p class="col-md-2 col-xs-2"><?= $avg_rating; ?></p>
							</div>
							<br>
							<br>
						<?php
						}



						?>
					</div>
				</div>
			</div>
		</div>

		<!-- Right Informatio -->
		<div class="col-md-7 col-xs-12">
			<div class="profileRightTopMenu">
				<?php
				if ($account_type == 'worker') {
					display('<h4>Review</h4>');
				} else
					display('<h4>Review</h4>');
				?>

				<div class="profileRightContents">
					<?php
					if ($account_type == 'worker') {
						$sql_count = $mysqli->query("SELECT worker_review_id FROM `worker_review_table` WHERE worker_id = '$worker_id'");

						//Total Count Data For Pagination
						$total_records = $sql_count->num_rows;
						$limit = 2;
						$total_pages = ceil($total_records / $limit);
						//First Time Load Data
						if (isset($_GET["page"])) {
							$page  = $_GET["page"];
						} else {
							$page = 1;
						}
						$start_from = ($page - 1) * $limit;

						$sql_r = $mysqli->query("SELECT job_table.job_id,job_table.job_title, job_table.post_time, user_table.user_id,user_table.first_name,worker_review_table.from_user_review,worker_review_table.review_description FROM worker_review_table INNER JOIN user_table ON user_table.user_id=worker_review_table.from_user_id INNER JOIN job_table ON job_table.job_id = worker_review_table.job_id WHERE worker_review_table.worker_id='$worker_id' LIMIT $start_from, $limit");

						if ($sql_r->num_rows > 0) {
							while ($rows = $sql_r->fetch_assoc()) {

								$job_id = $rows['job_id'];
								$job_title = $rows['job_title'];
								$job_post_time = $rows['post_time'];
								$j_post_time = Carbon::parse($job_post_time);
								$job_post_time = $j_post_time->toDayDateTimeString();
								$users_id = $rows['user_id'];
								$users_name = $rows['first_name'];
								$users_review = $rows['from_user_review'];
								$description = $rows['review_description'];

								?>
								<div class="rightSingleContent">
									<div class="headerContent">
										<h5><?= $job_title ?></h5>
										<p>Posted by <b><span><?= $users_name; ?></span></b><br>Posted <?= $job_post_time; ?></p>
									</div>
									<div class="childContent">
										<div class="row">
											<div class="col-md-12">
												<div class="rightChildContent">
													<h5><?= $users_name; ?></h5>
													<span class="rating-static rating-<?= $users_review; ?>"></span><br>
													<p><?= $description; ?></p>
												</div>
											</div>
										</div>
									</div>
								</div>
								<hr>
							<?php

									}
									?>
							<center>
								<?php
										if ($total_pages > 1) {
											?>
									<nav>
										<ul class="pagination">
											<?php if (!empty($total_pages)) : for ($i = 1; $i <= $total_pages; $i++) :
																if ($i == $page) : ?>
														<li class="active" id="<?php echo $i; ?>"><a href='profile.php?page=<?php echo $i; ?>'><?php echo $i; ?></a></li>
													<?php else : ?>
														<li id="<?php echo $i; ?>"><a href='profile.php?page=<?php echo $i; ?>'><?php echo $i; ?></a></li>
													<?php endif; ?>
											<?php endfor;
														endif; ?>
										</ul>
									</nav>
								<?php
										}
										?>
							</center>
							<?php
								} else {
									display('You have not received any reviews, yet.');
								}
							} else {

								$sql_count = $mysqli->query("SELECT user_review_id FROM `user_review_table` WHERE user_id = '$user_id'");
								//Total Count Data For Pagination
								$total_records = $sql_count->num_rows;
								$limit = 2;
								$total_pages = ceil($total_records / $limit);
								//First Time Load Data
								if (isset($_GET["page"])) {
									$page  = $_GET["page"];
								} else {
									$page = 1;
								}
								$start_from = ($page - 1) * $limit;

								$sql_p = $mysqli->query("SELECT job_table.job_id,job_table.job_title, job_table.post_time, worker_table.worker_id,worker_table.first_name,user_review_table.from_worker_review,user_review_table.review_description FROM user_review_table INNER JOIN worker_table ON worker_table.worker_id=user_review_table.from_worker_id INNER JOIN job_table ON job_table.job_id = user_review_table.job_id WHERE user_review_table.user_id='$user_id' LIMIT $start_from, $limit");
								if ($sql_p->num_rows > 0) {
									while ($rows = $sql_p->fetch_assoc()) {
										# code...
										$job_id = $rows['job_id'];
										$job_title = $rows['job_title'];
										$job_post_time = $rows['post_time'];
										$j_post_time = Carbon::parse($job_post_time);
										$job_post_time = $j_post_time->toDayDateTimeString();
										$workers_id = $rows['worker_id'];
										$workers_name = $rows['first_name'];
										$workers_review = $rows['from_worker_review'];
										$description = $rows['review_description'];

										?>
								<div class="rightSingleContent">
									<div class="headerContent">
										<h5><?= $job_title; ?></h5>
										<p>Posted <?= $job_post_time; ?></p>
									</div>
									<div class="childContent">
										<div class="row">
											<div class="col-md-12">
												<div class="rightChildContent">
													<h5><?= $workers_name; ?></h5>
													<span class="rating-static rating-<?= $workers_review; ?>"></span><br>
													<p><?= $description; ?></p>
												</div>
											</div>
										</div>
									</div>
								</div>
								<hr>
							<?php
									}
									?>
							<center>
								<?php
										if ($total_pages > 1) {
											?>
									<nav>
										<ul class="pagination">
											<?php if (!empty($total_pages)) : for ($i = 1; $i <= $total_pages; $i++) :
																if ($i == $page) : ?>
														<li class="active" id="<?php echo $i; ?>"><a href='profile.php?page=<?php echo $i; ?>'><?php echo $i; ?></a></li>
													<?php else : ?>
														<li id="<?php echo $i; ?>"><a href='profile.php?page=<?php echo $i; ?>'><?php echo $i; ?></a></li>
													<?php endif; ?>
											<?php endfor;
														endif; ?>
										</ul>
									</nav>
								<?php
										}
										?>

							</center>
						<?php
							} else {
								display('You have not hired anyone yet.');
							}
							?><br>
					<?php
					}
					?>



				</div>
			</div>
		</div>

	</div>

</body>

</html>