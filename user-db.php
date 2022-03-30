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

function addUserAsMember($username, $height, $weight, $goal)
{
    // db handler
    global $db;

    // write sql
    // insert into friends values('someone', 'cs', 4)";
    $query = "insert into member values(:username, :height, :weight, :goal)";

    // execute the sql
    //$statement = $db->query($query);   // query() will compile and execute the sql
    $statement = $db->prepare($query); // only compiles

    //fill in blanks, treat user input as plain string, this prevents sql injections
    $statement->bindValue(':username', $username);
    $statement->bindValue(':height', $height);
    $statement->bindValue(':weight', $weight);
    $statement->bindValue(':goal', $goal);


    //now execute
    $statement->execute();

    // release; free the connection to the server so other sql statements may be issued 
    $statement->closeCursor();
}
function addUserAsTrainer($username, $specialty, $experience, $certification)
{
    // db handler
    global $db;

    // write sql
    // insert into friends values('someone', 'cs', 4)";
    $query = "insert into trainer values(:username, :specialty, :experience, :certification)";

    // execute the sql
    //$statement = $db->query($query);   // query() will compile and execute the sql
    $statement = $db->prepare($query); // only compiles

    //fill in blanks, treat user input as plain string, this prevents sql injections
    $statement->bindValue(':username', $username);
    $statement->bindValue(':specialty', $specialty);
    $statement->bindValue(':experience', $experience);
    $statement->bindValue(':certification', $certification);


    //now execute
    $statement->execute();

    // release; free the connection to the server so other sql statements may be issued 
    $statement->closeCursor();
}

?>