<!DOCTYPE html>
<html>
<head>
<title>Admin: Add New Dependents</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
	<div class="wrapper fadeInDown">
		<div id="formContent2">
        <form action = "<?php $_PHP_SELF ?>" method = "POST">
            <input type = "text" name = "eSSN" placeholder = "Employee's SSN"/>
            <input type = "text" name = "dSSN" placeholder = "Dependent's SSN"/>
            <input type = "text" name = "dName" placeholder = "Dependent's name (optional)"/>
        <input type = "submit" />
        </form>
		
        <p> <?php 
                include 'C:\xampp\htdocs\Project\backend\database.php';
                include 'C:\xampp\htdocs\Project\logic\depAndBenQueries.php';

                $eSSN   = $_POST["eSSN"]??"";
                $dSSN   = $_POST["dSSN"]??"";
                $dName  = $_POST["dName"]??"";

                $conn = connect();

                $result = depAdmin($conn,$eSSN,'000000000',$dSSN,$dName,0);
                if ($result) {
                    echo "Successfully created new dependent for Employee $eSSN.<br>";
                }
                else {
                    echo "Failed to add data to the database. Ensure the Employee SSN exists in the database.<br>";    // should I add why?
                }

            ?>
        </p>
		</div>
	  </div>

</body>

</html> 