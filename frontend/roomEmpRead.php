<!DOCTYPE html>
<html>
<head>
<title>Admin/Employee: View Rooms</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
	<div class="wrapper fadeInDown">
		<div id="formContent2">

		<h1>Current Rooms</h1>
        <p> <?php 
                include_once 'C:\xampp\htdocs\Project\backend\database.php';
                include_once 'C:\xampp\htdocs\Project\logic\roomQueries.php';

                $conn = connect();

                $result = roomEmpRead($conn);
                
                if ($result) {
                    header("Content-Type: JSON");
                    $rowNumber = 0;
                    $output = array();
    
                    while ($row = mysqli_fetch_array($result)) {
                        $output[$rowNumber]['FloorNo'] = $row['FloorNo'];
                        $output[$rowNumber]['RoomNo'] = $row['RoomNo'];
                        $output[$rowNumber]['Cost'] = $row['Cost'];
                        $output[$rowNumber]['Beds'] = $row['Beds'];
                        $output[$rowNumber]['CleanStatus'] = $row['CleanStatus'];
                        $output[$rowNumber]['RoomType'] = $row['RoomType'];
                        $output[$rowNumber]['GCheckIn'] = $row['GCheckIn'];
                        $output[$rowNumber]['ChkInDate'] = $row['ChkInDate'];
                        $output[$rowNumber]['GCheckOut'] = $row['GCheckOut'];
                        $output[$rowNumber]['ChkOutDate'] = $row['ChkOutDate'];
                        echo "Floor No: ". $output[$rowNumber]['FloorNo'] . "<br> Room No: " . $output[$rowNumber]['RoomNo'] . 
                        "<br> Cost: " .$output[$rowNumber]['Cost'] . "<br> Beds: " . $output[$rowNumber]['Beds'] . "<br> Clean Status: " . 
                        $output[$rowNumber]['CleanStatus'] . "<br> Room Type: " . $output[$rowNumber]['RoomType'] . "<br> Guest Checked In: " . 
                        $output[$rowNumber]['GCheckIn'] . "<br> <br>";
                        $rowNumber++;
                    }
                   // echo json_encode($output, JSON_PRETTY_PRINT);
                    
                }
                else {
                    echo "Failed to retrieve data from the database.<br>";
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

