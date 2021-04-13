<!DOCTYPE html>
<html>
<head>
<title>Admin: Modify Floors</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
	<div class="wrapper fadeInDown">
		<div id="formContent2">

        <form action = "<?php $_PHP_SELF ?>" method = "POST">
            <input type = "text" name = "desiredFloor" placeholder = "Which floor would you like to change?"/>
            <input type = "text" name = "floorNo" placeholder = "Floor number"/>
            <input type = "text" name = "fAmenities" placeholder = "Floor amenities (if applicable)"/>
            <input type = "text" name = "numUtilities" placeholder = "Number of utilities (if applicable)"/>
         <input type = "submit" />
        </form>
		
        <p> <?php 
                include 'C:\xampp\htdocs\Project\backend\database.php';
                include 'C:\xampp\htdocs\Project\logic\floorQueries.php';

                $desiredFloor = $_POST["desiredFloor"];
                $floorNo = $_POST["floorNo"];
                $numUtilities = $_POST["numUtilities"];
                $fAmenities = $_POST["fAmenities"];

                // for debugging?
/*                 echo 
                    "You'd like to change data for Floor ".$_POST["desiredFloor"].
                    "<br>You entered:<br>Floor number: ".$_POST["floorNo"].
                    "<br>Number of utilities: ".$_POST["numUtilities"].
                    "<br>Floor amenities: ".$_POST["fAmenities"].
                    "<br>Maintenance employee's SSN: ".$_POST["maintSSN"].
                    "<br>"; */

                $conn = connect();

                $result1 = floorAdminWrite($conn,$desiredFloor,$floorNo,$fAmenities,$numUtilities);
                if ($result1) {
                    echo "Your changes to the Floor table have been accepted.<br>";
                }
                else {
                    echo "Your changes to the Floor table have been rejected.<br>";    // should I add why?
                }

            ?>
        </p>
		</div>
	  </div>

</body>

</html> 