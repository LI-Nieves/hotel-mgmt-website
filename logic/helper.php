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
        return true;
    }
    catch (TypeError $e) {
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
        return true;
    }
    catch (TypeError $e) {
        return false;
    }
}

?>