<?php  
session_start()

if (!isset($_SESSION['username'])) {
	header('Location: index.php');
	exit();
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Envelope - Assignments</title>
	<?php include 'includes/stylesheets.php'; ?>
</head>
<body>
	<?php echo "Who and how are you?"; ?>
</body>
</html>