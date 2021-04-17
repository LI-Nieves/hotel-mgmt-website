<!DOCTYPE html>
<html>
<head>
<title>Admin: View All Guests</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
	<div class="wrapper fadeInDown">
		<div id="formContent2">
		
        <p> <?php 
                include 'C:\xampp\htdocs\Project\backend\database.php';
                include 'C:\xampp\htdocs\Project\logic\guestQueries.php';

                $conn = connect();

                $result = guestAdminRead($conn);
                
                if ($result) {
                    header("Content-Type: JSON");
                    $rowNumber = 0;
                    $output = array();
    
                    while ($row = mysqli_fetch_array($result)) {
                        $output[$rowNumber]['GuestID'] = $row['GuestID'];
                        $output[$rowNumber]['GuestLogin'] = $row['GuestLogin'];
                        $output[$rowNumber]['CreditCard'] = $row['CreditCard'];
                        $output[$rowNumber]['PhoneNo'] = $row['PhoneNo'];
                        $output[$rowNumber]['GuestName'] = $row['GuestName'];
                        $output[$rowNumber]['Address'] = $row['Address'];
                        echo "Guest ID: ". $output[$rowNumber]['GuestID'] . "<br> Guest Login: " . $output[$rowNumber]['GuestLogin'] . 
                        "<br> Credit Card: " .$output[$rowNumber]['CreditCard'] . "<br> Phone No: " . $output[$rowNumber]['PhoneNo'] . 
                        "<br> Guest Name: " . 
                        $output[$rowNumber]['GuestName'] . "<br> Address: " . $output[$rowNumber]['Address'] .  "<br> <br>";


                        $rowNumber++;
                    }
                   json_encode($output, JSON_PRETTY_PRINT);
                }
                else {
                    echo "Failed to retrieve data from the database.<br>";
                }

            ?>
        </p>
        <input type="button" id="back" class="fadeIn second" value="Back"/>
        <script>
        var btn= document.getElementById('back');
                    btn.addEventListener('click',function(){
                        window.history.back();
                    }
                    );
        </script>
		</div>
	  </div>
</body>

</html> 