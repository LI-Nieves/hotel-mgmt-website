<!DOCTYPE html>
<html>
<head>
<title>Admin/Receptionist: View Reservations</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
	<div class="wrapper fadeInDown">
		<div id="formContent2">
		<h1>Hello Employee</h1>
        <p> <?php 
                include_once 'C:\xampp\htdocs\Project\backend\database.php';
                include_once 'C:\xampp\htdocs\Project\logic\employeeQueries.php';

                $conn = connect();

                $result = empEmpRead($conn);
                
                if ($result) {
                    header("Content-Type: JSON");
                    $rowNumber = 0;
                    $output = array();
    
                    while ($row = mysqli_fetch_array($result)) {
                        $output[$rowNumber]['SSN'] = $row['SSN'];
                        $output[$rowNumber]['Fname'] = $row['Fname'];
                        $output[$rowNumber]['Lname'] = $row['Lname'];
                        $output[$rowNumber]['Salary'] = $row['Salary'];
                        $output[$rowNumber]['Sex'] = $row['Sex'];
                        $output[$rowNumber]['DoB'] = $row['DoB'];
                        $output[$rowNumber]['ERole'] = $row['ERole'];
  
                        
                        if($output[$rowNumber]['SSN'] = $row['SSN']){
                            $correctRow = $rowNumber;
                            echo "SSN: ". $output[$rowNumber]['SSN'] . "<br> First Name: " . $output[$rowNumber]['Fname'] . 
                            "<br> Last Name: " .$output[$rowNumber]['Lname'] . 
                            "<br> Salary: " . $output[$rowNumber]['Salary'] . "<br> Sex: " . 
                            $output[$rowNumber]['Sex'] . "<br> Date of Birth: " . $output[$rowNumber]['DoB'] .        
                    
                            "<br> Role: " . $output[$rowNumber]['ERole'] . 
                             "<br> <br>";
                        
                        }
                        $rowNumber++;
                    }
                    
                }
                else {
                    echo "Failed to retrieve data from the database.<br>";
                }

            ?>
                <input type="submit" id="viewRoom" class="fadeIn second" value="View Rooms"/>
                <input type="submit" id="viewR" class="fadeIn second" value="Update Clean Status"/>  
        </p>

        <script>
                var btn= document.getElementById('viewRoom');
                 btn.addEventListener('click',function(){
                document.location.href ='roomEmpRead.php';
                 });
                var btn7= document.getElementById('viewEmpDep');
            btn7.addEventListener('click',function(){
                document.location.href ='roomEmpWrite.php';
            });
            </script>
		</div>
	  </div>
</body>

</html> 

