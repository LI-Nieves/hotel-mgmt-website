<!DOCTYPE html>
<html>
<head>
<title>Admin: View All Guests</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
	<div class="wrapper fadeInDown">
		<div id="formContent2">
		
        <p> <?php 
                include 'C:\xampp\htdocs\Project\backend\database.php';
                include 'C:\xampp\htdocs\Project\logic\guestQueries.php';

                $conn = connect();

                $result = guestAdminRead($conn);
                
                if ($result) {
                    header("Content-Type: JSON");
                    $rowNumber = 0;
                    $output = array();
    
                    while ($row = mysqli_fetch_array($result)) {
                        $output[$rowNumber]['GuestID'] = $row['GuestID'];
                        $output[$rowNumber]['GuestLogin'] = $row['GuestLogin'];
                        $output[$rowNumber]['CreditCard'] = $row['CreditCard'];
                        $output[$rowNumber]['PhoneNo'] = $row['PhoneNo'];
                        $output[$rowNumber]['GuestName'] = $row['GuestName'];
                        $output[$rowNumber]['Address'] = $row['Address'];
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