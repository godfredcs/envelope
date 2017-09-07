<?php 
	
	function isTaken($table, $field, $value) {
		
		global $db;
		
		$query = $db->query("SELECT * FROM $table WHERE $field = '$value'");

		if ($query->rowCount()) {
			return true;
		}
		
		return false;
	}

 ?>