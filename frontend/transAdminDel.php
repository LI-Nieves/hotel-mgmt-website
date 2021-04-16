<!DOCTYPE html>
<html>
<head>
<title>Admin: Delete Transaction Record</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
	<div class="wrapper fadeInDown">
		<div id="formContent2">

        <form action = "<?php $_PHP_SELF ?>" method = "POST">
            <input type = "text" name = "tID" placeholder = "Transaction ID" /><br>
            <input type = "submit" />
        </form>
		
        <p> <?php 
                include 'C:\xampp\htdocs\Project\backend\database.php';
                include 'C:\xampp\htdocs\Project\logic\transactionQueries.php';

                $tID  = $_POST["tID"];
                
                $conn = connect();

                // count how many records there are, pre-"deletion"
                $initial = countEntries($conn,"SELECT * FROM Transactions");

                $result = transAdminDel($conn,$tID);

                if ($result) {
                    // looking at all records in the Transactions table
                    $sqlCheck = "SELECT * FROM Transactions";
                    
                    // count how many records there are post-"deletion"
                    $final = countEntries($conn,$sqlCheck);

                    // if there's no difference in # of records, nothing was really deleted; fail
                    if ($initial == $final) {
                        echo "Failed to delete Transaction record. Please ensure you entered details for an existing Transaction.<br>";
                    }
                    else {
                        echo "Successfully deleted Transaction record.<br>";
                    }
                }
                else {
                    echo "Failed to delete Transaction record.<br>";
                }

            ?>
        </p>
		</div>
	  </div>

</body>

</html> 