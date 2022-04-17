<?php

function searchDB_name($name) {

    global $db;
	$query = "select * from exercise where name = :name";
	// "select * from exercise where name = $name";
	
	$statement = $db->prepare($query);
	$statement->bindValue(':name', $name);
	$statement->execute();

	// fetch() returns a row
	$results = $statement->fetchAll();   

	$statement->closeCursor();

	return $results;
    
}

function searchDB_equipment($equipment) {
    global $db;
	$query = "select * from exercise where equipment = :equipment";
	// "select * from exercise where name = $name";
	
	$statement = $db->prepare($query);
	$statement->bindValue(':equipment', $equipment);
	$statement->execute();

	// fetch() returns a row
	$results = $statement->fetchAll();   

	$statement->closeCursor();

	return $results;
}

function searchDB_time($time_per_set) {
    global $db;
	$query = "select * from exercise where time_per_set = :time_per_set";
	// "select * from exercise where name = $name";
	
	$statement = $db->prepare($query);
	$statement->bindValue(':time_per_set', $time_per_set);
	$statement->execute();

	// fetch() returns a row
	$results = $statement->fetchAll();   

	$statement->closeCursor();

	return $results;
}

function searchDB_body($body_part) {
    global $db;
	$query = "select * from exercise where body_part = :body_part";
	// "select * from exercise where name = $name";
	
	$statement = $db->prepare($query);
	$statement->bindValue(':body_part', $body_part);
	$statement->execute();

	// fetch() returns a row
	$results = $statement->fetchAll();   

	$statement->closeCursor();

	return $results;
}

function searchDB_intensity($intensity_factor) {
    global $db;
	$query = "select * from exercise where intensity_factor = :intensity_factor";
	// "select * from exercise where name = $name";
	
	$statement = $db->prepare($query);
	$statement->bindValue(':intensity_factor', $intensity_factor);
	$statement->execute();

	// fetch() returns a row
	$results = $statement->fetchAll();   

	$statement->closeCursor();

	return $results;
}

?>
