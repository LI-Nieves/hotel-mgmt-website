<!DOCTYPE html>
<html>
<head>
<title>Admin: Delete Room Record</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
	<div class="wrapper fadeInDown">
		<div id="formContent2">

        <form action = "<?php $_PHP_SELF ?>" method = "POST">
            <input type = "text" name = "fNo" placeholder = "Floor number" /><br>    
            <input type = "text" name = "rNo" placeholder = "Room number" /><br>
            <input type = "submit" />
        </form>
		
        <p> <?php 
                include 'C:\xampp\htdocs\Project\backend\database.php';
                include 'C:\xampp\htdocs\Project\logic\roomQueries.php';

                $fNo  = $_POST["fNo"];
                $rNo  = $_POST["rNo"];
                
                $conn = connect();

                // count how many records there are, pre-"deletion"
                $initial = countEntries($conn,"SELECT * FROM Room");

                $result = roomAdminDel($conn,$fNo,$rNo);

                if ($result) {
                    // looking at all records in the Room table
                    $sqlCheck = "SELECT * FROM Room";
                    
                    // count how many records there are post-"deletion"
                    $final = countEntries($conn,$sqlCheck);

                    // if there's no difference in # of records, nothing was really deleted; fail
                    if ($initial == $final) {
                        echo "Failed to delete Room record. Please ensure you entered details for existing Room.<br>";
                    }
                    else {
                        echo "Successfully deleted Room record.<br>";
                    }
                }
                else {
                    echo "Failed to delete Room record.<br>";
                }

            ?>
        </p>
		</div>
	  </div>

</body>

</html> 