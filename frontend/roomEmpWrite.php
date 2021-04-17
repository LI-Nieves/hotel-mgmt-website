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
                    just so they don't have to manually type it in?      -->
            <input type = "submit" />
        </form>
		
        <p> <?php 
                include_once 'C:\xampp\htdocs\Project\backend\database.php';
                include_once 'C:\xampp\htdocs\Project\logic\roomQueries.php';

                $fNo    = $_POST["fNo"];
                $rNo    = $_POST["rNo"];

                $conn = connect();

                // checking if the specified Floor and Room numbers exist in the table
                $eSSN = assignCookie();
                $check = "SELECT * FROM Room WHERE FloorNo = \"$fNo\" and RoomNo = \"$rNo\"";
                if (countEntries($conn,$check) == 0) {
                    echo "The room you desire to update data for does not exist in the table.<br>";
                    return false;
                }

                $result = roomEmpWrite($conn,$fNo,$rNo);

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