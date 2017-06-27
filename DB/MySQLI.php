<?php
    $dbHost = 'localhost';  //database host name
    $dbUser = 'root';       //database username
    $dbPass = 'toor';           //database password
    $dbName = 'new_mega_mart'; //database name
    $connmysqli = mysqli_connect($dbHost,$dbUser,$dbPass,$dbName);
    if(!$connmysqli){
        die("Database connection failed: " . mysqli_connect_error());
    }
?>