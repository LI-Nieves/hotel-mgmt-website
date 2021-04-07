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
        Which floor would you like to change? <input type = "text" name = "desiredFloor"/>
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

                $result1 = floorAdminWrite($conn,$desiredFloor,$floorNo,$numUtilities);
                if ($result1) {
                    echo "Your changes to the Floor table have been accepted.<br>";
                }
                else {
                    echo "Your changes to the Floor table have been rejected.<br>";    // should I add why?
                }

                $result2 = floorAdminWriteAmenities($conn,$desiredFloor,$floorNo,$fAmenities);
                if ($result2) {
                    echo "Your changes to the FloorAmenities table have been accepted.<br>";
                }
                else {
                    echo "Your changes to the FloorAmenities table have been rejected.<br>";    // should I add why?
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