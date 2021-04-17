<!DOCTYPE html>
<html>
<head>
<title>Employee: View My Dependents and Benefits</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
	<div class="wrapper fadeInDown">
		<div id="formContent2">
		<h1>Dependents</h1>
        <p> <?php 
                include_once 'C:\xampp\htdocs\Project\backend\database.php';
                include_once 'C:\xampp\htdocs\Project\logic\depAndBenQueries.php';

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
                        echo "Employee SSN: ". $output[$rowNumber]['EmpSSN'] . "<br> Dependent SSN: " . $output[$rowNumber]['DepSSN'] . 
                        "<br> Dependent Name: " .$output[$rowNumber]['DepName'] . "<br> <br>";

                        $rowNumber++;
                    }
                    //echo json_encode($output, JSON_PRETTY_PRINT);
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
                        echo "Employee SSN: ". $output[$rowNumber]['EmpSSN'] . "<br> Dependent SSN: " . $output[$rowNumber]['DepSSN'] . 
                        "<br> Dependent Benefits: " .$output[$rowNumber]['DepBenefits'] . "<br> <br>";
                        $rowNumber++;
                    }
                    //echo json_encode($output, JSON_PRETTY_PRINT);
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