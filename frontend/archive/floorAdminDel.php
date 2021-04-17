<!DOCTYPE html>
<html>
<head>
<title>Admin: Delete Floor Record</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
	<div class="wrapper fadeInDown">
		<div id="formContent2">

        <form action = "<?php $_PHP_SELF ?>" method = "POST">
            <input type = "text" name = "fNo" placeholder = "Floor number" /><br>
            <input type = "submit" />
        </form>
		
        <p> <?php 
                include 'C:\xampp\htdocs\Project\backend\database.php';
                include 'C:\xampp\htdocs\Project\logic\floorQueries.php';

                $fNo  = $_POST["fNo"];
                
                $conn = connect();

                // count how many records there are, pre-"deletion"
                $initial = countEntries($conn,"SELECT * FROM Floors");

                $result = floorAdminDel($conn,$fNo);

                if ($result) {
                    // looking at all records in the Floors table
                    $sqlCheck = "SELECT * FROM Floors";
                    
                    // count how many records there are post-"deletion"
                    $final = countEntries($conn,$sqlCheck);

                    // if there's no difference in # of records, nothing was really deleted; fail
                    if ($initial == $final) {
                        echo "Failed to delete Floor record. Please ensure you entered details for existing Floor.<br>";
                    }
                    else {
                        echo "Successfully deleted Floor record.<br>";
                    }
                }
                else {
                    echo "Failed to delete Floor record.<br>";
                }

            ?>
        </p>
		</div>
	  </div>

</body>

</html> 