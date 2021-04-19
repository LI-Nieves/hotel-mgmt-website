<!DOCTYPE html>
<html>
<head>
<title>Admin: Delete Dependent's Benefits</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
	<div class="wrapper fadeInDown">
		<div id="formContent2">
        <h1>Delete Dependent's Benefits</h1>
        <form action = "<?php $_PHP_SELF ?>" method = "POST">
            <input type = "text" name = "eSSN" placeholder = "SSN of Employee" /><br>
            <input type = "text" name = "dSSN" placeholder = "SSN of Dependent" /><br>
            <input type = "text" name = "dBen" placeholder = "Benefit name" /><br>
            <input type = "submit" />
        </form>
		
        <p> <?php 
                include_once 'C:\xampp\htdocs\Project\backend\database.php';
                include_once 'C:\xampp\htdocs\Project\logic\depAndBenQueries.php';

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