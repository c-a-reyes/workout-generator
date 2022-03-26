<?php

function addUser($username, $password, $gym_address)
{
    // db handler
    global $db;

    // write sql
    // insert into friends values('someone', 'cs', 4)";
    $query = "insert into user values(:username, :password, :gym_address)";

    // execute the sql
    //$statement = $db->query($query);   // query() will compile and execute the sql
    $statement = $db->prepare($query); // only compiles

    //fill in blanks, treat user input as plain string, this prevents sql injections
    $statement->bindValue(':username', $username);
    $statement->bindValue(':password', $password);
    $statement->bindValue(':gym_address', $gym_address);

    //now execute
    $statement->execute();

    // release; free the connection to the server so other sql statements may be issued 
    $statement->closeCursor();
}

function loginUser($username, $password)
{
     // db handler
     global $db;

     // write sql
     // insert into friends values('someone', 'cs', 4)";
     $query = "select * from user where username = :username and password = :password";
 
     // execute the sql
     //$statement = $db->query($query);   // query() will compile and execute the sql
     $statement = $db->prepare($query); // only compiles
 
     //fill in blanks, treat user input as plain string, this prevents sql injections
     $statement->bindValue(':username', $username);
     $statement->bindValue(':password', $password);

     //now execute
     $statement->execute();

     // release; free the connection to the server so other sql statements may be issued 
     $statement->closeCursor();
}

function addFriend($name,$major, $year)
{
	// db handler
	global $db;

	// write sql
	// insert into friends values('someone', 'cs', 4)";
	$query = "insert into friends values(:name, :major, :year)";

	// execute the sql
	//$statement = $db->query($query);   // query() will compile and execute the sql
	$statement = $db->prepare($query); // only compiles

	//fill in blanks, treat user input as plain string, this prevents sql injections
	$statement->bindValue(':name', $name);
	$statement->bindValue(':major', $major);
	$statement->bindValue(':year', $year);

	//now execute
	$statement->execute();

	// release; free the connection to the server so other sql statements may be issued 
	$statement->closeCursor();
}

?>