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
            <!-- They shouldn't be able to modify the benefits... should they? -->
            <input type = "submit" />
        </form>
		
        <p> <?php 
                include 'C:\xampp\htdocs\Project\backend\database.php';
                include 'C:\xampp\htdocs\Project\logic\depAndbenQueries.php';

                $dSSN   = $_POST["dSSN"];
                $dName  = $_POST["dName"];

                // for debugging?
/*                 echo 
                    "You'd like to change data for Floor ".$_POST["resFloor"].
                    "<br>You entered:<br>Floor number: ".$_POST["resRoom"].
                    "<br>Number of utilities: ".$_POST["aDate"].
                    "<br>Floor amenities: ".$_POST["dDate"].
                    "<br>Maintenance employee's SSN: ".$_POST["numPeople"].
                    "<br>"; */

                $conn = connect();

                $result = depEmp($conn,'000000000',$dSSN,$dName,2);

                if (isset($_COOKIE["user"])) {
                    $eSSN = $_COOKIE["user"];
                }
                else {
                    echo "Cookies have not been set.<br>";
                    return false;
                }

                if ($result) {
                    $check = mysqli_query($conn, "SELECT * FROM Dependent WHERE EmpSSN = \"$eSSN\" and DepSSN = \"$dSSN\" and DepName = \"$dName\"");
                    $count = 0;
                    $output = array();
    
                    while ($row = mysqli_fetch_array($check)) {
                        $count++;
                    }

                    if ($count > 0) {
                        echo "Successfully create a new dependent.<br>";
                    }
                    else {
                        echo "Failed to create a new dependent.<br>";
                    }
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