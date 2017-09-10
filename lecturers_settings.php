<?php 
	session_start();

	if (!isset($_SESSION['username'])) {
		header('Location: index.php');
		exit();
	}

	include 'includes/db_connect.php';

	$email = $_SESSION['email'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Envelope - Settings</title>
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
				<a href="lecturers_main.php" class="navbar-brand"><img src="assets/images/envelope-w.png" alt="" class="img-responsive"></a>
			</div>
			<div id="myNavbar" class="collapse navbar-collapse">
				<ul class="nav navbar-nav">
					<li><a href="lecturers_main.php">Home <span class="fa fa-home"></span></a></li>
					<li><a href="lecturers_dashboard.php">Dashboard <span class="fa fa-dashboard"></span></a></li>
				</ul>
				<ul class="nav navbar-nav navbar-right">
					<li class="dropdown current">
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
			<div class="row">
				<div class="col-xs-12 col-sm-10 col-md-8 col-lg-8 section animated slideInLeft">
					<h4><strong>Settings</strong></h4>
					<?php 
						$query = $db->query("SELECT * FROM lecturers WHERE email = '$email'");
						if ($query->rowCount() === 1) {
							while ($row = $query->fetch(PDO::FETCH_OBJ)) {						
					?> 
						<table class="table table-condensed table-hover">
							
							<tr>
								<td><strong>Name</strong></td>
								<td>
									<div id="full_name">
										<?php echo $row->full_name; ?>	
									</div>
								</td>
							</tr>

							<tr>
								<td><strong>Title</strong></td>
								<td>
									<div>
										<?php echo $row->title; ?>
									</div>
								</td>
							</tr>

							<tr>
								<td><strong>Gender</strong></td>
								<td>
									<div>
										<?php echo $row->gender; ?>
									</div>
								</td>
							</tr>

							<tr>
								<td><strong>Course</strong></td>
								<td>
									<div>
										<?php 
											$sql = $db->query("SELECT lecturers.email, courses.name FROM lecturers, courses WHERE lecturers.course_id = courses.id AND lecturers.email = '$row->email'"); 
											if ($sql->rowCount() === 1) {
												while ($course = $sql->fetch(PDO::FETCH_OBJ)){
													echo $course->name;
												}
											}
										?>
									</div>
								</td>
							</tr>

							<tr>
								<td><strong>Email</strong></td>
								<td>
									<div>
										<?php echo $row->email; ?>
									</div>
								</td>
							</tr>

							<tr>
								<td><strong>Password</strong></td>
								<td>
									<div>
										********************
									</div>
								</td>
							</tr>

							<tr>
								<td><strong>Created at</strong></td>
								<td>
									<div>
										<?php echo $row->created_at; ?>
									</div>
								</td>
							</tr>

							<tr>
								<td><strong>Updated at</strong></td>
								<td>
									<div>
										<?php echo $row->updated_at; ?>
									</div>
								</td>
							</tr>

						</table>

						<a href="lecturers_changesettings.php" class="btn btn-info">Edit Details</a>

						<!-- Trigger the modal with a button -->
						<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteModal">Delete Account</button>

						

					<?php  
							}
						}
					?>
				</div>
			</div>
		</div>
	</section>

	<!-- Modal -->
	<div id="deleteModal" class="modal fade" role="dialog">
	  <div class="modal-dialog">

	    <!-- Modal content-->
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal">&times;</button>
	        <h4 class="modal-title"><strong>Delete Account</strong></h4>
	      </div>
	      <div class="modal-body">
	        <p>Do you really want to delete your account?</p>
	      </div>
	      <div class="modal-footer">
	      	<div class="row">
	      		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
	      			<a href="lecturers_deleteaccount.php" class="btn btn-danger btn-block">Yes</a>
	      		</div>
	      		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
	        		<button type="button" class="btn btn-info btn-block" data-dismiss="modal">No</button>
	      		</div>
	      	</div>
	      </div>
	    </div>

	  </div>
	</div>

	<?php @include 'includes/lecturers_footer.php'; ?>
	<?php @include 'includes/scripts.php'; ?>

</body>
</html>