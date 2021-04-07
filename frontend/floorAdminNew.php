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
        Floor number: <input type = "text" name = "floorNo"/>
        Number of utilities (if applicable): <input type = "text" name = "numUtilities" />
        Floor amenities (if applicable): <input type = "text" name = "fAmenities" />
        Maintenance employee's SSN (if applicable): <input type = "text" name = "maintSSN" />
         <input type = "submit" />
        </form>
		
        <p> <?php 
                include 'C:\xampp\htdocs\Project\backend\database.php';
                include 'C:\xampp\htdocs\Project\businessLogic\queries.php';

                $desiredFloor = $_POST["desiredFloor"];
                $floorNo = $_POST["floorNo"];
                $numUtilities = $_POST["numUtilities"];
                $fAmenities = $_POST["fAmenities"];
                $maintSSN = $_POST["maintSSN"];

                // for debugging?
                echo 
                    "You'd like to change data for Floor ".$_POST["desiredFloor"].
                    "<br>You entered:<br>Floor number: ".$_POST["floorNo"].
                    "<br>Number of utilities: ".$_POST["numUtilities"].
                    "<br>Floor amenities: ".$_POST["fAmenities"].
                    "<br>Maintenance employee's SSN: ".$_POST["maintSSN"].
                    "<br>";

                $conn = connect();

                $result1 = floorAdminNew($conn,$floorNo,$numUtilities);
                if ($result1) {
                    echo "Successfully added data to the Floor table.<br>";
                }
                else {
                    echo "Failed to add data to the Floor table.<br>";    // should I add why?
                }

                $result2 = floorAdminNewAmenities($conn,$floorNo,$fAmenities);
                if ($result2) {
                    echo "Successfully added data to the FloorAmenities table.<br>";
                }
                else {
                    echo "Failed to add data to the FloorAmenities table.<br>";    // should I add why?
                }

                // for debugging
/*                 header("Content-Type: JSON");
                $rowNumber = 0;
                $output = array();

                while ($row = mysqli_fetch_array($result)) {
                    $output[$rowNumber]['FloorNo'] = $row['FloorNo'];
                    $rowNumber++;
                }
                echo json_encode($output, JSON_PRETTY_PRINT); */

            ?>
        </p>
		</div>
	  </div>

</body>

</html> 