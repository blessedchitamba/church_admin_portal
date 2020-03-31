<?php
session_start();

include("header.php");
include('functions.php');

//no need to start session in this case. We will redirect user to login page after
//creating an account. 
$errorMsg = "";
$cellLeaders = array(); //array for our user inputs

$formName="";
$formSurname="";

// if addData was pressed
if( isset( $_POST['add'] ) ) {
    // connect to database
    include('connection.php');

    echo "<p>Button pressed!</p>";
   //fill the cell leaders array
    foreach ($_POST["framework"] as $row) {
      array_push($cellLeaders, $row);
    }
    
    //loop through the cell leaders array and add to cell leaders database
    foreach($cellLeaders as $leader){
        echo $leader;
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
                      <form method="post" id="framework_form">
                          <div class="form-group">
                            <select id="framework" name="framework[]" multiple class="form-control" multiple searchable="Search here..">
                              <?php
                                  // connect to database
                                  include('connection.php');

                                  $query = "SELECT * FROM member_register";
                                  $result = mysqli_query($conn, $query);

                                  if(mysqli_num_rows($result) > 0 ) {
                                      // we have data!
                                      // output the data
                                      
                                      while( $row = mysqli_fetch_assoc($result) ) {
                                          
                                          echo "<option value='" . $row['memberID'] . "'>".$row['name']." ".$row['surname']."</option>";
                                          
                                      }
                                  }

                              ?>
                             </select>
                              <button type="submit" class="btn btn-success btn-block" name="add">Add!</button>              
                          </div>
                      </form>
                  </div>
                  <div class = "col-md-4 col-sm-4 col-xs-12"></div>
              </div>
          </div> <!--Form end-->

<?php
include("footer.php");
?>
