<!DOCTYPE html>
<html>
<head>
<title>Admin: Delete Room Record</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
	<div class="wrapper fadeInDown">
		<div id="formContent2">

        <form action = "<?php $_PHP_SELF ?>" method = "POST">
            <input type = "text" name = "fNo" placeholder = "Floor number" /><br>    
            <input type = "text" name = "rNo" placeholder = "Room number" /><br>
            <input type = "submit" />
        </form>
		
        <p> <?php 
                include 'C:\xampp\htdocs\Project\backend\database.php';
                include 'C:\xampp\htdocs\Project\logic\roomQueries.php';

                $fNo  = $_POST["fNo"];
                $rNo  = $_POST["rNo"];

                // for debugging?
/*                 echo 
                    "You'd like to change data for Floor ".$_POST["resFloor"].
                    "<br>You entered:<br>Floor number: ".$_POST["resRoom"].
                    "<br>Number of utilities: ".$_POST["aDate"].
                    "<br>Floor amenities: ".$_POST["dDate"].
                    "<br>Maintenance employee's SSN: ".$_POST["numPeople"].
                    "<br>"; */
                
                $conn = connect();

                $initial = countEntries($conn,"SELECT * FROM Room");

                $result = roomAdminDel($conn,$fNo,$rNo);

                if ($result) {
                    // checking if a reservation was truly deleted.
                    $sqlCheck = "SELECT * FROM Room";
                    
                    $final = countEntries($conn,$sqlCheck);

                    if ($initial == $final) {
                        echo "Failed to delete Room record. Please ensure you entered details for existing Room.<br>";
                    }
                    else {
                        echo "Successfully deleted Room record.<br>";
                    }
                }
                else {
                    echo "Failed to delete Room record.<br>";
                }

            ?>
        </p>
		</div>
	  </div>

</body>

</html> 