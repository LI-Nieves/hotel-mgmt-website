<!DOCTYPE html>
<html>
<head>
<title>Admin/Receptionist: Create Phone Call Records</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
	<div class="wrapper fadeInDown">
		<div id="formContent2">

        <form action = "<?php $_PHP_SELF ?>" method = "POST">
            <input type = "text" name = "gID" placeholder = "Guest ID of caller"/>
            <input type = "text" name = "duration" placeholder = "Duration (in mins) (optional)"/>
            <input type = "text" name = "pDate" placeholder = "Call date" />
            <input type = "submit" />
        </form>
		
        <p> <?php 
                include 'C:\xampp\htdocs\Project\backend\database.php';
                include 'C:\xampp\htdocs\Project\logic\phoneQueries.php';

                $gID        = $_POST["gID"];
                $duration   = $_POST["duration"];
                $pDate      = $_POST["pDate"];

                // for debugging?
/*                 echo 
                    "You'd like to change data for Floor ".$_POST["resFloor"].
                    "<br>You entered:<br>Floor number: ".$_POST["resRoom"].
                    "<br>Number of utilities: ".$_POST["aDate"].
                    "<br>Floor amenities: ".$_POST["dDate"].
                    "<br>Maintenance employee's SSN: ".$_POST["numPeople"].
                    "<br>"; */

                $conn = connect();

                $result = phoneEmpNew($conn,$gID,$duration,$pDate);

                if ($result) {
                    header("Content-Type: JSON");
                    $rowNumber = 0;
                    $output = array();
    
                    while ($row = mysqli_fetch_array($result)) {
                        $output[$rowNumber]['CallID'] = $row['CallID'];
                        $output[$rowNumber]['GuestID'] = $row['GuestID'];
                        $rowNumber++;
                    }
                    echo json_encode($output, JSON_PRETTY_PRINT);
                }
                else {
                    echo "Failed to create the phone call record. Please ensure that the Guest ID is valid.<br>";    // should I add why?
                }

            ?>
        </p>
		</div>
	  </div>

</body>

</html> 