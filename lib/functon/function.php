<?php

    use FTP\Connection;

    include("config.php");

    session_start();


    function reg_user($username,$email,$pass){
        $con = Connection();

        $check_user = "SELECT * FROM user_tbl WHERE username  name = '$username' && email = '$email'";
        $check_user_result = mysqli_query($con, $check_user);
        
    }

?>
