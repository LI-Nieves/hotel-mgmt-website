<!DOCTYPE html>
<html>
<head>
<title>Admin: Delete Phone Call Record</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
	<div class="wrapper fadeInDown">
		<div id="formContent2">

        <form action = "<?php $_PHP_SELF ?>" method = "POST">
            <input type = "text" name = "cID" placeholder = "Call ID" /><br>
            <input type = "submit" />
        </form>
		
        <p> <?php 
                include 'C:\xampp\htdocs\Project\backend\database.php';
                include 'C:\xampp\htdocs\Project\logic\phoneQueries.php';

                $cID  = $_POST["cID"];

                // for debugging?
/*                 echo 
                    "You'd like to change data for Floor ".$_POST["resFloor"].
                    "<br>You entered:<br>Floor number: ".$_POST["resRoom"].
                    "<br>Number of utilities: ".$_POST["aDate"].
                    "<br>Floor amenities: ".$_POST["dDate"].
                    "<br>Maintenance employee's SSN: ".$_POST["numPeople"].
                    "<br>"; */
                
                $conn = connect();

                $initial = countEntries($conn,"SELECT * FROM PhoneCall");

                $result = phoneAdminDel($conn,$cID);

                if ($result) {
                    // checking if a reservation was truly deleted.
                    $sqlCheck = "SELECT * FROM PhoneCall";
                    
                    $final = countEntries($conn,$sqlCheck);

                    if ($initial == $final) {
                        echo "Failed to delete Phone Call record. Please ensure you entered details for an existing Phone Call.<br>";
                    }
                    else {
                        echo "Successfully deleted Phone Call record.<br>";
                    }
                }
                else {
                    echo "Failed to delete Phone Call record.<br>";
                }

            ?>
        </p>
		</div>
	  </div>

</body>

</html> 