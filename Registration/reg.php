<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>TODO supply a title</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body bgcolor="#FFFFFF">
        <br>
        <div align="left" class = "form-group">
            <div style="width:500px;" class = "form-group" align="left">

                <form action="registration.php" method="post" id="form1" class = "form-group" role="form" >

                    <div class="form-group">
                        <label for="inputFName" class="control-label">First Name</label>
                        <input type="text" name="Fname" id="Fname" class="form-control" placeholder="John" required/>


                    </div>

                    <div class="form-group">
                        <label for="inputLName" class="control-label">Last Name</label>
                        <input type="text" name="Lname" id="Lname" class="form-control" placeholder="Hancock" required/>

                    </div>

                    <div class="form-group">
                        <label for="inputEmail" class="control-label">Email</label>
                        <input type="email" name="CustEmail" id="CustEmail" class="form-control" placeholder="j.hancock@tipfriendly.com" 
                               data-error="Email address is invalid" required/>
                        <span class="error"> 
                            <?php
                            session_start();
                            if ($_SESSION['valid_email'] != 1) {
                                $error = $_SESSION['valid_email'];
                                echo $error;
                                unset($_SESSION['valid_email']);
                            }
                            ?>
                        </span>
                    </div>

                    <div class="form-group">  
                        <label for="inputDOB" class="control-label">D.O.B</label>
                        <input type="date" name="CustDOB" id="CustDOB" class="form-control"  required/>

                    </div>

                    <div class="form-group">
                        <label for="inputCustType" class="control-label">Customer Type</label>
                        <input type="text" name="CustType" id="CustType" class="form-control" placeholder="8765555555" required/>
                        <span class="error"> 
                        </span>
                    </div>

                    <div class="form-group">
                        <label for="inputPoints" class="control-label">Points</label>
                        <input type="number" name="Points" id="Points" class="form-control" required/>
                        <span class="error"> 
                        </span>
                    </div>
                    <input class="btn btn-primary" type="submit" name="Submit" id ="Reister" value="Register"/> 

                </form>
            </div>

        </div>
    </body>
</html>
