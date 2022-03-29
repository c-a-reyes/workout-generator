<?php

function addExercise($id, $username, $intensity, $bodyPart, $time, $equipment, $name)
{
	// db handler
	global $db;

	// write sql
	$query = "insert into exercise values(NULL,'" . $username . "'," . $intensity . ",'" . $bodyPart . "'," . $time . ",'" . $equipment . "','" . $name  . "')";

	// execute the sql
	$statement = $db->query($query);   // query() will compile and execute the sql
	
	// release; free the connection to the server so other sql statements may be issued 
	$statement->closeCursor();
}

function getAllExercises()
{
	global $db;
	$query = "select * from exercise";
	$statement = $db->query($query);     // 16-Mar, stopped here, still need to fetch and return the result 
	
	// fetchAll() returns an array of all rows in the result set
	$results = $statement->fetchAll();   

	$statement->closeCursor();

	return $results;
}

?>