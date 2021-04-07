<!DOCTYPE html>
<html>
<head>
<title>Guest: Log In</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
	<div class="wrapper fadeInDown">
		<div id="formContent2">
        <form action = "<?php $_PHP_SELF ?>" method = "POST">
            Username: <input type = "text" name = "guestUser"/>
            Password: <input type = "text" name = "guestPass"/>
            <input type = "submit" />
        </form>
        <p> <?php 
                include 'C:\xampp\htdocs\Project\backend\database.php';
                include 'C:\xampp\htdocs\Project\businessLogic\queries.php';

                $gUser = $_POST["guestUser"];
                $gPass = $_POST["guestPass"];

                $conn = connect();

                $result = guestAccountRead($conn,$gUser,$gPass);
                
                if ($result) {
                    header("Content-Type: JSON");
                    $rowNumber = 0;
                    $output = array();
    
                    while ($row = mysqli_fetch_array($result)) {
                        $output[$rowNumber]['GuestID'] = $row['GuestID'];
                        $output[$rowNumber]['GuestLogin'] = $row['GuestLogin'];
                        $output[$rowNumber]['GuestPass'] = $row['GuestPass'];
                        $output[$rowNumber]['CreditCard'] = $row['CreditCard'];
                        $output[$rowNumber]['PhoneNo'] = $row['PhoneNo'];
                        $output[$rowNumber]['GuestName'] = $row['GuestName'];
                        $rowNumber++;
                    }

                    if (count($output) > 0) {
                        echo "Successfully logged in.<br>";
                    }
                    else {
                        echo "Login failed.<br>";
                    }
                    
                }
                else {
                    echo "Failed to retrieve data from the database.<br>";
                }

            ?>
        </p>
		</div>
	  </div>
</body>

</html> 

