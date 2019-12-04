<?php
session_start();

include("header.php");
include('functions.php');

//no need to start session in this case. We will redirect user to login page after
//creating an account. 

$formName="";
$formSurname="";
$formEmail="";
$errorMsg="";

// if sign up form was submitted
if( isset( $_POST['signUp'] ) ) {

    // create variables
    // wrap data with validate function
    $formName = validateFormData( $_POST['name']);
    $formSurname = validateFormData( $_POST['surname']);
    $formEmail = validateFormData( $_POST['email'] );
    $formPass = validateFormData( $_POST['password'] );
    $formConfirmPass = validateFormData( $_POST['confirmPassword'] );

    //if name is empty
    if( $formName=="" || $formSurname=="") {
    	$errorMsg = "<div class='alert alert-danger'>Name/Surname cannot be empty.<a class='close' data-dismiss='alert'>&times;</a></div>";
    } 
    elseif( (strlen($formPass) < 6) && ($errorMsg=="")) {  //if password too short
    	$errorMsg = "<div class='alert alert-danger'>Password must have at least 6 characters.<a class='close' data-dismiss='alert'>&times;</a></div>";
    }
    elseif( ($formPass != $formConfirmPass) && ($errorMsg=="")) {
    	$errorMsg = "<div class='alert alert-danger'>Passwords do not match. Try again.<a class='close' data-dismiss='alert'>&times;</a></div>";
    }
    
    //proceed if there are no password errors
    if( $errorMsg=="") {
	    // connect to database
	    include('connection.php');
	    
	    // check if email is used
	    $query = "SELECT * FROM users WHERE Email = '$formEmail' LIMIT 1";

	    // store the result
    	$result = mysqli_query( $conn, $query );

    	if( mysqli_num_rows($result) != 0 ) {
        	$errorMsg = "<div class='alert alert-danger'>This email is already in use.<a class='close' data-dismiss='alert'>&times;</a></div>";
        } elseif( !filter_var($formEmail, FILTER_VALIDATE_EMAIL) ) {
        	$errorMsg = "<div class='alert alert-danger'>Please enter a valid email.<a class='close' data-dismiss='alert'>&times;</a></div>";
        }
	    // insert into table
	   //hash the password
    }

    //proceed if no password and email errors
    if( $errorMsg=="") {
    	//hash password and insert it
    	$hashedPass = password_hash($formPass, PASSWORD_DEFAULT);
    	$query = "INSERT INTO users(Name, Surname, Email, Password) VALUES('$formName', '$formSurname', 
    				'$formEmail', '$hashedPass')";

    	$result = mysqli_query( $conn, $query );

    	if( $result) {
    		//redirect to success page
    		header( "Location: success.php?" );
    	} else {
    		 // something went wrong
            echo "Error: ". $query ."<br>" . mysqli_error($conn);
    	}
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
                            <button type="submit" class="btn btn-success btn-block" name="signUp">Sign Up</button>
                      </form>
                  </div>
                  <div class = "col-md-4 col-sm-4 col-xs-12"></div>
              </div>
          </div> <!--Form end-->

<?php
include("footer.php");
?>
