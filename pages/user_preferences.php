<?php
    require_once "../webpage.php";
    session_start(); // must be included for stored session variables to work

    //kick user back to index if they are not signed in
    if( !isset( $_SESSION["id"] ) ){
        header("location: ../index.php");
        exit();
    }

    class UserPreferences extends Webpage{

    }

    $userPreferences = new UserPreferences();
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>User Preferences</title>
    
    <!-- import bootstrap -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    
    <!-- import jquery -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    
	<link href="../index.css" rel="stylesheet">
</head>
<body>

<!-- Navigation -->
<nav class="navbar navbar-expand-md navbar-light bg-light sticky-top">

    <a class="navbar-brand" href="../index.php" >FINAL PROJECT - Random Movie Generator</a>


    <form action="../index.php" method="post">
        <button type="submit" class="btn btn-success mr-1" name="generateMovie" value="True">GENERATE</button>
    </form>

    <div class="navbar-nav ml-auto">
        <?php
            // if a user is not logged in, display a 'sign in' button
            if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
                echo "<button onclick='document.location=\"sign_in.php\"' class='btn btn-primary mr-1'>Sign in/Sign up</button>";
            }
            //otherwise display the username and a log out button
            if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] == true){
                $username = $_SESSION['username'];
                echo "
                    <p class='lead mt-1 mr-2'>Welcome, <a href='user_preferences.php'>$username</a> </p>
                ";

                echo "
                    <form action='../index.php' method='post'>
                        <button type='submit' name='logOut' value='true' class='btn btn-danger mr-1'>Logout</button>
                    </form>
                ";
            }
        ?>
    </div>


</nav>
    
    
<!-- User preferences Section -->
<hr class="my-4">
    <div class="container">
  <div class="row">
    <div class="col col-lg-4"></div>
    <div class="col-md-auto">    

        <?php
            // greet user
            $username = $_SESSION['username'];
            echo "
                <h1>Welcome, $username</h1>
                <br>
            ";
        ?>
        <!-- Display menu to user -->
        <ul>
            <li class="mb-2"><a href="change_password.php">change password</a></li>
            <li><a href="watched_list.php">manage watched list</a></li>
        </ul>

      </div>
  </div>
</div>
<hr class="my-4">
      

    
<!--- Footer -->
<footer class="fixed-bottom">
    <div class="container-fluid padding">
        <p class="text-center">Heriberto Flores</p>
        <p class="text-center">INF 653</p>
        <p class="text-center">h_flores@fhsu.mail.edu</p>
    </div>
</footer>

</body>
</html>


    
