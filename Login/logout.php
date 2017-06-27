<?php
include('../DB/MySQLI.php');
include("../Login/session.php");
$_SESSION = array();
unset($_COOKIE);//destroy cookies and sessions
unset($_SESSION);
//update userlog table with logout times
/*
$sql_users = "UPDATE
      new_mega_mart.UserLog
      SET
      new_mega_mart.UserLog.TimeLoggedOut = now()
      WHERE
      new_mega_mart.UserLog.EmpEmail = '$user_check' and
      new_mega_mart.UserLog.TimeLoggedIn < now() order by new_mega_mart.UserLog.TimeLoggedIn desc limit 1"; //a log of users that have logged out this app
mysqli_query($connmysqli, $sql_users); //execute the statement
 * 
 */
session_destroy(); //completely destroy the session
header("Location: ../Login/login.html");//redirect to login page
?>