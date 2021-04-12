<!DOCTYPE html>

<?php session_start(); ?>

<html>
<head>
  <link rel="stylesheet" href="style.css">
</head>
<title>Admin: Log In</title>
<body>

	<div class="wrapper fadeInDown">
		<div id="formContent">
		  <!-- Tabs Titles -->
		  <h2 class="active"> Sign In </h2>
		  <!-- <h2 class="inactive underlineHover" id="click-signup" onclick="document.location.href='./guestCreateAccount.php'">Sign Up </h2> -->
	  
		  <!-- Login Form -->
            <form action = "<?php $_PHP_SELF ?>" method = "POST">
                <input type="text" id="login" class="fadeIn second" name="aUser" placeholder="Username"/>
                <input type="text" id="password" class="fadeIn third" name="aPass" placeholder="Password"/>
                <input type="submit" id="click-login" class="fadeIn fourth" value="Log In" onclick= "init()"/>
		    </form>
            <p> <?php 
                include 'C:\xampp\htdocs\Project\backend\database.php';
                include 'C:\xampp\htdocs\Project\logic\employeeQueries.php';

                $aUser = $_POST["aUser"];
                $aPass = $_POST["aPass"];

                $conn = connect();

                $result = adminLogin($conn,$aUser,$aPass);
                
                if ($result) {
                    header("Content-Type: JSON");
                    $rowNumber = 0;
                    $output = array();
    
                    while ($row = mysqli_fetch_array($result)) {
                        $output[$rowNumber]['SSN'] = $row['SSN'];
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="./index.js"></script>
<script src="./start.js"></script>
</html>