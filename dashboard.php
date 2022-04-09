<?php
    session_start();


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
    <div class="container-fluid">
        <br><br>
        <p style='text-align:center; font-size:5vw'><a href="exercises.php">Add</a> an exercise</p>
        <p style='text-align:center; font-size:5vw'><a href="workouts.php">View</a> all workouts</p>
    </div>
    <div class="container-fluid">
        <br><br>
    </div>
</body>

</html>