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

                $tID  = $_POST["tID"]??"";
                
                $conn = connect();

                $result = transAdminDel($conn,$tID);

                if ($result) {
                    echo "Successfully deleted Transaction record.<br>";
                }
                else {
                    echo "Failed to delete Transaction record.<br> Please ensure you entered details for existing Transaction.<br>";
                }

            ?>
        </p>
		</div>
	  </div>

</body>

</html> 