<!DOCTYPE html>
<html>
<head>
<title>Employee: Log In</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
	<div class="wrapper fadeInDown">
		<div id="formContent2">
        <form action = "<?php $_PHP_SELF ?>" method = "POST">
            Employee Username: <input type = "text" name = "eUser"/>
            Employee Password: <input type = "text" name = "ePass"/>
            <input type = "submit" />
        </form>
        <p> <?php 
                include 'C:\xampp\htdocs\Project\backend\database.php';
                include 'C:\xampp\htdocs\Project\logic\queries.php';

                $eUser = $_POST["eUser"];
                $ePass = $_POST["ePass"];

                $conn = connect();

                $result = empAccountRead($conn,$eUser,$ePass);
                
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

