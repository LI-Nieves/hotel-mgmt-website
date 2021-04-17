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

                $eSSN   = $_POST["eSSN"]??"";
                $dSSN   = $_POST["dSSN"]??"";
                $temp   = $_POST["dBen"]??"";

                // take comma-separated string, split it into an array by string
                $dBen   = explode(',',$temp);
                
                // for each benefit, add it as a separate entry into the DepBenefits table
                for ($i = 0; $i < sizeof($dBen); $i++) {
                    $conn = connect();
                    $result = depBenAdminNew($conn,$eSSN,$dSSN,$dBen[$i]);
                    if ($result) {
                        echo "Successfully added Employee SSN: " .$eSSN. ", Dependent SSN: " .$dSSN. ", Benefit name: " .$dBen[$i]. " to the database.<br>";
                    }
                    else {
                        echo "Failed to add Employee SSN: " .$eSSN. ", Dependent SSN: " .$dSSN. ", Benefit name: " .$dBen[$i]. " to the database.<br>
                            Please ensure the Employee SSN and Dependent SSN exist in the database.<br>";

                    }
                }
            ?>
        </p>
		</div>
	  </div>

</body>

</html> 