<!DOCTYPE html>
<html>
<head>
<title>Admin: Add New Benefits for Dependents</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
	<div class="wrapper fadeInDown">
		<div id="formContent2">
        <form action = "<?php $_PHP_SELF ?>" method = "POST">
            <input type = "text" name = "eSSN" placeholder = "Employee's SSN"/>
            <input type = "text" name = "dSSN" placeholder = "Dependent's SSN"/>
            <input type = "text" name = "dBen" placeholder = "Dependent's benefits (separate by comma)"/>
            <input type = "submit" />
        </form>
		
        <p> <?php 
                include 'C:\xampp\htdocs\Project\backend\database.php';
                include 'C:\xampp\htdocs\Project\logic\depAndBenQueries.php';

                $eSSN   = $_POST["eSSN"];
                $dSSN   = $_POST["dSSN"];
                $temp   = $_POST["dBen"];

                // take comma-separated string, split it into an array by string
                $dBen   = explode(',',$temp);

                $conn = connect();

                $result = depBenAdminNew($conn,$eSSN,$dSSN,$dBen);
                
                if ($result) {
                    echo "Successfully added data to the database.<br>";
                }
                else {
                    echo "Failed to add data to the database. Please ensure the Employee SSN exists in the database.<br>";
                }
            ?>
        </p>
		</div>
	  </div>

</body>

</html> 