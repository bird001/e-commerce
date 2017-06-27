<?php

include ("../DB/MySQLI.php");
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = mysqli_real_escape_string($connmysqli, $_POST['loginusername']); //change to username 
    $password = mysqli_real_escape_string($connmysqli, $_POST['loginpassword']); //md5() to encrypt

    $sql_usercheck = "call sp_CheckUserExist('$email')";
    $result_usercheck = mysqli_query($connmysqli, $sql_usercheck);
    $row_usercheck = mysqli_fetch_array($result_usercheck, MYSQLI_ASSOC);
    $usercheck = $row_usercheck['@username_exists'];
    //$usercheck = mysqli_num_rows($result_usercheck);
    // If result matched $myusername and $mypassword, table row must be 1 row
    if ($usercheck === '1') {
        /*
          $sql_users = "insert into new_mega_mart.UserLog
          (User,TimeLoggedIn)
          select
          email, now()
          from
          new_mega_mart.Users
          where
          email = '$email'"; //a log of users that have logged into this app
          mysqli_query($connmysqli, $sql_users); //execute the statement
         */

        $_SESSION['login_user'] = $email;
        $_SESSION['login_pass'] = $password;
        $_SESSION['last_time'] = time();
        header("location: ../Login/profile.php");
    } else {
        echo $error = "invalid user";
        header("location: ../Login/login.html?error=" . $error);
    }

    /*
      if ($usercheck === 1 && $checkpassword === '0') {
      header("location: changepassword");
      }
     * */
}
?>