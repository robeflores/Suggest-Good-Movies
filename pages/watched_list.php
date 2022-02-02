<?php
    require_once "../webpage.php";
    session_start(); // must be included for stored session variables to work

    //kick user back to index if they are not signed in
    if( !isset( $_SESSION["id"] ) ){
        header("location: ../index.php");
        exit();
    }

    class WatchedList extends Webpage{
        /**
        * display table of movies in watched list to user
        */
        public function DisplayTable(){
            $sql = " SELECT u.*, m.*
                FROM user u
                INNER JOIN user_movie um
                ON um.um_user = u.id
                INNER JOIN movie m
                ON m.id = um.um_movie
                WHERE u.id = ?
            ";

            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([ $_SESSION["id"] ]);
            
            echo "
            <table id='watched'>
                <tr>
                    <th>Title</th>
                    <th>Year</th>
                    <th>Genre</th>
                    <th>IMDb Rating</th>
                    <th></th>
                </tr>
            ";

            //display each record that is in the user's watched list to a row in the html table
            $result = $stmt->fetchAll();
            foreach( $result as $row ) {
                echo "<tr>";

                $id = $row["ID"];

                $title = $row["Title"];
                echo "<td> $title </td>";

                $year = $row["Year"];
                echo "<td> $year </td>";

                $genre = $row["Genre"];
                echo "<td> $genre </td>";

                $rating = $row['IMDb Rating'];
                echo "<td> $rating </td>";

                //button for removing movie from the user's watched list
                echo "
                    <form method='post'>
                        <td> <button class='btn btn-danger mr-1 rowButton' type='button' name='movieIDToRemove' value='$id'>Remove</button> </td>
                    </form>
                ";

                echo "</tr>";
            }
            echo "</table>";
        }

    }

    $watchedList = new WatchedList();
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Watched List</title>
    
    <!-- import bootstrap -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    
    <!-- import jquery -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    
	<link href="../index.css" rel="stylesheet">

    <style>
        /*---Table---*/
        #watched {
            font-family: Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }
        
        #watched td, #watched th {
            border: 1px solid #ddd;
            padding: 8px;
        }
        
        #watched tr:nth-child(even){background-color: #f2f2f2;}
        
        #watched tr:hover {background-color: #ddd;}
        
        #watched th {
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: left;
            background-color: #4CAF50;
            color: white;
        }
    </style>

    <script>
        //uses AJAX to call php to remove row
        $(document).ready(function() {
	        $('.rowButton').on('click', function() {
                $(this).closest("tr").remove(); // remove the html row

                // asyncronously run the php script to remove the movie from the watched list
                $.ajax({
                    url: "update_watched_list.php",
                    type: "POST",
                    data: {
                        movieIDToRemove: $(this).val()
                    },
                    success: function(){},
                    error:function (){}
                    
                });

            });
        });
    </script>


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
    
    
<!-- Watched list table Section -->
<hr class="my-4">
    <div class="container">
  <div class="row">
    <div class="col col-lg-3"></div>
    <div class="col-md-auto">    

        <h1>Manage watched list:</h1>
        <br>

        <?php
            //generate the table
            $watchedList->DisplayTable();
        ?>
        

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


    
