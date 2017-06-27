<?php
include('../DB/MySQLI.php');
session_start();
header("refresh: 1801;");
$user_check = $_SESSION['login_user'];
$user_pass = $_SESSION['login_pass'];
$getcustid = "select CustomerId from UserAccess where UserName ='$user_check' and password = '$user_pass' ";
$ses_sql = mysqli_query($connmysqli, $getcustid);
$getcustid_row = mysqli_fetch_array($ses_sql, MYSQLI_ASSOC);
$_SESSION['custid']=$custid = $getcustid_row['CustomerId'];//get customer ID


$getcust = "select * from Customer where CustomerId = '$custid'";
$getcust_sql = mysqli_query($connmysqli, $getcust);
$getcust_row = mysqli_fetch_array($getcust_sql, MYSQLI_ASSOC);

$login_session = $getcust_row['CustomerId'];
$login_name = $getcust_row['FirstName']." ".$row['LastName'];

if (isset($_SESSION["login_user"])) {// ensures user times out after a certain time
    if ((time() - $_SESSION['last_time']) > 1800) { //time in secconds
        header("location:logout");
    } else {
        $_SESSION['last_time'] = time();
    }
} else {
    header("location:logout");
}
?>