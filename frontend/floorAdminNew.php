<!DOCTYPE html>
<html>
<head>
<title>Admin: Add New Floor</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
	<div class="wrapper fadeInDown">
		<div id="formContent2">
        <form action = "<?php $_PHP_SELF ?>" method = "POST">
            <input type = "text" name = "floorNo" placeholder = "Floor number"/>
            <input type = "text" name = "numUtilities" placeholder = "Number of utilities (if applicable)"/>
            <input type = "text" name = "fAmenities" placeholder = "Floor amenities (if applicable)"/>
         <input type = "submit" />
        </form>
		
        <p> <?php 
                include 'C:\xampp\htdocs\Project\backend\database.php';
                include 'C:\xampp\htdocs\Project\logic\floorQueries.php';

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

                $result1 = floorAdminNew($conn,$floorNo,$numUtilities,$fAmenities);
                if ($result1) {
                    echo "Successfully added data to the Floor table.<br>";
                }
                else {
                    echo "Failed to add data to the Floor table.<br>";    // should I add why?
                }

            ?>
        </p>
		</div>
	  </div>

</body>

</html> 