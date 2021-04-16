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

                $conn = connect();
            
                // checking if the specified floor and room number exist in the table
                $check = "SELECT * FROM Room WHERE FloorNo = $fNo AND RoomNo = $rNo";
                if (countEntries($conn,$check) == 0) {
                    echo "The room you desire to update data for does not exist in the table.<br>";
                    return false;
                }

                $result = roomRecepWrite($conn,$fNo,$rNo,$gID,$iDate,$oDate);

                if ($result) {
                    echo "Successfully modified guest check in/out.<br>";
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