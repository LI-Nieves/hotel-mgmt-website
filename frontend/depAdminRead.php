<!DOCTYPE html>
<html>
<head>
<title>Admin: View All Dependents and Benefits</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
	<div class="wrapper fadeInDown">
		<div id="formContent2">
		
        <p> <?php 
                include 'C:\xampp\htdocs\Project\backend\database.php';
                include 'C:\xampp\htdocs\Project\logic\depAndBenQueries.php';

                $conn = connect();
                // Pulling data from Dependent table
                $result = depAdminRead($conn,0);
                
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

                // Pulling data from DepBenefits table
                $conn = connect();
                $result2 = depAdminRead($conn,3);

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