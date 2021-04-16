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
                        }
                        $rowNumber++;
                    }
                    
                }
                else {
                    echo "Failed to retrieve data from the database.<br>";
                }

            ?>
                <h1>Hello Receptionist</h1>
                <h3>This is your Information</h3>
                <p>SSN: <?php echo $output[$correctRow]['SSN']; ?></p>
                <p>First Name: <?php echo $output[$correctRow]['Fname']; ?></p>
                <p>Last Name: <?php echo $output[$correctRow]['Lname']; ?></p>
                <p>Salary: <?php echo ($output[$correctRow]['Salary']); ?></p>
                <p>Sex: <?php echo $output[$correctRow]['Sex']; ?></p>
                <p>Date of Birth: <?php echo $output[$correctRow]['DoB']; ?></p>
                <p>Role: <?php echo $output[$correctRow]['ERole']; ?></p>   
                </p>

                <input type="submit" id="viewRoom" class="fadeIn second" value="View Rooms"/>

                <input type="button" id="modRoomClean" class="fadeIn second" value="Update Clean Status"/>

        </p>
		</div>
	  </div>
</body>

</html> 

