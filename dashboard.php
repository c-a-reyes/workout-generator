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

    <link rel="stylesheet" href="dashboard.css" type="text/css">

    <!-- if you choose to download bootstrap and host it locally -->
    <!-- <link rel="stylesheet" href="path-to-your-file/bootstrap.min.css" /> -->

    <!-- include your CSS -->
    <!-- <link rel="stylesheet" href="custom.css" />  -->
</head>

<div class="bg"></div>
<div class="bg bg2"></div>
<div class="bg bg3"></div>

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
    <div id="main" class="px-4">
        <div id="titleDiv" style="background-color: #">
            <center>
                <svg xmlns="http://www.w3.org/2000/svg" width="300" height="154" fill="currentColor"
                    class="bi bi-activity mt-3 mb-2" viewBox="0 0 16 16">
                    <path fill-rule="evenodd"
                        d="M6 2a.5.5 0 0 1 .47.33L10 12.036l1.53-4.208A.5.5 0 0 1 12 7.5h3.5a.5.5 0 0 1 0 1h-3.15l-1.88 5.17a.5.5 0 0 1-.94 0L6 3.964 4.47 8.171A.5.5 0 0 1 4 8.5H.5a.5.5 0 0 1 0-1h3.15l1.88-5.17A.5.5 0 0 1 6 2Z" />
                </svg>
                <h1 class="display-4"">Workout Generator</h1>
                <p class=" lead" style=" margin-left: 15%; margin-right: 15%; margin-top: 1%; font-size: 24px">Looking
                    to put muscle
                    on,
                    slim down, or
                    maintain your
                    physique?
                    With Workout Generator, you can find a workout plan
                    that works for you so you can achieve all your fitness goals.</p>
            </center>
        </div>
        <hr class="mt-5">
        <div class="container-fluid text-center" style="padding-bottom: 30px; padding-top: 20px; background-color:">
            <div class="row">
                <div class="col pt-2 px-3">
                    <a href="exercises.php" style="margin: 100px"><i class="bi-sliders"
                            style="color: #fff; font-size: 75px"></i></a>
                    <h3 class="display-6" style="margin-top: 25px; font-size: 32px">Create or View Exercises</h3>
                    <p class="lead" style="margin-top: 10px; font-size: 18px">Browse our collection of exercises. If you
                        can't find one that suits your
                        needs,
                        add it to our collection!</p>
                </div>
                <div class="col pt-2 px-3">
                    <a href="exercises.php" style="margin: 100px"><i class="bi-search"
                            style="color: #fff; font-size: 75px"></i></a>
                    <h3 class="display-6" style="margin-top: 25px; font-size: 32px">Search Exercises</h3>
                    <p class="lead" style="margin-top: 10px; font-size: 18px">Search for an exercise by any of it's
                        attributes, whether it be name, intensity, creator, and more.
                    </p>
                </div>
                <div class="col pt-2 px-3">
                    <a href="view_workout.php" style="margin: 100px"><i class="bi-stack"
                            style="color: #fff; font-size: 75px"></i></a>
                    <h3 class="display-6" style="margin-top: 25px; font-size: 32px">Build or View Workouts</h3>
                    <p class="lead" style="margin-top: 10px; font-size: 18px">Members can discover
                        cardio or muscle-group specific workouts. Trainers can create workouts.</p>
                </div>
            </div>
        </div>
    </div>
</body>

</html>