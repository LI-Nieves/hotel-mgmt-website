<!DOCTYPE html>

<?php session_start(); ?>

<html>
<head>
  <link rel="stylesheet" href="style.css">
</head>
<title>Admin: Log In</title>
<body>

	<div class="wrapper fadeInDown">
		<div id="formContent">
		  <!-- Tabs Titles -->
		 <h2 class="active" type = "button"> Sign In </h2>
		 <h2 class="inactive underlineHover" id="click-signup" onclick="document.location.href='./guestCreateAccount.php'">Sign Up </h2> 
	  
		  <!-- Login Form -->
            <form action = "<?php $_PHP_SELF ?>" method = "POST">
                <label for="loginType">Select User Type:</label>
                <select name="loginType" id="loginType">
                    <option value="g">Guest</option>
                    <option value="e">Employee</option>
                    <option value="a">Admin</option>
                    <option value="r">Receptionist</option>
                </select>
                <input type="text" id="login" class="fadeIn second" name="aUser" placeholder="Username"/>
                <input type="text" id="password" class="fadeIn third" name="aPass" placeholder="Password"/>
                <input type="submit" id="click-login" class="fadeIn fourth" value="Log In"/>
		      </form>
            <p> <?php 
                include_once 'C:\xampp\htdocs\Project\backend\database.php';
                include_once 'C:\xampp\htdocs\Project\logic\employeeQueries.php';
                include_once 'C:\xampp\htdocs\Project\logic\guestQueries.php';

                $guest = "g";
                $employee = "e";
                $admin = "a";
                $receptionist = "r";

                $aUser = $_POST["aUser"] ??"";
                $aPass = $_POST["aPass"] ??"";

                $aType = $_POST["loginType"] ??"";

                $conn = connect();
                
                
                if($aType =="g"){//login as guest
                    echo "login as guest";
                    $result = guestLogin($conn,$aUser,$aPass);
                    
                }elseif($aType =="e"){//login as employee
                    echo "login as emp";
                    $result = employeeLogin($conn,$aUser,$aPass);


                }elseif($aType =="a"){//login as admin
                    echo "login as admin";
                    $result = adminLogin($conn,$aUser,$aPass);


                }else{//login as receptionist
                    echo "login as rec   ";
                    $result = recepLogin($conn,$aUser,$aPass);
                }


                if ($result) {
                    header("Content-Type: JSON");
                    $rowNumber = 0;
                    $output = array();
    
                    while ($row = mysqli_fetch_array($result)) {
                        $output[$rowNumber]['SSN'] = $row['SSN']??"";
                        $rowNumber++;
                    }
                    
                    if (count($output) > 0) {
                        echo "Successfully logged in.<br>";
                        if($aType =="g"){//login as guest
                            echo "login as guest";
                      




                            header("location: resGuestRead.php");
                        }elseif($aType =="e"){//login as employee
                            echo "login as emp";
                            header("location: resEmpRead.php");

                        }elseif($aType =="a"){//login as admin
                            echo "login as admin";
                            header("location: resEmpRead.php");

                        }else{//login as receptionist
                            echo "login as rec   ";
                            header("location: resGuestRead.php");

                        }
                                
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="./index.js"></script>
<script src="./start.js"></script>
</html>