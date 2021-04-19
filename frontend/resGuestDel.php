<!DOCTYPE html>
<html>
<head>
<title>Guest: Delete a Reservation</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
	<div class="wrapper fadeInDown">
		<div id="formContent2">
        <h1>Delete Reservation</h1>
        <form action = "<?php $_PHP_SELF ?>" method = "POST">
            <input type = "text" name = "rID" placeholder = "Reservation ID"/><br>
            <input type = "text" name = "floorNo" placeholder = "Floor number of reserved room"/><br>
            <input type = "text" name = "roomNo" placeholder = "Room number of reserved room"/><br>
            <input type = "submit" />
        </form>
		<input type="button" id="back" class="fadeIn second" value="Back"/>
        <p> <?php 
                include_once 'C:\xampp\htdocs\Project\backend\database.php';
                include_once 'C:\xampp\htdocs\Project\logic\reservationQueries.php';

                $rID        = $_POST["rID"]??"";
                $floorNo    = $_POST["floorNo"]??"";
                $roomNo     = $_POST["roomNo"]??"";

                $conn = connect();

                $result = resGuestDel($conn,$rID,$floorNo,$roomNo);

                if ($result) {
                    echo "Successfully cancelled your reservation.<br>";
                }
                else {
                    echo "Failed to cancel reservation. Please ensure you entered details for an existing reservation.<br>";
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