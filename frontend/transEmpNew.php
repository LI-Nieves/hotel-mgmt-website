<!DOCTYPE html>
<html>
<head>
<title>Admin/Receptionist: Create Transaction</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
	<div class="wrapper fadeInDown">
		<div id="formContent2">
        <form action = "<?php $_PHP_SELF ?>" method = "POST">
        Transaction date:                   <input type = "text" name = "tDate"/>
        Payment type:                       <input type = "text" name = "tType" />
        Cost:                               <input type = "text" name = "tCost" />
        Guest's ID:                         <input type = "text" name = "tGuestID" />
        Manager's SSN (if applicable):      <input type = "text" name = "tMgrSSN" />
        Receptionist's SSN (if applicable): <input type = "text" name = "tRecSSN" />
         <input type = "submit" />
        </form>
		
        <p> <?php 
                include 'C:\xampp\htdocs\Project\backend\database.php';
                include 'C:\xampp\htdocs\Project\businessLogic\queries.php';

                $tDate      = $_POST["tDate"];
                $tType      = $_POST["tType"];
                $tCost      = $_POST["tCost"];
                $tGuestID   = $_POST["tGuestID"];
                $tMgrSSN    = $_POST["tMgrSSN"];
                $tRecSSN    = $_POST["tRecSSN"];

                $conn = connect();

                $result = transEmpNew($conn,$tDate,$tType,$tCost,$tGuestID,$tMgrSSN,$tRecSSN);
                if ($result) {
                    header("Content-Type: JSON");
                    $rowNumber = 0;
                    $output = array();
    
                    while ($row = mysqli_fetch_array($result)) {
                        $output[$rowNumber]['TransID'] = $row['TransID'];
                        $rowNumber++;
                    }
                    echo json_encode($output, JSON_PRETTY_PRINT);
                }
                else {
                    echo "Failed to add data to the database. 
                        Ensure the Employee SSN, Manager SSN, and Receptionist SSN all exist in the database.<br>
                        Note that at least one of the Manager SSN and the Receptionist SSN must be entered in.";
                }

            ?>
        </p>
		</div>
	  </div>

</body>

</html> 