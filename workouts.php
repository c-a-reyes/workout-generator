<!-- this php code checks if the user is logged in, if they aren't it redirects them back to the login page. -->
<?php
require('connect-db.php');
require('workout_db.php');
require('exercise_db.php');

session_start();

$list_of_workouts = getAllWorkouts();
$workouts_to_update = null;
$list_of_exercises = getAllExercises();
$exercises_per_workout = null;




// if ($_SERVER['REQUEST_METHOD'] == 'POST')
// {
//     if (!empty($_POST['btnAction']) && $_POST['btnAction'] == "Add")
//     {
//         addWorkout(NULL, $_POST['workout name'], $_POST['total_time'], $_POST['muscle_group'], $_POST['equipment']);
//         $list_of_workouts = getAllWorkouts();
//     }
//     else if (!empty($_POST['btnAction']) && $_POST['btnAction'] == "Update")
//     {  
       
//       $workout_to_update = getWorkout_byId($_POST['workout_to_update']);

//     }
//     else if (!empty($_POST['btnAction']) && $_POST['btnAction'] == "Delete")
//     {
//       deleteExercise($_POST['exercise_to_delete']);
//       $list_of_workouts = getAllWorkouts();
//     }

//     else if (!empty($_POST['btnAction']) && $_POST['btnAction'] == "View Workout")
//     {  
       
//       $list_of_exercises = getExerciseByWorkoutId($_POST['workout_id']);

//     }

//     if (!empty($_POST['btnAction']) && $_POST['btnAction'] == "Confirm update")
//     {
//       updateExercise($_POST['exercise_id'], $_SESSION['username'], $_POST['intensity_factor'], $_POST['body_part'], $_POST['time_per_set'], $_POST['equipment'], $_POST['exercise_name']);
//       $list_of_workouts = getAllWorkouts();
//     }

// }
    //session_start();


    if(!isset($_SESSION["username"]))
    {
        header("location:login.php");
    }

?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />

    <!-- 2. include meta tag to ensure proper rendering and touch zooming -->
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <!-- 
    Bootstrap is designed to be responsive to mobile.
    Mobile-first styles are part of the core framework.
    
    width=device-width sets the width of the page to follow the screen-width
    initial-scale=1 sets the initial zoom level when the page is first loaded   
    -->

    <title>Workout Generator</title>

    <!-- 3. link bootstrap -->
    <!-- if you choose to use CDN for CSS bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous" />

    <!-- bootstrap js -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>
    <!-- Bootstrap Font Icon CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">

    <!-- you may also use W3's formats -->
    <!-- <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css"> -->

    <!-- 
Use a link tag to link an external resource.
A rel (relationship) specifies relationship between the current document and the linked resource. 
-->

    <!-- If you choose to use a favicon, specify the destination of the resource in href -->
    <link rel="icon" type="image/png" href="http://www.cs.virginia.edu/~up3f/cs4750/images/db-icon.png" />

    <!-- if you choose to download bootstrap and host it locally -->
    <!-- <link rel="stylesheet" href="path-to-your-file/bootstrap.min.css" /> -->

    <!-- include your CSS -->
    <!-- <link rel="stylesheet" href="custom.css" />  -->
</head>

