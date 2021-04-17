<!DOCTYPE html>
<html>
<head>
<title>Guest: Book a Room</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
	<div class="wrapper fadeInDown">
		<div id="formContent2">

        <form action = "<?php $_PHP_SELF ?>" method = "POST">
            <input type = "text" name = "aDate" placeholder = "Arrival date"/>
            <input type = "text" name = "dDate" placeholder = "Departure date"/>
            <input type = "text" name = "numPeople" placeholder = "Number of people staying"/>
            <input type = "text" name = "numBeds" placeholder = "Number of beds preferred?"/>
            <input type = "submit" />
        </form>
		<input type="button" id="back" class="fadeIn second" value="Back"/>
        <p> <?php 
                include_once 'C:\xampp\htdocs\Project\backend\database.php';
                include_once 'C:\xampp\htdocs\Project\logic\reservationQueries.php';

                $aDate      = $_POST["aDate"]??"";
                $dDate      = $_POST["dDate"]??"";
                $numPeople  = $_POST["numPeople"]??"";
                $numBeds    = $_POST["numBeds"]??"";
                
                $conn = connect();

                $result = resGuestNew($conn,$aDate,$dDate,$numPeople,$numBeds);

                if ($result) {
                    $res = mysqli_query($conn,"CALL findRes($result[0],$result[1],$result[2],$result[3])");

                    header("Content-Type: JSON");
                    $rowNumber = 0;
                    $output = array();
    
                    while ($row = mysqli_fetch_array($res)) {
                        $output[$rowNumber]['ResID'] = $row['ResID'];
                        $output[$rowNumber]['ConfirmNo'] = $row['ConfirmNo'];
                        $rowNumber++;
                    }
                    $object = json_encode($output, JSON_PRETTY_PRINT);
                    $result = json_decode($object,true);
                    echo "Reservation ID: ".$result[0]['ResID'].", Confirmation Number: ".$result[0]['ConfirmNo'];
                }
                else {
                    echo "Failed to create the reservation.<br>";
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