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

                $rID        = $_POST["rID"];
                $floorNo    = $_POST["floorNo"];
                $roomNo     = $_POST["roomNo"];
                $gID        = $_POST["gID"];

                // for debugging?
/*                 echo 
                    "You'd like to change data for Floor ".$_POST["resFloor"].
                    "<br>You entered:<br>Floor number: ".$_POST["resRoom"].
                    "<br>Number of utilities: ".$_POST["aDate"].
                    "<br>Floor amenities: ".$_POST["dDate"].
                    "<br>Maintenance employee's SSN: ".$_POST["numPeople"].
                    "<br>"; */

                $conn = connect();

                $initial = countEntries($conn,"SELECT * FROM Reservation");

                $result = resEmpDel($conn,$rID,$floorNo,$roomNo,$gID);

                if ($result) {
                    // checking if a reservation was truly deleted.
                    $sqlCheck = "SELECT * FROM Reservation";
                    
                    $final = countEntries($conn,$sqlCheck);

                    if ($initial == $final) {
                        echo "Failed to delete reservation. Please ensure you entered details for existing reservation.<br>";
                    }
                    else {
                        echo "Successfully deleted your reservation.<br>";
                    }
                }
                else {
                    echo "Failed to delete reservation.<br>";
                }

            ?>
        </p>
		</div>
	  </div>

</body>

</html> 