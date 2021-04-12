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

                // for debugging?
/*                 echo 
                    "You'd like to change data for Floor ".$_POST["resFloor"].
                    "<br>You entered:<br>Floor number: ".$_POST["resRoom"].
                    "<br>Number of utilities: ".$_POST["aDate"].
                    "<br>Floor amenities: ".$_POST["dDate"].
                    "<br>Maintenance employee's SSN: ".$_POST["numPeople"].
                    "<br>"; */

                $conn = connect();

                $result = roomAdmin($conn,$fNo,$rNo,$cost,$bed,$rType,1);

                if ($result) {
                    $check = mysqli_query($conn, "SELECT * FROM Room WHERE FloorNo = $fNo AND RoomNo = $rNo");
                    $count = 0;
                    $output = array();

                    if ($check) {
                        while ($row = mysqli_fetch_array($check)) {
                            $count++;
                        }
    
                        if ($count > 0) {
                            echo "Successfully modified room details.<br>";
                        }
                        else {
                            echo "Failed to modify room details. 
                            Please ensure the Guest ID, Floor Number, and Room Number are valid.<br>";
                        }
                    }
                    else {
                        echo "Failed to modify room details. 
                        Please ensure the Guest ID, Floor Number, and Room Number are valid.<br>";
                    }
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