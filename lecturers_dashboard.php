<?php  
	session_start();

	// We need the email in order to get the id
	$email = $_SESSION['email'];

	include 'includes/db_connect.php';
	include 'includes/security.php';

	// Let's get the id of the current lecturer
	$get_id 		= $db->query("SELECT id FROM lecturers WHERE email = '$email'");
	$row 			= $get_id->fetch(PDO::FETCH_OBJ);
	$lecturer_id 	= $row->id;

	$lec 	= $db->query("SELECT * FROM lecturers")->rowCount();
	$stn 	= $db->query("SELECT * FROM students")->rowCount();
	$ass 	= $db->query("SELECT * FROM assignments WHERE lecturer_id = $lecturer_id")->rowCount();
	$sol 	= $db->query("SELECT * FROM solutions WHERE lecturer_id = $lecturer_id")->rowCount();

	$solutions = $db->query("SELECT s.*, a.* FROM solutions s LEFT JOIN assignments a ON s.lecturer_id =  a.lecturer_id WHERE s.lecturer_id = $lecturer_id GROUP BY a.id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0" >
	<title>Envelope - Dashboard</title>
	<?php include 'includes/stylesheets.php'; ?>
</head>
<body>
	<nav class="navbar navbar-default navbar-fixed-top">
		<div class="container">
			<div class="navbar-header">
				<button data-target="#myNavbar" class="navbar-toggle" data-toggle="collapse" type="button">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a href="lecturers_main.php" class="navbar-brand"><img src="assets/images/envelope-w.png" alt="" class="img-responsive"></a>
			</div>
			<div id="myNavbar" class="collapse navbar-collapse">
				<ul class="nav navbar-nav">
					<li><a href="lecturers_main.php">Home <span class="fa fa-home"></span></a></li>
					<li class="current"><a href="lecturers_dashboard.php">Dashboard <span class="fa fa-dashboard"></span></a></li>
				</ul>
				<ul class="nav navbar-nav navbar-right">
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo $_SESSION['username']; ?> <span class="fa fa-user"></span></a>
						<ul class="dropdown-menu">
							<li><a href="lecturers_settings.php">Settings</a></li>
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
				<p>This section provide you with an overview of all activities on this application.</p>
			</div>

			<div class="row">
				<div class="col-sm-4 col-md-4 animated slideInLeft">
					<div class="section stats">
						<div class="text-center bottom">Number Of Students</div>
						<div class="text-center dash"><strong><?= $stn; ?></strong></div>
					</div>
				</div>

				<div class="col-sm-4 col-md-4 animated fadeIn">
					<div class="section stats">
						<div class="text-center bottom">Number Of Lecturers</div>
						<div class="text-center dash"><strong><?= $lec; ?></strong></div>
					</div>
				</div>

				<div class="col-sm-4 col-md-4 animated slideInRight">
					<div class="section stats">
						<div class="text-center bottom">Number Of Assignments</div>
						<div class="text-center dash"><strong><?= $ass; ?></strong></div>
					</div>
				</div>
			</div>
			
			<?php 
				if ($sol) {
					$sol_count = 2;
					while ($solu = $solutions->fetch(PDO::FETCH_OBJ)) {
			?>
				<div class="row">
					<div class="col-sm-8 col-md-8">
						<div class="section stats">
							<div class="text-center bottom"><?= $solu->title; ?></div>
							<div class="text-center dash">
								<?php 
									echo $sol_count;
								?>
							</div>
						</div>
					</div>
				</div>
			<?php
					$sol_count += 2;
					}
				}
			?>
		</div>
	</section>
	
	<?php @include 'includes/lecturers_footer.php'; ?>
	<?php @include 'includes/scripts.php'; ?>

</body>
</html>
