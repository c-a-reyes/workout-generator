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
?>