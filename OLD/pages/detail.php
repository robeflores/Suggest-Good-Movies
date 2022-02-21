<!----- PHP DEFINITIONS ------>
<?php
    class Detail{
        public function DisplayDetails(){
            if(isset($_GET["databaseID"])){
                //log in
                $host = '127.0.0.1';
                $db = 'car_sales';
                $user = 'root';
                $pass = '';
                $charset = 'utf8';
                $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
                $opt = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
                ];
                $pdo = new PDO($dsn, $user, $pass, $opt);

                //get details from our car database at desired ID and display its fields
                $id = $_GET["databaseID"];
                $stmt = $pdo->query("SELECT Make, Model, Price, Color FROM cars WHERE id=$id");
                $row = $stmt->fetch();

                $make = $row['Make'];
                echo "<p>Make: $make </p>";

                $model = $row['Model'];
                echo "<p>Model: $model </p>";

                $price = $row['Price'];
                echo "<p>Price: $price </p>";

                $color = $row['Color'];
                echo "<p>Color: $color </p>";
            }
        }
    }

    $detail = new Detail();
?>


<!----- HTML ------>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Home</title>
    
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
<div class="d-flex justify-content-center">
    <a class="navbar-brand" href="../index.php" >Assignment 5</a>
</div>
</nav>
    
<!-- Display info section -->
<div class="container-fluid padding">
    <div class="row text-center">
        <div class="col-md-12">
            <h1>Car details</h1>
            <br>

            <?php
                $detail->DisplayDetails();
            ?>
        </div>
    </div>
</div>
    
    
    
<!--- Footer -->
<footer class="fixed-bottom">
    <div class="container-fluid padding">
        <div class="row text-center">
            <div class="col-md-12">
                <p>Heriberto Flores</p>
                <p>INF 653</p>
                <p>h_flores@fhsu.mail.edu</p>
            </div>
        </div>
    </div>
</footer>

</body>
</html>