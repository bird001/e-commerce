<?php

include('../DB/MySQLI.php');
include('../Validation/Validation.php');
//include('../PHPMailer/SmtpMailer.php'); thinking of doing an email function, if not done already(TO-DO)

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //$functiontype = $_POST['Submit']; if more needed
    //if ($functiontype == 'Add') {
    $fname = $_POST['Fname'];
    $lname = $_POST['Lname'];
    $custemail = $_POST['CustEmail'];
    $custdob = $_POST['CustDOB'];
    $custtype = $_POST['CustType'];
    $points = $_POST['Points'];

    $valid_fname = ValidateString($fname);
    $valid_lname = ValidateString($lname);
    $valid_email = ValidateEmail($custemail);
    $valid_dob = ValidateDOB($custdob);
    $valid_type = ValidateAlphaNumeric($custtype);
    $valid_points = ValidateNumeric($points);

    if ($valid_fname == 1 && $valid_lname == 1 && $valid_email == 1 && $valid_dob == 1 &&
            $valid_type == 1 && $valid_points == 1) {
        $register = "insert into customer (FirstName, LastName, email, dob, CustomerType, Points) values "
                . "('$fname','$lname','$custemail','$custdob','$custtype','$points')";
        mysqli_query($connmysqli, $register);


        header('Location: ../Registration/reg.php');
    } else {
        //these will be passed as error messages if needs be
        session_start();
        $_SESSION['valid_fname'] = $valid_fname;
        $_SESSION['valid_lname'] = $valid_lname;
        $_SESSION['valid_email'] = $valid_email;
        $_SESSION['valid_dob'] = $valid_dob;
        $_SESSION['valid_type'] = $valid_type;
        $_SESSION['valid_points'] = $valid_points;
        
        header('Location: ../Registration/reg.php');
    }
}
?>