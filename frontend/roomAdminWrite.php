<!DOCTYPE html>
<html>
<head>
<title>Admin: Modify Room Details</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
	<div class="wrapper fadeInDown">
		<div id="formContent2">

        <form action = "<?php $_PHP_SELF ?>" method = "POST">
            <input type = "text" name = "fNo" placeholder = "Floor number of room to modify?"/><br>
            <input type = "text" name = "rNo" placeholder = "Room number of room to modify?"/> <br>  
            WRITE NEW DETAILS BELOW:<br>
            <input type = "text" name = "cost" placeholder = "Cost"/><br>
            <input type = "text" name = "bed" placeholder = "Beds"/><br>
            <input type = "text" name = "rType" placeholder = "Room type"/><br>
            <input type = "submit" />
            <!-- Note that Availability and Clean Status will remain what they currently are. -->
        </form>
		
        <p> <?php 
                include 'C:\xampp\htdocs\Project\backend\database.php';
                include 'C:\xampp\htdocs\Project\logic\roomQueries.php';

                $fNo    = $_POST["fNo"]??"";
                $rNo    = $_POST["rNo"]??"";
                $cost   = $_POST["cost"]??"";
                $bed    = $_POST["bed"]??"";
                $rType  = $_POST["rType"]??"";

                $conn = connect();

                // checking if the specified original room exists in the table
                $stmt = $conn->prepare("CALL checkRoom(?,?)");
                $stmt->bind_param("ii",$fNo,$rNo);
                $stmt->execute();
                $result = $stmt->get_result();

                $count = mysqli_num_rows($result);
                if ($count == 0) {
                    echo "The room you desire to update does not exist in the table.<br>";
                    return false;
                }
                
                $conn = connect();
                $result = roomAdmin($conn,$fNo,$rNo,$cost,$bed,$rType);

                if ($result) {
                    echo "Successfully modified room details.<br>";
                }
                else {
                    echo "Failed to modify room details. 
                    Please ensure the Guest ID, Floor Number, and Room Number are valid.<br>";
                }

            ?>
        </p>
		</div>
	  </div>

</body>

</html> 