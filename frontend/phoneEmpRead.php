<!DOCTYPE html>
<html>
<head>
<title>Admin/Receptionist: View Phone Call Records</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
	<div class="wrapper fadeInDown">
		<div id="formContent2">
		
        <p> <?php 
                include 'C:\xampp\htdocs\Project\backend\database.php';
                include 'C:\xampp\htdocs\Project\logic\phoneQueries.php';

                $conn = connect();

                $result = phoneEmpRead($conn);
                
                if ($result) {
                    header("Content-Type: JSON");
                    $rowNumber = 0;
                    $output = array();
    
                    while ($row = mysqli_fetch_array($result)) {
                        $output[$rowNumber]['CallID'] = $row['CallID'];
                        $output[$rowNumber]['Duration'] = $row['Duration'];
                        $output[$rowNumber]['CallDate'] = $row['CallDate'];
                        $output[$rowNumber]['GuestID'] = $row['GuestID'];
                        $output[$rowNumber]['EmpSSN'] = $row['EmpSSN'];
                        echo "Caller ID: ". $output[$rowNumber]['CallID'] . "<br> Duration: " . $output[$rowNumber]['Duration'] . 
                        "<br> Call Date: " .$output[$rowNumber]['CallDate'] . "<br> Guest ID: " . $output[$rowNumber]['GuestID'] . "<br> Employee SSN: " . 
                        $output[$rowNumber]['EmpSSN'] . "<br> <br>";

                        $rowNumber++;
                    }
                   // echo json_encode($output, JSON_PRETTY_PRINT);

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

