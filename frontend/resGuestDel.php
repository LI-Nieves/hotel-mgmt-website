<!DOCTYPE html>
<html>
<head>
<title>Guest: Delete a Reservation</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
	<div class="wrapper fadeInDown">
		<div id="formContent2">

        <form action = "<?php $_PHP_SELF ?>" method = "POST">
            <input type = "text" name = "rID" placeholder = "Reservation ID"/><br>
            <input type = "text" name = "floorNo" placeholder = "Floor number of reserved room"/><br>
            <input type = "text" name = "roomNo" placeholder = "Room number of reserved room"/><br>
            <input type = "submit" />
        </form>
		<input type="button" id="back" class="fadeIn second" value="Back"/>
        <p> <?php 
                include 'C:\xampp\htdocs\Project\backend\database.php';
                include 'C:\xampp\htdocs\Project\logic\reservationQueries.php';

                $rID        = $_POST["rID"];
                $floorNo    = $_POST["floorNo"];
                $roomNo     = $_POST["roomNo"];

                $conn = connect();

                // count how many records there are, pre-"deletion"
                $initial = countEntries($conn,"SELECT * FROM Reservation");

                $result = resGuestDel($conn,$rID,$floorNo,$roomNo);

                if ($result) {
                    // looking at all records in the Reservation table
                    $sqlCheck = "SELECT * FROM Reservation";
                    
                    // count how many records there are post-"deletion"
                    $final = countEntries($conn,$sqlCheck);

                    // if there's no difference in # of records, nothing was really deleted; fail
                    if ($initial == $final) {
                        echo "Failed to delete reservation. Please ensure you entered details for existing reservation.<br>";
                    }
                    else {
                        echo "Successfully deleted your reservation.<br>";
                    }
                }
                else {
                    echo "Failed to delete reservation.<br>";
                }

            ?>
        </p>
        <script>
        var btn= document.getElementById('back');
                    btn.addEventListener('click',function(){
                        document.location.href ='resGuestRead.php';
                    }
                    );
        </script>
		</div>
	  </div>

</body>

</html> 