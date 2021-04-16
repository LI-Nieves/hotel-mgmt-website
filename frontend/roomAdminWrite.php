<!DOCTYPE html>
<html>
<head>
<title>Admin: Modify Room Details</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
	<div class="wrapper fadeInDown">
		<div id="formContent2">

        <form action = "<?php $_PHP_SELF ?>" method = "POST">
            <input type = "text" name = "fNo" placeholder = "Floor number of room to modify?"/><br>
            <input type = "text" name = "rNo" placeholder = "Room number of room to modify?"/> <br>  
            WRITE NEW DETAILS BELOW:<br>
            <input type = "text" name = "cost" placeholder = "Cost"/><br>
            <input type = "text" name = "bed" placeholder = "Beds"/><br>
            <input type = "text" name = "rType" placeholder = "Room type"/><br>
            <input type = "submit" />
            <!-- Note that Availability and Clean Status will remain what they currently are. -->
        </form>
		
        <p> <?php 
                include 'C:\xampp\htdocs\Project\backend\database.php';
                include 'C:\xampp\htdocs\Project\logic\roomQueries.php';

                $fNo    = $_POST["fNo"];
                $rNo    = $_POST["rNo"];
                $cost   = $_POST["cost"];
                $bed    = $_POST["bed"];
                $rType  = $_POST["rType"];

                $conn = connect();

                // checking if the specified original DepSSN exists in the table
                $check = "SELECT * FROM Room WHERE FloorNo = $fNo AND RoomNo = $rNo";
                if (countEntries($conn,$check) == 0) {
                    echo "The room you desire to update data for does not exist in the table.<br>";
                    return false;
                }

                $result = roomAdmin($conn,$fNo,$rNo,$cost,$bed,$rType,1);

                if ($result) {
                    echo "Successfully modified room details.<br>";
                }
                else {
                    echo "Failed to modify room details. 
                    Please ensure the Guest ID, Floor Number, and Room Number are valid.<br>";
                }

            ?>
        </p>
		</div>
	  </div>

</body>

</html> 