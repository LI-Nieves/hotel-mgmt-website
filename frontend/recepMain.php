<!DOCTYPE html>
<html>
<head>
<title>Admin/Receptionist: View Reservations</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
	<div class="wrapper fadeInDown">
		<div id="formContent2">
		<h1>Hello Receptionist</h1>
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
                    json_encode($output);
                    
                }
                else {
                    echo "Failed to retrieve data from the database.<br>";
                }

            ?>
                
            </p>

                <input type="submit" id="viewRoom" class="fadeIn second" value="View Rooms"/>

                <input type="submit" id="check" class="fadeIn second" value="Check In/Out"/>

                <input type="submit" id="viewPh" class="fadeIn second" value="View Phone Calls"/>
                <input type="submit" id="makePh" class="fadeIn second" value="Create Phone Calls"/>

                <input type="submit" id="viewTrans" class="fadeIn second" value="View Transactions"/>
                <input type="submit" id="makeTrans" class="fadeIn second" value="Create Transaction"/>

                <input type="submit" id="viewRes" class="fadeIn second" value="View Reservations"/>
                <input type="submit" id="makeRes" class="fadeIn second" value="Create Reservation"/>
                <input type="submit" id="removeRes" class="fadeIn second" value="Delete Reservation"/>

                <input type="submit" id="modEmpPass" class="fadeIn second" value="Change Employee Password"/>
                <input type="button" id="logOut" class="fadeIn second" value="Log Out"/>

                <script>
                 var btn33= document.getElementById('logOut');
                btn33.addEventListener('click',function(){
                    document.location.href ='login.php';
                }
                );
                var btn= document.getElementById('viewRoom');
                 btn.addEventListener('click',function(){
                document.location.href ='roomEmpRead.php';
                });
                var btn32= document.getElementById('check');
                btn32.addEventListener('click',function(){
                    document.location.href ='roomRecepWrite.php';
                });    
                //Phone
                var btn27= document.getElementById('viewPh');
                btn27.addEventListener('click',function(){
                    document.location.href ='phoneEmpRead.php';
                });
                var btn29= document.getElementById('makePh');
                btn29.addEventListener('click',function(){
                    document.location.href ='phoneEmpNew.php';
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

                    var btn72= document.getElementById('modEmpPass');
                btn72.addEventListener('click',function(){
                    document.location.href ='empChangePass.php';
                });

                 //Transaction  
                var btn17= document.getElementById('viewTrans');
                btn17.addEventListener('click',function(){
                    document.location.href ='transEmpRead.php';
                });
                var btn18= document.getElementById('makeTrans');
                btn18.addEventListener('click',function(){
                document.location.href ='transEmpNew.php';
            });
                </script>
        </p>
		</div>
	  </div>
</body>

</html> 

