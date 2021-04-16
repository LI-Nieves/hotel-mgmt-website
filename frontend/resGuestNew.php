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
                    header("Content-Type: JSON");
                    $rowNumber = 0;
                    $output = array();
    
                    while ($row = mysqli_fetch_array($result)) {
                        $output[$rowNumber]['ResID'] = $row['ResID'];
                        $output[$rowNumber]['ConfirmNo'] = $row['ConfirmNo'];
                        $rowNumber++;
                    }
                    echo json_encode($output, JSON_PRETTY_PRINT);
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