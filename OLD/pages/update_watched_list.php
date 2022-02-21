<?php
    session_start();

    //log in
    $servername = "localhost";
    $username="root";
    $password="";
    $db="finalprojectdb";
    $conn = mysqli_connect($servername, $username, $password, $db);


    //add the movie to watched list if that is the action that has been submitted
    if(isset( $_POST["movieIDToAdd"] )){
        $movieID = $_POST["movieIDToAdd"];
        $userID = $_SESSION["id"];

        $sql = "INSERT INTO `user_movie` (`um_id`, `um_user`, `um_movie`) VALUES (NULL, ?, ?)";
        $stmt = $conn->prepare($sql);

        $stmt->bind_param('sd', $userID, $movieID);
        $stmt->execute();
    }

    //remove the movie from watched list if that is the action submitted by a form
    if(isset( $_POST["movieIDToRemove"] )){
        $movieID = $_POST["movieIDToRemove"];
        $userID = $_SESSION["id"];

        $sql = "DELETE FROM user_movie
            WHERE um_user = ? AND um_movie = ?
        ";

        $stmt = $conn->prepare($sql);
        
        $stmt->bind_param('sd', $userID, $movieID);
        $stmt->execute();

    }

    mysqli_close($conn);
?>