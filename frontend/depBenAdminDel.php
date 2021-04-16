<!DOCTYPE html>
<html>
<head>
<title>Admin: Delete Dependent's Benefits</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
	<div class="wrapper fadeInDown">
		<div id="formContent2">

        <form action = "<?php $_PHP_SELF ?>" method = "POST">
            <input type = "text" name = "eSSN" placeholder = "SSN of Employee" /><br>
            <input type = "text" name = "dSSN" placeholder = "SSN of Dependent" /><br>
            <input type = "text" name = "dBen" placeholder = "Benefit name" /><br>
            <input type = "submit" />
        </form>
		
        <p> <?php 
                include 'C:\xampp\htdocs\Project\backend\database.php';
                include 'C:\xampp\htdocs\Project\logic\depAndBenQueries.php';

                $eSSN  = $_POST["eSSN"];
                $dSSN  = $_POST["dSSN"];
                $dBen  = $_POST["dBen"];
                
                $conn = connect();

                // count how many records there are, pre-"deletion"
                $initial = countEntries($conn,"SELECT * FROM DepBenefits");

                $result = depBenAdminDel($conn,$eSSN,$dSSN,$dBen);

                if ($result) {
                    // looking at all records in the DepBenefits table
                    $sqlCheck = "SELECT * FROM DepBenefits";
                    
                    // count how many records there are post-"deletion"
                    $final = countEntries($conn,$sqlCheck);

                    // if there's no difference in # of records, nothing was really deleted; fail
                    if ($initial == $final) {
                        echo "Failed to delete Benefit for that Dependent. Please ensure you entered details for an existing Benefit for that Dependent.<br>";
                    }
                    else {
                        echo "Successfully deleted Benefit for that Dependent record.<br>";
                    }
                }
                else {
                    echo "Failed to delete Benefit for that Dependent record.<br>";
                }

            ?>
        </p>
		</div>
	  </div>

</body>

</html> 