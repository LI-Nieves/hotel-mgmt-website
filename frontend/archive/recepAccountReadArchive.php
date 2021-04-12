<!DOCTYPE html>
<html>
<head>
<title>Receptionist: Log In</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
	<div class="wrapper fadeInDown">
		<div id="formContent2">
        <form action = "<?php $_PHP_SELF ?>" method = "POST">
            Receptionist Username: <input type = "text" name = "rUser"/>
            Receptionist Password: <input type = "text" name = "rPass"/>
            <input type = "submit" />
        </form>
        <p> <?php 
                include 'C:\xampp\htdocs\Project\backend\database.php';
                include 'C:\xampp\htdocs\Project\businessLogic\queries.php';

                $rUser = $_POST["rUser"];
                $rPass = $_POST["rPass"];

                $conn = connect();

                $result = recepAccountRead($conn,$rUser,$rPass);
                
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

</html> 

