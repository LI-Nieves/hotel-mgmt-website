<!DOCTYPE html>
<html>
<head>
<title>Admin: Create a Room</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
	<div class="wrapper fadeInDown">
		<div id="formContent2">

        <form action = "<?php $_PHP_SELF ?>" method = "POST">
            Floor number:                                   <input type = "text" name = "fNo"/>
            Room number:                                    <input type = "text" name = "rNo"/>       
            Cost:                                           <input type = "text" name = "cost" />
            Beds:                                           <input type = "text" name = "bed" />
            Room type:                                      <input type = "text" name = "rType" />
            <input type = "submit" />
            <!-- Note that Availability and Clean Status will be automatically True,
                    since the room is newly created. -->
        </form>
		
        <p> <?php 
                include 'C:\xampp\htdocs\Project\backend\database.php';
                include 'C:\xampp\htdocs\Project\businessLogic\queries.php';

                $fNo        = $_POST["fNo"];
                $rNo        = $_POST["rNo"];
                $cost       = $_POST["cost"];
                $bed        = $_POST["bed"];
                $rType      = $_POST["rType"];

/*                 // for debugging?
                echo 
                    "You'd like to change data for Floor ".$_POST["resFloor"].
                    "<br>You entered:<br>Floor number: ".$_POST["resRoom"].
                    "<br>Number of utilities: ".$_POST["aDate"].
                    "<br>Floor amenities: ".$_POST["dDate"].
                    "<br>Maintenance employee's SSN: ".$_POST["numPeople"].
                    "<br>"; */

                $conn = connect();

                $result = roomAdminNew($conn,$fNo,$rNo,$cost,$bed,$rType);

                if ($result) {
                    echo "Successfully created room.<br>";
                }
                else {
                    echo "Failed to create the room. 
                        Please ensure the Guest ID, Floor Number, and Room Number are valid.<br>";
                }

            ?>
        </p>
		</div>
	  </div>

</body>

</html> 