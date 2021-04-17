<!DOCTYPE html>
<html>
<head>
<title>Employee: Modify my Dependents</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
	<div class="wrapper fadeInDown">
		<div id="formContent2">

        <form action = "<?php $_PHP_SELF ?>" method = "POST">
            <input type = "text" name = "dSSN1" placeholder = "Dependent's SSN as of now?"/><br>
            WRITE NEW DETAILS BELOW:<br>
            <input type = "text" name = "dSSN" placeholder = "Dependent's SSN"/><br>
            <input type = "text" name = "dName" placeholder = "Dependent's name"/><br>
            <input type = "submit" />
        </form>
		
        <p> <?php 
                include 'C:\xampp\htdocs\Project\backend\database.php';
                include 'C:\xampp\htdocs\Project\logic\depAndBenQueries.php';

                $dSSN1  = $_POST["dSSN1"]??"";
                $dSSN   = $_POST["dSSN"]??"";
                $dName  = $_POST["dName"]??"";

                $conn = connect();

                // checking if the specified original DepSSN exists in the table
                $eSSN = assignCookie();
                $stmt = $conn->prepare("CALL checkDep(?,?)");
                $stmt->bind_param("ss",$eSSN,$dSSN1);
                $stmt->execute();
                $result = $stmt->get_result();

                $count = mysqli_num_rows($result);
                if ($count == 0) {
                    echo "The SSN you desire to update does not exist in the table.<br>";
                    return false;
                }

                $conn = connect();
                $result = depEmp($conn,$dSSN1,$dSSN,$dName,1);

                if ($result) {
                    echo "Successfully updated your dependent information.<br>";
                }
                else {
                    echo "Failed to updated your dependent information.<br>";
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