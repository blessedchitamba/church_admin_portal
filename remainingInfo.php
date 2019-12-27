<?php
session_start();

include("header.php");
include('functions.php');

//this page is for when a user has created an account and they were not originally in the members database
//in which case they need to fill in the rest of the information needed by the member_register table

$formContact="";
$formDegree="";
$formStudyYear="";
$formUniversity="";
$errorMsg="";

// if sign up form was submitted
if( isset( $_POST['Submit'] ) ) {
    // connect to database
    include('connection.php');

    // create variables
    // wrap data with validate function
    $formContact = validateFormData( $_POST['contact']);
    $formDegree = validateFormData( $_POST['degree']);
    $formStudyYear = validateFormData( $_POST['studyYear'] );
    $formUniversity = validateFormData( $_POST['university'] );

    //if name is empty
    if( $formContact=="") {
    	$errorMsg = "<div class='alert alert-danger'>Please provide a contact number.<a class='close' data-dismiss='alert'>&times;</a></div>";
    } 
    elseif( (strlen($formContact) != 10) && ($errorMsg=="")) {  //if password too short
    	$errorMsg = "<div class='alert alert-danger'>Contact number must be 10 digits long.<a class='close' data-dismiss='alert'>&times;</a></div>";
    }

    //proceed if there are no password errors
    if( $errorMsg=="") {
	    
        //check if the person exists in members table
        $query = "UPDATE member_register SET phone_number= '$formContact', university='$formUniversity',
                                                degree= '$formDegree', year_of_study= '$formStudyYear'
                                                WHERE memberID=".$_SESSION['user_id'];
        $result = mysqli_query( $conn, $query );

        if( $result) {
            //redirect to success page
            header( "Location: profile.php?" );
        } else {
             // something went wrong
            echo "Error: ". $query ."<br>" . mysqli_error($conn);
        }
    }
    
}


// close mysql connection
if(isset($conn)) {
  mysqli_close($conn);
}
?>

          <h1>Since you are new, just spare a second to give us these few details!</h1>

          <?php echo $errorMsg; ?>
          <!--Form start-->
          <div class = "container-fluid">
              <div class = "row">
                  <div class = "col-md-4 col-sm-4 col-xs-12"></div>
                  <div class = "col-md-4 col-sm-4 col-xs-12">
                      <form class = "form-container" action="<?php echo htmlspecialchars( $_SERVER['PHP_SELF'] ); ?>" method="post">
                            <div class="form-group">
                                <label for="InputContact">Phone number</label>
                                <input type="text" class="form-control" id="InputContact" aria-describedby="contactHelp" placeholder="e.g 0123456789" name="contact" value="<?php echo $formContact; ?>">
                                <small id="contactHelp" class="form-text text-muted">We'll never share your contact with anyone else.</small>
                            </div>
                            <div class="form-group">
                                <label for="InputUniversity">University</label>
                                <input type="text" class="form-control" id="InputUniversity" placeholder="University" name="university" value="<?php echo $formUniversity; ?>">
                            </div>
                            <div class="form-group">
                                <label for="InputDegree">Degree/Area of study</label>
                                <input type="text" class="form-control" id="InputDegree" placeholder="e.g Chemical Engineering/NA" 
name="degree" value="<?php echo $formDegree; ?>">
                            </div>
                             <div class="form-group">
                                <label for="InputStudyYear">Year of study</label>
                                <input type="text" class="form-control" id="InputStudyYear" placeholder="e.g First or Masters" 
name="studyYear" value="<?php echo $formStudyYear; ?>">
                            </div>

                            <button type="submit" class="btn btn-success btn-block" name="Submit">Submit</button>
                      </form>
                  </div>
                  <div class = "col-md-4 col-sm-4 col-xs-12"></div>
              </div>
          </div> <!--Form end-->

<?php
include("footer.php");
?>
