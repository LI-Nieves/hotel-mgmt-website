<?php
    $host = 'localhost';
    $user = 'root';
    $pwd = '';
    $db = 'hoteldb';

    $conn;

    //print "here 1";

    function connect() {
        global $host;
        global $user;
        global $pwd;
        global $db;

        global $conn;

        //print "here 2";

        $conn = mysqli_connect($host, $user, $pwd, $db);

        //if (mysqli_connect_errno($conn)) {
        if (mysqli_connect_errno()) {
            print "Connection to $db failed.<br>";
        }
        else {
            print "Connection successfully established to $db database.<br>";
        }

        return $conn;
    }

    //connect();

?>