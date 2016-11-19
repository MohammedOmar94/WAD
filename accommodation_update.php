<?php
require 'mysql.php';
if (isset($_SESSION['verificationCode']) && $_SESSION['verificationCode'] !== '0') {//If the user is logged in, and if they are NOT a verified user..
    header("Location: verification.php"); //..redirect them to verification.php.
    exit;
} else if (!isset($_SESSION['user'])) {//If the user is not logged in..
    header("Location: login.php"); //..redirect them to login.php
    exit;
} else if (!isset($_SESSION["propertyid"])) {//But if they don't have a propertyid from url jumping, send them back to propertylist.
    header("Location: propertylist.php");
    exit;
} else {//If the user is logged in and they have the propertyid..
    $assoc = get_property($_SESSION["propertyid"]); //Get the Property details and display them within the input fields. DO NOT GET THIS FUNCTION MIXED UP with get_propertyid().
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
        <h3>Update Accommodation details </h3>
        <div id="register">
            <form action="mysql.php" method="post" enctype="multipart/form-data">
                <label>Area</label><input id="carrier_search_input" type="text"  name="area" value="<?php echo $assoc['Area']; ?>" oninput="data_input(this)"/> <br/>
                <label>Address</label><input id="carrier_search_input"  name="address" value="<?php echo $assoc['Address']; ?>" oninput="data_input(this)"/> <br/>
                <label>Number of rooms</label><select name="rooms" >
                    <?php for ($i = 1; $i <= $assoc['Bedrooms'] - 1; $i++) { //Just before we get to our value  ?> 
                        <option value="<?php echo $i; ?>" ><?php echo $i; ?></option>
                    <?php } ?>
                    <option value="<?php echo $assoc['Bedrooms']; ?>" selected="<?php echo $assoc['Bedrooms']; ?>"><?php echo $assoc['Bedrooms']; ?></option>
                    <?php for ($i = $assoc['Bedrooms'] + 1; $i <= 10; $i++) { //Continue from after our added value  ?>
                        <option value="<?php echo $i; ?>" ><?php echo $i; ?></option>
                    <?php } ?>
                </select> <br/>
                <label>Weekly rate (£)</label><input id="carrier_search_input"  name="rate" value="<?php echo $assoc['Rate']; ?>" oninput="data_input(this)"/> <br/>
                <input type="submit" name="update" value="Update"></input><br/> 
            </form>
        </div>


    </body>

</html>


