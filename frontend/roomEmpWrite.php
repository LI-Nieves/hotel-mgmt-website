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
            <input type = "submit" />
        </form>
		
        <p> <?php 
                include 'C:\xampp\htdocs\Project\backend\database.php';
                include 'C:\xampp\htdocs\Project\logic\roomQueries.php';

                $fNo    = $_POST["fNo"]??"";
                $rNo    = $_POST["rNo"]??"";

                $conn = connect();

                // checking if the specified Floor and Room numbers exist in the table
                $eSSN = assignCookie();
                
                $stmt = $conn->prepare("CALL checkRoom(?,?)");
                $stmt->bind_param("ii",$fNo,$rNo);
                $stmt->execute();
                $result = $stmt->get_result();

                $count = mysqli_num_rows($result);
                if ($count == 0) {
                    echo "The room you desire to update does not exist in the table.<br>";
                    return false;
                }
                
                $conn3 = connect();
                $result = roomEmpWrite($conn3,$fNo,$rNo);

                if ($result) {
                    echo "Successfully set the room as clean.<br>";
                    $conn2 = connect();
                    $conn4 = connect();
                    $eSSN = assignCookie();
                    maintEmpWrite($conn2,$conn4,$fNo,$eSSN);
                }
                else {
                    echo "Failed to modify the room's clean status. 
                        Please ensure the floor number and room number are valid.<br>";
                }

            ?>
        </p>
		</div>
	  </div>

</body>

</html> 