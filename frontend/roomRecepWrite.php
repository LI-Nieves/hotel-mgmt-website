<!DOCTYPE html>
<html>
<head>
<title>Admin: Guest Check In/Out</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
	<div class="wrapper fadeInDown">
		<div id="formContent2">
        <h1>Check In / Out</h1>
        <form action = "<?php $_PHP_SELF ?>" method = "POST">
            <input type = "text" name = "fNo" placeholder = "Floor number of room?"/><br>
            <input type = "text" name = "rNo" placeholder = "Room number of room?"/><br>
            WRITE NEW DETAILS BELOW:<br>
            <input type = "text" name = "gID" placeholder = "ID of Guest staying in room"/><br>
            <input type = "text" name = "iDate" placeholder = "Check-in date"/><br>
            <input type = "text" name = "oDate" placeholder = "Check-out date (if applicable)"/><br>
            <input type = "submit" />
            <input type="button" id="back" class="fadeIn second" value="Back"/>
            <!--    Note that Clean Status will remain what it currently is. 
                    When checking in, Availability = FALSE and when checking out, vice versa. -->
        </form>
        <script>
        var btn= document.getElementById('back');
                    btn.addEventListener('click',function(){
                        document.location.href ='recepMain.php';
                    }
                    );
        </script>
        <p> <?php 
                include_once 'C:\xampp\htdocs\Project\backend\database.php';
                include_once 'C:\xampp\htdocs\Project\logic\roomQueries.php';

                $fNo    = $_POST["fNo"]??"";
                $rNo    = $_POST["rNo"]??"";
                $gID    = $_POST["gID"]??"";
                $iDate  = $_POST["iDate"]??"";
                $oDate  = $_POST["oDate"]??"";

                $conn = connect();
            
                // checking if the specified floor and room number exist in the table
                $stmt = $conn->prepare("CALL checkRoom(?,?)");
                $stmt->bind_param("ii",$fNo,$rNo);
                $stmt->execute();
                $result = $stmt->get_result();

                $count = mysqli_num_rows($result);
                if ($count == 0) {
                    echo "The Room you desire to update does not exist in the database.<br>";
                    return false;
                }

                $conn = connect();
                $result = roomRecepWrite($conn,$fNo,$rNo,$gID,$iDate,$oDate);

                if ($result) {
                    echo "Successfully modified guest check in/out.<br>";
                }
                else {
                    echo "Failed to check Guest in/out. 
                        Please ensure the Guest ID, Floor Number, and Room Number are valid.<br>";
                }

            ?>
           
        </p>
        
       

       
       
		</div>
	  </div>

</body>

</html> 