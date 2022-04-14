<?php

require('connect-db.php');
require('user-db.php');

session_start();

$user = "placeholder";

if($_SERVER["REQUEST_METHOD"]=="POST")
{
    if (!empty($_POST['btnAction']) && $_POST['btnAction'] == "Login")
    {       
            $user = loginUser($_POST['username'], $_POST['password']);
            if ($user != NULL)
            {
                $_SESSION["username"]=$_POST['username'];
                header("location:dashboard.php");     
            }
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
        </div>
    </nav>
    <?php echo ($user == NULL) ? "<br> <center style='color: red; bottom: 0px'>Username or password incorrect. Please try again.</center>" : ""; ?>
    <center>
        <div class="bg-light" style="width: 50%; border-radius: 15px; margin-top: 50px">
            <h1 style="padding-top: 30px">Welcome to Workout Generator!</h1>
            <span>Login or create an account to get started.</span>
            <form name="mainForm" action="login.php" method="post">
                <br>
                <div class="row mx-3" style="padding: 15px">
                    Username:
                    <input type="text" class="form-control" name="username" required minlength="3" maxlength="30" />
                </div>
                <div class="row mb-3 mx-3" style="padding: 15px">
                    Password:
                    <input type="password" class="form-control" name="password" />
                </div>
                <input type="submit" value="Login" name="btnAction" class="btn btn-dark" style="margin: 15px" />
            </form>
            <hr style="margin: 15px">
            <br>
            <p>New user? Create an account <a href=" create-account.php">here</a></p>
            <br>
        </div>
    </center>
</body>

</html>