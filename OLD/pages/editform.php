<!----- PHP DEFINITIONS ------>
<?php

    class Edit{
        private $pdo;
        private $row;
        private $id;

        function __construct() {
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
            $this->pdo = new PDO($dsn, $user, $pass, $opt);

            if(isset($_POST["databaseID"])){
                
                //get details from our car database at desired ID and display its fields
                $this->id = $_POST["databaseID"];
                $stmt = $this->pdo->query("SELECT Make, Model, Price, Color FROM cars WHERE id=$this->id");
                $this->row = $stmt->fetch();
            }
        }

        public function InsertMakeForm(){
            if(isset($_POST["databaseID"])){
                $make = $this->row['Make'];
                echo "<input type='text' name='editMake' id='makeEdit' value=$make required='required'>";
            }
        }

        public function InsertModelForm(){
            if(isset($_POST["databaseID"])){
                $model = $this->row['Model'];
                echo "<input type='text' name='editModel' id='modelEdit' value=$model required='required'>";
            }
        }

        public function InsertPriceForm(){
            if(isset($_POST["databaseID"])){
                $price = $this->row['Price'];
                echo "<input type='text' name='editPrice' id='priceEdit' value=$price required='required'>";
            }
        }

        public function InsertColorForm(){
            if(isset($_POST["databaseID"])){
                $color = $this->row['Color'];
                echo "<input type='text' name='editColor' id='colorEdit' value=$color required='required'>";
            }
        }

        public function InsertIDForm(){
            if(isset($_POST["databaseID"])){
                echo "<input type='text' name='editID' id='editID' value='$this->id' readonly='readonly'>";
            }
        }

        public function InsertDeleteForm(){
            echo "
                <form action='../index.php' method='post'>
                    <button type='submit' name='deleteID' value='$this->id' class='btn btn-danger mt-2'>DELETE</button>
                </form>
            ";
        }
    }

    $edit = new Edit();

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
    
    
<!-- Edit form section -->
<hr class="my-4">
    <div class="container">
  <div class="row">
    <div class="col col-lg-4"></div>
    <div class="col-md-auto">    
    
        <h1>Edit Car entry</h1>
        <br>


        <form action="../index.php" method="post">

        <p><label for="makeEdit">Make:</label>
        <?php
            $edit->InsertMakeForm();
        ?>
        </p>
        
        <p><label for="modelEdit">Model:</label>
        <?php
            $edit->InsertModelForm();
        ?>
        </p>

        <p><label for="priceEdit">Price:</label>
        <?php
            $edit->InsertPriceForm();
        ?>
        </p>

        <p><label for="colorEdit">Color:</label>
        <?php
            $edit->InsertColorForm();
        ?>
        </p>

        <p><label for="editID">ID:</label>
        <?php
            $edit->InsertIDForm();
        ?>
        </p>

        <input type="submit" value="Submit" > <input type="reset" value="Reset">
        </form>

        <?php
            $edit->InsertDeleteForm();
        ?>

      </div>
    <div class="col col-lg-4"></div>
  </div>
</div>
<hr class="my-4">
      
    

    
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