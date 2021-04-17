<!DOCTYPE html>
<html>
<head>
<title>Admin/Receptionist: View Reservations</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
	<div class="wrapper fadeInDown">
		<div id="formContent2">
		
        <p> <?php 
                include_once 'C:\xampp\htdocs\Project\backend\database.php';
                include_once 'C:\xampp\htdocs\Project\logic\employeeQueries.php';
                include_once 'C:\xampp\htdocs\Project\logic\reservationQueries.php';

                $conn = connect();

                $result = resEmpRead($conn);
                
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
                            $validRes = true;
                        }
                        echo "Reservation No: ". $output[$rowNumber]['ResID'] . "<br> Start Date: " . $output[$rowNumber]['StartDate'] . 
                        "<br> End Date: " .$output[$rowNumber]['EndDate'] . "<br> Room No: " . $output[$rowNumber]['RoomNo'] . "<br> Floor No: " . 
                        $output[$rowNumber]['FloorNo'] . "<br> Number of People: " . $output[$rowNumber]['NumPeople'] . "<br> Confirmation No: " .
                        $output[$rowNumber]['ConfirmNo'] . "<br> Guest ID: " . $output[$rowNumber]['GuestID'] . "<br> <br>";

                        $rowNumber++;
                    }
                    
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

