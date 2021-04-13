<?php

    function logOut() {
        $currentID = 0;
        session_destroy();
    }

    function assignCookie() {
        if (isset($_COOKIE["user"])) {
            $user = $_COOKIE["user"];
            return $user;
        }
        else {
            echo "Cookies have not been set.<br>";
            return 0;
        }
    }

    function handleInputInteger() {
        try {
            $numArgs = func_num_args();
            $argList = func_get_args();
            for ($i = 0; $i < $numArgs; $i++) {
                if ($argList[$i] != '') {
                    $argList[$i] + 0;
                }
            }
            //echo "int good<br>";
            return true;
        }
        catch (TypeError $e) {
            //echo "integer <br>";
            return false;
        }
    }

    function handleInputDate() {
        try {
            $numArgs = func_num_args();
            $argList = func_get_args();
            for ($i = 0; $i < $numArgs; $i++) {
                if ($argList[$i] != '') {
                    strtotime($argList[$i]);
                }
            }
            //echo "date good<br>";
            return true;
        }
        catch (TypeError $e) {
            //echo "dates <br>";
            return false;
        }
    }

    function countEntries($conn,$stmt) {
        $resultCheck = mysqli_query($conn,$stmt);
                    
        $count = 0;

        while ($row = mysqli_fetch_array($resultCheck)) {
            $count++;
        }

        return $count;
    }

?>