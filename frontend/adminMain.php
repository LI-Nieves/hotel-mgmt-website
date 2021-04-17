<!DOCTYPE html>
<html>
<head>
<title>Admin View Information</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
	<div class="wrapper fadeInDown">
		<div id="formContent2">
		
        
                <h1>Hello Admin</h1>
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
                <input type="submit" id="modRoom" class="fadeIn second" value="Modify Rooms"/>
            
                <input type="submit" id="viewEmp" class="fadeIn second" value="View Employees"/>
                <input type="submit" id="modEmp" class="fadeIn second" value="Modify Employees"/>
                <input type="submit" id="makeEmp" class="fadeIn second" value="Create Employees"/>
                <input type="submit" id="deleteEmp" class="fadeIn second" value="Delete Employees"/>

                <input type="submit" id="viewEmpDep" class="fadeIn second" value="View Employees Dependents"/>
                <input type="submit" id="makeEmpDep" class="fadeIn second" value="Create Employees Dependents"/>
                <input type="submit" id="removeEmpDep" class="fadeIn second" value="Delete Employees Dependents"/>
                <input type="submit" id="modEmpDep" class="fadeIn second" value="Modify Employees Dependents"/>

                <input type="submit" id="makeBen" class="fadeIn second" value="Create Dependents Benefits"/>
                <input type="submit" id="deleteBen" class="fadeIn second" value="Delete Dependents Benefits"/>

                <input type="submit" id="viewTrans" class="fadeIn second" value="View Transactions"/>
                <input type="submit" id="makeTrans" class="fadeIn second" value="Create Transaction"/>

                <input type="submit" id="viewRes" class="fadeIn second" value="View Reservations"/>
                <input type="submit" id="makeRes" class="fadeIn second" value="Create Reservation"/>
                <input type="submit" id="removeRes" class="fadeIn second" value="Delete Reservation"/>

                <input type="submit" id="viewFl" class="fadeIn second" value="View Floor"/>
                <input type="submit" id="modFl" class="fadeIn second" value="Modify Floor"/>
                

                <input type="submit" id="viewGuest" class="fadeIn second" value="View Guests"/>
                <input type="submit" id="makeGuest" class="fadeIn second" value="Create Guests"/>
                <input type="submit" id="deleteGuest" class="fadeIn second" value="Delete Guests"/>


                <input type="submit" id="viewPh" class="fadeIn second" value="View Phone Calls"/>
                <input type="submit" id="makePh" class="fadeIn second" value="Create Phone Calls"/>
                <input type="submit" id="removePh" class="fadeIn second" value="Delete Phone Calls"/>



        </p>
        <script>
        //Room
            var btn= document.getElementById('viewRoom');
            btn.addEventListener('click',function(){
                document.location.href ='roomEmpRead.php';
            });
            var btn3= document.getElementById('modRoom');
            btn3.addEventListener('click',function(){
                document.location.href ='roomAdminWrite.php';
            });
            //Employee
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
            var btn94= document.getElementById('deleteEmp');
            btn94.addEventListener('click',function(){
                document.location.href ='empAdminDel.php';
            });

            //Dependants
            var btn7= document.getElementById('viewEmpDep');
            btn7.addEventListener('click',function(){
                document.location.href ='depAdminRead.php';
            });
            var btn8= document.getElementById('makeEmpDep');
            btn8.addEventListener('click',function(){
                document.location.href ='depAdminNew.php';
            });
            var btn9= document.getElementById('removeEmpDep');
            btn9.addEventListener('click',function(){
                document.location.href ='depAdminDel.php';
            });

            var btn91= document.getElementById('modEmpDep');
            btn91.addEventListener('click',function(){
                document.location.href ='depAdminWrite.php';
            });
            //Benefits
            var btn92= document.getElementById('makeBen');
            btn92.addEventListener('click',function(){
                document.location.href ='depBenAdminNew.php';
            });
            var btn93= document.getElementById('deleteBen');
            btn93.addEventListener('click',function(){
                document.location.href ='depBenAdminDel.php';
            });

             //Transaction View 
             var btn17= document.getElementById('viewTrans');
            btn17.addEventListener('click',function(){
                document.location.href ='transEmpRead.php';
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
           
            
            </script>
		</div>
	  </div>
</body>

</html> 

