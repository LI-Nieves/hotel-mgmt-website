<!DOCTYPE html>
<html>
<head>
<title>Admin/Receptionist: View Transactions</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
	<div class="wrapper fadeInDown">
		<div id="formContent2">
		
        <p> <?php 
                include 'C:\xampp\htdocs\Project\backend\database.php';
                include 'C:\xampp\htdocs\Project\logic\transactionQueries.php';

                $conn = connect();

                $result = transEmpRead($conn);
                
                if ($result) {
                    header("Content-Type: JSON");
                    $rowNumber = 0;
                    $output = array();
    
                    while ($row = mysqli_fetch_array($result)) {
                        $output[$rowNumber]['TransID'] = $row['TransID'];
                        $output[$rowNumber]['TransDate'] = $row['TransDate'];
                        $output[$rowNumber]['PaymentType'] = $row['PaymentType'];
                        $output[$rowNumber]['Cost'] = $row['Cost'];
                        $output[$rowNumber]['GuestID'] = $row['GuestID'];
                        $output[$rowNumber]['EmpSSN'] = $row['EmpSSN'];
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

