<!DOCTYPE html>
<html>
<head>
<title>Guest: View My Reservations</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
	<div class="wrapper fadeInDown">
		<div id="formContent2">
		
        <p> <?php 
                include_once 'C:\xampp\htdocs\Project\backend\database.php';
                include_once 'C:\xampp\htdocs\Project\logic\reservationQueries.php';

                $conn = connect();

                $result = resGuestRead($conn);

                if ($result) {
                    header("Content-Type: JSON");
                    $rowNumber = 0;
                    $output = array();
    
                    while ($row = mysqli_fetch_array($result)) {
                        $output[$rowNumber]['GuestID'] = $row['GuestID'];
                        $output[$rowNumber]['FloorNo'] = $row['FloorNo'];
                        $output[$rowNumber]['RoomNo'] = $row['RoomNo'];
                        $output[$rowNumber]['ResID'] = $row['ResID'];
                        $output[$rowNumber]['StartDate'] = $row['StartDate'];
                        $output[$rowNumber]['EndDate'] = $row['EndDate'];
                        $output[$rowNumber]['ConfirmNo'] = $row['ConfirmNo'];
                        $output[$rowNumber]['NumPeople'] = $row['NumPeople'];
                        if($output[$rowNumber]['GuestID'] = $row['GuestID']){
                            $correctRow = $rowNumber;
                        }
                        $rowNumber++;
                    }
                   
                }

                else {
                    echo "Failed to retrieve data from database.<br>";
                }

            ?>
        <h1>Hello Guest</h1>
        <h3>This is your Reservation</h3>
        <p>Guest ID: <?php echo $output[$correctRow]['GuestID']; ?></p>
        <p>Floor No: <?php echo ($output[$correctRow]['FloorNo']); ?></p>
        <p>Room No: <?php echo $output[$correctRow]['RoomNo']; ?></p>
        <p>Reservation No: <?php echo $output[$correctRow]['ResID']; ?></p>
        <p>Start Date: <?php echo $output[$correctRow]['StartDate']; ?></p>
        <p>End Date: <?php echo $output[$correctRow]['EndDate']; ?></p>
        <p>Confirmation No: <?php echo $output[$correctRow]['ConfirmNo']; ?></p>
        <p>Number of People: <?php echo $output[$correctRow]['NumPeople']; ?></p>       
        </p>

        <input type="submit" id="modRes" class="fadeIn second" value="Modify Reservation"/>

        <input type="button" id="newRes" class="fadeIn second" value="New Reservation"/>
		</div>
	  </div>
</body>

</html>