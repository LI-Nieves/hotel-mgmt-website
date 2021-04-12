<!DOCTYPE html>
<html>
<head>
<title>Employee: Modify my Dependents</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
	<div class="wrapper fadeInDown">
		<div id="formContent2">

        <form action = "<?php $_PHP_SELF ?>" method = "POST">
            <input type = "text" name = "dSSN1" placeholder = "Dependent's SSN as of now?"/><br>
            WRITE NEW DETAILS BELOW:<br>
            <input type = "text" name = "dSSN" placeholder = "Dependent's SSN"/><br>
            <input type = "text" name = "dName" placeholder = "Dependent's name"/><br>
            <!-- They shouldn't be able to modify the benefits... should they? -->
            <input type = "submit" />
        </form>
		
        <p> <?php 
                include 'C:\xampp\htdocs\Project\backend\database.php';
                include 'C:\xampp\htdocs\Project\logic\depAndBenQueries.php';

                $dSSN1  = $_POST["dSSN1"];
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

                //$result = depEmpWrite($conn,$dSSN1,$dSSN,$dName);
                $result = depEmp($conn,$dSSN1,$dSSN,$dName,1);

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
                        echo "Successfully updated your dependent information.<br>";
                    }
                    else {
                        echo "Failed to updated your dependent information.<br>";
                    }
                }
                else {
                    echo "Failed to updated your dependent information.<br>";
                }

            ?>
        </p>
		</div>
	  </div>

</body>

</html> 