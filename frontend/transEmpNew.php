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
            <input type = "text" name = "tDate" placeholder = "Transaction date (optional)"/>
            <input type = "text" name = "tType" placeholder = "Payment type (optional)"/>
            <input type = "text" name = "tCost" placeholder = "Cost"/>
            <input type = "text" name = "tGuestID" placeholder = "Guest's ID (optional)"/>
            <input type = "submit" />
        </form>
		
        <p> <?php 
                include 'C:\xampp\htdocs\Project\backend\database.php';
                include 'C:\xampp\htdocs\Project\logic\transactionQueries.php';

                $tDate      = $_POST["tDate"];
                $tType      = $_POST["tType"];
                $tCost      = $_POST["tCost"];
                $tGuestID   = $_POST["tGuestID"];

                $conn = connect();

                $result = transEmpNew($conn,$tDate,$tType,$tCost,$tGuestID);

                
                if ($result) {
                    echo "Successfully created transaction.<br>Here's the Transaction ID: $result";
                    json_encode($result, JSON_PRETTY_PRINT);
                }
                else {
                    echo "Failed to add data to the database. 
                        Please ensure the Guest ID exists in the database.<br>";
                }

            ?>
        </p>
		</div>
	  </div>

</body>

</html> 