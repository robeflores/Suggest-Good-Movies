<?php
    require_once "../webpage.php";
    session_start(); // must be included for stored session variables to work

    //kick user back to index if they are signed in already
    if( isset( $_SESSION["id"] ) ){
        header("location: ../index.php");
        exit();
    }


    class Signin extends Webpage{
        private $row; // tracks the record within the user database corresponding to the info the user submits

        /**
        * sign the user in if they have submitted the form after entering their credentials in.
        */
        public function ProcessSignin(){
            //if the user did not submit the form, return
            if( !isset($_POST["username"]) )
                return;

            // if credentials match, then sign in is succesful
            if($this->CheckIfCredentialsMatch()){
                            
                // Store data in session variables
                $_SESSION["loggedin"] = true;
                $_SESSION["id"] = $this->row['id'];
                $_SESSION["username"] = $this->row['username'];                            
                
                // Redirect user to index page
                header("location: ../index.php");

                
            }           
        }

        /**
        * query the database in order to verify that the user's credentials exists in the database.
        */
        public function CheckIfCredentialsMatch(){
            $sql = "SELECT id, username, password FROM user WHERE username = ?";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([ $_POST["username"] ]);

            // if user exists
            if($stmt->rowCount() == 1){
                $this->row = $stmt->fetch();

                //if password matches the user
                if(password_verify( $_POST["password"], $this->row['password']))
                    return true; // then user exists, return true
            }

            //otherwise no such user exists with the username/password combination
            return false;
        }
    }

    $signin = new Signin();
    $signin->ProcessSignin();
?>



<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Sign-in</title>
    
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
    
    
<!-- Sign-in form Section -->
<hr class="my-4">
    <div class="container">
  <div class="row">
    <div class="col col-lg-4"></div>
    <div class="col-md-auto">    

        <h1>Sign in</h1>
        <br>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

        <?php
            // if the entered credentials do not exist, print message to user
            if(isset($_POST["username"]) && !$signin->CheckIfCredentialsMatch()){
                echo "<p class='mb-5' style='color: red;'>Invalid username or password.</p>";
                
            }
        ?>

        <p><label for="inputUN">username:<sup>*</sup></label>
        <input type="text" name="username" id="inputUN" required='required'>
        </p>

        <p><label for="inputPW">password:<sup>*</sup></label>
        <input type="text" name="password" id="inputPW" required='required'>
        </p>

        <input type="submit" value="Submit" > <input type="reset" value="Reset">
        </form>

        <p class="mt-5">No account? <a href="sign_up.php">Sign up.</a> </p>

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


    
