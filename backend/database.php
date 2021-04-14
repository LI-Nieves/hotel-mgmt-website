<?php
    $host = 'localhost';
    $user = 'root';
    $pwd = '';
    $db = 'hoteldb';

    $conn;

    function connect() {
        global $host;
        global $user;
        global $pwd;
        global $db;

        global $conn;

        $conn = mysqli_connect($host, $user, $pwd, $db);

        //if (mysqli_connect_errno($conn)) {
        if (mysqli_connect_errno()) {
            print "Connection to $db failed.<br>";
        }

        return $conn;
    }

?>