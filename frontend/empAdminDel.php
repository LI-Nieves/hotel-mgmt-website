<!DOCTYPE html>
<html>
<head>
<title>Admin: Delete Employee Record</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
	<div class="wrapper fadeInDown">
		<div id="formContent2">

        <form action = "<?php $_PHP_SELF ?>" method = "POST">
            <input type = "text" name = "eSSN" placeholder = "SSN of Employee to delete" /><br>
            <input type = "submit" />
        </form>
		
        <p> <?php 
                include 'C:\xampp\htdocs\Project\backend\database.php';
                include 'C:\xampp\htdocs\Project\logic\employeeQueries.php';

                $eSSN  = $_POST["eSSN"];

                // for debugging?
/*                 echo 
                    "You'd like to change data for Floor ".$_POST["resFloor"].
                    "<br>You entered:<br>Floor number: ".$_POST["resRoom"].
                    "<br>Number of utilities: ".$_POST["aDate"].
                    "<br>Floor amenities: ".$_POST["dDate"].
                    "<br>Maintenance employee's SSN: ".$_POST["numPeople"].
                    "<br>"; */
                
                $conn = connect();

                $initial = countEntries($conn,"SELECT * FROM Employee");

                $result = empAdminDel($conn,$eSSN);

                if ($result) {
                    // checking if a reservation was truly deleted.
                    $sqlCheck = "SELECT * FROM Employee";
                    
                    $final = countEntries($conn,$sqlCheck);

                    if ($initial == $final) {
                        echo "Failed to delete Employee record. Please ensure you entered details for existing Employee.<br>";
                    }
                    else {
                        echo "Successfully deleted Employee record.<br>";
                    }
                }
                else {
                    echo "Failed to delete Employee record.<br>";
                }

            ?>
        </p>
		</div>
	  </div>

</body>

</html> 