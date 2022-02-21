<?php
    require_once "../webpage.php";
    session_start(); // must be included for stored session variables to work

    //kick user back to index if they are signed in already
    if( isset( $_SESSION["id"] ) ){
        header("location: ../index.php");
        exit();
    }


    class Signup extends Webpage{
        /**
        * create a new record using the credentials submitted by the user in our database
        */
        public function ProcessSignup(){
            //if the user did not submit the form, do not do anything
            if( !isset($_POST["username"]) )
                return;

            if(!$this->CheckIfUsernameTaken()){

                //add new user to database
                // Prepare an insert statement
                $sql = "INSERT INTO user (username, password) VALUES (:username, :password)";
                
                if($stmt = $this->pdo->prepare($sql)){
                    // Set parameters
                    $username = $_POST["username"];
                    $password = password_hash($_POST["password"], PASSWORD_DEFAULT); // encrypts the password by creating a password hash

                    // Bind variables to the prepared statement as parameters
                    $stmt->bindParam(":username", $username, PDO::PARAM_STR);
                    $stmt->bindParam(":password", $password, PDO::PARAM_STR);
                    
                    // Attempt to execute the prepared statement
                    if($stmt->execute()){
                        // Redirect to login page
                        header("location: sign_in.php");
                    }
                }
            }           
        }

        /**
        * check to see if the username submitted matches any record in the user table. prevents duplicates of users with same username
        */
        public function CheckIfUsernameTaken(){
            if( !isset($_POST["username"]) )
                return;

            //check if username is taken
            $sql = "SELECT id FROM user WHERE username = ?";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([ $_POST["username"] ]);
            if($stmt->rowCount() == 1)
                return true;
            return false;
        }

    }

    $signup = new Signup();
    $signup->ProcessSignup();
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Sign-up</title>
    
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
        <button onclick="document.location='sign_in.php'" class="btn btn-primary mr-1">Sign in/Sign up</button>
    </div>


</nav>
    
    
<!-- Sign-up form Section -->
<hr class="my-4">
    <div class="container">
  <div class="row">
    <div class="col col-lg-4"></div>
    <div class="col-md-auto">    

        <h1>Sign up</h1>
        <br>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

        <p><label for="inputUN">new username:<sup>*</sup></label>
        <input type="text" name="username" id="inputUN" required='required' maxlength="20">
        </p>

        <?php
            // if username is taken, print message
            if($signup->CheckIfUsernameTaken()){
                echo "<p class='mb-5' style='color: red;'>This username is already taken.</p>";
                
            }
        ?>



        <p><label for="inputPW">new password:<sup>*</sup></label>
        <input type="text" name="password" id="inputPW" required='required' maxlength="20">
        </p>

        <input type="submit" value="Submit" > <input type="reset" value="Reset">
        </form>

        <p class="mt-5">Already have an account? <a href="sign_in.php">Sign in.</a> </p>

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


    
