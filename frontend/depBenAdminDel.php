<!DOCTYPE html>
<html>
<head>
<title>Admin: Delete Dependent's Benefits</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
	<div class="wrapper fadeInDown">
		<div id="formContent2">

        <form action = "<?php $_PHP_SELF ?>" method = "POST">
            <input type = "text" name = "eSSN" placeholder = "SSN of Employee" /><br>
            <input type = "text" name = "dSSN" placeholder = "SSN of Dependent" /><br>
            <input type = "text" name = "dBen" placeholder = "Benefit name" /><br>
            <input type = "submit" />
        </form>
		
        <p> <?php 
                include 'C:\xampp\htdocs\Project\backend\database.php';
                include 'C:\xampp\htdocs\Project\logic\depAndBenQueries.php';

                $eSSN  = $_POST["eSSN"]??"";
                $dSSN  = $_POST["dSSN"]??"";
                $dBen  = $_POST["dBen"]??"";
                
                $conn = connect();
                $result = depBenAdminDel($conn,$eSSN,$dSSN,$dBen);

                if ($result) {
                    echo "Successfully deleted Benefit for that Dependent record.<br>";
                }
                else {
                    echo "Failed to delete Benefit for that Dependent record. Please ensure you entered details for an existing Benefit.<br>";
                }
            ?>
        </p>
		</div>
	  </div>

</body>

</html> 