<!DOCTYPE html>
<html>
<head>
<title>Admin: Delete Employee Record</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
	<div class="wrapper fadeInDown">
		<div id="formContent2">

        <form action = "<?php $_PHP_SELF ?>" method = "POST">
            <input type = "text" name = "eSSN" placeholder = "SSN of Employee to delete" /><br>
            <input type = "submit" />
        </form>
		
        <p> <?php 
                include 'C:\xampp\htdocs\Project\backend\database.php';
                include 'C:\xampp\htdocs\Project\logic\employeeQueries.php';

                $eSSN  = $_POST["eSSN"];
                
                $conn = connect();

                // count how many records there are, pre-"deletion"
                $initial = countEntries($conn,"SELECT * FROM Employee");

                $result = empAdminDel($conn,$eSSN);

                if ($result) {
                    // looking at all records in the Employee table
                    $sqlCheck = "SELECT * FROM Employee";
                    
                    // count how many records there are post-"deletion"
                    $final = countEntries($conn,$sqlCheck);

                    // if there's no difference in # of records, nothing was really deleted; fail
                    if ($initial == $final) {
                        echo "Failed to delete Employee record. Please ensure you entered details for existing Employee.<br>";
                    }
                    else {
                        echo "Successfully deleted Employee record.<br>";
                    }
                }
                else {
                    echo "Failed to delete Employee record.<br>";
                }

            ?>
        </p>
		</div>
	  </div>

</body>

</html> 