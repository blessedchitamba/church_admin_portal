<?php
session_start();

include('functions.php');

$formEmail = "";
$formPass = "";
$loginError = "";
// if login form was submitted
if( isset( $_POST['login'] ) ) {
    
    // create variables
    // wrap data with validate function
    $formEmail = validateFormData( $_POST['email'] );
    $formPass = validateFormData( $_POST['password'] );
    
    // connect to database
    include('connection.php');
    
    // create query. nested query because we are selecting from two tables
    $query = "SELECT memberID, hashedPass, officeID FROM users WHERE memberID= 
                (SELECT memberID FROM member_register WHERE email = '$formEmail')";
    
    // store the result
    $result = mysqli_query( $conn, $query );

    //echo $name;
    
    // verify if result is returned
    if( mysqli_num_rows($result) > 0 ) {
        
        // store basic user data in variables
        while( $row = mysqli_fetch_assoc($result) ) {
            //$name       = $row['name'];
            $hashedPass = $row['hashedPass'];
            $user_id = $row['memberID'];
        }

        //echo $name;
        
        // verify hashed password with submitted password
        if( password_verify( $formPass, $hashedPass ) ) {
            
            // correct login details!
            // store data in SESSION variables
            $_SESSION['user_id'] = $user_id;

            //check if the user is not the group pastor
            $groupPastorID = "";
            $query = "SELECT memberID FROM users WHERE officeID= 
                (SELECT officeID FROM offices WHERE office= 'Group Pastor')";
            $result = mysqli_query( $conn, $query );
            if($result){
              while($row = mysqli_fetch_assoc($result)){
                $_SESSION['groupPastorID'] = $row['memberID'];
              }
            }
            if($_SESSION['groupPastorID']==$user_id){
               header( "Location: groupPastor.php" );
            } else {
              // redirect user to clients page
              header( "Location: profile.php" );
            }
        } else { // hashed password didn't verify
            
            // error message
            $loginError = "<div class='alert alert-danger'>Wrong username / password combination. Try again.</div>";
        }
        
    } else { // there are no results in database
        
        // error message
        $loginError = "<div class='alert alert-danger'>No such user in database. Please try again. <a class='close' data-dismiss='alert'>&times;</a></div>";
    }
    
}

//$password = password_hash("Blessed01", PASSWORD_DEFAULT);
//echo $password;


// close mysql connection
if(isset($conn)) {
  mysqli_close($conn);
}

include('header.php');
?>


      <h1>LW Group I Admin</h1>

      <?php echo $loginError; ?>
      <!--Form start-->
      <div class = "container-fluid">
          <div class = "row">
              <div class = "col-md-4 col-sm-4 col-xs-12"></div>
              <div class = "col-md-4 col-sm-4 col-xs-12">
                  <form class = "form-container" action="<?php echo htmlspecialchars( $_SERVER['PHP_SELF'] ); ?>" method="post">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Email address</label>
                        <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email" name = "email" value="<?php echo $formEmail; ?>">
                        <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Password</label>
                        <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password" name="password">
                    </div>
                    <div id = "logins">
                        <button type="submit" class="btn btn-success btn-block" name="login">Login</button>
                        <p>Don't have an account? <a href="signUp.php">Sign Up</a></p>
                    </div>
                  </form>
              </div>
              <div class = "col-md-4 col-sm-4 col-xs-12"></div>
          </div>
      </div> <!--Form end-->

<?php
include('footer.php');
?>