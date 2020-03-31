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
$invalidEntries = array();  //array for any invalid member entries
$validEntries = array();  //array of valid entries
$duplicateEntries = array();  //array of duplicate entries
$offices = array();

$formName="";
$formSurname="";
$mult = 20;

// if addData was pressed
if( isset( $_POST['add'] ) ) {
    // connect to database
    include('connection.php');

    //select all offices with null and push them into array
    $query = "SELECT office FROM offices";
    $result = mysqli_query( $conn, $query );
    while($row = mysqli_fetch_assoc($result)){
      array_push($offices, $row['office']);
    }
    
    //loop through the user inputs and validate them
    for($k=1; $k<=$_SESSION['i']; $k++){
        $formName = validateFormData( $_POST[$k]);
        $formSurname = validateFormData($_POST[$mult*$k]);

        //continue if form name and surname are empty
        if($formName=="" || $formSurname==""){ continue; }

        //error handling in case group pastor types a non existant name
        $query = "SELECT memberID FROM member_register WHERE name='$formName' AND surname='$formSurname' LIMIT 1";
        $result = mysqli_query( $conn, $query );
        

        //carry on with inserting member into db
        if($result){
            //if the member is in, run the insert query
            $row=   mysqli_fetch_array($result);

            //checking for duplicate entries into the table
            $query = "SELECT memberID, officeID FROM user_privileges WHERE memberID=".$row['memberID']." AND 
                            officeID=(SELECT officeID FROM offices WHERE office='".$offices[$k-1]."') LIMIT 1";
            $result = mysqli_query($conn, $query);
            if($result){ 
              if(mysqli_num_rows($result) > 0){
                 continue;
              }
           }

            //go ahead with the insertion
            $query = "INSERT INTO user_privileges(memberID, officeID) VALUES(".$row['memberID'].", 
                          (SELECT officeID FROM offices WHERE office='".$offices[$k-1]."') )";
            $result = mysqli_query( $conn, $query );

            if($result){
                array_push($validEntries, $formName);
            }else{
                //if for any funny reason it did not go through
                array_push($invalidEntries, $formName);
            }
        }else{
            //add this name to array of invalid entries
            echo "Error: ". $query ."<br>" . mysqli_error($conn);
            array_push($invalidEntries, $formName);
        }      
    }

    //display success message of entered names
    if(sizeof($validEntries)>0){
      $names = implode(", ", $validEntries);
      echo "<div class='alert alert-success' role='alert'>".$names." added successfully!<a class='close' data-dismiss='alert'>&times;</a></div>";
    }
    //after the loop, display an error message showing who needs to be re-entered
    if(sizeof($invalidEntries)>0){
      $names = implode(", ", $invalidEntries);
      echo "<div class='alert alert-danger'>".$names." could not be entered. Please ensure name and surname spellings are correct or that
                they exist in the members database.<a class='close' data-dismiss='alert'>&times;</a></div>";
    }

    //redirect to same page to avoid form resubmission on page reload
    //header("Location: assignPrivileges.php");
    
}


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
                                $i = 1;
                                // connect to database
                                include('connection.php');
                                $query = "SELECT officeID, office FROM offices";
                                $result = mysqli_query( $conn, $query );
                                
                                if(mysqli_num_rows($result) > 0 ){ 
                                  echo "<h3>Enter correct name and surname of each officer to be assigned below:</h3><br>";
                                  while($row = mysqli_fetch_assoc($result)){ 

                                      echo "<label for='".$i."'>".$row['office']."</label>";

                                      //first do a query to display all the people given to that office
                                      $query = "SELECT name FROM member_register 
                                                  INNER JOIN user_privileges ON user_privileges.memberID=member_register.memberID 
                                                  AND user_privileges.officeID=".$row['officeID'];
                                      $result2 = mysqli_query($conn, $query);

                                      //store office names in array
                                      $officers = array();
                                      while($row2 = mysqli_fetch_assoc($result2)){
                                          array_push($officers, $row2['name']);
                                      }
                                      if(sizeof($officers)>0){
                                          echo "<p>The following are already assigned to this office: ".implode(", ",$officers)." </p>";
                                      }

                                      echo  "<div class='form-row' id='".$i."'>
                                                  
                                                  <div class='col-md-6 col-sm-6 col-xs-6' style='padding-right: 5px; padding-left: 0px'>
                                                      <input type='text' class='form-control' placeholder='Name' name='".$i."'>
                                                  </div>
                                                  <div class='col-md-6 col-sm-6 col-xs-6' style='padding-right: 0px; padding-left: 5px'>
                                                      <input type='text' class='form-control' placeholder='Surname' name='".$mult*$i."'>
                                                  </div>
                                            </div><br>";
                                      $i++;
                                  }
                                  $_SESSION['i'] = $i-1;
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
