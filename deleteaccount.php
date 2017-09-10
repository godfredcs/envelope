<?php 
	session_start();

	if (!isset($_SESSION['username'])) {
		header('Location: index.php');
		exit();
	}
	
	$index_number = $_SESSION['index_number'];

	session_destroy();
	
	include 'includes/db_connect.php';

	$query = $db->query("DELETE FROM students WHERE index_number = $index_number");

	header('Location: index.php');
	exit();
?>