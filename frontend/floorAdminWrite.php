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

                $conn = connect();

                // checking if the specified floor exists in the table
                $check = "SELECT * FROM Floors WHERE FloorNo = $desiredFloor";
                if (countEntries($conn,$check) == 0) {
                    echo "The floor number you desire to update data for does not exist in the table.<br>";
                    return false;
                }   

                $result1 = floorAdminWrite($conn,$desiredFloor,$floorNo,$fAmenities,$numUtilities);

                if ($result1) {
                    echo "Your changes to the Floor table have been accepted.<br>";
                }
                else {
                    echo "Your changes to the Floor table have been rejected.<br>";
                }

            ?>
        </p>
		</div>
	  </div>

</body>

</html> 