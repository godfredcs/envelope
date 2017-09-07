<?php 
	session_start();

	include 'includes/db_connect.php';	
	include 'includes/security.php';

	if (isset($_POST['submit'])) {
		$first_name       = ucfirst(trim($_POST['first_name']));
		$last_name        = ucfirst(trim($_POST['last_name']));
		$middle_name      = ucfirst(trim($_POST['middle_name']));
		$gender 		  = ucfirst(trim($_POST['gender']));
		$email            = trim($_POST['email']);
		$index_number     = trim($_POST['index_number']);
		$password         = trim($_POST['password']);
		$confirm_password = trim($_POST['confirm_password']);

		if (!empty($first_name) && !empty($last_name) && !empty($index_number) && !empty($email) && !empty($password) && !empty($confirm_password)) {

			if (!isTaken('students', 'email', $email) && !isTaken('students', 'index_number', $index_number)) {	

				if ($password === $confirm_password) {

					$password = md5($password);
					
					if (!empty($_POST['middle_name'])) {
						$full_name = $last_name.' '.$first_name.' '.$middle_name;
					} else {
						$full_name = $last_name.' '.$first_name;
					}

					$sql = "INSERT INTO students (first_name, last_name, middle_name, full_name, email, index_number, password, gender, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())";
					
					$query = $db->prepare($sql);

					$query->execute(array($first_name, $last_name, $middle_name, $full_name, $email, $index_number, $password, $gender));

					$_SESSION['success_message'] = 'You have successfully signed up.';

					$_SESSION['username'] = $first_name;

					$_SESSION['index_number'] = $index_number;

					header('Location: main.php');
					exit();

				} else {
					$password_unmatch = 'Sorry, passwords do not match.';
				}

			} else {
				$unique_message = 'Email or Index number is already taken.';
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
					<li><a href="login.php";>Log In</a></li>
				</ul>
			</div>
		</div>
	</nav>

	<div class="container">
		<div class="row signup">		
			<div class="col-lg-4 col-md-4 col-sm-8 col-xs-10 col-lg-offset-4 col-md-offset-4 col-sm-offset-2 col-xs-offset-1 login-body animated slideInRight">
				<h2 class="text-center">Sign Up</h2>
				<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" id="signup">
					<?php  
						if (isset($password_unmatch)) {
							echo '<div class="alert alert-danger">Sorry, passwords do not match.</div>';
						}

						if (isset($unique_message)) {
							echo '<div class="alert alert-danger">Email or index number is already taken.</div>';
						}
					?>

					<div class="form-group">
						<input type="alpha" name="first_name" id="first_name" placeholder="First Name" class="form-control name-text" onkeyup="this.value = this.value.replace(/[^a-zA-Z]/g,'');" autofocus required>
					</div>
					
					<div class="form-group">
						<input type="text" name="last_name" id="last_name" placeholder="Last Name" class="form-control name-text" onkeyup="this.value = this.value.replace(/[^a-zA-Z]/g,'');" required>
					</div>			
				
					<div class="form-group">
						<input type="text" name="middle_name" id="middle_name" placeholder="Middle Name *" class="form-control name-text" onkeyup="this.value = this.value.replace(/[^a-zA-Z]/g,'');">
					</div>

					<div class="form-group">
						<input type="radio" name="gender" value="Male" required> Male
						<input type="radio" name="gender" value="Female" class="radio-margin" required> Female
					</div>
					
					<div class="form-group">
						<input type="text" name="email" id="email" placeholder="Email" class="form-control" required>
					</div>
					
					<div class="form-group">
						<input type="number" name="index_number" id="index_number" placeholder="Index Number" class="form-control" required>
					</div>

					<div class="form-group">
						<input type="password" name="password" id="password" placeholder="Password" class="form-control" required>
					</div>

					<div class="form-group">
						<input type="password" name="confirm_password" id="confirm_password" placeholder="Confirm Password" class="form-control" required>
					</div>
					
					<div class="form-group">
						<input type="submit" name="submit" id="register" value="Create Account" class="btn btn-block btn-success">
					</div>
				</form>
			</div>			
		</div>
	</div>
	
	<?php include 'includes/scripts.php'; ?>
	
</body>
</html>


