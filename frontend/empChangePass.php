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

                // for debugging?
/*                 echo 
                    "You'd like to change data for Floor ".$_POST["resFloor"].
                    "<br>You entered:<br>Floor number: ".$_POST["resRoom"].
                    "<br>Number of utilities: ".$_POST["aDate"].
                    "<br>Floor amenities: ".$_POST["dDate"].
                    "<br>Maintenance employee's SSN: ".$_POST["numPeople"].
                    "<br>"; */

                $conn = connect();

                $result = empChangePass($conn,$ePass,$rPass,$aPass);

                $eSSN = assignCookie();

                if ($result) {
                    $check = mysqli_query($conn, "SELECT * FROM Employee WHERE SSN = \"$eSSN\"");
                    $count = 0;
                    $output = array();
                    if ($check) {
                        while ($row = mysqli_fetch_array($check)) {
                            $count++;
                        }
                    }
                    if ($count > 0) {
                        echo "Successfully changed your password(s).<br>";
                    }
                    else {
                        echo "Failed to change your password(s).<br>";
                    }

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