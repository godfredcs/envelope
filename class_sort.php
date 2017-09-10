<?php  
	session_start();

	if (!isset($_SESSION['username'])) {
		header('Location: index.php');
		exit();
	}

	$course = $_POST['course'];

	@include 'includes/db_connect.php';

	if(!empty($_POST['course'])) {
		$query = $db->query(" SELECT id FROM lecturers WHERE course_id = '$course' ");
		$result = $query->fetch();
		$lecturer_id = $result['id'];

		$assignments = [];

		$query = $db->query("
			SELECT id, title
			FROM assignments
			WHERE lecturer_id = $lecturer_id
			ORDER BY assignments.title ASC
		");

		while($assignment = $query->fetch(PDO::FETCH_OBJ)) {
			$assignments[] = ['id' => $assignment->id, 'title' => ucwords(strtolower($assignment->title))];
		};

		exit(json_encode(['assignments' => $assignments]));
	}
?>