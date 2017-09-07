<?php  
	session_start();

	// We need the email in order to get the id
	$email = $_SESSION['email'];

	include 'includes/db_connect.php';
	include 'includes/security.php';

	// Let's get the id of the current lecturer
	$query = $db->query("SELECT id FROM lecturers WHERE email = '$email'");
	$row = $query->fetch(PDO::FETCH_OBJ);
	$lecturer_id = $row->id;

	// These codes handle the upload of an assignment
	if (isset($_POST['submit'])) {
		if (isset($_FILES['file']) && !empty($_FILES['file'])) {

			$title 				= trim($_POST['title']);
			$submission_date 	= trim($_POST['submission_date']);
			$filename 			= $_FILES['file']['name'];
			$filesize 			= $_FILES['file']['size'];
			$tmp_loc 			= $_FILES['file']['tmp_name'];
			$path 				= $_SERVER['DOCUMENT_ROOT'].'/assets/files/assignments/';

			if (!isTaken('assignments', 'title', $title)) {
			
				move_uploaded_file($tmp_loc, "$path$filename");
				
				$sql = $db->query("INSERT INTO assignments(title, assignment_path, size, lecturer_id, submission_date, created_at) VALUES ('$title', '$filename', '$filesize', $lecturer_id, '$submission_date', NOW());");

				// This variable holds the path of a unique solution directory for the assignment
				$structure = './assets/files/solutions/lecturer '.$lecturer_id.'/'.$title;

				// Let's create a solution directory for the assignment uploaded
				if (!mkdir($structure, 0777, true)) {
					die('Directory could not be created.');
				}

				$_SESSION['upload_success'] = "You have successfully uploaded assignment.";
			} else {
				$_SESSION['not_uploaded'] = "Sorry, assignment with the same title already exists. Please choose a different title.";
			}
		} else {
			$_SESSION['upload_failure'] = "Error while uploading assignment.";
		}
	}

	$downloads = $db->query(" SELECT * FROM assignments WHERE lecturer_id = $lecturer_id ");
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0" >
	<title>Envelope - Main</title>
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
					<li class="current"><a href="lecturers_main.php">Home <span class="fa fa-home"></span></a></li>
					<li><a href="lecturers_dashboard.php">Dashboard <span class="fa fa-dashboard"></span></a></li>
					<li><a href="#upload_assignment" data-toggle="modal">Upload <span class="fa fa-upload"></span></a></li>
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
			<?php
				if (isset($_SESSION['success_message'])) {
					echo '<div id="success_message" class="alert alert-success">'.$_SESSION['success_message'].'</div>';
					unset($_SESSION['success_message']);
				} 

				if (isset($_SESSION['upload_success'])) {
					echo '<div id="success_message" class="alert alert-success">'.$_SESSION['upload_success'].'</div>';
					unset($_SESSION['upload_success']);
				} else if (isset($_SESSION['upload_failure'])) {
					echo '<div id="success_message" class="alert alert-danger">'.$_SESSION['upload_failure'].'</div>';
					unset($_SESSION['upload_failure']);
				}

				if (isset($_SESSION['not_uploaded'])) {
					echo '<div id="success_message" class="alert alert-danger">'.$_SESSION['not_uploaded'].'</div>';
					unset($_SESSION['not_uploaded']);
				}
			?>

			<div class="section">
				<div><h3>Welcome <?php echo '<strong>'.$_SESSION['username'].'</strong>'; ?></h3></div>
				<div>
					Upload assignments and download solutions to assignments right here.
				</div>
			</div>

			<div class="section animated bounceInUp table-responsive">
				
				<h3 class="page-header">Download Students' Solutions</h3>
				<table class="table table-hover">
					
					<thead>
						<tr>
							<th>No.</th>
							<th>Title</th>
							<th>Date Created</th>
							<th>Submission Date</th>
							<th>Download</th>
						</tr>
					</thead>
					<tbody>	
						<?php 
							$counter = 1;
							while ($dl = $downloads->fetch(PDO::FETCH_OBJ)) {
						?>	
							<tr>
								<td><?= $counter.'.'; ?></td>
								<td><?= $dl->title; ?></td>
								<td><?= $dl->created_at; ?></td>
								<td><?= $dl->submission_date; ?></td>
								<td><a href="<?= '/download.php?assignment_id='.$dl->id; ?>" class="btn btn-primary btn-sm"><span class="fa fa-download"></span></a></td>
							</tr>
						<?php 
							$counter++; 
							}
						?>
					</tbody>
				
				</table>		
			</div>

			<div id="upload_assignment" class="modal fade" role="dialog">
			  	<div class="modal-dialog">
			    	<!-- Modal content-->
				    <div class="modal-content">
				      	<div class="modal-header">
					        <button type="button" class="close" data-dismiss="modal">&times;</button>
					        <h4 class="modal-title"><strong>Upload Assignment</strong></h4>
				      	</div>
				      	<div class="modal-body">
							<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data" role="form">
								<div class="form-group">
									<label for="title">Title:</label>
									<input type="text" name="title" id="title" class="form-control" placeholder="Title" autofocus required>
								</div>
								<div class="form-group">
									<label for="file">Choose File:</label>
									<input type="file" name="file" id="file" class="form-control" required>
								</div>
								<div class="form-group">
									<label for="submission_date">Submission Date:</label>
									<input type="datetime-local" name="submission_date" id="submission_date" class="form-control" required>
								</div>
								<div class="form-group">
									<input type="submit" name="submit" value="Upload Assignment" class="btn btn-block btn-success">
								</div>
							</form>
				      	</div>
				    </div>
			  	</div>
			</div>
		</div>
	</section>
	
	<?php @include 'includes/lecturers_footer.php'; ?>
	<?php @include 'includes/scripts.php'; ?>
	
</body>
</html>