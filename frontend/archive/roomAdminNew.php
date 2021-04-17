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
            <input type = "text" name = "fNo" placeholder = "Floor number"/>
            <input type = "text" name = "rNo" placeholder = "Room number"/>       
            <input type = "text" name = "cost" placeholder = "Cost"/>
            <input type = "text" name = "bed" placeholder = "Beds"/>
            <input type = "text" name = "rType" placeholder = "Room type (optional)"/>
            <input type = "submit" />
            <!-- Note that Availability and Clean Status will be automatically True,
                    since the room is newly created. -->
        </form>
		
        <p> <?php 
                include 'C:\xampp\htdocs\Project\backend\database.php';
                include 'C:\xampp\htdocs\Project\logic\roomQueries.php';

                $fNo        = $_POST["fNo"];
                $rNo        = $_POST["rNo"];
                $cost       = $_POST["cost"];
                $bed        = $_POST["bed"];
                $rType      = $_POST["rType"];

                $conn = connect();

                $result = roomAdmin($conn,$fNo,$rNo,$cost,$bed,$rType,0);

                if ($result) {
                    echo "Successfully created room.<br>";
                }
                else {
                    echo "Failed to create the room. 
                        Please ensure the Floor Number and Room Number are valid.<br>";
                }

            ?>
        </p>
		</div>
	  </div>

</body>

</html> 