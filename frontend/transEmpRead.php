<!DOCTYPE html>
<html>
<head>
<title>Admin/Receptionist: View Transactions</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
	<div class="wrapper fadeInDown">
		<div id="formContent2">
		<h1>List of Transactions</h1>
        <p> <?php 
                include_once 'C:\xampp\htdocs\Project\backend\database.php';
                include_once 'C:\xampp\htdocs\Project\logic\transactionQueries.php';

                $conn = connect();

                $result = transEmpRead($conn);
                
                if ($result) {
                    header("Content-Type: JSON");
                    $rowNumber = 0;
                    $output = array();
    
                    while ($row = mysqli_fetch_array($result)) {
                        $output[$rowNumber]['TransID'] = $row['TransID'];
                        $output[$rowNumber]['TransDate'] = $row['TransDate'];
                        $output[$rowNumber]['PaymentType'] = $row['PaymentType'];
                        $output[$rowNumber]['Cost'] = $row['Cost'];
                        $output[$rowNumber]['GuestID'] = $row['GuestID'];
                        $output[$rowNumber]['EmpSSN'] = $row['EmpSSN'];

                        echo "Transaction ID: ". $output[$rowNumber]['TransID'] . "<br> Transaction Date: " . $output[$rowNumber]['TransDate'] . 
                        "<br> Payment Type: " .$output[$rowNumber]['PaymentType'] . "<br> Cost: " . $output[$rowNumber]['Cost'] . 
                        "<br> Guest ID: " . $output[$rowNumber]['GuestID'] . "<br> Employee SSN: " . 
                        $output[$rowNumber]['EmpSSN'] . 

                         "<br> <br>";

                        $rowNumber++;
                    }
                   
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

