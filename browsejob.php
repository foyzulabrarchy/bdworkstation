<!DOCTYPE html>
<html>

<head>
	<title>BdWorkStation | Browse Job</title>

	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="description" content="It is human resource management project in Bangladesh">
	<meta name="keywords" content="human resource management, work, daily work, homework, earn money" />
	<meta name="author" content="M Irfanul Kalam Chowdhury, Foyzul Abrar Chowdhury, Yamin Sobhan">

	<!-- Mobile Metas -->
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<link rel="shortcut icon" href="img/site_logo/favicon.ico" />


	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">

	<!-- Theme CSS -->
	<link rel="stylesheet" href="css/reset.css">
	<link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" href="css/mobile.css">

	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

</head>

<body class="browse-job-page-body">







	<?php
	if (!isset($_SESSION)) session_start();
	require 'vendor/autoload.php';
	require 'class/classForFunctions.php';
	require "backEnds/dbConnection.php";

	use Carbon\Carbon;

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
				closeOnClickOutside: false
			}).then(function() {
				window.location = "index.php";
			});
		</script>
	<?php
	}

	$account_type = $_SESSION['account_type'];

	$job_status = $mysqli->query("SELECT job_id FROM job_status WHERE is_started='0' AND is_done='0' AND is_canceled='0' AND in_progress='0' ORDER BY id DESC");

	// $job_id_check = $mysqli->query("SELECT * FROM job_table WHERE is_done='0' AND is_canceled='0' AND in_progress='0' ORDER BY post_time DESC") or die($mysqli->error);

	$area = $mysqli->query("SELECT * FROM area_table");
	$categories = $mysqli->query("SELECT * FROM category");

	if (isset($_GET['searchQuery'])) {
		$key = $_GET['searchQuery'];
		// $job_id_check = $mysqli->query("SELECT * FROM job_table WHERE is_done='0' AND is_canceled='0' AND in_progress='0' AND (`job_title` LIKE '%" . $key . "%') ORDER BY post_time DESC");

		$job_status = $mysqli->query("SELECT * FROM job_table WHERE `job_title` LIKE '%" . $key . "%' AND (SELECT job_status.job_id FROM job_status WHERE is_done='0' AND is_canceled='0' AND in_progress='0' AND job_table.job_id = job_status.job_id) ORDER BY post_time DESC");
	}

	if (isset($_GET['cId']) || isset($_GET['aId'])) {

		$link = $_SERVER['REQUEST_URI'];
		if (parse_url($link, PHP_URL_QUERY)) {
			$parts = parse_url($link);
			parse_str($parts['query'], $qq);

			if (!empty($qq['cId']) && !empty($qq['aId'])) {
				$cId = $qq['cId'];
				$aId = $qq['aId'];
				// Search job both aId and cId
				$job_status = $mysqli->query("SELECT * FROM job_table WHERE job_area='$aId' AND category_id='$cId' AND (SELECT job_status.job_id FROM job_status WHERE is_done='0' AND is_canceled='0' AND in_progress='0' AND job_table.job_id = job_status.job_id) ORDER BY post_time DESC");
			} elseif (!empty($qq['cId']) && empty($qq['aId'])) {
				$cId = $qq['cId'];
				// Search job with cId
				$job_status = $mysqli->query("SELECT * FROM job_table WHERE category_id='$cId' AND (SELECT job_status.job_id FROM job_status WHERE is_done='0' AND is_canceled='0' AND in_progress='0' AND job_table.job_id = job_status.job_id) ORDER BY post_time DESC");
			} elseif (empty($qq['cId']) && !empty($qq['aId'])) {
				$aId = $qq['aId'];
				// Search job both aId and aId
				$job_status = $mysqli->query("SELECT * FROM job_table WHERE job_area='$aId' AND (SELECT job_status.job_id FROM job_status WHERE is_done='0' AND is_canceled='0' AND in_progress='0' AND job_table.job_id = job_status.job_id) ORDER BY post_time DESC");
			}
		}
	}

	if (isset($_GET['cId'])) {
		$cId = $_GET['cId'];
		// $job_id_check = $mysqli->query("SELECT * FROM job_table WHERE is_done='0' AND is_canceled='0' AND in_progress='0' AND category_id = '$cId' ORDER BY post_time DESC");
		$category_name = $mysqli->query("SELECT * FROM category WHERE category_id = '$cId'");
		$category_name_show = mysqli_fetch_assoc($category_name);
	}
	if (isset($_GET['aId'])) {
		$aId = $_GET['aId'];
		// $job_id_check = $mysqli->query("SELECT * FROM job_table WHERE is_done='0' AND is_canceled='0' AND in_progress='0' AND job_area = '$aId' ORDER BY post_time DESC");
		$area_name = $mysqli->query("SELECT * FROM area_table WHERE area_id = '$aId'");
		$area_name_show = mysqli_fetch_assoc($area_name);
	}
	if ($account_type == 'worker') {
		$phone = $_SESSION['phone'];
		$worker_check = $mysqli->query("SELECT * FROM worker_table WHERE phone_number=$phone");
		$worker = $worker_check->fetch_assoc();
		$worker_id = $worker['worker_id'];
		$_SESSION['worker_category_id'] = $worker_id;
		$worker_category = $worker['category_id'];
	}

	?>


	<!--Facebook chat plugin-->


	<?php

	include "layouts/facebookContact.php"

	?>


	<!--facebook chat plugin ends-->

	<?php

	include "layouts/nav.php"

	?>

	<div class="container browse-job-page">
		<div class="row">
			<div class="col-md-8">
				<a href="browsejob.php" class="heading">
					<h3>Browse&nbsp;Your&nbsp;<span>Job</span></h3>
				</a>
				<hr>

				<!-- Search start -->
				<form class="search-box" action="browsejob.php" method="GET">
					<div class="input-group">
						<input type="text" class="form-control" <?php if (isset($_GET['searchQuery'])) { ?> placeholder="<?= $key; ?>" <?php } ?> placeholder="Search" name="searchQuery" id="searchQuery">
						<div class="input-group-btn">
							<button class="btn btn-danger" type="submit">
								<i class="fa fa-search"></i>
							</button>
						</div>
					</div>
				</form>
				<!-- Search End -->
				<div class="row container">
					<div class="col-md-2">
						<h4 class="h4">Sort By</h4>
					</div>
					<div class="col-md-8">
						<div class="dropdown">
							<button class="btn btn-active dropdown-toggle" type="button" data-toggle="dropdown"><i class="fas fa-map-marker-alt"></i><?php if (isset($_GET['aId'])) {
																																							echo $area_name_show['area_name'];
																																						} else { ?> Location <?php } ?>
								<span class="caret"></span></button>
							<ul class="dropdown-menu">
								<?php
								$link = $_SERVER['REQUEST_URI'];

								if (parse_url($link, PHP_URL_QUERY)) {
									$parts = parse_url($link);
									parse_str($parts['query'], $qq);

									if (!empty($qq['cId'])) {
										$cId = $qq['cId'];

										while ($row = mysqli_fetch_array($area)) {
											?>
											<li><a href="browsejob.php?cId=<?= $cId; ?>&aId=<?= $row['area_id'] ?>"><?= $row['area_name']; ?></a></li>
										<?php
												}
											} else {
												while ($row = mysqli_fetch_array($area)) {
													?>
											<li><a href="browsejob.php?aId=<?= $row['area_id'] ?>"><?= $row['area_name']; ?></a></li>
										<?php
												}
											}
										} else {
											while ($row = mysqli_fetch_array($area)) { ?>
										<li><a href="browsejob.php?aId=<?= $row['area_id'] ?>"><?= $row['area_name']; ?></a></li>
								<?php
									}
								}
								?>

							</ul>
						</div>

						<div class="dropdown">
							<button class="btn btn-active dropdown-toggle" type="button" data-toggle="dropdown"><i class="fas fa-align-justify"></i> <?php if (isset($_GET['cId'])) {
																																							if (!empty($category_name_show['category_name'])) {
																																								echo $category_name_show['category_name'];
																																							} else {
																																								echo "Other";
																																							}
																																						} else { ?> Category <?php } ?>
								<span class="caret"></span></button>
							<ul class="dropdown-menu">

								<?php
								$link = $_SERVER['REQUEST_URI'];

								if (parse_url($link, PHP_URL_QUERY)) {

									$parts = parse_url($link);
									parse_str($parts['query'], $qq);

									if (!empty($qq['aId'])) {
										$aId = $qq['aId'];

										while ($row = mysqli_fetch_array($categories)) {
											?>
											<li><a href="browsejob.php?cId=<?= $row['category_id'] ?>&aId=<?= $aId ?>"><?= $row['category_name']; ?></a></li>
										<?php
												}
												?>
										<li><a href="browsejob.php?cId=''">Other</a></li>
										<?php
											} else {
												while ($row = mysqli_fetch_array($categories)) {
													?>
											<li><a href="browsejob.php?cId=<?= $row['category_id'] ?>"><?= $row['category_name']; ?></a></li>
										<?php
												}
												?>
										<li><a href="browsejob.php?cId=''">Other</a></li>
									<?php
										}
									} else {
										while ($row = mysqli_fetch_array($categories)) { ?>
										<li><a href="browsejob.php?cId=<?= $row['category_id'] ?>"><?= $row['category_name']; ?></a></li>
									<?php

										}
										?>
									<li><a href="browsejob.php?cId=''">Other</a></li>
								<?php
								}
								?>


							</ul>
						</div>
					</div>
				</div>
				<hr>
				<?php
				$cc = 0;
				while ($status_row = $job_status->fetch_assoc()) {
					$job_id = $status_row['job_id'];
					$job_id_check = $mysqli->query("SELECT * FROM job_table WHERE job_id = '$job_id' ORDER BY post_time DESC");

					while ($row = mysqli_fetch_array($job_id_check)) {
						$job_id = $row['job_id'];
						$job_title = $row['job_title'];
						$job_area = $row['job_area'];
						$job_category = $row['category_id'];
						$area_id_check = $mysqli->query("SELECT area_name from area_table WHERE area_id = '$job_area'");
						$area_name = mysqli_fetch_array($area_id_check)['area_name'];
						$post_time = $row['post_time'];
						$arr = check_job_stable($post_time);
						if ($account_type == 'worker') {
							$proposal_check = $mysqli->query("SELECT *from proposal_table where worker_id=$worker_id and job_id=$job_id");
							$proposal_arr = check_proposal_status($proposal_check);
						}
						if ($arr[0] < 0) {
							$mysqli->query("UPDATE job_status SET is_canceled='1' WHERE job_id=' $job_id'");
						}

						if ($arr[0] >= 0) {
							$cc++;

							?>
							<div class="jobs row line-content">

								<?php
											//Alert for Worker, If Category not matched.
											if ($account_type == 'worker') {
												if ($worker_category != $job_category) {
													if (empty($job_category)) { ?>
											<a target="_blank" href="jobDetails.php?jId=<?= $job_id ?>&jobStatus">
											<?php
																} else { ?>
												<a target="_blank" href="jobDetails.php?jId=<?= $job_id ?>&cat_alert&jobStatus">
												<?php
																	}	?>

												<div class="col-md-9">
													<h5><?= $job_title ?> &nbsp;&nbsp;&nbsp;&nbsp;
														<?php
																			if (empty($job_category)) {
																				?>
															<label class="label label-info" title="Other Category">other</label>

														<?php
																			} else {
																				?>
															<label class="label label-warning" title="Category not match">alert</label>

														<?php
																			}
																		} else {
																			?>
														<a target="_blank" href="jobDetails.php?jId=<?= $job_id ?>&jobStatus">
															<div class="col-md-9">
																<h5><?= $job_title ?> &nbsp;&nbsp;&nbsp;&nbsp;
																<?php
																				}
																			} else {
																				?>
																<a target="_blank" href="jobDetails.php?jId=<?= $job_id; ?>&jobStatus">
																	<div class="col-md-9">
																		<h5><?= $job_title ?> &nbsp;&nbsp;&nbsp;&nbsp;
																		<?php
																					}
																					?>
																		</h5>

																		<!-- <br> -->
																		<p class="browseJobDetailsInfo"><i class="far fa-clock"></i> Posted <?= $arr[1] ?></p>
																		<p class="browseJobDetailsInfo"><i class="fas fa-map-marker-alt"></i> <?= $area_name ?></p>
																	</div>
																	<div class="col-md-3">
																		<?php
																					if ($account_type == 'worker') {
																						if ($proposal_arr[0] == 1) { ?>
																				<button class="btn btn-danger">View Proposal</button></div>
																</a>
															</div>
														<?php
																		} else { ?>
															<button class="btn btn-danger">Send Proposal</button>
												</div>
												</a>
							</div>
						<?php
										}
									} else { ?>
			</div></a>
		</div>
<?php
			}
		}
	}
}


if ($cc > 0) {
	?>
<!-- Pagination Number Start -->
<center>
	<?php include "layouts/pagination.php" ?>
</center>
<!-- Pagination Number End -->
<?php } else { ?>
	<img src='https://img.icons8.com/color/48/000000/sad.png'>
	<!-- <i class="fas fa-sad-tear" style="font-size:55px;"></i> -->
	<h3 class='h3'>There are no Jobs.</h3>
<?php
} ?>
	</div>

	<div class="col-md-3 terms-conditions-section">
		<h5>Tips & Tricks</h5>
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

	include "layouts/footer.php"

	?>
	<script type="text/javascript" src="js/pagination.js"> </script>
</body>

</html>