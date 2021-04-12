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
            <input type = "text" name = "fNo" placeholder = "Floor number of room?"/><br>
            <input type = "text" name = "rNo" placeholder = "Room number of room?"/><br>
            WRITE NEW DETAILS BELOW:<br>
            <input type = "text" name = "gID" placeholder = "ID of Guest staying in room"/><br>
            <input type = "text" name = "iDate" placeholder = "Check-in date"/><br>
            <input type = "text" name = "oDate" placeholder = "Check-out date (if applicable)"/><br>
            <input type = "submit" />
            <!--    Note that Clean Status will remain what it currently is. 
                    When checking in, Availability = FALSE and when checking out, vice versa. -->
        </form>
		
        <p> <?php 
                include 'C:\xampp\htdocs\Project\backend\database.php';
                include 'C:\xampp\htdocs\Project\logic\roomQueries.php';

                $fNo    = $_POST["fNo"];
                $rNo    = $_POST["rNo"];
                $gID    = $_POST["gID"];
                $iDate  = $_POST["iDate"];
                $oDate  = $_POST["oDate"];

                // for debugging?
/*                 echo 
                    "You'd like to change data for Floor ".$_POST["resFloor"].
                    "<br>You entered:<br>Floor number: ".$_POST["resRoom"].
                    "<br>Number of utilities: ".$_POST["aDate"].
                    "<br>Floor amenities: ".$_POST["dDate"].
                    "<br>Maintenance employee's SSN: ".$_POST["numPeople"].
                    "<br>"; */

                $conn = connect();

                $result = roomRecepWrite($conn,$fNo,$rNo,$gID,$iDate,$oDate);

                if ($result) {
                    $check = mysqli_query($conn, "SELECT * FROM Room WHERE FloorNo = $fNo AND RoomNo = $rNo");
                    $count = 0;
                    $output = array();
    
                    while ($row = mysqli_fetch_array($check)) {
                        $count++;
                    }

                    if ($count > 0) {
                        echo "Successfully modified guest check in/out.<br>";
                    }
                    else {
                        echo "Failed to check Guest in/out. 
                            Please ensure the Guest ID, Floor Number, and Room Number are valid.<br>";
                    }
                }
                else {
                    echo "Failed to check Guest in/out. 
                        Please ensure the Guest ID, Floor Number, and Room Number are valid.<br>";
                }

            ?>
        </p>
		</div>
	  </div>

</body>

</html> 