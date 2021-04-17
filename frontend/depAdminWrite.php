<!DOCTYPE html>
<html>
<head>
<title>Admin: Change Dependents</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
	<div class="wrapper fadeInDown">
		<div id="formContent2">
        <form action = "<?php $_PHP_SELF ?>" method = "POST">
            <input type = "text" name = "eSSN" placeholder = "Change dependent details for which Employee (enter SSN)?"/><br>
            <input type = "text" name = "dSSN1" placeholder = "Change dependent details for which Dependent (enter SSN)?"/><br>
            <input type = "text" name = "dSSN" placeholder = "Dependent's new SSN"/><br>
            <input type = "text" name = "dName" placeholder = "Dependent's new name (optional)"/><br>
        <input type = "submit" />
        </form>
		
        <p> <?php 
                include_once 'C:\xampp\htdocs\Project\backend\database.php';
                include_once 'C:\xampp\htdocs\Project\logic\depAndBenQueries.php';

                $eSSN   = $_POST["eSSN"]??"";
                $dSSN1   = $_POST["dSSN1"]??"";
                $dSSN   = $_POST["dSSN"]??"";
                $dName  = $_POST["dName"]??"";

                $conn = connect();
                // checking if the specified eSSN and DepSSN exists in the table
                $stmt = $conn->prepare("CALL checkDep(?,?)");
                $stmt->bind_param("ss",$eSSN,$dSSN1);
                $stmt->execute();
                $result = $stmt->get_result();

                $count = mysqli_num_rows($result);
                if ($count == 0) {
                    echo "The Dependent you desire to update does not exist in the table.<br>";
                    return false;
                }
                
                $conn = connect();
                $result = depAdmin($conn,$eSSN,$dSSN1,$dSSN,$dName,1);
                if ($result) {
                    echo "Successfully updated dependent information.<br>";
                }
                else {
                    echo "Failed to updated dependent information. Ensure the Employee SSN exists in the database.<br>";    // should I add why?
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