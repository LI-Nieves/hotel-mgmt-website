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
            <input type = "text" name = "fAmenities" placeholder = "Floor amenities (if applicable)"/>
            <input type = "text" name = "numUtilities" placeholder = "Number of utilities (if applicable)"/>
         <input type = "submit" />
        </form>
		
        <p> <?php 
                include 'C:\xampp\htdocs\Project\backend\database.php';
                include 'C:\xampp\htdocs\Project\logic\floorQueries.php';

                $desiredFloor = $_POST["desiredFloor"]??"";
                $numUtilities = $_POST["numUtilities"]??"";
                $fAmenities = $_POST["fAmenities"]??"";

                $conn = connect();

                // checking if the specified floor exists in the table
                $stmt = $conn->prepare("CALL checkFloor(?)");
                $stmt->bind_param("s",$desiredFloor);
                $stmt->execute();
                $result = $stmt->get_result();

                $count = mysqli_num_rows($result);
                if ($count == 0) {
                    echo "The Floor you desire to update data for does not exist in the table.<br>";
                    return false;
                } 

                $conn2 = connect();

                $result1 = floorAdminWrite($conn2,$desiredFloor,$fAmenities,$numUtilities);

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