<?php

    use FTP\Connection;

    include("config.php");

    session_start();


    function reg_user($username,$email,$pass){
        $con = Connection();

        $check_user = "SELECT * FROM user_tbl WHERE username  = '$username' && email = '$email'";
        $check_user_result = mysqli_query($con, $check_user);
        $check_user_nor = mysqli_num_rows($check_user_result);

        if($check_user_nor == 0){
            $insert_user = "INSERT INTO user_tbl (username,email,user_pass,user_type,is_pending,is_active,join_date)VALUES('$username','$email','$pass','user',1,0,NOW())";
            $insert_user_result = mysqli_query($con, $insert_user);

            if($insert_user_result){

            }else{

            }

        }else{
            return  "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                    <strong>Username Error</strong>User Already Exists...!
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                    <span aria-hidden='true'>&times;</span>
                    </button>
            </div>";
        }

    }

?>
