<!DOCTYPE html>
<html>
<head>
<title>Guest: View My Reservations</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
	<div class="wrapper fadeInDown">
		<div id="formContent2">
		
        <p> <?php 
                include_once 'C:\xampp\htdocs\Project\backend\database.php';
                include_once 'C:\xampp\htdocs\Project\logic\reservationQueries.php';

                $conn = connect();

                $result = resGuestRead($conn);

                $validRes = false;
                if ($result) {
                    header("Content-Type: JSON");
                    $rowNumber = 0;
                    $output = array();
    
                    while ($row = mysqli_fetch_array($result)) {
                        $output[$rowNumber]['GuestID'] = $row['GuestID'];
                        $output[$rowNumber]['FloorNo'] = $row['FloorNo'];
                        $output[$rowNumber]['RoomNo'] = $row['RoomNo'];
                        $output[$rowNumber]['ResID'] = $row['ResID'];
                        $output[$rowNumber]['StartDate'] = $row['StartDate'];
                        $output[$rowNumber]['EndDate'] = $row['EndDate'];
                        $output[$rowNumber]['ConfirmNo'] = $row['ConfirmNo'];
                        $output[$rowNumber]['NumPeople'] = $row['NumPeople'];
                        if($output[$rowNumber]['GuestID'] = $row['GuestID']){
                            $correctRow = $rowNumber;
                            $validRes = true;
                        }
                        $rowNumber++;
                    }
                    
                }

                else {
                    echo "Failed to retrieve data from database.<br>";
                }

            ?>
        <h1>Hello Guest</h1>
        <h3>This is your Reservation</h3>
        <p>Guest ID: <?php  if($validRes==true ){echo $output[$correctRow]['GuestID']; }?></p>
        <p>Floor No: <?php if($validRes==true ){echo ($output[$correctRow]['FloorNo']);} ?></p>
        <p>Room No: <?php if($validRes==true ){echo $output[$correctRow]['RoomNo']; }?></p>
        <p>Reservation No: <?php if($validRes==true ){echo $output[$correctRow]['ResID']; }?></p>
        <p>Start Date: <?php if($validRes==true ){echo $output[$correctRow]['StartDate'];} ?></p>
        <p>End Date: <?php if($validRes==true ){echo $output[$correctRow]['EndDate'];} ?></p>
        <p>Confirmation No: <?php if($validRes==true ){echo $output[$correctRow]['ConfirmNo'];} ?></p>
        <p>Number of People: <?php if($validRes==true ){echo $output[$correctRow]['NumPeople']; }?></p>       
        </p>
        
                <form action=""></form>

        <input type="button" id="modRes" class="fadeIn second" value="Delete Reservation"/>

        <input type="button" id="newRes" class="fadeIn second" value="New Reservation"/>
            <script>
            var btn= document.getElementById('modRes');
            btn.addEventListener('click',function(){
                document.location.href ='resGuestDel.php';
            }
            );
            var btn2= document.getElementById('newRes');
            btn2.addEventListener('click',function(){
                document.location.href ='resGuestNew.php';
            }
            );
            </script>    


		</div>
	  </div>
</body>

</html>