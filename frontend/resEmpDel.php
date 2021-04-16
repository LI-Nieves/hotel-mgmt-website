<!DOCTYPE html>
<html>
<head>
<title>Admin/Receptionist: Delete a Reservation</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
	<div class="wrapper fadeInDown">
		<div id="formContent2">

        <form action = "<?php $_PHP_SELF ?>" method = "POST">
            <input type = "text" name = "rID" placeholder = "Reservation ID"/><br>
            <input type = "text" name = "floorNo" placeholder = "Floor number of reserved room"/><br>
            <input type = "text" name = "roomNo" placeholder = "Room number of reserved room"/><br>
            <input type = "text" name = "gID" placeholder = "Guest's ID"/>
            <input type = "submit" />
        </form>
		
        <p> <?php 
                include 'C:\xampp\htdocs\Project\backend\database.php';
                include 'C:\xampp\htdocs\Project\logic\reservationQueries.php';

                $rID        = $_POST["rID"]??"";
                $floorNo    = $_POST["floorNo"]??"";
                $roomNo     = $_POST["roomNo"]??"";
                $gID        = $_POST["gID"]??"";

                $conn = connect();

                $result = resEmpDel($conn,$rID,$floorNo,$roomNo,$gID);

                if ($result) {
                    echo "Successfully cancelled reservation.<br>";
                }
                else {
                    echo "Failed to cancel reservation. Please ensure you entered details for an existing reservation.<br>";
                }
            ?>
        </p>
		</div>
	  </div>

</body>

</html> 