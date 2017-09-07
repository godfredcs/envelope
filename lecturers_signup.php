<?php 
	session_start();

	include 'includes/db_connect.php';	
	include 'includes/security.php';

	if (isset($_POST['submit'])) {
		$first_name       = trim($_POST['first_name']);
		$last_name        = trim($_POST['last_name']);
		$middle_name      = trim($_POST['middle_name']);
		$title 			  = trim($_POST['title']);
		$gender 		  = trim($_POST['gender']);
		$course 		  = trim($_POST['course']);
		$email            = trim($_POST['email']);
		$password         = trim($_POST['password']);
		$confirm_password = trim($_POST['confirm_password']);
		
		if (!empty($first_name) && !empty($last_name) && !empty($course) && !empty($email) && !empty($password) && !empty($confirm_password)) {

			if ($password === $confirm_password) {

				$password = md5($password);

				if (!empty($middle_name)) {
					$full_name = $last_name.' '.$first_name.' '.$middle_name;
				} else {
					$full_name = $last_name.' '.$first_name;
				}

				if (!isTaken('courses', 'name', $course) && !isTaken('lecturers', 'email', $email)) {
						
					$sql = "INSERT INTO courses (name, created_at) VALUES (?, NOW())";
					$query = $db->prepare($sql);
					$query->execute(array($course));

					$course_id = $db->lastInsertId();

					$sql2 = "INSERT INTO lecturers (first_name, last_name, middle_name, full_name, title, email, password, course_id, gender, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())";
					$query2 = $db->prepare($sql2);
					$query2->execute(array($first_name, $last_name, $middle_name, $full_name, $title, $email, $password, $course_id, $gender));

					$structure = './assets/files/solutions/lecturer '.$db->lastInsertId();

					if (!mkdir($structure, 0777, true)) {
						die('Failed to create directory.');
					}

					$_SESSION['username'] = $title.' '.$last_name;

					$_SESSION['success_message'] = 'You have successfully signed up';

					$_SESSION['email'] = $email;

					header('Location: lecturers_main.php');
					exit();

				} else {
					$unique_message = 'Email or course already exists.';
				}
			} else {
				$password_unmatch = 'Passwords do not match';
			}

		}

	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Envelope - Sign Up</title>
	<?php include 'includes/stylesheets.php'; ?>
</head>
<body>
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
			<div class="collapse navbar-collapse" id="myNavbar">
				<ul class="nav navbar-nav navbar-right">
					<li><a href="lecturers_login.php";>Log In</a></li>
				</ul>
			</div>
		</div>
	</nav>

	<div class="container">
		<div class="row signup">
			<div class="col-lg-4 col-md-4 col-sm-8 col-xs-10 col-lg-offset-4 col-md-offset-4 col-sm-offset-2 col-xs-offset-1 login-body animated slideInRight">
				<h2 class="text-center">Sign Up</h2>
				<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
					<?php  
						if (isset($password_unmatch)) {
							echo '<div class="alert alert-danger">Sorry, passwords do not match.</div>';
						}

						if (isset($unique_message)) {
							echo '<div class="alert alert-danger">Email or course already exists.</div>';
						}
					?>

					<div class="form-group">
						<input type="text" name="first_name" id="first_name" placeholder="First Name" class="form-control" onkeyup="this.value = this.value.replace(/[^a-zA-Z]/g,'');" autofocus required>
					</div>
					
					<div class="form-group">
						<input type="text" name="last_name" id="last_name" placeholder="Last Name" class="form-control" onkeyup="this.value = this.value.replace(/[^a-zA-Z]/g,'');" required>
					</div>			
				
					<div class="form-group">
						<input type="text" name="middle_name" id="middle_name" placeholder="Middle Name *" class="form-control" onkeyup="this.value = this.value.replace(/[^a-zA-Z]/g,'');">
					</div>

					<div class="form-group">
						<select name="title" id="title" class="form-control">
							<option value="Mr.">Mr.</option>
							<option value="Mrs.">Mrs.</option>
							<option value="Miss.">Miss.</option>
							<option value="Dr.">Dr.</option>
							<option value="Prof.">Prof.</option>
						</select>
					</div>

					<div class="form-group">
						<input type="radio" name="gender" value="Male"> Male
						<input type="radio" name="gender" value="Female" class="radio-margin"> Female
					</div>

					<div class="form-group">
						<input type="text" name="course" id="course" placeholder="Course" class="form-control" required>
					</div>

					<div class="form-group">
						<input type="email" name="email" id="email" placeholder="Email" class="form-control" required>
					</div>

					<div class="form-group">
						<input type="password" name="password" id="password" placeholder="Password" class="form-control" required>
					</div>

					<div class="form-group">
						<input type="password" name="confirm_password" id="confirm_password" placeholder="Confirm Password" class="form-control" required>
					</div>

					<div class="form-group">
						<input type="submit" name="submit" value="Create Account" class="btn btn-block btn-success">
					</div>
				</form>
			</div>			
		</div>
	</div>

	<?php @include 'includes/scripts.php'; ?>
	
</body>
</html>


