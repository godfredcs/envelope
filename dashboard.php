<?php  
	session_start();

	if (!isset($_SESSION['username'])) {
		header('Location: index.php');
		exit();
	}

	include 'includes/db_connect.php';

	$index_number = $_SESSION['index_number'];
	$get_id = $db->query("SELECT id FROM students WHERE index_number = $index_number");
	$g_id = $get_id->fetch(PDO::FETCH_OBJ);

	$lec = $db->query("SELECT * FROM lecturers")->rowCount();
	$stn = $db->query("SELECT * FROM students")->rowCount();
	$ass = $db->query("SELECT * FROM assignments")->rowCount();
	$sol = $db->query("SELECT * FROM solutions WHERE student_id = $g_id->id")->rowCount();

	$query = $db->query("SELECT * FROM lecturers");
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" charset="utf-8">
	<title>Envelope - Dashboard</title>
	<?php include 'includes/stylesheets.php'; ?>
</head>
<body>
	<nav class="navbar navbar-default navbar-fixed-top">
		<div class="container">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a href="main.php" class="navbar-brand"><img src="assets/images/envelope-w.png" alt="" class="img-responsive"></a>
			</div>
			<div id="myNavbar" class="collapse navbar-collapse">
				<ul class="nav navbar-nav">
					<li><a href="main.php">Home <span class="fa fa-home"></span></a></li>
					<li class="current"><a href="dashboard.php">Dashboard <span class="fa fa-dashboard"></span></a></li>
				</ul>
				<ul class="nav navbar-nav navbar-right">
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo $_SESSION['username']; ?> <span class="fa fa-user"></span></a>
						<ul class="dropdown-menu">
							<li><a href="settings.php">Settings</a></li>
							<li><a href="logout.php">Log Out</a></li>
						</ul>
					</li>
				</ul>
			</div>
		</div>
	</nav>

	<section id="wrapper">
		<div class="container">
			<div class="section">
				<h3>Welcome to <strong>Dashboard</strong></h3>
				<p>This page contains an overview of everything that goes on in this application.</p>
			</div>
			<div class="row">
				<div class="col-lg-8 col-md-8 col-sm-8 animated slideInLeft">
					<div class="row">
						<div class="col-lg-12 col-md-12 col-sm-12">
							<div class="row">
								<div class="col-sm-6">
									<div class="section stats">
										<div class="text-center head bottom">Number Of Lecturers</div>
										<div class="text-center dash"><strong><?= $lec; ?></strong></div>
									</div>
								</div>
								<div class="col-sm-6">
									<div class="section stats">
										<div class="text-center head bottom">Number Of Students</div>
										<div class="text-center dash"><strong><?= $stn; ?></strong></div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-6 col-md-6">
							<div class="section stats">
								<div class="text-center head bottom">Assignments</div>
								<div class="text-center dash"><strong><?= $ass; ?></strong></div>
							</div>
						</div>
						<div class="col-sm-6 col-md-6">
							<div class="section stats">
								<div class="text-center head bottom">Your Solutions Uploaded</div>
								<div class="text-center dash"><strong><?= $sol; ?></strong></div>
							</div>
						</div>
					</div>
				</div>

				<div class="col-lg-4 col-md-4 col-sm-4 animated slideInRight">
					<div class="row">
						<div class="col-sm-12">
							<div class="section stats">
								<div class="bottom head">Lecturers Available</div>
								<ul>
									<?php
										while($row = $query->fetch(PDO::FETCH_OBJ)) {
									?>
										<li class="name-course">
											<div class="lecs">
												<?= $row->title.' '.$row->full_name.'<br/>'; ?>
												<?php 
													$sql = $db->query(" SELECT name FROM courses WHERE id = $row->course_id "); 
													while($course = $sql->fetch(PDO::FETCH_OBJ)) { 
												?>
														<div class="indent"><strong><?= $course->name;  ?></strong></div>
												<?php 
													} 
												?>
											</div>
										</li>
									<?php 
										} 
									?>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	
	<?php @include 'includes/footer.php'; ?>
	<?php @include 'includes/scripts.php'; ?>

</body>
</html>