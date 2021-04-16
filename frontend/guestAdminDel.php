<!DOCTYPE html>
<html>
<head>
<title>Admin: Delete Guest Record</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
	<div class="wrapper fadeInDown">
		<div id="formContent2">

        <form action = "<?php $_PHP_SELF ?>" method = "POST">
            <input type = "text" name = "gID" placeholder = "ID of Guest to delete" /><br>
            <input type = "submit" />
        </form>
		
        <p> <?php 
                include 'C:\xampp\htdocs\Project\backend\database.php';
                include 'C:\xampp\htdocs\Project\logic\guestQueries.php';

                $gID  = $_POST["gID"];
                
                $conn1 = connect();
                $initial = countEntries($conn1,"CALL guestAdminRead()");
                
                $conn2 = connect();
                guestAdminDel($conn2,$gID);

                $conn3 = connect();
                $final = countEntries($conn3,"CALL guestAdminRead()");

                // if there's no difference in # of records, nothing was really deleted; fail
                if ($initial == $final) {
                    echo "Failed to delete Guest record. Please ensure you entered details for existing Guest.<br>";
                }
                else {
                    echo "Successfully deleted Guest record.<br>";
                }


/*                 // count how many records there are, pre-"deletion"
                $initial = countEntries($conn,"SELECT * FROM Guest");

                $result = guestAdminDel($conn,$gID);

                if ($result) {
                    // looking at all records in the Guest table
                    $sqlCheck = "SELECT * FROM Guest";
                    
                    // count how many records there are post-"deletion"
                    $final = countEntries($conn,$sqlCheck);

                    // if there's no difference in # of records, nothing was really deleted; fail
                    if ($initial == $final) {
                        echo "Failed to delete Guest record. Please ensure you entered details for existing Guest.<br>";
                    }
                    else {
                        echo "Successfully deleted Guest record.<br>";
                    }
                }
                else {
                    echo "Failed to delete Guest record.<br>";
                } */

            ?>
        </p>
		</div>
	  </div>

</body>

</html> 