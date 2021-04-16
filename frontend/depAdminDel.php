<!DOCTYPE html>
<html>
<head>
<title>Admin: Delete Dependents</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
	<div class="wrapper fadeInDown">
		<div id="formContent2">

        <form action = "<?php $_PHP_SELF ?>" method = "POST">
            <input type = "text" name = "eSSN" placeholder = "SSN of Employee" /><br>
            <input type = "text" name = "dSSN" placeholder = "SSN of Dependent" /><br>
            <input type = "submit" />
        </form>
		
        <p> <?php 
                include 'C:\xampp\htdocs\Project\backend\database.php';
                include 'C:\xampp\htdocs\Project\logic\depAndBenQueries.php';

                $eSSN  = $_POST["eSSN"];
                $dSSN  = $_POST["dSSN"];
                
                $conn = connect();

                // count how many records there are, pre-"deletion"
                $initial = countEntries($conn,"SELECT * FROM Dependent");

                $result = depAdminDel($conn,$eSSN,$dSSN);

                if ($result) {
                    // looking at all records in the Dependent table
                    $sqlCheck = "SELECT * FROM Dependent";
                    
                    // count how many records there are post-"deletion"
                    $final = countEntries($conn,$sqlCheck);

                    // if there's no difference in # of records, nothing was really deleted; fail
                    if ($initial == $final) {
                        echo "Failed to delete Dependent record. Please ensure you entered details for an existing Dependent.<br>";
                    }
                    else {
                        echo "Successfully deleted Dependent record.<br>";
                    }
                }
                else {
                    echo "Failed to delete Dependent record.<br>";
                }
            ?>
        </p>
		</div>
	  </div>

</body>

</html> 