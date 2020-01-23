<!DOCTYPE html>

<html>

    <head>
        
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>LW Group I Admin</title>

        <!-- Bootstrap CSS -->
          <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
          <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.2/bootstrap3-typeahead.min.js"></script>  
          <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
          <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
          <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.js"></script>
          <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/css/bootstrap-multiselect.css" />

        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
            <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <style>
        table, th, td {
          border: 1px solid black;
        }
    </style>
    <!--Script to prevent form resubmission when page is reloaded-->
    <script>
        if ( window.history.replaceState ) {
            window.history.replaceState( null, null, window.location.href );
        }
    </script>
    <body style="padding-top: 60px;">            
    <nav class="navbar navbar-default navbar-fixed-top">

        <div class="container-fluid">

            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#"><strong>LW Group I Admin</strong></a>
            </div>

            <div class="collapse navbar-collapse" id="navbar-collapse">
                
                <?php
                    $href = "";

                    if( isset( $_SESSION['user_id'] ) ) { // if user is logged in
                        //check if the group pastor is the one logged in
                        if(isset($_SESSION['groupPastorID'])){
                            $href = "groupPastor.php";
                        }else{
                            $href = "profile.php";
                        }     

                        echo "<ul class='nav navbar-nav'>";
                            echo "<li><a href=".$href.">Back to home</a></li>
                            <li><a href='#'>Create table</a></li>
                        </ul>";
                    ?>

                        <ul class="nav navbar-nav navbar-right">
                            <p class="navbar-text">Aloha, <?php echo $_SESSION['user_id']?>!</p>

                            <li><a href="logout.php">Log out</a></li>
                        </ul>
                    <?php
                    } else {
                    ?>
                        <ul class="nav navbar-nav navbar-right">
                            <li><a href="index.php">Log in</a></li>
                        </ul>
                    <?php
                    }
                    ?>

            </div>

        </div>

    </nav>
        
    <div class="container">
