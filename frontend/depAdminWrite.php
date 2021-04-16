<!DOCTYPE html>
<html>
<head>
<title>Admin: Change Dependents</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
	<div class="wrapper fadeInDown">
		<div id="formContent2">
        <form action = "<?php $_PHP_SELF ?>" method = "POST">
            <input type = "text" name = "eSSN" placeholder = "Change dependent details for which Employee (enter SSN)?"/><br>
            <input type = "text" name = "dSSN1" placeholder = "Change dependent details for which Dependent (enter SSN)?"/><br>
            <input type = "text" name = "dSSN" placeholder = "Dependent's new SSN"/><br>
            <input type = "text" name = "dName" placeholder = "Dependent's new name (optional)"/><br>
        <input type = "submit" />
        </form>
		
        <p> <?php 
                include 'C:\xampp\htdocs\Project\backend\database.php';
                include 'C:\xampp\htdocs\Project\logic\depAndBenQueries.php';

                $eSSN   = $_POST["eSSN"];
                $dSSN1   = $_POST["dSSN1"];
                $dSSN   = $_POST["dSSN"];
                $dName  = $_POST["dName"];

                $conn = connect();

                // checking if the specified eSSN and DepSSN exists in the table
                $eSSN = assignCookie();
                $check = "SELECT * FROM Dependent WHERE EmpSSN = \"$eSSN\" and DepSSN = \"$dSSN1\"";
                if (countEntries($conn,$check) == 0) {
                    echo "The SSNs you desire to update data for does not exist in the table.<br>";
                    return false;
                }

                $result = depAdmin($conn,$eSSN,$dSSN1,$dSSN,$dName,1);
                if ($result) {
                    echo "Successfully updated dependent information.<br>";
                }
                else {
                    echo "Failed to updated dependent information. Ensure the Employee SSN exists in the database.<br>";    // should I add why?
                }

            ?>
        </p>
		</div>
	  </div>

</body>

</html> 