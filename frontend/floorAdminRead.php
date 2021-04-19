<!DOCTYPE html>
<html>
<head>
<title>Admin: View Floors</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
	<div class="wrapper fadeInDown">
		<div id="formContent2">
		<h1>View Floors</h1>
        <p> <?php 
                include_once 'C:\xampp\htdocs\Project\backend\database.php';
                include_once 'C:\xampp\htdocs\Project\logic\floorQueries.php';

                $conn = connect();

                // Pulling data from Floors table
                $result = floorAdminRead($conn);

                if ($result) {
                    header("Content-Type: JSON");
                    $rowNumber = 0;
                    $output = array();
    
                    while ($row = mysqli_fetch_array($result)) {
                        $output[$rowNumber]['FloorNo'] = $row['FloorNo'];
                        $output[$rowNumber]['FAmenities'] = $row['FAmenities'];
                        $output[$rowNumber]['NumUtilities'] = $row['NumUtilities'];
                        echo "Floor No: ". $output[$rowNumber]['FloorNo'] . "<br> Floor Amenities " . $output[$rowNumber]['FAmenities'] . 
                        "<br> Number of Utilities: " .$output[$rowNumber]['NumUtilities'] . "<br> <br>";

                        $rowNumber++;

                    }
                   json_encode($output, JSON_PRETTY_PRINT);
                }

                else {
                    echo "Failed to retrieve data from database.<br>";
                }

                // Pulling data from MaintHandling table
                $conn2 = connect();
                $result2 = maintAdminRead($conn2);

                if ($result2) {
                    header("Content-Type: JSON");
                    $rowNumber = 0;
                    $output = array();
    
                    while ($row = mysqli_fetch_array($result2)) {
                        $output[$rowNumber]['MaintSSN'] = $row['MaintSSN'];
                        $output[$rowNumber]['FloorNo'] = $row['FloorNo'];
                        echo "Maintenance SSN: ". $output[$rowNumber]['MaintSSN'] . "<br> Floor No " . $output[$rowNumber]['FloorNo'] . 
                       "<br> <br>";

                        $rowNumber++;
                    }
                   json_encode($output, JSON_PRETTY_PRINT);
                }
                else {
                    echo "Failed to retrieve data from database.<br>";
                }

            ?>
        </p>
        <input type="button" id="back" class="fadeIn second" value="Back"/>
        <script>
        var btn= document.getElementById('back');
                    btn.addEventListener('click',function(){
                        window.history.back();
                    }
                    );
        </script>
		</div>
	  </div>
</body>

</html> 

