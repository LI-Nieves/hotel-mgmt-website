<!DOCTYPE html>
<html>
<head>
<title>Employee: Modify my Information</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
	<div class="wrapper fadeInDown">
		<div id="formContent2">

        <form action = "<?php $_PHP_SELF ?>" method = "POST">
            <input type = "text" name = "ePass" placeholder = "New Employee password"/><br>
            <input type = "text" name = "rPass" placeholder = "New Receptionist password (if applicable)"/><br>
            <input type = "text" name = "aPass" placeholder = "New Admin password (if applicable)"/><br>
            <input type = "submit" />
        </form>
		
        <p> <?php 
                include 'C:\xampp\htdocs\Project\backend\database.php';
                include 'C:\xampp\htdocs\Project\logic\employeeQueries.php';

                $ePass  = $_POST["ePass"];
                $rPass  = $_POST["rPass"];
                $aPass  = $_POST["aPass"];

                $conn = connect();

                $result = empChangePass($conn,$ePass,$rPass,$aPass);

                $eSSN = assignCookie();

                if ($result) {
                    echo "Successfully changed your password(s).<br>";
                }
                else {
                    echo "Failed to change your password(s).<br>";
                }

            ?>
        </p>
		</div>
	  </div>

</body>

</html> 