<!DOCTYPE html>
<html>
<head>
<title>Employee: Change Clean Status of Room</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
	<div class="wrapper fadeInDown">
		<div id="formContent2">

        <form action = "<?php $_PHP_SELF ?>" method = "POST">
            <input type = "text" name = "fNo" placeholder = "Floor number"/><br>
            <input type = "text" name = "rNo" placeholder = "Room number"/><br>
            <!--    Clean status (true, false): <input type = "text" name = "stat" /> 
                    I'm thinking there could be a button that just says "Set to clean
                    just so they don't have to manually type it in? Up to you tho       -->
            <input type = "submit" />
        </form>
		
        <p> <?php 
                include 'C:\xampp\htdocs\Project\backend\database.php';
                include 'C:\xampp\htdocs\Project\logic\roomQueries.php';

                $fNo    = $_POST["fNo"];
                $rNo    = $_POST["rNo"];

                // for debugging?
/*                 echo 
                    "You'd like to change data for Floor ".$_POST["resFloor"].
                    "<br>You entered:<br>Floor number: ".$_POST["resRoom"].
                    "<br>Number of utilities: ".$_POST["aDate"].
                    "<br>Floor amenities: ".$_POST["dDate"].
                    "<br>Maintenance employee's SSN: ".$_POST["numPeople"].
                    "<br>"; */

                $conn = connect();

                $result = roomEmpWrite($conn,$fNo,$rNo);//,$stat);

                if (!$result) {
                    echo "Failed to modify the room's clean status. 
                        Please ensure the floor number and room number are valid.<br>";
                }

            ?>
        </p>
		</div>
	  </div>

</body>

</html> 