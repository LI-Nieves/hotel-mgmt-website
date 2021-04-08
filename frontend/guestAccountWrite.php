<!DOCTYPE html>
<html>
<head>
<title>Guest: Create a New Account</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
	<div class="wrapper fadeInDown">
		<div id="formContent2">
        <form action = "<?php $_PHP_SELF ?>" method = "POST">
            Name:           <input type = "text" name = "gName"/>
            Username:       <input type = "text" name = "gUser"/>
            Password:       <input type = "text" name = "gPass" />
            Credit card:    <input type = "text" name = "gCredit" />
            Phone number:   <input type = "text" name = "gPhone" />
            Address:        <input type = "text" name = "gAddress" />
         <input type = "submit" />
        </form>
		
        <p> <?php 
                include 'C:\xampp\htdocs\Project\backend\database.php';
                include 'C:\xampp\htdocs\Project\businessLogic\queries.php';

                $gName      = $_POST["gName"];
                $gUser      = $_POST["gUser"];
                $gPass      = $_POST["gPass"];
                $gCredit    = $_POST["gCredit"];
                $gPhone     = $_POST["gPhone"];
                $gAddress   = $_POST["gAddress"];

                // for debugging?
                echo 
                    "Here are your inputs, "    .$_POST["gName"].
                    ":<br>Login: "              .$_POST["gUser"].
                    "<br>Password: "            .$_POST["gPass"].
                    "<br>Credit card: "         .$_POST["gCredit"].
                    "<br>Phone number: "        .$_POST["gPhone"].
                    "<br>Address: "             .$_POST["gAddress"].
                    "<br>";

                $conn = connect();

                $result = guestAccountWrite($conn,$gName,$gUser,$gPass,$gCredit,$gPhone,$gAddress);
                if ($result) {
                    header("Content-Type: JSON");
                    $rowNumber = 0;
                    $output = array();
    
                    while ($row = mysqli_fetch_array($result)) {
                        $output[$rowNumber]['GuestID'] = $row['GuestID'];
                        $output[$rowNumber]['GuestName'] = $row['GuestName'];
                        $output[$rowNumber]['GuestLogin'] = $row['GuestLogin'];
                        $output[$rowNumber]['GuestPass'] = $row['GuestPass'];
                        $output[$rowNumber]['CreditCard'] = $row['CreditCard'];
                        $output[$rowNumber]['PhoneNo'] = $row['PhoneNo'];
                        $output[$rowNumber]['Address'] = $row['Address'];
                        $rowNumber++;
                    }
                    echo json_encode($output, JSON_PRETTY_PRINT);
                }
                else {
                    echo "Failed to create account.<br>";
                }

            ?>
        </p>
		</div>
	  </div>

</body>

</html> 