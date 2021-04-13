<!DOCTYPE html>

<?php session_start(); ?>

<html>
<head>
<title>Guest: Log In</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
	<div class="wrapper fadeInDown">
		<div id="formContent2">
        
        <form action = "<?php $_PHP_SELF ?>" method = "POST">
            Guest Username: <input type = "text" name = "guestUser"/><br>
            Guest Password: <input type = "text" name = "guestPass"/><br>
            <input type = "submit" />
        </form>
        <p> <?php 
                include 'C:\xampp\htdocs\Project\backend\database.php';
                include 'C:\xampp\htdocs\Project\logic\guestQueries.php';

                $gUser = $_POST["guestUser"];
                $gPass = $_POST["guestPass"];

                $conn = connect();

                $result = guestLogin($conn,$gUser,$gPass);
                
                if ($result) {
                    $count = mysqli_fetch_array($result);
                    if ($count > 0) {
                        echo "Successfully logged in.<br>";
                    }
                    else {
                        echo "Login failed.<br>";
                    }
                    
                }
                else {
                    echo "Username not found.<br>";
                }

            ?>
        </p>
		</div>
	  </div>
</body>

</html> 

