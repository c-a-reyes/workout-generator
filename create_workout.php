<?php
require('connect-db.php');
require('workout_db.php');
require('exercise_db.php');

session_start();

if(!isset($_SESSION["username"]))
{
    header("location:login.php");
}

$trainer = trainerCheck($_SESSION['username']);

if ($trainer == null)
{
    header("location:view_workout.php");
}
$list_of_workouts = getAllWorkouts();
$workout_to_update = null;
$list_of_exercises = getAllExercises();

 if ($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        if (!empty($_POST['btnAction']) && $_POST['btnAction'] == "Create")
        {
            createWorkout(NULL, $_POST['workout_name'], $_POST['total_time'], $_POST['muscle_group'], $_POST['equipment'], $_SESSION['username']);
            $list_of_workouts = getAllWorkouts();
        }
        else if (!empty($_POST['btnAction']) && $_POST['btnAction'] == "Update")
        {   
          $workout_to_update = getWorkout_byId($_POST['workout_to_update']);
        }
        else if (!empty($_POST['btnAction']) && $_POST['btnAction'] == "Delete")
        {
          deleteWorkout($_POST['workout_to_delete']);
          $list_of_workouts = getAllWorkouts();
        }
        if (!empty($_POST['btnAction']) && $_POST['btnAction'] == "Confirm Update")
        {
          updateWorkout($_POST['workout_id'], $_POST['workout_name'], $_POST['total_time'], $_POST['muscle_group'], $_POST['equipment'], $_SESSION['username']);
          $list_of_workouts = getAllWorkouts();
        }
        if (!empty($_POST['btnAction']) && $_POST['btnAction'] == "Add these exercises")
        {
            if (isset($_POST['workout-dropdown']))
            {
                foreach ($_POST['add'] as $exercise)
                {
                addExercisesToWorkout(null, $exercise, $_POST['workout-dropdown']);
                addMetrics($exercise, null);
                if (isset($_POST['distance']) and isset($_POST['duration']))
                    {
                        addCardioMetrics($exercise, null, $_POST['distance'], $_POST['duration']);   
                    }  
                elseif (isset($_POST['reps']) and isset($_POST['sets']))
                    {
                        addLiftingMetrics($exercise, null, $_POST['reps'], $_POST['set']);
                    }
                }
                // foreach ($_POST['delete'] as $exercise)
                // {
                // deleteExercisesFromWorkout(null, $exercise, $_POST['workout-dropdown']);                
                // }
            }
            else
            {
                echo 'failed';
            }
            header('location:view_workout.php');
        }
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
            <a class="navbar-brand mx-3" href="dashboard.php">Dashboard</a>
            <a class="nav-item mx-3" style="color: #d9d9d9; text-decoration: none" href="exercises.php">Exercises</a>
            <a class="nav-item mx-3" style="color: #d9d9d9; text-decoration: none" href="view_workout.php">Workouts</a>
        </div>
        <div class="nav-item mx-3">
            <span class="navbar-text mx-3">
                Welcome, <?php echo $_SESSION["username"]?>
            </span>
            <a href="logout.php" class="navbar-item btn btn-outline-light">Logout</a>
        </div>
    </nav>
    <div class="container">
        <h1 class="display-2" style="padding-top: 30px; padding-bottom: 20px">Create or Update a Workout.</h1>
        <form name="workoutForm" action="view_workout.php" method="post">
            <div class="row mb-3 mx-2" style="padding: 5px">
                Workout Name:
                <input placeholder="Enter workout name" aria-describedby="nameHelp" type="text" class="form-control"
                    name="workout_name" required
                    value="<?php if ($workout_to_update!=null) echo $workout_to_update['workout_name'] ?>" />
                <small id="nameHelp" class="form-text text-muted" style="text-align: left; padding-left: 0px">e.g.
                    Upper Body Destroyer Workout
                </small>
            </div>
            <div class="row mb-3 mx-2" style="padding: 5px">
                Equipment:
                <input placeholder="Enter equipment" aria-describedby="equipmentHelp" type="text" class="form-control"
                    name="equipment" required
                    value="<?php if ($workout_to_update!=null) echo $workout_to_update['equipment'] ?>" />
                <small id="equipmentHelp" class="form-text text-muted" style="text-align: left; padding-left: 0px">Enter
                    your equipment in a comma-separated list. If
                    your workout requires no equipment, enter None.
                </small>
            </div>
            <div class="row mb-3 mx-2" style="padding: 5px">
                Muscle Group(s):
                <input placeholder="Enter muscle group(s)" aria-describedby="bodypartHelp" type="text"
                    class="form-control" name="muscle_group" required
                    value="<?php if ($workout_to_update!=null) echo $workout_to_update['muscle_group'] ?>" />
                <small id="bodypartHelp" class="form-text text-muted" style="text-align: left; padding-left: 0px">e.g.
                    Push, Pull, Legs, Full Body
                </small>
            </div>
            <div class="row mb-3 mx-2">

                <div class="col" style="padding: 5px">
                    Total Time:
                    <div class="input-group">
                        <div>
                            <input placeholder="Enter total time" aria-describedby="timeHelp" style="width: 543px"
                                type="number" class="form-control" name="total_time" required
                                value="<?php if ($workout_to_update!=null) echo $workout_to_update['total_time'] ?>" />
                            <small id="timeHelp" class="form-text text-muted"
                                style="text-align: left; padding-left: 0px">The time it takes to complete the entire
                                workout.
                            </small>
                        </div>
                        <div class="input-group-append">
                            <span class="input-group-text">minutes</span>
                        </div>
                    </div>
                </div>
                <div class="col" style="padding: 5px">
                    Created by:
                    <input placeholder="<?php echo $_SESSION['username']?>" aria-describedby="ifHelp" type="text"
                        class="form-control" name="username"
                        value="<?php if ($workout_to_update!=null) echo $workout_to_update['username'] ?>" />
                    <small id="ifHelp" class="form-text text-muted" style="text-align: left; padding-left: 0px">Enter
                        your username so others can see that this workout is yours.
                    </small>
                </div>
            </div>
            <input type="hidden" name="workout_id" required
                value="<?php if ($workout_to_update!=null) echo $workout_to_update['workout_id'] ?>" />

            <?php if ($workout_to_update==null): ?>
            <input type="submit" value="Create" name="btnAction" class="btn btn-dark mx-3 my-2 px-3" />
            <a href="view_workout.php" class="btn btn-dark my-2 px-3">Cancel</a>

            <?php else: ?>
            <input type="submit" value="Confirm Update" name="btnAction" class="btn btn-outline-success mx-3 my-2 px-3"
                title="confirm update on workout" />
            <a href="view_workout.php" class="btn btn-dark my-2 px-3">Cancel</a>
            <?php endif ?>
        </form>
        <form name="addExercisesToWorkout" id="addExercisesToWorkout" action="create_workout.php" method="post">
            <br>
            <hr>
            <h1 class="display-2" style="padding-top: 20px">Add Exercises to a Workout.</h1>
            <br>
            <select form="addExercisesToWorkout" name="workout-dropdown" class="form-select"
                aria-label="Default select example">
                <option selected>Choose workout to add exercises to</option>
                <?php foreach ($list_of_workouts as $workout):  ?>
                <option value="<?php echo $workout['workout_id']?>"><?php echo $workout['workout_name']; ?></option>
                <?php endforeach; ?>
            </select>
            <br>
            <center>
                <div class="table-responsive">
                    <table class="table table-striped table-hover table-light">
                        <thead>
                            <tr>
                                <th scope=" col">Name</th>
                                <th scope="col">Equipment</th>
                                <th scope="col">Time Per Set</th>
                                <th scope="col">Body Part(s)</th>
                                <th scope="col">Intensity Factor</th>
                                <th scope="col">Cardio (Fill One)</th>
                                <th scope="col">Lifting (Fill One)</th>
                                <th scope="col">Add</th>
                                <th scope="col">Remove</th>
                            </tr>
                        </thead>
                        <div class="form-check">
                            <?php foreach ($list_of_exercises as $exercise):  ?>
                            <tr>
                                <th scope="col"><?php echo $exercise['name']; ?></td>
                                <td><?php echo $exercise['equipment']; ?></td>
                                <td><?php echo $exercise['time_per_set']; ?></td>
                                <td><?php echo $exercise['body_part']; ?></td>
                                <td><?php echo $exercise['intensity_factor']; ?></td>
                                <!-- Start of Metrics -->
                                <td id="cardioInfo<?php echo $exercise['exercise_id'];?>">
                                    <div class="row mb-3 mx-3" style="padding: 5px">
                                        <input aria-describedby="distanceHelp" placeholder="Enter distance" type="text"
                                            class="form-control" name="distance" />
                                        <small id="distanceHelp" class="form-text text-muted">e.g. 3.1 miles</small>

                                    </div>
                                    <div class="row mb-3 mx-3" style="padding: 5px">
                                        <input aria-describedby="durationHelp" placeholder="Enter duration" type="text"
                                            class="form-control" name="duration" />
                                        <small id="durationHelp" class="form-text text-muted">e.g. 15 minutes</small>
                                    </div>
                                </td>
                                <td id="liftingInfo<?php echo $exercise['exercise_id'];?>">
                                    <div class="row mb-3 mx-3" style="padding: 5px">
                                        <div class="input-group px-0">
                                            <input placeholder="Enter reps" type="number" class="form-control"
                                                name="reps" />
                                            <div class="input-group-append">
                                                <span class="input-group-text">reps</span>
                                            </div>
                                        </div>
                                        <small class="form-text text-muted">i.e. Single movements</small>
                                    </div>
                                    <div class="row mb-3 mx-3" style="padding: 5px">
                                        <div class="input-group px-0">
                                            <input placeholder="Enter sets" type="number" class="form-control"
                                                name="sets" />
                                            <div class="input-group-append">
                                                <span class="input-group-text">sets</span>
                                            </div>
                                        </div>
                                        <small class="form-text text-muted">i.e. Series of repetitions</small>
                                    </div>
                                </td>
                                <td>
                                    <input value='<?php echo $exercise['exercise_id']?>' name="add[]" type="checkbox">
                                </td>
                                <td>
                                    <input value='<?php echo $exercise['exercise_id']?>' name="delete[]"
                                        type="checkbox">
                                </td>
                            </tr>
                        </div>
                        <?php endforeach; ?>
                    </table>
                </div>
            </center>
            <button
                style=" background-color: rgb(10, 55, 146);; color: #fff; float: right; font-size: 25px; height: 85px"
                type="submit" name="btnAction" value="Add these exercises" class="btn my-3"><i style="font-size: 35px;"
                    class="px-1 bi-plus-lg"></i>Add
                Exercises
            </button>
        </form>
</body>

</html>