<?php

function trainerCheck($username)
{
    // db handler
    global $db;

    // write sql
    // insert into friends values('someone', 'cs', 4)";
    $query = "select * from trainer where username = :username";

    // execute the sql
    //$statement = $db->query($query);   // query() will compile and execute the sql
    $statement = $db->prepare($query); // only compiles

    //fill in blanks, treat user input as plain string, this prevents sql injections
    $statement->bindValue(':username', $username);


    //now execute
    $statement->execute();
    $result = $statement->fetch();

    // release; free the connection to the server so other sql statements may be issued 
    $statement->closeCursor();
    return $result;
}

function createWorkout($workout_id, $workout_name, $total_time, $muscle_group, $equipment, $username)
{
    // db handler
	global $db;

	// write sql
	$query = "insert into workout values(:workout_id,:workout_name, :total_time, :muscle_group, :equipment, :username)";

	// 1. prepare
	// 2. bindValue & execute
	$statement = $db->prepare($query);
    $statement->bindValue(':workout_id', $workout_id);
	$statement->bindValue(':workout_name', $workout_name);
	$statement->bindValue(':total_time', $total_time);
	$statement->bindValue(':muscle_group', $muscle_group);
	$statement->bindValue(':equipment', $equipment);
	$statement->bindValue(':username', $username);


	$statement->execute();
	
	// release; free the connection to the server so other sql statements may be issued 
	$statement->closeCursor();
}

function getAllWorkouts()
{
	global $db;
	$query = "select * from workout";
	$statement = $db->query($query);     // 16-Mar, stopped here, still need to fetch and return the result 
	
	// fetchAll() returns an array of all rows in the result set
	$results = $statement->fetchAll();   

	$statement->closeCursor();

	return $results;
}

