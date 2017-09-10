<?php  
	session_start();

	if (!isset($_SESSION['username'])) {
		header('Location: index.php');
		exit();
	}

	$email = $_SESSION['email'];

	session_destroy();

	include 'includes/db_connect.php';

	$query = $db->query("SELECT lecturers.full_name, courses.id FROM lecturers, courses WHERE lecturers.course_id = courses.id AND lecturers.email = '$email'");

	$sql = $db->query("DELETE FROM lecturers WHERE email = '$email'");
	
	if ($query->rowCount() === 1) {
		while ($row = $query->fetch(PDO::FETCH_OBJ)) {
			$sql1 = $db->query("DELETE FROM courses WHERE id = $row->id");
		}
	}

	header('Location: index.php');
	exit();
?>