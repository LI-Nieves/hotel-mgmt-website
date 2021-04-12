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
            <input type = "text" name = "eSSN" placeholder = "Change dependent details for which Employee (enter SSN)?"/>
            <input type = "text" name = "dSSN1" placeholder = "Change dependent details for which Dependent (enter SSN)?"/>
            <input type = "text" name = "dSSN" placeholder = "Dependent's new SSN"/>
            <input type = "text" name = "dName" placeholder = "Dependent's new name (optional)"/>
        <input type = "submit" />
        </form>
		
        <p> <?php 
                include 'C:\xampp\htdocs\Project\backend\database.php';
                include 'C:\xampp\htdocs\Project\logic\depAndBenQueries.php';

                $eSSN   = $_POST["eSSN"];
                $dSSN1   = $_POST["dSSN1"];
                $dSSN   = $_POST["dSSN"];
                $dName  = $_POST["dName"];

                // for debugging?
/*                 echo 
                    "You entered:<br>eSSN: ".$_POST["eSSN"].
                    "<br>dSSN: ".$_POST["dSSN"].
                    "<br>dName: ".$_POST["dName"].
                    "<br>"; */

                $conn = connect();

                $result = depAdmin($conn,$eSSN,$dSSN1,$dSSN,$dName,1);
                if ($result) {
                    $check = mysqli_query($conn, "SELECT * FROM Dependent WHERE EmpSSN = \"$eSSN\" and DepSSN = \"$dSSN\" and DepName = \"$dName\"");
                    $count = 0;
                    $output = array();
    
                    while ($row = mysqli_fetch_array($check)) {
                        $count++;
                    }

                    if ($count > 0) {
                        echo "Successfully updated dependent information.<br>";
                    }
                    else {
                        echo "Failed to updated dependent information.<br>";
                    }
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