function getWorkout_byId($workout_id)
{
	global $db;
	$query = "select * from workout where workout_id = :workout_id";
	// "select * from exercise where name = $name";
	
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

function getExerciseIdByWorkoutId($workout_id)
{
	global $db;
	$query = "select * from contains where workout_id = :workout_id";
	// "select * from exercise where name = $name";
	
	// 1. prepare
	// 2. bindValue & execute
	$statement = $db->prepare($query);
	$statement->bindValue(':workout_id', $workout_id);
	$statement->execute();

	// fetch() returns a row
	$results = $statement->fetchAll();   

	$statement->closeCursor();

	return $results;	
}

function getExerciseNameByExerciseId($exercise_id)
{
	global $db;
	$query = "select name from exercise where exercise_id = :exercise_id";
	// "select * from exercise where name = $name";
	
	// 1. prepare
	// 2. bindValue & execute
	$statement = $db->prepare($query);
	$statement->bindValue(':exercise_id', $exercise_id);
	$statement->execute();

	// fetch() returns a row
	$results = $statement->fetch();   

	$statement->closeCursor();

	return $results;	
}

function updateWorkout($workout_id, $workout_name, $total_time, $muscle_group, $equipment, $username)
{
	global $db;
	$query = "update workout set workout_name = :workout_name, total_time = :total_time, muscle_group = :muscle_group, equipment = :equipment, username = :username where workout_id = :workout_id";
	$statement = $db->prepare($query); 
	$statement->bindValue(':workout_name', $workout_name);
	$statement->bindValue(':total_time', $total_time);
	$statement->bindValue(':muscle_group', $muscle_group);
	$statement->bindValue(':equipment', $equipment);
	$statement->bindValue(':username', $username);
	$statement->bindValue(':workout_id', $workout_id);
	$statement->execute();
	$statement->closeCursor();
}


function deleteWorkout($workout_id)
{
	global $db;
	$query = "delete from workout where workout_id = :workout_id";
	$statement = $db->prepare($query); 
	$statement->bindValue(':workout_id', $workout_id);
	$statement->execute();
	$statement->closeCursor();
}


function getCardioMetric($metric_id)
{
	global $db;
	$query = "select * from cardioMetrics where metric_id = :metric_id";
	// "select * from exercise where name = $name";
	
	// 1. prepare
	// 2. bindValue & execute
	$statement = $db->prepare($query);
	$statement->bindValue(':metric_id', $metric_id);
	$statement->execute();

	// fetch() returns a row
	$results = $statement->fetch();   

	$statement->closeCursor();

	return $results;	
}

function getLiftingMetric($metric_id)
{
	global $db;
	$query = "select * from liftingMetrics where metric_id = :metric_id";
	// "select * from exercise where name = $name";
	
	// 1. prepare
	// 2. bindValue & execute
	$statement = $db->prepare($query);
	$statement->bindValue(':metric_id', $metric_id);
	$statement->execute();

	// fetch() returns a row
	$results = $statement->fetch();   

	$statement->closeCursor();

	return $results;	
}


function addExercisesToWorkout($metric_id, $exercise_id, $workout_id)
{
	global $db;
	$query = "insert into contains values(:metric_id,:exercise_id, :workout_id)";
	// "select * from exercise where name = $name";
	
// 1. prepare
// 2. bindValue & execute
	$statement = $db->prepare($query);
	$statement->bindValue(':exercise_id', $exercise_id);
	$statement->bindValue(':workout_id', $workout_id);
	$statement->bindValue(':metric_id', $metric_id);
	$statement->execute();

	$statement->closeCursor();
}


function deleteExercisesFromWorkout($metric_id, $exercise_id, $workout_id)
{
	global $db;
	$query = "delete from contains where metric_id = :metric_id, exercise_id = :exercise_id, workout_id = :workout_id";
	// "select * from exercise where name = $name";
	
// 1. prepare
// 2. bindValue & execute
	$statement = $db->prepare($query);
	$statement->bindValue(':exercise_id', $exercise_id);
	$statement->bindValue(':workout_id', $workout_id);
	$statement->bindValue(':metric_id', $metric_id);
	$statement->execute();

	$statement->closeCursor();
}


function addMetrics($exercise_id, $metric_id)
{
	// db handler
    global $db;

    // write sql
    // insert into friends values('someone', 'cs', 4)";
    $query = "insert into metrics values(:exercise_id, :metric_id)";

    // execute the sql
    //$statement = $db->query($query);   // query() will compile and execute the sql
    $statement = $db->prepare($query); // only compiles

    //fill in blanks, treat user input as plain string, this prevents sql injections
    $statement->bindValue(':exercise_id', $exercise_id);
    $statement->bindValue(':metric_id', $metric_id);
    //now execute
    $statement->execute();

    // release; free the connection to the server so other sql statements may be issued 
    $statement->closeCursor();
}

function addCardioMetrics($exercise_id, $metric_id, $distance, $duration)
{
	// db handler
    global $db;

    // write sql
    // insert into friends values('someone', 'cs', 4)";
    $query = "insert into cardioMetrics values(:exercise_id, :metric_id, :distance, :duration)";

    // execute the sql
    //$statement = $db->query($query);   // query() will compile and execute the sql
    $statement = $db->prepare($query); // only compiles

    //fill in blanks, treat user input as plain string, this prevents sql injections
    $statement->bindValue(':exercise_id', $exercise_id);
    $statement->bindValue(':metric_id', $metric_id);
	$statement->bindValue(':distance', $distance);
    $statement->bindValue(':duration', $duration);

    //now execute
    $statement->execute();

    // release; free the connection to the server so other sql statements may be issued 
    $statement->closeCursor();
}

function addLiftingMetrics($exercise_id, $metric_id, $reps, $sets)
{
	// db handler
    global $db;

    // write sql
    // insert into friends values('someone', 'cs', 4)";
    $query = "insert into liftingMetrics values(:exercise_id, :metric_id, :reps, :sets)";

    // execute the sql
    //$statement = $db->query($query);   // query() will compile and execute the sql
    $statement = $db->prepare($query); // only compiles

    //fill in blanks, treat user input as plain string, this prevents sql injections
    $statement->bindValue(':exercise_id', $exercise_id);
    $statement->bindValue(':metric_id', $metric_id);
	$statement->bindValue(':reps', $reps);
    $statement->bindValue(':sets', $sets);

    //now execute
    $statement->execute();

    // release; free the connection to the server so other sql statements may be issued 
    $statement->closeCursor();
}

?>