<?php
session_start();

// if user is not logged in
if( !$_SESSION['loggedInUser'] ) {
    
    // send them to the login page
    header("Location: index.php");
}

// connect to database
include('connection.php');

// query & result
$query = "SELECT * FROM does_course WHERE user_id=".$_SESSION['user_id'];
$result = mysqli_query( $conn, $query );

// check for query string
if( isset( $_GET['alert'] ) ) {
    
    // new course added
    if( $_GET['alert'] == 'success' ) {
        $alertMessage = "<div class='alert alert-success'>New course added! <a class='close' data-dismiss='alert'>&times;</a></div>";
    
    // course deleted
    } elseif( $_GET['alert'] == 'remove' ) {
        $alertMessage = "<div class='alert alert-success'>Course deleted! <a class='close' data-dismiss='alert'>&times;</a></div>";
    }
      
}

// close the mysql connection
mysqli_close($conn);

include('header.php');
?>

<h1>Hie. Below is a list of your courses.</h1>

<?php 
if( isset( $alertMessage ) ) {
    echo $alertMessage;
}
?>
    
    <?php
    
    if( !$result ) {
        echo "<div class='alert alert-warning'>Mmmm, looks lonely here. Please add courses.</div>";

    } elseif(mysqli_num_rows($result) > 0 ) { // if no entries
        //echo "<div class='alert alert-warning'>Mmmm, looks lonely here. Please add courses.</div>";
        // we have data!
        // output the data
        
        while( $row = mysqli_fetch_assoc($result) ) {
            
            echo "<p><a href='course.php' id='course'>" . $row['code'] . '</a><a href="remove.php?id=' . $row['user_id'] . '" type="button" class="btn btn-primary btn-sm">
                    <span class="glyphicon glyphicon-delete"></span></a></p>';
            
        }
    }

    ?>

    <div class="text-center"><a href="addCourse.php" type="button" class="btn btn-sm btn-success"><span class="glyphicon glyphicon-plus"></span> Add Course</a></div>

    <script type="text/javascript">
         $('#course').click(function(){
                document.cookie = "cookieName="+$(this).text();
        });
    </script>

<?php
include('footer.php');
?>