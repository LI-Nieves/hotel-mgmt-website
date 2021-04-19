<!DOCTYPE html>
<html>
<head>
<title>Admin: Delete Guest Record</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
	<div class="wrapper fadeInDown">
		<div id="formContent2">
        <h1>Delete Guest</h1>
        <form action = "<?php $_PHP_SELF ?>" method = "POST">
            <input type = "text" name = "gID" placeholder = "ID of Guest to delete" /><br>
            <input type = "submit" />
        </form>
		
        <p> <?php 
                include 'C:\xampp\htdocs\Project\backend\database.php';
                include 'C:\xampp\htdocs\Project\logic\guestQueries.php';

                $gID  = $_POST["gID"]??"";
                
                $conn2 = connect();
                $result = guestAdminDel($conn2,$gID);

                if ($result) {
                    echo "Successfully deleted Guest record.<br>";
                }
                else {
                    echo "Failed to delete Guest record. Please ensure you entered details for an existing Guest.<br>";
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