<!DOCTYPE html>
<html>
<head>
<title>Admin: Delete Phone Call Record</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
	<div class="wrapper fadeInDown">
		<div id="formContent2">
        <h1>Delete Phone Call</h1>
        <form action = "<?php $_PHP_SELF ?>" method = "POST">
            <input type = "text" name = "cID" placeholder = "Call ID" /><br>
            <input type = "submit" />
        </form>
		
        <p> <?php 
                include_once 'C:\xampp\htdocs\Project\backend\database.php';
                include_once 'C:\xampp\htdocs\Project\logic\phoneQueries.php';

                $cID  = $_POST["cID"]??"";
                
                $conn2 = connect();
                $result = phoneAdminDel($conn2,$cID);

                if (!$result) {
                    echo "Failed to delete Phone Call record. Please ensure you entered details for existing Phone Call.<br>";
                }
                else {
                    echo "Successfully deleted Phone Call record.<br>";
                }
            ?>
        </p>
        <input type="button" id="back" class="fadeIn second" value="Back"/>
        <script>
        var btn= document.getElementById('back');
                    btn.addEventListener('click',function(){
                        document.location.href ='adminMain.php';
                    }
                    );
        </script>
		</div>
	  </div>

</body>

</html> 