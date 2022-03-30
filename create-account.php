<?php
    require('connect-db.php');
    require('user-db.php');
    if($_SERVER["REQUEST_METHOD"]=="POST")
    {
        if (!empty($_POST['btnAction']) && $_POST['btnAction'] == "Create")
        {
            addUser($_POST['username'], $_POST['password'], $_POST['gym_address']);
            header("location:dashboard.php");
            echo "success";
            if ($_POST['UserRadios'] == 'member') {
                addUserAsMember($_POST['username'], $_POST['height'], $_POST['weight'], $_POST['goal'] );
            }
            if ($_POST['UserRadios'] == 'trainer') {
                addUserAsTrainer($_POST['username'], $_POST['specialty'], $_POST['experience'], $_POST['certification'] );
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
            document.getElementById('memberInfo').style.display = 'block';
            document.getElementById('trainerInfo').style.display = 'none';

        } else if (document.getElementById('TrainerRadio1').checked) {
            document.getElementById('trainerInfo').style.display = 'block';
            document.getElementById('memberInfo').style.display = 'none';
        }
    }
    </script>
</head>

<body>
    <nav class="navbar navbar-dark bg-dark">
        <a class="navbar-brand mx-3" href="dashboard.php">Workout Generator</a>
        <div class="nav-item mx-3">
            <span class="navbar-text mx-3">
                Welcome
            </span>
        </div>
    </nav>
    <center>
        <div class="bg-light" style="width: 50%; border-radius: 15px; margin-top: 50px">
            <h1 style="padding-top: 30px">Create an Account.</h1>
            <form name="mainForm" action="create-account.php" method="post">
                <div class="row mb-3 mx-3" style="padding: 5px">
                    Username:
                    <input type="text" class="form-control" name="username" required />
                </div>
                <div class="row mb-3 mx-3" style="padding: 5px">
                    Password:
                    <input type="password" class="form-control" name="password" required />
                </div>
                <div class="row mb-3 mx-3" style="padding: 5px">
                    Gym Address:
                    <input type="text" class="form-control" name="gym_address" required />
                </div>
                <br>
                <div id="MemberTrainerFunc">
                    <div>
                        <h4>I am a...</h4>
                        <div class="form-check-inline">
                            <input class="form-check-input" type="radio" name="UserRadios" id="MemberRadio1"
                                onclick="javascript:memberCheck();" value="member">
                            <label class="form-check-label" for="MemberRadio1">
                                Member
                            </label>
                        </div>
                        <div class="form-check-inline">
                            <input class="form-check-input" type="radio" name="UserRadios" id="TrainerRadio1"
                                onclick="javascript:memberCheck();" value="trainer">
                            <label class=" form-check-label" for="TrainerRadio1">
                                Trainer
                            </label>
                        </div>
                        <div id="memberInfo" style="display:none">
                            <div class="row mb-3 mx-3" style="padding: 5px">
                                Height:
                                <input type="text" class="form-control" name="height" required />
                            </div>
                            <div class="row mb-3 mx-3" style="padding: 5px">
                                Weight:
                                <input type="number" class="form-control" name="weight" required />
                            </div>
                            <div class="row mb-3 mx-3" style="padding: 5px">
                                Goal:
                                <input type="text" class="form-control" name="goal" required />
                            </div>
                        </div>
                        <div id="trainerInfo" style="display:none">
                            <div class="row mb-3 mx-3" style="padding: 5px">
                                Specialty:
                                <input type="text" class="form-control" name="specialty" />
                            </div>
                            <div class="row mb-3 mx-3" style="padding: 5px">
                                Experience:
                                <input type="number" class="form-control" name="experience" />
                            </div>
                            <div class="row mb-3 mx-3" style="padding: 5px">
                                Certifications:
                                <input type="text" class="form-control" name="certifications" />
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
        </div>
    </center>
</body>

</html>