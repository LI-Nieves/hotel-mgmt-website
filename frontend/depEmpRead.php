<!DOCTYPE html>
<html>
<head>
<title>Employee: View My Dependents and Benefits</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
	<div class="wrapper fadeInDown">
		<div id="formContent2">
		
        <p> <?php 
                include 'C:\xampp\htdocs\Project\backend\database.php';
                include 'C:\xampp\htdocs\Project\logic\depAndBenQueries.php';

                $conn = connect();
                $result = depEmp($conn,'000000000','000000000','',0);
                
                // Pulling data from the Dependent table
                if ($result) {
                    header("Content-Type: JSON");
                    $rowNumber = 0;
                    $output = array();
    
                    while ($row = mysqli_fetch_array($result)) {
                        $output[$rowNumber]['EmpSSN'] = $row['EmpSSN'];
                        $output[$rowNumber]['DepSSN'] = $row['DepSSN'];
                        $output[$rowNumber]['DepName'] = $row['DepName'];
                        $rowNumber++;
                    }
                    echo json_encode($output, JSON_PRETTY_PRINT);
                }
                else {
                    echo "Failed to retrieve data from the database.<br>";
                }

                $conn = connect();
                $result2 = depEmp($conn,'000000000','000000000','',3);

                // Pulling data from the DepBenefits table
                if ($result2) {
                    header("Content-Type: JSON");
                    $rowNumber = 0;
                    $output = array();
    
                    while ($row = mysqli_fetch_array($result2)) {
                        $output[$rowNumber]['EmpSSN'] = $row['EmpSSN'];
                        $output[$rowNumber]['DepSSN'] = $row['DepSSN'];
                        $output[$rowNumber]['DepBenefits'] = $row['DepBenefits'];
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