<!DOCTYPE html>
<html>
<head>
<title>Employee: Modify my Information</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
	<div class="wrapper fadeInDown">
		<div id="formContent2">

        <form action = "<?php $_PHP_SELF ?>" method = "POST">
            <input type = "text" name = "ePass" placeholder = "New Employee password"/><br>
            <input type = "text" name = "rPass" placeholder = "New Receptionist password (if applicable)"/><br>
            <input type = "text" name = "aPass" placeholder = "New Admin password (if applicable)"/><br>
            <input type = "submit" />
        </form>
		
        <p> <?php 
                include 'C:\xampp\htdocs\Project\backend\database.php';
                include 'C:\xampp\htdocs\Project\logic\employeeQueries.php';

                $ePass  = $_POST["ePass"]??"";
                $rPass  = $_POST["rPass"]??"";
                $aPass  = $_POST["aPass"]??"";

                $conn = connect();
                $eSSN = assignCookie();
                $eType = checkEmpType($conn,$eSSN);

                $conn2 = connect();
                $result = empChangePass($conn2,$ePass,$rPass,$aPass,$eType);


                if ($result) {
                    echo "Successfully changed your password(s).<br>";
                }
                else {
                    echo "Failed to change your password(s).<br>";
                }

            ?>
        </p>
        <input type="button" id="back" class="fadeIn second" value="Back"/>
        <script>
        var btn= document.getElementById('back');
                    btn.addEventListener('click',function(){
                        window.history.back();
                    }
                    );
        </script>
		</div>
	  </div>

</body>

</html> 