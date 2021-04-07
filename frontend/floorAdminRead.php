<!DOCTYPE html>
<html>
<head>
<title>Admin: View Floors</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
	<div class="wrapper fadeInDown">
		<div id="formContent2">
		
        <p> <?php 
                include 'C:\xampp\htdocs\Project\backend\database.php';
                include 'C:\xampp\htdocs\Project\businessLogic\queries.php';

                $conn = connect();

                // for Floor
                $result = floorAdminRead($conn);

                if ($result) {
                    header("Content-Type: JSON");
                    $rowNumber = 0;
                    $output = array();
    
                    while ($row = mysqli_fetch_array($result)) {
                        $output[$rowNumber]['FloorNo'] = $row['FloorNo'];
                        $output[$rowNumber]['NumUtilities'] = $row['NumUtilities'];
                        $rowNumber++;
                    }
                    echo json_encode($output, JSON_PRETTY_PRINT);
                }

                else {
                    echo "Failed to retrieve data from database.<br>";
                }

                // for FloorAmenities
                $result = floorAdminReadAmenities($conn);

                if ($result) {
                    header("Content-Type: JSON");
                    $rowNumber = 0;
                    $output = array();
    
                    while ($row = mysqli_fetch_array($result)) {
                        $output[$rowNumber]['FloorNo'] = $row['FloorNo'];
                        $output[$rowNumber]['FAmenities'] = $row['FAmenities'];
                        $rowNumber++;
                    }
                    echo json_encode($output, JSON_PRETTY_PRINT);
                }

                else {
                    echo "Failed to retrieve data from database.<br>";
                }

            ?>
        </p>
		</div>
	  </div>
</body>

</html> 

