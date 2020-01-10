<?php
session_start();

// if user is not logged in
if( !$_SESSION['user_id'] ) {
    
    // send them to the login page
    header("Location: index.php");
}

// connect to database
include('connection.php');
include('functions.php');

// check first if user has some missing details in member_register
$query = "SELECT phone_number FROM member_register WHERE memberID=".$_SESSION['user_id'];
$result = mysqli_query( $conn, $query );

//if phone number is null, redirect to remainingInfo.php
if($row = mysqli_fetch_assoc($result)) {  
   if($row['phone_number']==NULL){
        header("Location: remainingInfo.php");
   }    
}

//page to be redirected if the user wants to alter the table
if( isset( $_POST['editData'] ) ){
    header("Location: editData.php");
}

// close the mysql connection
mysqli_close($conn);

include('header.php');
//include('functions.php');
?>

<div class = "container-fluid">
              <div class = "row">
                  <div class = "col-md-4 col-sm-4 col-xs-12"></div>
                  <div class = "col-md-4 col-sm-4 col-xs-12">
                      <form class = "form-container" action="<?php echo htmlspecialchars( $_SERVER['PHP_SELF'] ); ?>" method="post">
                            <div class="form-group">
                                <label for="userCategory">Select table to view</label>
                                <?php
                                //-------The dropdown list that shows the categories the user can pick from-------- 
                                    include('connection.php');
                                    $query= "SELECT category FROM categories INNER JOIN privileges ON categories.categoryID=privileges.categoryID AND privileges.memberID=".$_SESSION['user_id'];
                                    $result = mysqli_query( $conn, $query );
                                    if(mysqli_num_rows($result) > 0 ) {
                                        echo "<select id='userCategory' name='category'>";
                                        echo "<option value=''>Select table...</option>";
                                        while ($row=   mysqli_fetch_assoc($result) )
                                        {
                                            //echo "<option value='' >Hello there</option>";
                                            echo "<option value='".htmlspecialchars($row["category"])."' >".htmlspecialchars($row["category"])."</option>";
                                        }
                                        echo "</select>";
                                    }
                                ?>
                                <button type="submit" class="btn btn-success btn-block" name="viewData">View data</button>

                                <?php
                                //----------The viewing of the data------------
                                    $formCategory="";
                                    $tableName="";
                                    // if view data was pressed form was submitted
                                    if( isset( $_POST['viewData'] ) ) {
                                        // create variables
                                        // wrap data with validate function
                                        $formCategory = validateFormData( $_POST['category']);
                                        
                                        //if user did not select category
                                        if( $formCategory=="") {
                                            $errorMsg = "<div class='alert alert-danger'>Please select a category first.<a class='close' data-dismiss='alert'>&times;</a></div>";
                                            echo $errorMsg;
                                            return;
                                        }

                                        //based on the category, select data from the appropriate table name and display it to the screen
                                        $query = "SELECT tb_name FROM table_names WHERE user_input='$formCategory'";
                                        $result = mysqli_query( $conn, $query );
                                        while($row = mysqli_fetch_assoc($result)){
                                            $tableName = $row['tb_name'];
                                            $_SESSION['tb_name'] = $tableName;
                                        }

                                        $query = "SELECT COLUMN_NAME FROM information_schema.columns WHERE TABLE_NAME='$tableName'";
                                        $result = mysqli_query( $conn, $query );

                                        if($result){
                                            $columnNames = array();
                                            $count = 0;
                                            while ($row=   mysqli_fetch_array($result) ){
                                                $columnNames[$count] = $row[0];
                                                $count++;
                                            }

                                            //send the array to the session variable
                                            $_SESSION['columnNames'] = $columnNames;
                                            //$string = implode(',',$columnNames);
                                            //echo $string, '<br>';

                                            //-------Create the table------- 

                                            //the data rows
                                            $row = array();
                                            //use alias for member_register to cater for the case where $tableName is member_register and its a self join
                                            $query = "SELECT m.name, m.surname, $tableName.* FROM $tableName INNER JOIN member_register m ON $tableName.memberID=m.memberID";
                                            $result = mysqli_query( $conn, $query );
                                            if($result){
                                                //table header
                                                echo "<br><table style= 'width:100%'>";
                                                echo "<tr>";
                                                echo "<th>Name</th>";
                                                echo "<th>Surname</th>";
                                                for($i=1; $i<sizeof($columnNames); $i++){
                                                    echo "<th>".$columnNames[$i]."</th>";
                                                }
                                                echo "</tr>";

                                                while($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                                                    echo "<tr>";
                                                    for($i=0; $i<sizeof($row); $i++){
                                                        //skip the memberID
                                                        if($i==2){continue;}
                                                        echo "<td>".$row[$i]."</td>";
                                                    }
                                                    echo "</tr>";
                                                }
                                                echo "</table>";
                                            }
                                            echo "<br>";
                                            echo "<button type='submit' class='btn btn-success btn-block' name='editData'>Add/Remove entry</button>";

                                        }
                                    }
                                    mysqli_close($conn);
                                ?>
                            </div>

                      </form>
                  </div>
                  <div class = "col-md-4 col-sm-4 col-xs-12"></div>
              </div>
          </div> <!--Form end-->

<?php 
if( isset( $alertMessage ) ) {
    echo $alertMessage;
}
?>
    
    

<?php
include('footer.php');
?>