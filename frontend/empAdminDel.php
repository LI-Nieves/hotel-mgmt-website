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

                $eSSN  = $_POST["eSSN"]??"";
                
                $conn = connect();
                $result = empAdminDel($conn,$eSSN);

                if ($result) {
                    echo "Successfully deleted Employee record.<br>";
                }
                else {
                    echo "Failed to delete Employee record. Please ensure you entered details for an existing Employee.<br>";
                }
            ?>
        </p>
		</div>
	  </div>

</body>

</html> 