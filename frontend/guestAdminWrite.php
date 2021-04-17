<!DOCTYPE html>
<html>
<head>
<title>Admin: Modify Guest Information</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
	<div class="wrapper fadeInDown">
		<div id="formContent2">

        <form action = "<?php $_PHP_SELF ?>" method = "POST">
            <input type = "text" name = "gID" placeholder = "ID of Guest to modify?" /><br>
            WRITE NEW DETAILS BELOW:<br>
            <input type = "text" name = "gLogin" placeholder = "Guest's login" /><br>
            <input type = "text" name = "gCard" placeholder = "Guest's credit card" /><br>
            <input type = "text" name = "gPhone" placeholder = "Guest's phone number" /><br>
            <input type = "text" name = "gName" placeholder = "Guest's name" /><br>
            <input type = "text" name = "gAddress" placeholder = "Guest's address" /><br>
            <input type = "submit" />
        </form>
		
        <p> <?php 
                include 'C:\xampp\htdocs\Project\backend\database.php';
                include 'C:\xampp\htdocs\Project\logic\guestQueries.php';

                $gID  = $_POST["gID"]??"";
                $gLogin   = $_POST["gLogin"]??"";
                $gCard  = $_POST["gCard"]??"";
                $gPhone  = $_POST["gPhone"]??"";
                $gName   = $_POST["gName"]??"";
                $gAddress  = $_POST["gAddress"]??"";

                $conn = connect();

                // checking if the specified original Guest ID exists in the table
                $stmt = $conn->prepare("CALL checkGuest(?)");
                $stmt->bind_param("s",$gID);
                $stmt->execute();
                $result = $stmt->get_result();

                $count = mysqli_num_rows($result);
                if ($count == 0) {
                    echo "The Guest ID you desire to update data for does not exist in the table.<br>";
                    return false;
                }
                
                $conn2 = connect();
                $result = guestAdminWrite($conn2,$gID,$gLogin,$gCard,$gPhone,$gName,$gAddress);

                if ($result) {
                    echo "Successfully updated guest information.<br>";
                }
                else {
                    echo "Failed to updated guest information.<br>";
                }

            ?>
        </p>
		</div>
	  </div>

</body>

</html> 