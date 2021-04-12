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
        Reservation ID:             <input type = "text" name = "rID"/>
        Guest ID:                   <input type = "text" name = "gID"/>       
        Arrival date:               <input type = "text" name = "aDate" />
        Departure date:             <input type = "text" name = "dDate" />
        Number of people staying:   <input type = "text" name = "numPeople" />
         <input type = "submit" />
        </form>
		
        <p> <?php 
                include 'C:\xampp\htdocs\Project\backend\database.php';
                include 'C:\xampp\htdocs\Project\businessLogic\queries.php';

                $rID        = $_POST["rID"];
                $gID        = $_POST["gID"];
                $aDate      = $_POST["aDate"];
                $dDate      = $_POST["dDate"];
                $numPeople  = $_POST["numPeople"];

/*                 // for debugging?
                echo 
                    "You'd like to change data for Floor ".$_POST["resFloor"].
                    "<br>You entered:<br>Floor number: ".$_POST["resRoom"].
                    "<br>Number of utilities: ".$_POST["aDate"].
                    "<br>Floor amenities: ".$_POST["dDate"].
                    "<br>Maintenance employee's SSN: ".$_POST["numPeople"].
                    "<br>"; */

                $conn = connect();

                $result = resEmpWrite($conn,$rID,$aDate,$dDate,$numPeople,$gID);

                if ($result) {
                    header("Content-Type: JSON");
                    $rowNumber = 0;
                    $output = array();
    
                    while ($row = mysqli_fetch_array($result)) {
                        $output[$rowNumber]['ResID'] = $row['ResID'];
                        $output[$rowNumber]['GuestID'] = $row['GuestID'];
                        $output[$rowNumber]['ConfirmNo'] = $row['ConfirmNo'];
                        $output[$rowNumber]['StartDate'] = $row['StartDate'];
                        $output[$rowNumber]['EndDate'] = $row['EndDate'];
                        $output[$rowNumber]['NumPeople'] = $row['NumPeople'];
                        $rowNumber++;
                    }
                    echo json_encode($output, JSON_PRETTY_PRINT);
                }
                else {
                    echo "Failed to modify the reservation. 
                        Please ensure the Guest ID and Reservation ID are valid.<br>";
                }

            ?>
        </p>
		</div>
	  </div>

</body>

</html> 