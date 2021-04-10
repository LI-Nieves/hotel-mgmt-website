<!DOCTYPE html>
<html>
<head>
<title>Admin: Guest Check In/Out</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
	<div class="wrapper fadeInDown">
		<div id="formContent2">

        <form action = "<?php $_PHP_SELF ?>" method = "POST">
            Floor number of room?           <input type = "text" name = "fNo"/><br>
            Room number of room?            <input type = "text" name = "rNo"/><br>
            WRITE NEW DETAILS BELOW:<br>
            Cost:                           <input type = "text" name = "cost" /><br>
            Number of beds:                 <input type = "text" name = "bed" /><br>
            Room type:                      <input type = "text" name = "rType" /><br>
            <input type = "submit" />
            <!-- Note that Availability and Clean Status will remain what they currently are. -->
        </form>
		
        <p> <?php 
                include 'C:\xampp\htdocs\Project\backend\database.php';
                include 'C:\xampp\htdocs\Project\businessLogic\queries.php';

                $fNo    = $_POST["fNo"];
                $rNo    = $_POST["rNo"];
                $cost   = $_POST["cost"];
                $bed    = $_POST["bed"];
                $rType  = $_POST["rType"];

/*                 // for debugging?
                echo 
                    "You'd like to change data for Floor ".$_POST["resFloor"].
                    "<br>You entered:<br>Floor number: ".$_POST["resRoom"].
                    "<br>Number of utilities: ".$_POST["aDate"].
                    "<br>Floor amenities: ".$_POST["dDate"].
                    "<br>Maintenance employee's SSN: ".$_POST["numPeople"].
                    "<br>"; */

                $conn = connect();

                $result = roomAdminWrite($conn,$fNo,$rNo,$cost,$bed,$rType);

                if ($result) {
                    $check = mysqli_query($conn, "SELECT * FROM Room WHERE FloorNo = $fNo AND RoomNo = $rNo");
                    $count = 0;
                    $output = array();
    
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
                    echo "Failed to modify the room details. 
                        Please ensure the Guest ID, Floor Number, and Room Number are valid.<br>";
                }

            ?>
        </p>
		</div>
	  </div>

</body>

</html> 