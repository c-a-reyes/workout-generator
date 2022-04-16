<?php
    require('connect-db.php');
    require('user-db.php');

    session_start();

    $password = null;
    $confirmPassword = null;
    $usernameTaken = null;
    
    if($_SERVER["REQUEST_METHOD"]=="POST")
    {
        if (!empty($_POST['btnAction']) && $_POST['btnAction'] == "Create")
        {
            $password = $_POST['password'];
            $confirmPassword = $_POST['confirmPassword'];
            $usernameTaken = checkUser($_POST['username']);
            if ($usernameTaken == false)
            {
                if ($password == $confirmPassword)
                {
                    addUser($_POST['username'], $_POST['password'], NULL);
                    if ($_POST['UserRadios'] == 'member') {
                        addUserAsMember($_POST['username'], $_POST['height'], $_POST['weight'], $_POST['goal'] );
                    }
                    if ($_POST['UserRadios'] == 'trainer') {
                        addUserAsTrainer($_POST['username'], $_POST['specialty'], $_POST['experience'], $_POST['certification'] );
                    }

                    addGym(NULL, $_POST['gym_name'], $_POST['gym_address'], $_POST['gym_phone_number'], $_POST['gym_hours'], $_POST['gym_rate']);

                    $_SESSION["username"]=$_POST['username'];
                    header("location:dashboard.php");
                }
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
    <script type="text/javascript">
    function memberCheck() {
        if (document.getElementById('MemberRadio1').checked) {
            document.getElementById("specs").removeAttribute("required");
            document.getElementById("exp").removeAttribute("required");
            document.getElementById("certs").removeAttribute("required");
            document.getElementById('memberInfo').style.display = 'block';
            document.getElementById('trainerInfo').style.display = 'none';

        } else if (document.getElementById('TrainerRadio1').checked) {
            document.getElementById("hite").removeAttribute("required");
            document.getElementById("wate").removeAttribute("required");
            document.getElementById("gole").removeAttribute("required");
            document.getElementById('trainerInfo').style.display = 'block';
            document.getElementById('memberInfo').style.display = 'none';
        }
    }
    </script>
</head>

<body>
    <nav class="navbar navbar-dark bg-dark">
        <div>
            <a class="navbar-brand mx-3" href="dashboard.php">Workout Generator</a>
            <a class="nav-item mx-3" style="color: #d9d9d9; text-decoration: none" href="exercises.php">Exercises</a>
            <a class="nav-item mx-3" style="color: #d9d9d9; text-decoration: none" href="view_workout.php">Workouts</a>
        </div>
    </nav>
    <?php echo ($password != $confirmPassword) ? "<div style='margin-bottom: 0px' class='alert alert-danger' role='alert'>
 Passwords do not match. Please try again.</div>" : ""; ?>
    <?php echo ($usernameTaken == true) ? "<div class='alert alert-danger' role='alert'>
 Username taken. Please try again.</div><br>" : ""; ?>
    <center>
        <div class="bg-light" style="width: 75%; border-radius: 15px; margin-top: 50px; margin-bottom: 50px">
            <h1 style="padding-top: 30px" class="display-4">Create an Account.</h1>
            <br>
            <form name="mainForm" action="create-account.php" method="post">
                <div id="userInfo">
                    <div class="mx-3">
                        <div class="row mb-3 mx-3" style="padding: 5px">
                            Username:
                            <input type="text" placeholder="Enter username" aria-describedby="usernameHelp"
                                class="form-control" name="username" required minlength="3" maxlength="20" />
                            <small id="usernameHelp" class="form-text text-muted"
                                style="text-align: left; padding-left: 0px">Username must
                                be between 3 and 20
                                characters.
                            </small>
                        </div>
                    </div>
                    <div class="row mx-3">
                        <div class="col mb-3 mx-3" style="padding: 5px; text-align: left">
                            Password:
                            <input type="password" placeholder="Enter password" aria-describedby="passwordHelp"
                                class="form-control" name="password" required minlength="8" maxlength="30" />
                            <small id="passwordHelp" class="form-text text-muted"
                                style="text-align: left; padding-left: 0px">Password must
                                be between 8 and 30
                                characters.
                            </small>
                        </div>
                        <div class="col mb-3 mx-3" style="padding: 5px; text-align: left">
                            Confirm Password:
                            <input type="password" placeholder="Confirm password" aria-describedby="confirmPasswordHelp"
                                class="form-control" name="confirmPassword" required />
                            <small id="confirmPasswordHelp" class="form-text text-muted"
                                style="text-align: left; padding-left: 0px">Passwords must
                                match in order to successfully create your account.
                            </small>
                        </div>
                    </div>
                </div>
                <br>
                <br>
                <div id="gymInfo">
                    <div class="row mx-3">
                        <div class="col mb-3 mx-3" style="padding: 5px; text-align: left">
                            Gym Name:
                            <input type="text" aria-describedby="gymNameHelp" placeholder="Enter gym name"
                                class="form-control" name="gym_name" required />
                            <small id="gymNameHelp" class="form-text text-muted">e.g. Aquatic & Fitness Center
                            </small>
                        </div>
                        <div class="col mb-3 mx-3" style="padding: 5px; text-align: left">
                            Gym Address:
                            <input type="text" placeholder="Enter gym address" aria-describedby="addressHelp"
                                class="form-control" name="gym_address" required />
                            <small id="addressHelp" class="form-text text-muted">e.g. 1600 Pennsylvania Avenue NW,
                                Washington, DC 20500
                            </small>
                        </div>
                    </div>
                    <div class="row mx-3">
                        <div class="col mb-3 mx-3" style="padding: 5px; text-align: left">
                            Gym Phone Number:
                            <input type="text" placeholder="Enter gym phone number" aria-describedby="pnHelp"
                                class="form-control" name="gym_phone_number" required />
                            <small id="pnHelp" class="form-text text-muted">e.g. (123)-456-6789
                            </small>
                        </div>
                        <div class="col mb-3 mx-3" style="padding: 5px; text-align: left">
                            Gym Hours:
                            <input type="text" placeholder="Enter gym hours" aria-describedby="hoursHelp"
                                class="form-control" name="gym_hours" required />
                            <small id="hoursHelp" class="form-text text-muted">e.g. 6am-11pm
                            </small>
                        </div>
                        <div class="col mb-3 mx-3" style="padding: 5px; text-align: left">
                            <span style="padding-left: 2.25rem">Monthly Gym Rate:</span>
                            <div class="row">
                                <div class="input-group px-0">
                                    <div class="input-group-prepend">
                                        <span style="margin-left: .75rem" class="input-group-text">$</span>
                                    </div>
                                    <div>
                                        <input style="width: 268px" placeholder="Enter gym rate" type="number"
                                            class="form-control" name="gym_rate" aria-describedby="rateHelp" required />
                                        <small id="rateHelp" class="form-text text-muted">Round to the nearest whole
                                            number.
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <br>
                    <div id="MemberTrainerFunc">
                        <div>
                            <h4>I am a...</h4>
                            <br>
                            <div class="form-check-inline">
                                <input class="form-check-input" type="radio" name="UserRadios" id="MemberRadio1"
                                    onclick="javascript:memberCheck();" value="member" />
                                <label class="form-check-label" for="MemberRadio1">
                                    Member
                                </label>
                            </div>
                            <div class="form-check-inline">
                                <input class="form-check-input" type="radio" name="UserRadios" id="TrainerRadio1"
                                    onclick="javascript:memberCheck();" value="trainer" />
                                <label class=" form-check-label" for="TrainerRadio1">
                                    Trainer
                                </label>
                            </div>
                            <div id="memberInfo" style="display:none">
                                <div class="row mb-3 mx-3" style="padding: 5px">
                                    Height:
                                    <div class="input-group px-0">
                                        <input aria-describedby="heightHelp" placeholder="Enter height" id="hite"
                                            type="number" class="form-control" name="height" required />
                                        <div class="input-group-append">
                                            <span id="heightHelp" class="input-group-text">inches</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3 mx-3" style="padding: 5px">
                                    Weight:
                                    <div class="input-group px-0">
                                        <input aria-describedby="weightHelp" placeholder="Enter weight" id="wate"
                                            type="number" class="form-control" name="weight" required />
                                        <div class="input-group-append">
                                            <span id="weightHelp" class="input-group-text">pounds</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3 mx-3" style="padding: 5px">
                                    Goal:
                                    <input aria-describedby="goalHelp" placeholder="Enter goal" id="gole" type="text"
                                        class="form-control" name="goal" required />
                                    <small style="text-align: left; padding-left: 0px" id="goalHelp"
                                        class="form-text text-muted">Briefly describe the goal you want Workout
                                        Generator to help you achieve.
                                    </small>
                                </div>
                            </div>
                            <div id="trainerInfo" style="display:none">
                                <div class="row mb-3 mx-3" style="padding: 5px">
                                    Specialty
                                    <input placeholder="Enter specialty" aria-describedby="specHelp" id="specs"
                                        type="text" class="form-control" name="specialty" required />
                                    <small id="specHelp" style="text-align: left; padding-left: 0px"
                                        class="form-text text-muted">e.g. Bodybuilding, Crossfit, etc.
                                    </small>

                                </div>
                                <div class="row mb-3 mx-3" style="padding: 5px">
                                    Experience:
                                    <div class="input-group px-0">
                                        <div class="col">
                                            <input placeholder="Enter experience" aria-describedby="expHelp" id="exp"
                                                type="number" class="form-control" name="experience" min="1" required />
                                            <small id="expHelp" style="padding-left: 0px; float: left"
                                                class="form-text text-muted">You
                                                must
                                                have at least one year of experience
                                                to become a trainer.
                                            </small>
                                        </div>
                                        <div class="input-group-append">
                                            <span class="input-group-text">years</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3 mx-3" style="padding: 5px">
                                    Certifications:
                                    <input placeholder="Enter certification" aria-describedby="certHelp" id="certs"
                                        type="text" class="form-control" name="certification" required />
                                    <small id="certHelp" style="text-align: left; padding-left: 0px"
                                        class="form-text text-muted">e.g. NASM, CrossFit L3, etc.
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <input type="submit" value="Create" name="btnAction" class="btn btn-dark" style="margin: 15px" />
                    <hr style="margin: 15px">
                    <br>
                    <p>Returning user? Login <a href="login.php">here</a></p>
                    <br>
            </form>
            <br>
            <br>
        </div>
    </center>
</body>

</html>