<?php 
	session_start();

?>


<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale = 1.0">
	<title>Envelope - Welcome</title>
	<?php include 'includes/stylesheets.php'; ?>
</head>
<body>
	<div id="homepage">
		<nav class="navbar navbar-default">
			<div class="container">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a href="index.php" class="navbar-brand"><img src="assets/images/envelope-w.png" alt="" class="img-responsive"></a>
				</div>
				<div id="myNavbar" class="collapse navbar-collapse">
					<ul class="nav navbar-nav navbar-right">
						<li><a href="about.php">About</a></li>
					</ul>
				</div>
			</div>	
		</nav>
		
		<div class="middle-color animated bounceInDown">
			<div class="container">
				<div class="row">
					<div class="col-lg-3 col-md-4 col-sm-4 col-xs-4">
						<img src="./assets/images/owl.png" alt="owl" class="img-responsive">
					</div>
					<div class="col-lg-9 col-md-8 col-sm-8 col-xs-8">
						<h3 class="text-center">Welcome to <strong>Envelope</strong></h3>
						<p>This is the one-stop application to upload and download assignments by students and lecturers altogether.
						Create account as lecturer to upload assignments and download student solutions. Create accont as student and have the freedom of downloading and submitting your work on time.</p>
					</div>
				</div>
			</div>
		</div>

		<div class="container">
			<div class="type-buttons">
				<center>
					<a href="lecturers_login.php" class="btn btn-lg btn-success animated slideInLeft">Lecturer</a>
					<a href="login.php" class="btn btn-lg btn-danger animated slideInRight">Student</a>
				</center>
			</div>
		</div>
		
		<?php include 'includes/scripts.php'; ?>
	
	</div>
</body>
</html>