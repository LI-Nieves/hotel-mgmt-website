<!DOCTYPE html>
<html>
<head>
<title>Admin: View Employees</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
	<div class="wrapper fadeInDown">
		<div id="formContent2">
		<h1>List of Employees</h1>
        <p> <?php 
                include_once 'C:\xampp\htdocs\Project\backend\database.php';
                include_once 'C:\xampp\htdocs\Project\logic\employeeQueries.php';

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
                   
                    echo "SSN: ". $output[$rowNumber]['SSN'] . "<br> First Name: " . $output[$rowNumber]['Fname'] . 
                        "<br> Last Name: " .$output[$rowNumber]['Lname'] . "<br> Address: " . $output[$rowNumber]['Address'] . 
                        "<br> Salary: " . $output[$rowNumber]['Salary'] . "<br> Sex: " . 
                        $output[$rowNumber]['Sex'] . "<br> Date of Birth: " . $output[$rowNumber]['DoB'] . 
                        "<br> Employee Login: " . $output[$rowNumber]['EmpLogin'] . 
                        "<br> Employee Pass: " . $output[$rowNumber]['EmpPass'] . 
                        "<br> SuperSSN: " . $output[$rowNumber]['SuperSSN'] . 
                        "<br> Phone: " . $output[$rowNumber]['BusiPhone'] . 
                        "<br> Email: " . $output[$rowNumber]['BusiEmail'] . 
                        "<br> Role: " . $output[$rowNumber]['ERole'] . 
                        "<br> Admin Login: " . $output[$rowNumber]['AdminLogin'] . 
                        "<br> Admin Pass: " . $output[$rowNumber]['AdminPass'] . 
                        "<br> Receptionist Login: " . $output[$rowNumber]['RecepLogin'] . 
                        "<br> Receptionist Pass: " . $output[$rowNumber]['RecepPass'] . 


                         "<br> <br>";
                    $rowNumber++;

                }
                json_encode($output);
               

            ?>
        </p>
        <input type="button" id="back" class="fadeIn second" value="Back"/>
        <script>
        var btn= document.getElementById('back');
                    btn.addEventListener('click',function(){
                        document.location.href ='adminMain.php';
                    }
                    );
        </script>
		</div>
	  </div>
</body>

</html> 