<body>
    <nav class="navbar navbar-dark bg-dark">
        <div>
            <a class="navbar-brand mx-3" href="dashboard.php">Workout Generator</a>
            <a class="nav-item mx-3" style="color: #d9d9d9; text-decoration: none" href="exercises.php">Exercises</a>
            <a class="nav-item mx-3" style="color: #d9d9d9; text-decoration: none" href="workouts.php">Workouts</a>
        </div>
        <div class="nav-item mx-3">
            <span class="navbar-text mx-3">
                Welcome, <?php echo $_SESSION["username"]?>
            </span>
            <a href="logout.php" class="navbar-item btn btn-outline-light">Logout</a>
        </div>
    </nav>
    <div class="container">
        <!-- <input id="searchBar" type="text" placeholder="Search for an exercise">
        <style type="text/css">
        #searchBar {
            float: center;
            padding: 6px;
            margin-top: 8px;
            margin-right: px;
            font-size: 20px;
        } -->
        </style>
        <!-- <p>Search criteria would go here once we integrate it</p>
        <hr> -->
        <!-- <h1>Add a Workout.</h1>
        <form name="exerciseForm" action="exercises.php" method="post">
            <div class="row mb-3 mx-3" style="padding: 5px">
                Exercise Name:
                <input type="text" class="form-control" name="exercise_name" required
                    value="<?php if ($workout_to_update!=null) echo $workout_to_update['workout_name'] ?>" />
            </div>
            <div class="row mb-3 mx-3" style="padding: 5px">
                Equipment:
                <input type="text" class="form-control" name="equipment" required
                    value="<?php if ($workout_to_update!=null) echo $workout_to_update['total_time'] ?>" />
            </div>
            <div class="row mb-3 mx-3" style="padding: 5px">
                Time Per Set:
                <input type="text" class="form-control" name="time_per_set" required
                    value="<?php if ($workout_to_update!=null) echo $workout_to_update['time_per_set'] ?>" />
            </div>
            <div class="row mb-3 mx-3" style="padding: 5px">
                Body Part:
                <input type="text" class="form-control" name="body_part" required
                    value="<?php if ($workout_to_update!=null) echo $workout_to_update['muscle_group'] ?>" />
            </div>
            <div class="row mb-3 mx-3" style="padding: 5px">
                Intensity Factor:
                <input type="text" class="form-control" name="intensity_factor" required
                    value="<?php if ($workout_to_update!=null) echo $workout_to_update['equipment'] ?>" />
            </div>

            <input type="hidden" name="exercise_id" required
                value="<?php if ($workout_to_update!=null) echo $workout_to_update['workout_id'] ?>" />

            <?php if ($workout_to_update==null): ?>
            <input type="submit" value="Add" name="btnAction" class="btn btn-dark" style="margin: 15px" />
            <?php else: ?>
            <input type="submit" value="Confirm update" name="btnAction" class="btn btn-dark"
                title="confirm update an exercise" />
            <?php endif ?>
        </form> -->

        <hr />
        <h2 class="display-5">List of Workouts</h2>
        <!-- <div class="row justify-content-center">   -->

        <div style="display:grid; grid-template-columns: 1fr 1fr 1fr">
            <?php foreach ($list_of_workouts as $workout):  ?>
            <div>
                <div class="card h-100">
                    <div class="card-deck">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title"> <?php echo $workout['workout_name']; ?> </h5>
                                <p class="card-text">
                                    Total Time: <?php echo $workout['total_time']; ?>
                                </p>
                                <p class="card-text">
                                    Muscle Group: <?php echo $workout['muscle_group']; ?>
                                </p>
                                <p class="card-text">
                                    Equipment: <?php echo $workout['equipment']; ?></p>
                                <p class="card-text">
                                    Created by: <?php echo $workout['username']; ?></p>
                                <button type="button" class="btn btn-dark" data-toggle="modal"
                                    data-target="#exampleModal">View Workout</button>
                                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">
                                                    <?php echo $workout['muscle_group']?></h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <?php 
                                                    $exercises_per_workout = getExerciseByWorkoutId($workout['workout_id']);
                                                    foreach ($exercises_per_workout as $ex)
                                                    {
                                                         print_r($exercises_per_workout);
                                                    }  
                                                ?>
                                                
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">Close</button>
                                                <button type="button" class="btn btn-primary">Save changes</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
            <!-- add something that makes it so only trainers can see below button -->
            <div class="container">
                <br><br>
                <p style=><a href="create_workout.php">Create</a> a workout</p>
            </div>
</body>

</html>