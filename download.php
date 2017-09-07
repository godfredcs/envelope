<?php
	@include 'includes/db_connect.php';

	if (isset($_GET['assignment_id']) && !empty($_GET['assignment_id'])) {
		$assignment_id = htmlspecialchars(trim($_GET['assignment_id']));

		$query = $db->query("SELECT title, lecturer_id FROM assignments WHERE id = $assignment_id");
		$row = $query->fetch(PDO::FETCH_OBJ);
		$assignment_title = $row->title;
		$lecturer_id = $row->lecturer_id;

		$assignments_path = $_SERVER['DOCUMENT_ROOT'] . 'assets/files/solutions/lecturer ' . $lecturer_id . '/' . $assignment_title;

		if (is_dir($assignments_path)) {
			$archive_path = $assignments_path . '/' . str_replace(' ', '_', $assignment_title) . '.zip';

			$zip = new ZipArchive();

			if ($zip->open($archive_path, ZipArchive::CREATE | ZipArchive::OVERWRITE) === true) {
				$folder = opendir($assignments_path);

				while ($file = readdir($folder)) {
					$file_path = $assignments_path . '/' . $file;

					if (is_file($file_path)) {
						$zip->addFile($file_path, $file);
					}
				}
			}

			$zip->close();
		}

		$file_path = $archive_path;
	    $file_name = str_replace(' ', '_', $assignment_title) . '.zip';
	    $file_size = filesize($file_path);
	    $file_type = filetype($file_path);

	    // write the HTML headers
	    header('Content-Type: ' . $file_type);
	    header('Content-Description: File Transfer');
	    header('Content-Type: application/octet-stream');
	    header('Content-Disposition: attachment; filename=' . $file_name); 
	    header('Content-Transfer-Encoding: binary');
	    header('Connection: Keep-Alive');
	    header('Expires: 0');
	    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
	    header('Pragma: public');
	    header('Content-Length: ' . $file_size);    
	    echo readfile($file_path);

	    unlink($file_path);
	}
?>