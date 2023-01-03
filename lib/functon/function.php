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
                return  "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                        <strong>Successfully</strong>User Create Successfully <a href='login.php' style='text-decoration:none;'>Login</a>
                        <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                        <span aria-hidden='true'>&times;</span>
                        </button>
                </div>";
            }else{
                return  "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                        <strong>Sign Up Error</strong>Can not Process the Task...!
                        <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                        <span aria-hidden='true'>&times;</span>
                        </button>
                </div>";
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

    function login_user($username, $pass){
        $con = Connection();

        $check_user_pending = "SELECT * FROM user_tbl WHERE username = '$username' && user_pass = '$pass' && is_pending = 1 && is_active = 0";
        $check_user_pending_result = mysqli_query($con, $check_user_pending);
        $check_user_pending_nor = mysqli_num_rows($check_user_pending_result);

        if($check_user_pending_nor > 0){
            header("location:waiting_user.php");
        }else{
            $check_user_deactive = "SELECT * FROM user_tbl WHERE username = '$username' && user_pass = '$pass' && is_pending = 0 && is_active = 0";
            $check_user_deactive_result = mysqli_query($con, $check_user_deactive);
            $check_user_deactive_nor = mysqli_num_rows($check_user_deactive_result);

            if($check_user_deactive_nor > 0){
                return  "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                    <strong>Account Error</strong>Account Deactive...!
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                    <span aria-hidden='true'>&times;</span>
                    </button>
            </div>";
            }
            else{
                $login_user = "SELECT * FROM user_tbl WHERE username = '$username' && user_pass = '$pass' && is_pending = 0 && is_active = 1";
                $login_user_result = mysqli_query($con, $login_user);
                $login_user_nor = mysqli_num_rows($login_user_result);
                $login_user_row = mysqli_fetch_assoc($login_user_result);

                if($login_user_nor > 0){
                    if($login_user_row['user_type'] == "student"){
                        setcookie('login',$login_user_row['email'],time()+60*60,'/');
                        $_SESSION['LoginSession'] = $login_user_row['email'];
                        header("location:../routes/student.php");
                    }elseif($login_user_row['user_type'] == "teacher"){
                        setcookie('login',$login_user_row['email'],time()+60*60,'/');
                        $_SESSION['LoginSession'] = $login_user_row['email'];
                        header("location:../routes/teacher.php");
                    }
                    elseif($login_user_row['user_type'] == "admin"){
                        setcookie('login',$login_user_row['email'],time()+60*60,'/');
                        $_SESSION['LoginSession'] = $login_user_row['email'];
                        header("location:../routes/admin.php");
                    }
                }else{
                    return  "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                                <strong>User Error</strong>User Does not Exist..!
                                <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                                <span aria-hidden='true'>&times;</span>
                                </button>
                        </div>";
                }
            }
        }
    }

?>
