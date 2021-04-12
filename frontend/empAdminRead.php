<!DOCTYPE html>
<html>
<head>
<title>Admin: View Employees</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
	<div class="wrapper fadeInDown">
		<div id="formContent2">
		
        <p> <?php 
                include 'C:\xampp\htdocs\Project\backend\database.php';
                include 'C:\xampp\htdocs\Project\logic\employeeQueries.php';

                $conn = connect();

                $result = empAdminRead($conn);

                header("Content-Type: JSON");
                $rowNumber = 0;
                $output = array();

                while ($row = mysqli_fetch_array($result)) {
                    $output[$rowNumber]['SSN'] = $row['SSN'];
                    $output[$rowNumber]['Fname'] = $row['Fname'];
                    $output[$rowNumber]['Lname'] = $row['Lname'];
                    $output[$rowNumber]['Address'] = $row['Address'];
                    $output[$rowNumber]['Salary'] = $row['Salary'];
                    $output[$rowNumber]['Sex'] = $row['Sex'];
                    $output[$rowNumber]['DoB'] = $row['DoB'];
                    $output[$rowNumber]['EmpLogin'] = $row['EmpLogin'];
                    $output[$rowNumber]['EmpPass'] = $row['EmpPass'];
                    $output[$rowNumber]['SuperSSN'] = $row['SuperSSN'];
                    $output[$rowNumber]['BusiPhone'] = $row['BusiPhone'];
                    $output[$rowNumber]['BusiEmail'] = $row['BusiEmail'];
                    $output[$rowNumber]['ERole'] = $row['ERole'];
                    $output[$rowNumber]['AdminLogin'] = $row['AdminLogin'];
                    $output[$rowNumber]['AdminPass'] = $row['AdminPass'];
                    $output[$rowNumber]['RecepLogin'] = $row['RecepLogin'];
                    $output[$rowNumber]['RecepPass'] = $row['RecepPass'];
                    $rowNumber++;
                }
                echo json_encode($output, JSON_PRETTY_PRINT);

            ?>
        </p>
		</div>
	  </div>
</body>

</html> 

