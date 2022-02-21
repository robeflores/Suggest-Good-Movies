<!----- PHP DEFINITIONS ------>
<?php

    class Webpage {
        protected $pdo; // keep track of the pdo object used to work with our mysql database and execute queries.

        /**
        * Connect to the database. Setup pdo object
        */
        function __construct() {
            $host = '127.0.0.1';
            $db = 'finalprojectdb';
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
        }

    }
?>
