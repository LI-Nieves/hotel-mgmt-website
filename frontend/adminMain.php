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
                <h1>Hello Admin</h1>
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
                <input type="submit" id="makeRoom" class="fadeIn second" value="Create Rooms"/>
                <input type="submit" id="modRoom" class="fadeIn second" value="Delete Rooms"/>
                <input type="submit" id="viewEmp" class="fadeIn second" value="View Employees"/>
                <input type="submit" id="modEmp" class="fadeIn second" value="Modify Employees"/>
                <input type="submit" id="makeEmp" class="fadeIn second" value="Create Employees"/>

                <input type="submit" id="viewEmpDep" class="fadeIn second" value="View Employees Dependents"/>

                <input type="submit" id="modEmpDep" class="fadeIn second" value="Modify Employees Dependents"/>

                <input type="submit" id="makeBen" class="fadeIn second" value="Create Dependents Benefits"/>
                <input type="submit" id="viewTran" class="fadeIn second" value="View Transactions"/>

                <input type="submit" id="viewRes" class="fadeIn second" value="View Reservations"/>
                <input type="submit" id="makeRes" class="fadeIn second" value="Create Reservation"/>
                <input type="submit" id="removeRes" class="fadeIn second" value="Delete Reservation"/>

                <input type="submit" id="viewFl" class="fadeIn second" value="View Floor"/>
                <input type="submit" id="modFl" class="fadeIn second" value="Modify Floor"/>
                <input type="submit" id="makeFl" class="fadeIn second" value="Create Floor"/>

                <input type="submit" id="viewGuest" class="fadeIn second" value="View Guests"/>
                <input type="submit" id="viewTrans" class="fadeIn second" value="View Transactions"/>



        </p>
        <script>
            var btn= document.getElementById('viewRoom');
            btn.addEventListener('click',function(){
                document.location.href ='roomEmpRead.php';
            });
            var btn2= document.getElementById('makeRoom');
            btn2.addEventListener('click',function(){
                document.location.href ='roomAdminNew.php';
            });
            var btn3= document.getElementById('modRoom');
            btn3.addEventListener('click',function(){
                document.location.href ='roomAdminDel.php';
            });
            var btn4= document.getElementById('viewEmp');
            btn4.addEventListener('click',function(){
                document.location.href ='empAdminRead.php';
            });
            var btn5= document.getElementById('modEmp');
            btn5.addEventListener('click',function(){
                document.location.href ='empAdminWrite.php';
            });
            var btn6= document.getElementById('makeEmp');
            btn6.addEventListener('click',function(){
                document.location.href ='empAdminNew.php';
            });
            var btn7= document.getElementById('viewEmpDep');
            btn7.addEventListener('click',function(){
                document.location.href ='depEmpRead.php';
            });
            var btn8= document.getElementById('modEmpDep');
            btn8.addEventListener('click',function(){
                document.location.href ='roomAdminDel.php';
            });
            //var btn3= document.getElementById('modRoom'); here
            btn3.addEventListener('click',function(){
                document.location.href ='roomAdminDel.php';
            });

            //reservation
            var btn10= document.getElementById('viewRes');
            btn10.addEventListener('click',function(){
                document.location.href ='resEmpRead.php';
            });
            var btn11= document.getElementById('makeRes');
            btn11.addEventListener('click',function(){
                document.location.href ='resEmpNew.php';
            });
            var btn12= document.getElementById('removeRes');
            btn12.addEventListener('click',function(){
                document.location.href ='resEmpDel.php';
            });
            //Floor
            var btn13= document.getElementById('viewFloor');
            btn13.addEventListener('click',function(){
                document.location.href ='floorAdminRead.php';
            });
            var btn14= document.getElementById('modFloor');
            btn14.addEventListener('click',function(){
                document.location.href ='floorAdminWrite.php';
            });
            //Guest 
            var btn15= document.getElementById('viewGuest');
            btn13.addEventListener('click',function(){
                document.location.href ='resEmpRead.php';//Not sure
            });
            //Transaction View 
            var btn17= document.getElementById('viewTrans');
            btn13.addEventListener('click',function(){
                document.location.href ='transEmpRead.php';
            });
            
            </script>
		</div>
	  </div>
</body>

</html> 

