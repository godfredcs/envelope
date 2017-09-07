<?php 
	session_start();

	date_default_timezone_set('Africa/Accra');

	if (!isset($_SESSION['username'])) {
		header('Location: index.php');
		exit();
	}

	include 'includes/db_connect.php';
	include 'includes/security.php';
	
	$index_number = $_SESSION['index_number'];
	$get_id = $db->query("SELECT id FROM students WHERE index_number = $index_number");
	$g_id = $get_id->fetch(PDO::FETCH_OBJ);

	if (isset($_POST['submit'])) {

		$title = $_POST['assignment'];
		
		$get_assignment = $db->query(" SELECT * FROM assignments WHERE id = $title ");
		$get_ass = $get_assignment->fetch(PDO::FETCH_OBJ);

		if (isset($_FILES['file']) && !empty($_FILES['file'])) {
			$title 		= $get_ass->title;
			$filename 	= $_FILES['file']['name'];
			$filesize 	= $_FILES['file']['size'];
			$tmp_loc 	= $_FILES['file']['tmp_name'];
			$location 	= $_SERVER['DOCUMENT_ROOT'].'assets/files/solutions/lecturer '.$get_ass->lecturer_id.'/'.$title.'/';
			
			$submit_exists = $db->query("SELECT * FROM solutions WHERE assignment_id = $get_ass->id AND student_id = $g_id->id AND lecturer_id = $get_ass->lecturer_id")->rowCount();

			if (!( (strtotime(date('l jS F Y h:i:s A'))) > strtotime($get_ass->submission_date) )) {
				if (!$submit_exists) {

					move_uploaded_file($tmp_loc, "$location$filename");

					$upl = $db->query("INSERT INTO solutions(assignment_id, student_id, lecturer_id, solution_path, size, created_at) VALUES ($get_ass->id, $g_id->id, $get_ass->lecturer_id, '$filename', $filesize, NOW())");

					$_SESSION['submit_success'] = 'You have successfully submitted your solution.';
				} else {
					$_SESSION['submit_exists'] = 'Sorry, you have already submitted your solution to this assignment.';
				}
			} else {	
				 $_SESSION['deadline_reached'] = 'Sorry, your assignment cannot be submitted because the deadline has passed.';
			}
		} else {
			$_SESSION['submit_failure'] = 'Sorry, error while submitting your solution. Please try again.';
		}
	}

	$downloads = $db->query("SELECT lecturers.*, courses.*, assignments.* FROM lecturers, courses, assignments WHERE lecturers.id = assignments.lecturer_id AND assignments.lecturer_id = courses.id ORDER BY assignments.created_at DESC;");

	$query = $db->query("SELECT * FROM courses;"); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale = 1.0">
	<title>Envelope - Main</title>
	<?php @include 'includes/stylesheets.php'; ?>
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
				<a href="main.php" class="navbar-brand"><img src="assets/images/envelope-w.png" alt="" class="img-responsive"></a>
			</div>
			<div id="myNavbar" class="collapse navbar-collapse">
				<ul class="nav navbar-nav">
					<li class="current"><a href="main.php">Home <span class="fa fa-home"></span></a></li>
					<li><a href="dashboard.php">Dashboard <span class="fa fa-dashboard"></span></a></li>
					<li><a href="#upload" data-toggle="modal">Upload <span class="fa fa-upload"></span></a></li>
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
			<?php
				if (isset($_SESSION['success_message'])) {
					echo '<div id="success_message" class="alert alert-success">'. $_SESSION['success_message'] .'</div>';
					unset($_SESSION['success_message']);
				} 

				if (isset($_SESSION['submit_success'])) {
					echo '<div id="success_message" class="alert alert-success">'. $_SESSION['submit_success'] .'</div>';
					unset($_SESSION['submit_success']);
				} else if (isset($_SESSION['submit_failure'])) {
					echo '<div id="success_message" class="alert alert-danger">'. $_SESSION['submit_failure'] .'</div>';
					unset($_SESSION['submit_failure']);
				}

				if (isset($_SESSION['submit_exists'])) {
					echo '<div id="success_message" class="alert alert-warning">'. $_SESSION['submit_exists'] .'</div>';
					unset($_SESSION['submit_exists']);
				}

				if (isset($_SESSION['deadline_reached'])) {
					echo '<div id="success_message" class="alert alert-danger">'. $_SESSION['deadline_reached'] .'</div>';
					unset($_SESSION['deadline_reached']);
				}
			?>
			<div class="section">
				<div><h3>Welcome <?php echo '<strong>'.$_SESSION['username'].'</strong>'; ?></h3></div>
				<div>
					Download your assignments and submit them when you finish answering them right here.
				</div>
			</div>
			
			<div class="section animated bounceInUp table-responsive">				
				<h3 class="page-header">Download Assignments</h3>
				<table class="table table-hover">					
					<thead>
						<tr>
							<th>No.</th>
							<th>Title</th>
							<th>Course</th>
							<th>Upload Date</th>
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
								<td><?php echo $counter.'.'; ?></td>
								<td><?php echo $dl->title; ?></td>
								<td><?php echo $dl->name; ?></td>
								<td><?php echo date_format(date_create($dl->created_at), 'l jS F Y h:i:s A'); ?></td>
								<td><?php echo date_format(date_create($dl->submission_date), 'l jS F Y h:i:s A'); ?></td>
								<td><a href="<?php echo './assets/files/assignments/'.$dl->assignment_path; ?>" class="btn btn-primary btn-sm"><span class="fa fa-download"></span></span></a></td>
							</tr>
						<?php 
							$counter++; 
							}
						?>
					</tbody>				
				</table>		
			</div>
		</div>
	</section>

	<div id="upload" class="modal fade" role="dialog">
	  	<div class="modal-dialog">
	    	<!-- Modal content-->
		    <div class="modal-content">
		      	<div class="modal-header">
			        <button type="button" class="close" data-dismiss="modal">&times;</button>
			        <h4 class="modal-title"><strong>Upload Solution</strong></h4>
		      	</div>
		      	<div class="modal-body">

					<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data" role="form">

						<div class="form-group">
							<label for="course">Select Course:</label>
							<select name="course" id="course" class="form-control" required>
								<option value="">-- Select the course --</option>
								<?php 
									while ($row = $query->fetch(PDO::FETCH_OBJ)) {
								?>
									<option value="<?= $row->id; ?>"><?= $row->name; ?></option>
								<?php 
									} 
								?>
							</select>
						</div>

						<div class="form-group">
							<label for="assignment">Select Assignment:</label>
							<select name="assignment" id="assignment" class="form-control" required>
								
							</select>
						</div>
						
						<div class="form-group">
							<label for="file">Choose File:</label>
							<input type="file" name="file" id="file" class="form-control" required>
						</div>

						<div class="form-group">
							<input type="submit" name="submit" value="Submit" class="btn btn-block btn-success">
						</div>

					</form>
		      	</div>
		    </div>
	  	</div>
	</div>

	<?php @include 'includes/footer.php'; ?>
	<?php @include 'includes/scripts.php'; ?>

<script>
	$('#course').change(function() {

		var course = $(this).val();

		$.ajax({
			type: "POST",
			url: "class_sort.php",
			data: {
				course
			},
			success: function(result) {
				var response = JSON.parse(result);

				$dataHTML = '<option value="">-- Select the Assignment --</option>';

				$.each(response.assignments, function (index, assignment) {
					$dataHTML += '<option value="' + assignment.id + '">' + assignment.title + '</option>';
				});

				$('#assignment').html($dataHTML);
			},
			error: function() {
				alert('An error occured try again')
			}
		});
	});
</script>
</body>
</html>