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
        Employee's SSN:                             <input type = "text" name = "eSSN"/>
        Dependent's SSN:                            <input type = "text" name = "dSSN" />
        Dependent's benefits (separate by comma):   <input type = "text" name = "dBen" />
         <input type = "submit" />
        </form>
		
        <p> <?php 
                include 'C:\xampp\htdocs\Project\backend\database.php';
                include 'C:\xampp\htdocs\Project\businessLogic\queries.php';

                $eSSN   = $_POST["eSSN"];
                $dSSN   = $_POST["dSSN"];
                $temp   = $_POST["dBen"];

                $dBen   = explode(',',$temp);

                // for debugging?
/*                 echo 
                    "You entered:<br>eSSN: ".$_POST["eSSN"].
                    "<br>dSSN: ".$_POST["dSSN"].
                    "<br>dBen: ".$dBen[1].
                    "<br>"; */

                $conn = connect();

                $result = depBenAdminNew($conn,$eSSN,$dSSN,$dBen);
                if ($result) {
                    echo "Successfully added data to the database.<br>";
                }
                else {
                    echo "Failed to add data to the database. Ensure the Employee SSN exists in the database.<br>";    // should I add why?
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