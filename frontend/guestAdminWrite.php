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

                $gID  = $_POST["gID"];
                $gLogin   = $_POST["gLogin"];
                $gCard  = $_POST["gCard"];
                $gPhone  = $_POST["gPhone"];
                $gName   = $_POST["gName"];
                $gAddress  = $_POST["gAddress"];

                // for debugging?
/*                 echo 
                    "You'd like to change data for Floor ".$_POST["resFloor"].
                    "<br>You entered:<br>Floor number: ".$_POST["resRoom"].
                    "<br>Number of utilities: ".$_POST["aDate"].
                    "<br>Floor amenities: ".$_POST["dDate"].
                    "<br>Maintenance employee's SSN: ".$_POST["numPeople"].
                    "<br>"; */

                $conn = connect();

                $result = guestAdminWrite($conn,$gID,$gLogin,$gCard,$gPhone,$gName,$gAddress);

                if ($result) {
                    $check = mysqli_query($conn, "SELECT * FROM Guest WHERE GuestLogin = \"$gLogin\" and CreditCard = $gCard 
                        and PhoneNo = $gPhone and GuestName = \"$gName\" and Address = \"$gAddress\" and GuestID = \"$gID\"");
                    $count = 0;
                    $output = array();

                    if ($check) {
                        while ($row = mysqli_fetch_array($check)) {
                            $count++;
                        }
    
                        if ($count > 0) {
                            echo "Successfully updated guest information.<br>";
                        }
                        else {
                            echo "Failed to updated guest information.<br>";
                        }
                    }
                    else {
                        echo "Failed to updated guest information.<br>";
                    }
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