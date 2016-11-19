<?php
require 'mysql.php'; //Always has property id when editing image.
$assoc = get_image($_SESSION['propertyid']); //needs error checking
//var_dump($assoc);
if (isset($_SESSION["userid"]) && !isset($_SESSION['propertyid'])) { //If the user is logged in, has just added a property, and wants to upload an image.
    get_propertyid($_SESSION["userid"]); //Get the property for the logged in user. THIS IS THE ONLY PLACE THIS IS REQUIRED.
} else if (!isset($_SESSION["userid"])) { //Trying to access page without logging in. 
    echo "Please login first to upload an image.";
    return;
} else { //User already has logged in, and has property id, most likely here to add/delete an image. 
    echo "UserID: " . $_SESSION["userid"] . " <br/>";
    echo "PropertyID: " . $_SESSION["propertyid"] . " <br/>";
}
?>
<?xml version="1.0" encoding="UTF-8"?>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Brighton and & Hove Agency</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>  
        <script src="./js/connection_functions.js?v=1.08" type="text/javascript"></script> <!-- Be sure to change the version number (v=1.XX) each time you update a file. There may be problems as the browser may cache and use the older file.  -->
        <script src="./js/gui_functions.js?v=1.07" type="text/javascript"></script> <!-- Be sure to change the version number (v=1.XX) each time you update a file. There may be problems as the browser may cache and use the older file.  -->
        <script src="./js/validation_functions.js?v=1.07" type="text/javascript"></script><!-- Be sure to change the version number (v=1.XX) each time you update a file. There may be problems as the browser may cache and use the older file.  -->
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.0/jquery.min.js" type="text/javascript"></script>
        <script src="./js/jquery.tablesorter.js" type="text/javascript" ></script>
        <script src="./js//jquery.tablesorter.pager.js" type="text/javascript"></script>
        <script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>       
        <script src="js/moment.js" type="text/javascript"></script>     
        <script src="ammap/ammap.js" type="text/javascript"></script>
        <script src="ammap/maps/js/worldLow.js" type="text/javascript"></script>
        <script src="./ammap/themes/light.js" type="text/javascript"></script>
        <script src="./js/map_functions.js?v=1.07" type="text/javascript"></script><!-- Be sure to change the version number (v=1.XX) each time you update a file. There may be problems as the browser may cache and use the older file.  --> 
        <script src="dist/sweetalert.min.js" type="text/javascript"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap3-dialog/1.34.5/js/bootstrap-dialog.min.js" type="text/javascript"></script>
        <!--<script src="https://code.jquery.com/qunit/qunit-1.23.1.js"></script>-->

        <link rel="stylesheet" href="ammap/ammap.css" type="text/css" media="all" />
        <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css"/>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap3-dialog/1.34.5/css/bootstrap-dialog.min.css" rel="stylesheet" type="text/css"/>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css"/>
        <link rel="stylesheet" type="text/css" href="dist/sweetalert.css"/>
        <link rel="stylesheet" href="https://code.jquery.com/qunit/qunit-1.23.1.css"/>
        <link rel="stylesheet" href="css/input.css?v=1.07"/>
        <link rel="stylesheet" href="css/background.css?v=1.07"/>
        <link rel="stylesheet" href="css/heading.css?v=1.07"/> 
        <link rel="stylesheet" href="css/table.css?v=1.07"/> 
        <link rel="stylesheet" href="css/main_content.css?v=1.07"/>
        <link rel="stylesheet" href="css/container.css?v=1.07"/>
        <link rel="stylesheet" href="css/bootstrap.css?v=1.07"/>
        <!--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.7/css/materialize.min.css"/>
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet"/> -->
        <meta charset="UTF-8"/>
    </head>
    <body>
        <div id="background"></div>   <!-- Having two backgrounds, allows one to overlay the other to create a tint effect. -->
        <div id="backgroundLayer"></div>
        <div id="headingColour">
            <h1 id="CDT_Heading" ><a href="index.xhtml" class="homeLink">Brighton and Hove Agency</a></h1> 
        </div>    
        <h3>Property images </h3>

        <form action="mysql.php" method="post" enctype="multipart/form-data">
            <?php
//        var_dump($assoc[0]['img']); 
            for ($i = 0; $i < count($assoc); $i++) {
//            var_dump($assoc[$i]['img']); 
                echo "<br/><input type='radio' name='image_radio' value='" . $assoc[$i]['img'] . "'/>";
                echo "<img src='" . $assoc[$i]['img'] . "' alt='" . $assoc[$i]['alt'] . "'width='10%' height='10%'/>";
            }

//        echo "<img src=$image width='10%' height='10%'/><br/>";
            ?> 

            <br/><input type="submit" name="delete_image" value="Delete"></input><br/>
        </form>
        <!--        
                <img src="<?php // echo $assoc['img'];  ?>" width="10%" height="10%"/><br/>
                <input type='radio' name='radio' value='<?php // echo $assoc['id'];  ?>"'/>-->


        <div id="register">
            <form action="upload.php" method="post" enctype="multipart/form-data">
                <label for="fileToUpload">Property image </label>
                <input type="file" name="fileToUpload" id="fileToUpload"/>
                <label>Description of image</label><input id="carrier_search_input"  name="alt_text" oninput="data_input(this)"/><br/>
                <input type="submit" name="upload" value="Upload"></input>
            </form>

        </div>


    </body>

</html>


