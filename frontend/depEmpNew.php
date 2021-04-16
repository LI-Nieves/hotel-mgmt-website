<!DOCTYPE html>
<html>
<head>
<title>Employee: Create New Dependents</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
	<div class="wrapper fadeInDown">
		<div id="formContent2">

        <form action = "<?php $_PHP_SELF ?>" method = "POST">
            WRITE NEW DETAILS BELOW:<br>
            <input type = "text" name = "dSSN" placeholder = "Dependent's SSN"/><br>
            <input type = "text" name = "dName" placeholder = "Dependent's name"/><br>
            <input type = "submit" />
        </form>
		
        <p> <?php 
                include 'C:\xampp\htdocs\Project\backend\database.php';
                include 'C:\xampp\htdocs\Project\logic\depAndbenQueries.php';

                $dSSN   = $_POST["dSSN"];
                $dName  = $_POST["dName"];

                $conn = connect();

                $result = depEmp($conn,'000000000',$dSSN,$dName,2);

                if ($result) {
                    echo "Successfully create a new dependent.<br>";
                }
                else {
                    echo "Failed to create a new dependent.<br>";
                }

            ?>
        </p>
		</div>
	  </div>

</body>

</html> 