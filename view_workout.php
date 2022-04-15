<?php
require('connect-db.php');
require('workout_db.php');

session_start();

if(!isset($_SESSION["username"]))
{
    header("location:login.php");
}

$trainer = trainerCheck($_SESSION['username']);

$list_of_workouts = getAllWorkouts();
$workout_to_update = null;

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
        <div class="row pb-4">
            <span class="col display-2" style="padding-top: 30px;">View Workouts</span>
            <?php echo ($trainer != NULL) ? 
            "<a href='create_workout.php' class='col-md-auto btn mx-3' style='background-color: rgb(10, 55, 146); color: white; font-size: 26px; height:85px; margin-top: 30px'>
                <i class='bi-wrench-adjustable' style='font-size: 40px'></i>
                 Create a Workout
             </a>"
              : 
            "<button  disabled class='col-md-auto btn mx-3' style='background-color: rgb(10, 55, 146); color: white; font-size: 26px; height:85px; margin-top: 30px'>
                    <i class='bi-wrench-adjustable' style='font-size: 40px'></i> 
                    Create a Workout
             </button> 
             <small class='text-muted' style='text-align: right'>You must be a trainer to create a workout.</small>
            "; ?>
        </div>
        <center>
            <div class="table-responsive">
                <table class="lead table table-striped table-hover table-light">
                    <thead>
                        <tr>
                            <th scope="col">Name</th>
                            <th scope="col">Equipment</th>
                            <th scope="col">Muscle Group</th>
                            <th scope="col">Time</th>
                            <th scope="col">Creator:</th>
                            <th scope="col">Update</th>
                            <th scope="col">Delete</th>
                        </tr>
                    </thead>
                    <?php foreach ($list_of_workouts as $workout):  ?>
                    <tr>
                        <th scope="col"><?php echo $workout['workout_name']; ?>
                            <!-- <div class="collapse"
                                id="collapseExample">
                                <div class="card card-body">
                                    Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry
                                    richardson ad squid. Nihil anim keffiyeh helvetica, craft beer labore wes anderson
                                    cred nesciunt sapiente ea proident.
                                </div>
                            </div> -->
                        </th>
                        <td><?php echo $workout['equipment']; ?></td>
                        <td><?php echo $workout['muscle_group']; ?></td>
                        <td><?php echo $workout['total_time']; ?></td>
                        <td><?php echo $workout['username']; ?></td>

                        <td>
                            <?php if ($_SESSION['username'] == $workout['username']): ?>
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-secondary" data-toggle="modal"
                                data-target="#updateModal<?php echo $workout['workout_id'] ?>"><i
                                    class="bi-pencil"></i></button>
                            <!-- Modal -->
                            <div class="modal fade" id="updateModal<?php echo $workout['workout_id'] ?>" tabindex="-1"
                                role="dialog" aria-labeledby="updateModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="updateModalLabel">Are you sure you want to
                                                update
                                                this
                                                workout?
                                            </h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <br>
                                            <p class="text-muted mx-3">Updating this workout will update it for all
                                                members
                                                and trainers. This
                                                CANNOT be undone.
                                            </p>
                                        </div>
                                        <div class="modal-footer">
                                            <form action="create_workout.php" method="post">
                                                <input type="submit" value="Update" name="btnAction"
                                                    class="btn btn-primary" />
                                                <input type="hidden" name="workout_to_update"
                                                    value="<?php echo $workout['workout_id'] ?>" />
                                            </form>
                                            <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php else: ?>
                            <button class="btn btn-secondary" disabled><i class="bi-pencil"></i></button>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if ($_SESSION['username'] == $workout['username']): ?>
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-danger" data-toggle="modal"
                                data-target="#deleteModal<?php echo $workout['workout_id'] ?>"><i
                                    class="bi-trash3"></i></button>
                            <!-- Modal -->
                            <div class="modal fade" id="deleteModal<?php echo $workout['workout_id'] ?>" tabindex="-1"
                                role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="deleteModalLabel">Are you sure you want to
                                                delete
                                                this
                                                workout?
                                            </h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <br>
                                            <p class="text-muted mx-3">
                                                Deleting this workout will permanently remove it
                                                from our collection of workouts. This CANNOT be undone.
                                            </p>
                                        </div>
                                        <div class="modal-footer">
                                            <form action="view_workout.php" method="post">
                                                <input type="submit" value="Delete" name="btnAction"
                                                    class="btn btn-danger" />
                                                <input type="hidden" name="workout_to_delete"
                                                    value="<?php echo $workout['workout_id'] ?>" />
                                            </form>
                                            <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php else: ?>
                            <button class="btn btn-danger" disabled><i class="bi-trash3"></i></button>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </table>
            </div>
        </center>
    </div>
</body>

</html>