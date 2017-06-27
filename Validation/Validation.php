<?php
include('../DB/MySQLI.php');


function validate_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// YYYY-MM-DD Format(Limitation) too lazy to do over(TO-DO)
// '%y Year %m Month %d Day %h Hours %i Minute %s Seconds'        =>  1 Year 3 Month 14 Day 11 Hours 49 Minute 36 Seconds
// '%y Year %m Month %d Day'                                    =>  1 Year 3 Month 14 Days
// '%m Month %d Day'                                            =>  3 Month 14 Day
// '%d Day %h Hours'                                            =>  14 Day 11 Hours
// '%d Day'                                                        =>  14 Days
// '%h Hours %i Minute %s Seconds'                                =>  11 Hours 49 Minute 36 Seconds
// '%i Minute %s Seconds'                                        =>  49 Minute 36 Seconds
// '%h Hours                                                    =>  11 Hours
// '%a Days                                                        =>  468 Days
function dateDifferenceYears($date_1, $date_2, $differenceFormat = '%y') {
    $datetime1 = date_create($date_1);
    $datetime2 = date_create($date_2);
    $interval = date_diff($datetime1, $datetime2);
    return $interval->format($differenceFormat);
}

//Form Validation
function ValidateString($name) {
    if (empty($name)) {
        return "cannot be empty";
    } else {
        $name = validate_input($name);
// check if name only contains letters and whitespace
        if (!preg_match("/^[a-zA-Z ]*$/", $name)) {
            return "only letters and white space";
        } else {
            return 1;
        }
    }
}

function ValidateAlphaNumeric($alphanum) {
    if (empty($alphanum)) {
        return "cannot be empty";
    } else {
        $alphanum = validate_input($alphanum);
// check if name only contains letters, numbers and whitespace
        if (!preg_match("/^[a-zA-Z()0-9 ]*$/", $alphanum)) {
            return "only letters numbers and white space";
        } else {
            return 1;
        }
    }
}

function ValidateNumeric($num){ //can be used to validate phone numbers as well
    if (empty($num)) {
        return "cannot be empty";
    } else {
        $num = validate_input($num);
// check if name only contains numbers, '-', and whitespace
        if (!preg_match("/^[0-9 -]*$/", $num)) {
            return "only numbers and white space";
        } else {
            return 1;
        }
    }
}

function ValidateEmail($email) {
    global $connmysqli;
    if (empty($email)) {
        return "Email is required";
    } else {
        $email = validate_input($email);
// check if email is in valid format
        if (!preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/", $email)) {
            return "Invalid Email Format";
        } else {
            $emailtest = "call sp_CheckUserExist('$email')"; //stored procedure that checks if username exists
            $emailtestresult = mysqli_query($connmysqli, $emailtest);
            $row_emailtest = mysqli_fetch_array($emailtestresult, MYSQLI_ASSOC);
            
            if ($row_emailtest['@username_exists'] === '1') {
                return "Email already exists, contact Web Admin";
            } else {
                return 1;
            }
        }
    }
}
//ValidateEmail('a.thomas@test.com');

function ValidateDOB($dob) {
    if (empty($dob)) {
        return "DOB is required";
    } else {
        $DOB = date("d-m-Y", strtotime($dob));
        $currentDate = date("d-m-Y");
        if (dateDifferenceYears($DOB, $currentDate) < 18) {
            return "This person is too young to be access this website";
        } else {
            return 1;
        }
    }
}

//ValidateDatePast(05/20/2017);
function ComparePasswords($pass1, $pass2) {
    if (empty($pass1) || empty($pass2)) {
        return "both feilds should be filled";
    } else {
        if ($pass1 == $pass2) {
            return 1;
        } else {
            return "passwords do not match";
        }
    }
}

?>