<?php
session_start();

// if user is not logged in
if( !$_SESSION['user_id'] ) {
    
    // send them to the login page
    header("Location: index.php");
}

// connect to database
include('connection.php');

// check first if user has some missing details in member_register
$query = "SELECT phone_number FROM member_register WHERE memberID=".$_SESSION['user_id'];
$result = mysqli_query( $conn, $query );

//if phone number is null, redirect to remainingInfo.php
if($row = mysqli_fetch_assoc($result)) {  
   if($row['phone_number']==NULL){
        header("Location: remainingInfo.php");
   }    
}

// close the mysql connection
mysqli_close($conn);

include('header.php');
?>

<h1>Welcome. Choose an action.</h1>

<?php 
if( isset( $alertMessage ) ) {
    echo $alertMessage;
}
?>
    
    

<?php
include('footer.php');
?>