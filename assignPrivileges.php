<?php
session_start();

if( (!$_SESSION['user_id']) && (!$_SESSION['groupPastorID']==$_SESSION['user_id']) ) {
    
    // send them to the login page
    header("Location: index.php");
}

include("header.php");
include('functions.php');

//no need to start session in this case. We will redirect user to login page after
//creating an account. 
$errorMsg = "";
$formInputs = array(); //array for our user inputs

$formName="";
$formSurname="";

// if addData was pressed
if( isset( $_POST['add'] ) ) {
    // connect to database
    include('connection.php');

    // create variables
    // wrap data with validate function
    $formName = validateFormData( $_POST['name']);
    $formSurname = validateFormData( $_POST['surname']);
    
    //loop through the user inputs and validate them
    for($i=1; $i<sizeof($columnNames); $i++){
        $formInputs[$i-1] = validateFormData( $_POST[$i]);
    }

    //proceed if there are no password errors
    if( $errorMsg=="") {
	    
        //do the insert of the data. select the appropriate memberID first
        $columns = implode("`, `", $columnNames);
        $inputs = implode("', '", $formInputs);
        $query = "INSERT INTO ".$_SESSION['tb_name']."(`$columns`) VALUES (
                    (SELECT memberID FROM member_register WHERE name = '$formName' AND surname='$formSurname'), 
                    '$inputs')";
        $result = mysqli_query( $conn, $query );

        if( $result) {
            echo "<div class='alert alert-success' role='alert'>Entry added successfully!<a class='close' data-dismiss='alert'>&times;</a></div>";
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

          <?php echo $errorMsg; ?>
          <!--Form start-->
          <div class = "container-fluid">
              <div class = "row">
                  <div class = "col-md-4 col-sm-4 col-xs-12"></div>
                  <div class = "col-md-4 col-sm-4 col-xs-12">
                      <form class = "form-container" action="<?php echo htmlspecialchars( $_SERVER['PHP_SELF'] ); ?>" method="post">

                            <!--For the other table input fields-->
                            <?php
                                // connect to database
                                include('connection.php');
                                $query = "SELECT office FROM offices WHERE officer IS NULL";
                                $result = mysqli_query( $conn, $query );
                                $i = 0;
                                if(mysqli_num_rows($result) > 0 ){ 
                                  echo "<h3>Enter correct name and surname of each officer to be assigned below:</h3><br>";
                                  while($row = mysqli_fetch_assoc($result)){ 
                                      echo "<div class='form-group'>
                                                  <label for='".$i."'>".$row['office']."</label>
                                                  <input type='text' class='form-control' id='".$i."' placeholder='e.g Tebogo Jones' name='".$i."'>
                                          </div>";
                                  }
                                }else{
                                  //all offices are occupied
                                  echo "<p>You have assigned all offices. Click on any to change.</p>";
                                }
                            ?>

                            <button type="submit" class="btn btn-success btn-block" name="add">Add!</button>
                      </form>
                  </div>
                  <div class = "col-md-4 col-sm-4 col-xs-12"></div>
              </div>
          </div> <!--Form end-->

<?php
include("footer.php");
?>
