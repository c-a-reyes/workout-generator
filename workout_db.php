<?php

//creates a row in workout table, need separate command to add exercises to the contains table
function addWorkout($workout_id, $workout_name, $total_time, $muscle_group, $equipment, $username)
{
	// db handler
	global $db;

	// write sql
	$query = "insert into workout values(NULL,'" . $workout_name . "'," . $total_time . ",'" . $muscle_group . ",'" . $equipment . ",'" . $username . "')";

	// execute the sql
	$statement = $db->query($query);   // query() will compile and execute the sql
	
	// release; free the connection to the server so other sql statements may be issued 
	$statement->closeCursor();
}

function getAllWorkouts()
{
	global $db;
	$query = "select * from workout";
	$statement = $db->query($query); 
	
	// fetchAll() returns an array of all rows in the result set
	$results = $statement->fetchAll();   

	$statement->closeCursor();

	return $results;
}

function getWorkout_byId($workout_id)
{
	global $db;
	$query = "select * from workout where workout_id = :workout_id";
	// "select * from workout where name = $workout_name";
	
    // 1. prepare
    // 2. bindValue & execute
	$statement = $db->prepare($query);
	$statement->bindValue(':workout_id', $workout_id);
	$statement->execute();

	// fetch() returns a row
	$results = $statement->fetch();   

	$statement->closeCursor();

	return $results;	
}

// function getExercise_byUsername($username) {
// 	global $db;
// 	$query = "select * from exercise where username = :username";
// 	// "select * from exercise where name = $name";
	
// // 1. prepare
// // 2. bindValue & execute
// 	$statement = $db->prepare($query);
// 	$statement->bindValue(':username', $username);
// 	$statement->execute();

// 	// fetch() returns a row
// 	$results = $statement->fetch();   

// 	$statement->closeCursor();

// 	return $results;
// }

// function updateExercise($id, $username, $intensity, $bodyPart, $time, $equipment, $name)
// {
// 	global $db;
// 	$query = "update exercise set intensity_factor=:intensity, name =:name, body_part=:bodyPart, time_per_set=:time, equipment=:equipment, name=:name where id=:id";
// 	$statement = $db->prepare($query); 
// 	$statement->bindValue(':intensity', $intensity);
// 	$statement->bindValue(':bodyPart', $bodyPart);
// 	$statement->bindValue(':time', $time);
// 	$statement->bindValue(':equipment', $equipment);
// 	$statement->bindValue(':name', $name);
// 	$statement->bindValue(':id', $id);
// 	$statement->bindValue(':username', $username);
// 	$statement->execute();
// 	$statement->closeCursor();
// }

// deletes row from workout table, also need to account for contains table
function deleteWorkout($id)
{
	global $db;
	$query = "delete from exercise where id=:id";
	$statement = $db->prepare($query); 
	$statement->bindValue(':id', $id);
	$statement->execute();
	$statement->closeCursor();
}
?>