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
        Change dependent for which Employee (enter SSN)?:   <input type = "text" name = "eSSN"/>
        Dependent's new SSN:                                <input type = "text" name = "dSSN" />
        Dependent's new name (optional):                    <input type = "text" name = "dName" />
         <input type = "submit" />
        </form>
		
        <p> <?php 
                include 'C:\xampp\htdocs\Project\backend\database.php';
                include 'C:\xampp\htdocs\Project\businessLogic\queries.php';

                $eSSN   = $_POST["eSSN"];
                $dSSN   = $_POST["dSSN"];
                $dName  = $_POST["dName"];

                // for debugging?
                echo 
                    "You entered:<br>eSSN: ".$_POST["eSSN"].
                    "<br>dSSN: ".$_POST["dSSN"].
                    "<br>dName: ".$_POST["dName"].
                    "<br>";

                $conn = connect();

                $result = depAdminWrite($conn,$eSSN,$dSSN,$dName);
                if ($result) {
                    echo "Successfully modified data in the database.<br>";
                }
                else {
                    echo "Failed to modify data in the database. Ensure the Employee SSN exists in the database.<br>";    // should I add why?
                }

/*                 $result2 = floorAdminNewAmenities($conn,$floorNo,$fAmenities);
                if ($result2) {
                    echo "Successfully added data to the FloorAmenities table.<br>";
                }
                else {
                    echo "Failed to add data to the FloorAmenities table.<br>";    // should I add why?
                } */

                // for debugging
/*                 header("Content-Type: JSON");
                $rowNumber = 0;
                $output = array();

                while ($row = mysqli_fetch_array($result)) {
                    $output[$rowNumber]['FloorNo'] = $row['FloorNo'];
                    $rowNumber++;
                }
                echo json_encode($output, JSON_PRETTY_PRINT); */

            ?>
        </p>
		</div>
	  </div>

</body>

</html> 