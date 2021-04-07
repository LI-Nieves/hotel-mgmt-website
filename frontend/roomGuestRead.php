<!DOCTYPE html>
<html>
<head>
<title>Guest: View Rooms</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
	<div class="wrapper fadeInDown">
		<div id="formContent2">
		
        <p> <?php 
                include 'C:\xampp\htdocs\Project\backend\database.php';
                include 'C:\xampp\htdocs\Project\businessLogic\queries.php';

                echo "Files included.<br>"; // for debugging

                $conn = connect();

                $result = viewRoomsGuest($conn);
                
                if ($result) {
                    header("Content-Type: JSON");
                    $rowNumber = 0;
                    $output = array();
    
                    while ($row = mysqli_fetch_array($result)) {
                        $output[$rowNumber]['FloorNo'] = $row['FloorNo'];
                        $output[$rowNumber]['RoomNo'] = $row['RoomNo'];
                        $output[$rowNumber]['Cost'] = $row['Cost'];
                        $output[$rowNumber]['Beds'] = $row['Beds'];
                        $output[$rowNumber]['Availability'] = $row['Availability'];
                        $output[$rowNumber]['CleanStatus'] = $row['CleanStatus'];
                        $output[$rowNumber]['RoomType'] = $row['RoomType'];
                        $rowNumber++;
                    }
                    echo json_encode($output, JSON_PRETTY_PRINT);
                }
                else {
                    echo "Failed to retrieve data from the database.<br>";
                }


                $result2 = viewRoomsGuestAmen($conn);

                if ($result) {
                    header("Content-Type: JSON");
                    $rowNumber = 0;
                    $output = array();
    
                    while ($row = mysqli_fetch_array($result)) {
                        $output[$rowNumber]['FloorNo'] = $row['FloorNo'];
                        $output[$rowNumber]['RoomNo'] = $row['RoomNo'];
                        $output[$rowNumber]['RAmenities'] = $row['RAmenities'];
                        $rowNumber++;
                    }
                    echo json_encode($output, JSON_PRETTY_PRINT);
                }
                else {
                    echo "Failed to retrieve data from the database.<br>";
                }

            ?>
        </p>
		</div>
	  </div>
</body>

</html> 

