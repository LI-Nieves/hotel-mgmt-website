<!DOCTYPE html>

<?php session_start(); ?>

<html>
<head>
  <link rel="stylesheet" href="style.css">
</head>
<title>Guest: Log In</title>
<body>

	<div class="wrapper fadeInDown">
		<div id="formContent">
		  <!-- Tabs Titles -->
		  <h2 class="active"> Sign In </h2>
		  <h2 class="inactive underlineHover" id="click-signup" onclick="document.location.href='./guestCreateAccount.php'">Sign Up </h2>
	  
		  <!-- Login Form -->
            <form action = "<?php $_PHP_SELF ?>" method = "POST">
                <input type="text" id="login" class="fadeIn second" name="guestUser" placeholder="Username"/>
                <input type="text" id="password" class="fadeIn third" name="guestPass" placeholder="Password"/>
                <input type="submit" id="click-login" class="fadeIn fourth" value="Log In" onclick= "init()"/>
		    </form>

            <p> <?php 
                include 'C:\xampp\htdocs\Project\backend\database.php';
                include 'C:\xampp\htdocs\Project\logic\guestQueries.php';

                $gUser = $_POST["guestUser"];
                $gPass = $_POST["guestPass"];

                $conn = connect();

                $result = guestLogin($conn,$gUser,$gPass);
                
                
                if ($result) {
                    echo "Successfully logged in.<br>";
                }
                else {
                    echo "Username not found.<br>";
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