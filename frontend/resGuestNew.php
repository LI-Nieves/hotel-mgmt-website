<!DOCTYPE html>
<html>
<head>
<title>Guest: Book a Room</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
	<div class="wrapper fadeInDown">
		<div id="formContent2">

        <form action = "<?php $_PHP_SELF ?>" method = "POST">
            <input type = "text" name = "resFloor" placeholder = "Floor number"/>
            <input type = "text" name = "resRoom" placeholder = "Room number"/>
            <input type = "text" name = "aDate" placeholder = "Arrival date"/>
            <input type = "text" name = "dDate" placeholder = "Departure date"/>
            <input type = "text" name = "numPeople" placeholder = "Number of people staying"/>
            <input type = "submit" />
        </form>
		
        <p> <?php 
                include 'C:\xampp\htdocs\Project\backend\database.php';
                include 'C:\xampp\htdocs\Project\logic\reservationQueries.php';

                $resFloor   = $_POST["resFloor"];
                $resRoom    = $_POST["resRoom"];
                $aDate      = $_POST["aDate"];
                $dDate      = $_POST["dDate"];
                $numPeople  = $_POST["numPeople"];

                // for debugging?
/*                 echo 
                    "You'd like to change data for Floor ".$_POST["resFloor"].
                    "<br>You entered:<br>Floor number: ".$_POST["resRoom"].
                    "<br>Number of utilities: ".$_POST["aDate"].
                    "<br>Floor amenities: ".$_POST["dDate"].
                    "<br>Maintenance employee's SSN: ".$_POST["numPeople"].
                    "<br>"; */

                $conn = connect();

                $result = resGuestNew($conn,$resFloor,$resRoom,$aDate,$dDate,$numPeople);

                if ($result) {
                    header("Content-Type: JSON");
                    $rowNumber = 0;
                    $output = array();
    
                    while ($row = mysqli_fetch_array($result)) {
                        $output[$rowNumber]['ResID'] = $row['ResID'];
                        $output[$rowNumber]['ConfirmNo'] = $row['ConfirmNo'];
                        $rowNumber++;
                    }
                    echo json_encode($output, JSON_PRETTY_PRINT);
                }
                else {
                    echo "Failed to create the reservation. Please ensure that the floor number and room number are valid.<br>";    // should I add why?
                }

            ?>
        </p>
		</div>
	  </div>

</body>

</html> 