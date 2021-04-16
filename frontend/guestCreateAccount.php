<!DOCTYPE html>
<html>
<title>Guest: Create a New Account</title>
<head>
  <link rel="stylesheet" href="style.css">
</head>
<body>

	<div class="wrapper fadeInDown">
		<div id="formContent">
		  <!-- Tabs Titles -->
		  <h2 class="inactive underlineHover" onclick="document.location.href='./login.php'"> Sign In </h2>
		  <h2 class="active">Sign Up </h2>
	  
		  <!-- Icon -->
		  <div class="fadeIn first">
			
		  </div>
	  
		  <!-- Login Form -->
		  <form action = "<?php $_PHP_SELF ?>" method = "POST">
			<input type="text" id="user" class="fadeIn third" name="gUser" placeholder="Username">  
			<input type="text" id="pass" class="fadeIn second" name="gPass" placeholder="Password">
			<input type="text" id="name" class="fadeIn second" name="gName" placeholder="Name">
            <input type="text" id="credit" class="fadeIn third" name="gCredit" placeholder="Credit card number">  
			<input type="text" id="phone" class="fadeIn second" name="gPhone" placeholder="Phone number">
			<input type="text" id="address" class="fadeIn second" name="gAddress" placeholder="Address">
			<input type="submit" class="fadeIn fourth" value="Sign Up">
		  </form>
	  
          <p>   <?php 
                include_once 'C:\xampp\htdocs\Project\backend\database.php';
                include_once 'C:\xampp\htdocs\Project\logic\guestQueries.php';

                $gName      = $_POST["gName"]??"";
                $gUser      = $_POST["gUser"]??"";
                $gPass      = $_POST["gPass"]??"";
                $gCredit    = $_POST["gCredit"]??"";
                $gPhone     = $_POST["gPhone"]??"";
                $gAddress   = $_POST["gAddress"]??"";

                $conn = connect();

                guestAccountNew($conn,$gName,$gUser,$gPass,$gCredit,$gPhone,$gAddress);
/*                 $result = guestAccountNew($conn,$gName,$gUser,$gPass,$gCredit,$gPhone,$gAddress);

                if (!$result) {
                    echo "Failed to create account.<br>";
                } */

                ?>
            </p>
	  
		</div>
	  </div>
</body>
</html> 