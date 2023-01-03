<?php

    use FTP\Connection;

    include("config.php");

    session_start();


    function reg_user($username,$email,$pass){
        $con = Connection();

        $check_user = "SELECT * FROM user_tbl WHERE username  name = '$username' && email = '$email'";
        $check_user_result = mysqli_query($con, $check_user);
        $check_user_nor = mysqli_num_rows($check_user_result);
        $check_user_row = mysqli_fetch_assoc($check_user_result);

        if($check_user_nor == 0){

        }else{
            return "<span style='red'>User Already Exists</span>";
        }

    }

?>
