<?php
require('search-db.php');
require('connect-db.php');
require('exercise_db.php');

session_start();

if(!isset($_SESSION["username"])) {
    header("location:login.php");
}

$list_of_exercises = getAllExercises();
$exercise_matches = null;



if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if(!empty($_POST['action']) && $_POST['action'] == "Search Name of Exercise") {
        $exercise_matches = searchDB_name($_POST['search']);
    
    }
    elseif(!empty($_POST['action']) && $_POST['action'] == "Search Equipment Used") {
        $exercise_matches = searchDB_equipment($_POST['search']);
    
    }
    elseif(!empty($_POST['action']) && $_POST['action'] == "Search Time Per Set") {
        $exercise_matches = searchDB_time($_POST['search']);
    
    }
    elseif(!empty($_POST['action']) && $_POST['action'] == "Search Target Body Part") {
        $exercise_matches = searchDB_body($_POST['search']);
    
    }
    elseif(!empty($_POST['action']) && $_POST['action'] == "Search Intensity Factor") {
        $exercise_matches = searchDB_intensity($_POST['search']);
    
    }
    else {
        echo "Nothing!";
    }
}

?>

<html>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous" />



<body>
    <nav class="navbar navbar-dark bg-dark">
        <div>
            <a class="navbar-brand mx-3" href="dashboard.php">Dashboard</a>
            <a class="nav-item mx-3" style="color: #d9d9d9; text-decoration: none" href="exercises.php">Exercise
                Management</a>
            <a class="nav-item mx-3" style="color: #d9d9d9; text-decoration: none" href="search.php">Search
                Exercises</a>
        </div>
        <div class="nav-item mx-3">
            <span class="navbar-text mx-3">
                Welcome, <?php echo $_SESSION["username"]?>
            </span>
            <a href="logout.php" class="navbar-item btn btn-outline-light">Logout</a>
        </div>
    </nav>

    <div class="container">
        <form action="search.php" method="POST">
            <div class="form-group mx-sm-3 mb-2" padding="20 px">
                <center>
                    <h2 for="example"> Search our database with any of these criteria! </h2>
                </center>
                <input type="text" name="search" class="form-control" required />
            </div>
            <center>
                <div class="btn-group">
                    <input class="btn btn-outline-dark" type="submit" name="action" value="Search Name of Exercise" />
                    <input class="btn btn-outline-dark" type="submit" name="action" value="Search Equipment Used" />
                    <input class="btn btn-outline-dark" type="submit" name="action" value="Search Time Per Set" />
                    <input class="btn btn-outline-dark" type="submit" name="action" value="Search Target Body Part" />
                    <input class="btn btn-outline-dark" type="submit" name="action" value="Search Intensity Factor" />
                </div>
            </center>

        </form>


        <div class="table-responsive">
            <table class="table table-striped table-hover table-light">
                <thead>
                    <tr>
                        <th scope=" col">Name</th>
                        <th scope="col">Equipment</th>
                        <th scope="col">Time Per Set</th>
                        <th scope="col">Body Part(s)</th>
                        <th scope="col">Intensity Factor</th>
                    </tr>
                </thead>
                <?php if (is_array($exercise_matches) || is_object($exercise_matches)): ?>
                <?php foreach ($exercise_matches as $exercise):  ?>
                <tr>
                    <th scope="col"><?php echo $exercise['name']; ?></td>
                    <td><?php echo $exercise['equipment']; ?></td>
                    <td><?php echo $exercise['time_per_set']; ?></td>
                    <td><?php echo $exercise['body_part']; ?></td>
                    <td><?php echo $exercise['intensity_factor']; ?></td>
                </tr>
                <?php endforeach; ?>
                <?php endif ?>
            </table>
        </div>
    </div>
</body>

</html>