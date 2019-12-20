<?php
session_start();

include("header.php");
include('functions.php');

//no need to start session in this case. We will redirect user to login page after
//creating an account. 

$formName="";
$formSurname="";
$formEmail="";
$formOffice="";
$errorMsg="";

// if sign up form was submitted
if( isset( $_POST['signUp'] ) ) {
    // connect to database
    include('connection.php');

    // create variables
    // wrap data with validate function
    $formName = validateFormData( $_POST['name']);
    $formSurname = validateFormData( $_POST['surname']);
    $formEmail = validateFormData( $_POST['email'] );
    $formOffice = validateFormData( $_POST['office'] );
    $formPass = validateFormData( $_POST['password'] );
    $formConfirmPass = validateFormData( $_POST['confirmPassword'] );

    //if name is empty
    if( $formName=="" || $formSurname=="") {
    	$errorMsg = "<div class='alert alert-danger'>Name/Surname/Office cannot be empty.<a class='close' data-dismiss='alert'>&times;</a></div>";
    } 
    elseif( (strlen($formPass) < 6) && ($errorMsg=="")) {  //if password too short
    	$errorMsg = "<div class='alert alert-danger'>Password must have at least 6 characters.<a class='close' data-dismiss='alert'>&times;</a></div>";
    }
    elseif( ($formPass != $formConfirmPass) && ($errorMsg=="")) {
    	$errorMsg = "<div class='alert alert-danger'>Passwords do not match. Try again.<a class='close' data-dismiss='alert'>&times;</a></div>";
    }
    

    // check if email is used
    $query = "SELECT * FROM users WHERE memberID = (SELECT memberID FROM member_register WHERE email = '$formEmail') LIMIT 1";

    // store the result
    $result = mysqli_query( $conn, $query );

    if( mysqli_num_rows($result) != 0 ) {
        $errorMsg = "<div class='alert alert-danger'>This email is already in use.<a class='close' data-dismiss='alert'>&times;</a></div>";
    } elseif( !filter_var($formEmail, FILTER_VALIDATE_EMAIL) ) {
        $errorMsg = "<div class='alert alert-danger'>Please enter a valid email.<a class='close' data-dismiss='alert'>&times;</a></div>";
    }

    //proceed if there are no password errors
    if( $errorMsg=="") {
	    
        //check if the person exists in members table
        $query = "SELECT * FROM member_register WHERE email = '$formEmail' LIMIT 1";
        $result = mysqli_query( $conn, $query );

        $hashedPass = password_hash($formPass, PASSWORD_DEFAULT);
        //. if member exists, add them to users
        if(mysqli_num_rows($result) != 0 ){
            //user exists in members
            $query = "INSERT INTO users(memberID, hashedPass, officeID) VALUES(
                            (SELECT memberID FROM member_register WHERE name = '$formName'), '$hashedPass', 
                            (SELECT officeID FROM offices WHERE office = '$formOffice'))";
            $result = mysqli_query( $conn, $query );
        } else {
            //user does not exist in members; add them first. Add the other values as null values and update them when they log in first time
            $query = "INSERT INTO member_register(name, surname, email, phone_number, university, degree, year_of_study)
                            VALUES('$formName', '$formSurname', '$formEmail', NULL, NULL, NULL, NULL)";
            $result = mysqli_query( $conn, $query );

            //then add them to users
            $query = "INSERT INTO users(memberID, hashedPass, officeID) VALUES(
                            (SELECT memberID FROM member_register WHERE name = '$formName'), '$hashedPass', 
                            (SELECT officeID FROM offices WHERE office = '$formOffice'))";
            $result = mysqli_query( $conn, $query );
        }

        if( $result) {
            //redirect to success page
            header( "Location: success.php?" );
        } else {
             // something went wrong
            echo "Error: ". $query ."<br>" . mysqli_error($conn);
        }
	    
	    // insert into table
	   //hash the password
    }
    
}

//$password = password_hash("Blessed01", PASSWORD_DEFAULT);
//echo $password;


// close mysql connection
if(isset($conn)) {
  mysqli_close($conn);
}
?>

          <h1>Sign Up!</h1>

          <?php echo $errorMsg; ?>
          <!--Form start-->
          <div class = "container-fluid">
              <div class = "row">
                  <div class = "col-md-4 col-sm-4 col-xs-12"></div>
                  <div class = "col-md-4 col-sm-4 col-xs-12">
                      <form class = "form-container" action="<?php echo htmlspecialchars( $_SERVER['PHP_SELF'] ); ?>" method="post">
                            <div class="form-group">
                                <label for="InputName">First name</label>
                                <input type="text" class="form-control" id="InputName" placeholder="First name" name="name" value="<?php echo $formName; ?>">
                            </div>
                            <div class="form-group">
                                <label for="InputName">Surname</label>
                                <input type="text" class="form-control" id="InputSurname" placeholder="Surname" name="surname" value="<?php echo $formSurname; ?>">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Email address</label>
                                <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email" 
name="email" value="<?php echo $formEmail; ?>">
                                <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Password</label>
                                <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password" name="password">

                                <small id="passwordHelp" class="form-text text-muted">Password must be at least 6 characters long.</small>
                            </div>
                            <div class="form-group">
                                <label for="confirmPassword">Confirm Password</label>
                                <input type="password" class="form-control" id="confirmPassword" placeholder="Password" name="confirmPassword">
                            </div>
                            <div class="form-group">
                                <label for="userOffice">Office</label>
                                <?php
                                    include('connection.php');
                                    $query= "SELECT * FROM offices";
                                    $result = mysqli_query( $conn, $query );
                                    if(mysqli_num_rows($result) > 0 ) {
                                        echo "<select id='userOffice' name='office'>";
                                        echo "<option value=''>Select office...</option>";
                                        while ($row=   mysqli_fetch_assoc($result) )
                                        {
                                            //echo "<option value='' >Hello there</option>";
                                            echo "<option value='".htmlspecialchars($row["office"])."' >".htmlspecialchars($row["office"])."</option>";
                                        }
                                        echo "</select>";
                                        }
                                    mysqli_close($conn);
                                ?>
                            </div>

                            <button type="submit" class="btn btn-success btn-block" name="signUp">Sign Up</button>
                      </form>
                  </div>
                  <div class = "col-md-4 col-sm-4 col-xs-12"></div>
              </div>
          </div> <!--Form end-->

<?php
include("footer.php");
?>
