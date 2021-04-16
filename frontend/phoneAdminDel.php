<!DOCTYPE html>
<html>
<head>
<title>Admin: Delete Phone Call Record</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
	<div class="wrapper fadeInDown">
		<div id="formContent2">

        <form action = "<?php $_PHP_SELF ?>" method = "POST">
            <input type = "text" name = "cID" placeholder = "Call ID" /><br>
            <input type = "submit" />
        </form>
		
        <p> <?php 
                include 'C:\xampp\htdocs\Project\backend\database.php';
                include 'C:\xampp\htdocs\Project\logic\phoneQueries.php';

                $cID  = $_POST["cID"];
                
                $conn1 = connect();
                $initial = countEntries($conn1,"CALL phoneEmpRead()");
                
                $conn2 = connect();
                phoneAdminDel($conn2,$cID);

                $conn3 = connect();
                $final = countEntries($conn3,"CALL phoneEmpRead()");

                // if there's no difference in # of records, nothing was really deleted; fail
                if ($initial == $final) {
                    echo "Failed to delete Phone Call record. Please ensure you entered details for existing Phone Call.<br>";
                }
                else {
                    echo "Successfully deleted Phone Call record.<br>";
                }

/*                 // count how many records there are, pre-"deletion"
                $initial = countEntries($conn,"SELECT * FROM PhoneCall");

                $result = phoneAdminDel($conn,$cID);

                if ($result) {
                    // looking at all records in the PhoneCall table
                    $sqlCheck = "SELECT * FROM PhoneCall";
                    
                    // count how many records there are post-"deletion"
                    $final = countEntries($conn,$sqlCheck);

                    // if there's no difference in # of records, nothing was really deleted; fail
                    if ($initial == $final) {
                        echo "Failed to delete Phone Call record. Please ensure you entered details for an existing Phone Call.<br>";
                    }
                    else {
                        echo "Successfully deleted Phone Call record.<br>";
                    }
                }
                else {
                    echo "Failed to delete Phone Call record.<br>";
                } */

            ?>
        </p>
		</div>
	  </div>

</body>

</html> 