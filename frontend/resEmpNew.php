<!DOCTYPE html>
<html>
<head>
<title>Admin/Receptionist: Create a Reservation</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
	<div class="wrapper fadeInDown">
		<div id="formContent2">

        <form action = "<?php $_PHP_SELF ?>" method = "POST">
            <input type = "text" name = "aDate" placeholder = "Arrival date"/>
            <input type = "text" name = "dDate" placeholder = "Departure date"/>
            <input type = "text" name = "numPeople" placeholder = "Number of people staying"/>
            <input type = "text" name = "numBeds" placeholder = "Number of beds preferred?"/>
            <input type = "text" name = "gID" placeholder = "Guest's ID"/>
            <input type = "submit" />
        </form>
		
        <p> <?php 
                include 'C:\xampp\htdocs\Project\backend\database.php';
                include 'C:\xampp\htdocs\Project\logic\reservationQueries.php';

                $aDate      = $_POST["aDate"];
                $dDate      = $_POST["dDate"];
                $numPeople  = $_POST["numPeople"];
                $numBeds    = $_POST["numBeds"];
                $gID        = $_POST["gID"];

                $conn = connect();

                $result = resEmpNew($conn,$aDate,$dDate,$numPeople,$numBeds,$gID);

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