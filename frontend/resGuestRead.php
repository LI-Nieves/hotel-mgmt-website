<!DOCTYPE html>
<html>
<head>
<title>Guest: View My Reservations</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
	<div class="wrapper fadeInDown">
		<div id="formContent2">
		
      
        <h1>Hello Guest</h1>
        <h3>This is your Reservation(s)</h3>
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
                        echo "Reservation No: ". $output[$rowNumber]['ResID'] . "<br> Start Date: " . $output[$rowNumber]['StartDate'] . 
                        "<br> End Date: " .$output[$rowNumber]['EndDate'] . "<br> Room No: " . $output[$rowNumber]['RoomNo'] . "<br> Floor No: " . 
                        $output[$rowNumber]['FloorNo'] . "<br> Number of People: " . $output[$rowNumber]['NumPeople'] . "<br> Confirmation No: " .
                        $output[$rowNumber]['ConfirmNo'] . "<br> Guest ID: " . $output[$rowNumber]['GuestID'] . "<br> <br>";

                        $rowNumber++;
                    }
                    
                }

                else {
                    echo "Failed to retrieve data from database.<br>";
                }

            ?>
     
        </p>
        
                <form action=""></form>

        <input type="button" id="modRes" class="fadeIn second" value="Delete Reservation"/>

        <input type="button" id="newRes" class="fadeIn second" value="New Reservation"/>
        <input type="button" id="logOut" class="fadeIn second" value="Log Out"/>
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
            var btn33= document.getElementById('logOut');
            btn33.addEventListener('click',function(){
                document.location.href ='login.php';
            }
            );

            </script>    


		</div>
	  </div>
</body>

</html>