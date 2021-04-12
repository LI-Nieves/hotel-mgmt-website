<!DOCTYPE html>
<html>
<head>
<title>Guest: Create a New Account</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
	<div class="wrapper fadeInDown">
		<div id="formContent2">
        <!-- Asking for user input. Necessity at the discretion of front-end. -->
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
                include 'C:\xampp\htdocs\Project\logic\guestQueries.php';

                $gName      = $_POST["gName"];
                $gUser      = $_POST["gUser"];
                $gPass      = $_POST["gPass"];
                $gCredit    = $_POST["gCredit"];
                $gPhone     = $_POST["gPhone"];
                $gAddress   = $_POST["gAddress"];

                // for debugging?
/*                 echo 
                    "Here are your inputs, "    .$_POST["gName"].
                    ":<br>Login: "              .$_POST["gUser"].
                    "<br>Password: "            .$_POST["gPass"].
                    "<br>Credit card: "         .$_POST["gCredit"].
                    "<br>Phone number: "        .$_POST["gPhone"].
                    "<br>Address: "             .$_POST["gAddress"].
                    "<br>"; */

                $conn = connect();

                $result = guestAccountNew($conn,$gName,$gUser,$gPass,$gCredit,$gPhone,$gAddress);

                if (!$result) {
                    echo "Failed to create account.<br>";
                }

                ?>
        </p>
		</div>
	  </div>

</body>

</html> 