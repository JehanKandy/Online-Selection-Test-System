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
            $insert_user = "INSERT INTO user_tbl (username,email,user_pass,user_type,is_pending,is_active,join_date)VALUES('$username','$email','$pass','student',1,0,NOW())";
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

        $_SESSION['userName'] = $username; 

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
    function view_username(){
        $con = Connection();

        $useremail = strval($_SESSION['userName']);
        echo $useremail;
    }

    function request_otp($username, $email){
        $con = Connection();


        if(empty($username)){
            return  "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                    <strong>Username Error</strong> Username Can not be empty..!
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                    <span aria-hidden='true'>&times;</span>
                    </button>
            </div>";
        }
        if(empty($email)){
            return  "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                    <strong>Email Error</strong> Email Can not be empty..!
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                    <span aria-hidden='true'>&times;</span>
                    </button>
            </div>";
        }

        $check_user_otp = "SELECT * FROM user_tbl WHERE username='$username' && email='$email' && is_pending = 0 && is_active = 1";
        $check_user_otp_result = mysqli_query($con, $check_user_otp);
        $check_user_otp_nor = mysqli_num_rows($check_user_otp_result);
        $check_user_otp_row = mysqli_fetch_assoc($check_user_otp_result);
        
        if($check_user_otp_nor > 0){
            $otp_number = rand(10000,99999);
            $pass_otp = md5($otp_number);

            $recever = $email;
            $subject = "Password Reset";
            $body = "OTP For Resent Password";
            $body .= " use the OTP to update Password : " .$otp_number;
            $sender = "From:jehankandy@gmail.com";

            if(mail($recever,$subject,$body,$sender)){
                $check_otp_db = "SELECT * FROM pass_reset_tbl WHERE username ='$username' && email = '$email'";
                $check_otp_db_result = mysqli_query($con, $check_otp_db);
                $check_otp_db_nor = mysqli_num_rows($check_otp_db_result);
                
                if($check_otp_db_nor > 0){
                    return  "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                            <strong>Process Error</strong> Can not Process Task..!
                            <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                            <span aria-hidden='true'>&times;</span>
                            </button>
                    </div>";
                }
                else{
                    $insert_otp = "INSERT INTO pass_reset_tbl(username,email,otp_no,get_date)VALUES('$username','$email','$pass_otp',NOW())";
                    $insert_otp_result = mysqli_query($con, $insert_otp);

                    setcookie('ResetPass',$check_user_otp_row['email'],time()+5,'/');
                    $_SESSION['resetPass'] = $check_user_otp_row['email'];
                    header("location:verify_otp.php");
                }
            }
            
        }else{
            return  "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                    <strong>User Error</strong> User Does not Exist..!
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                    <span aria-hidden='true'>&times;</span>
                    </button>
            </div>";
        }

    }

    function verify_otp($otp_num){
        $con = Connection();

        if(empty($otp_num)){
            return  "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                    <strong>OTP Error</strong> OTP Can not be empty..!
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                    <span aria-hidden='true'>&times;</span>
                    </button>
            </div>";
        }

        else{
            $email = strval($_SESSION['resetPass']);

            $check_otp_user = "SELECT * FROM pass_reset_tbl WHERE email = '$email'";
            $check_otp_user_reuslt = mysqli_query($con, $check_otp_user);
            $check_otp_user_row = mysqli_fetch_assoc($check_otp_user_reuslt);
            $check_otp_user_nor = mysqli_num_rows($check_otp_user_reuslt);

            if($check_otp_user_nor > 0){
                if($check_otp_user_row['otp_no'] == $otp_num){
                    $delete_otp = "DELETE FROM pass_reset_tbl WHERE email = '$email'";
                    $delete_otp_result = mysqli_query($con, $delete_otp);

                    header("location:update_pass.php");
                }else{
                    return  "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                            <strong>Process Error</strong> Can not Process Task..!
                            <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                            <span aria-hidden='true'>&times;</span>
                            </button>
                    </div>";
                }
            }else{
                return  "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                        <strong>OTP Error</strong> Can not Find OTP..!
                        <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                        <span aria-hidden='true'>&times;</span>
                        </button>
                </div>";
            }
        }
    }

    function update_password($username,$email,$pass,$cpass){
        $con = Connection();

        if(empty($username)){
            return  "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                    <strong>Username Error</strong> Username Can not be Empty...!
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                    <span aria-hidden='true'>&times;</span>
                    </button>
            </div>";
        }
        if(empty($email)){
            return  "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                    <strong>Email Error</strong> Email Can not be Empty..!
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                    <span aria-hidden='true'>&times;</span>
                    </button>
            </div>";
        }
        if(empty($pass)){
            return  "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                    <strong>Password Error</strong> New Password Can not be Empty..!
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                    <span aria-hidden='true'>&times;</span>
                    </button>
            </div>";
        }
        if(empty($cpass)){
            return  "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                    <strong>Password Error</strong> Confirm New Password Can not be Empty..!
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                    <span aria-hidden='true'>&times;</span>
                    </button>
            </div>";
        }
        if($pass != $cpass){
            return  "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                    <strong>Password Error</strong> Password not Match...!
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                    <span aria-hidden='true'>&times;</span>
                    </button>
            </div>";
        }
        else{
            $check_user = "SELECT * FROM user_tbl WHERE username='$username' && email='$email' && is_pending = 0 && is_active = 1";
            $check_user_result = mysqli_query($con, $check_user);
            $check_user_row = mysqli_fetch_assoc($check_user_result);
            $check_user_nor = mysqli_num_rows($check_user_result);

            if($check_user_nor > 0){
                $update_pass = "UPDATE user_tbl SET user_pass = '$pass' WHERE username='$username' && email = '$email'";
                $update_pass_result = mysqli_query($con,$update_pass);

                setcookie('ResetPass',NULL,time()-60*60,'/');
                session_destroy() ;
                header('location:login.php');

            }else{
                return  "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                        <strong>Password Error</strong> Password not Match...!
                        <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                        <span aria-hidden='true'>&times;</span>
                        </button>
                </div>";
            }
        }
    }

    function view_all_user_data(){
        $con = Connection();

        $login_email = strval($_SESSION['LoginSession']);

        $select_all_user = "SELECT * FROM user_tbl WHERE email = '$login_email' && is_pending = 0 && is_active = 1";
        $select_all_user_result = mysqli_query($con, $select_all_user);
        $select_all_user_nor = mysqli_num_rows($select_all_user_result);
        $user_data = mysqli_fetch_assoc($select_all_user_result);

        if($select_all_user_nor > 0){
            $view_user = "
                <table border='0'>
                    <tr>
                        <td><span class='view-text'>Username : <span></td>
                        <td><span class='view-data'>".$user_data['username']."<span></td>
                    </tr>
                    <tr>
                        <td><span class='view-text'>Email : <span></td>
                        <td><span class='view-data'>".$user_data['email']."</span></td>
                    </tr>
                    <tr>
                        <td><span class='view-text'>Address : <span></td>
                        <td><span class='view-data'>".$user_data['user_address']."</span></td>
                    </tr>
                    <tr>
                        <td><span class='view-text'>NIC : <span></td>
                        <td><span class='view-data'>".$user_data['nic']."</span></td>
                    </tr>
                    <tr>
                        <td><span class='view-text'>Date of birth : <span></td>
                        <td><span class='view-data'>".$user_data['dob']."</span></td>
                    </tr>
                    <tr>
                        <td><span class='view-text'>Contact Number : <span></td>
                        <td><span class='view-data'>".$user_data['mobile_no']."</span></td>
                    </tr>
                </table>            
            ";

            echo $view_user;
        }else{
            return  "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                <strong>Password Error</strong> Password not Match...!
                <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                <span aria-hidden='true'>&times;</span>
                </button>
        </div>";
        }
    }

    function update_user_value($update_value){
        $con = Connection();
        
        $_SESSION['UpdateUser'] = $update_value;

    }

    function update_user_data(){
        $con = Connection();

        $login_email = strval($_SESSION['LoginSession']);
        $update_user_data = strval($_SESSION['UpdateUser']);

        $select_all_user = "SELECT * FROM user_tbl WHERE email = '$login_email' && is_pending = 0 && is_active = 1";
        $select_all_user_result = mysqli_query($con, $select_all_user);
        $user_data = mysqli_fetch_assoc($select_all_user_result);

        if($update_user_data == 1){
            $view_user_update = "
                <table border='0'>
                    <form action='' method='POST'>
                        <tr>
                            <td><span class='view-text'>Username : <span></td>
                            <td><input type='text' name='update_username' class='form-input' value='".$user_data['username']."'></td>
                        </tr>
                        <tr>
                            <td><span class='view-text'>Email : <span></td>
                            <td><input type='email' name='update_email' class='form-input' value='".$user_data['email']."' disabled></td>
                        </tr>
                        <tr>
                            <td><span class='view-text'>Address : <span></td>
                            <td><input type='text' name='update_address' class='form-input' value='".$user_data['user_address']."'></td>

                        </tr>
                        <tr>
                            <td><span class='view-text'>NIC : <span></td>
                            <td><input type='text' name='update_nic' class='form-input' value='".$user_data['nic']."'></td>

                        </tr>
                        <tr>
                            <td><span class='view-text'>Date of birth : <span></td>
                            <td><input type='date' name='update_dob' class='form-input'></td>

                        </tr>
                        <tr>
                            <td><span class='view-text'>Contact Number : <span></td>
                            <td><input type='text' name='update_mobile' class='form-input' value='".$user_data['mobile_no']."'></td>
                        </tr>

                        <tr>
                            <td colspan='2'>
                                <input type='submit' name='update_user_data_infor' class='btn btn-success' value='Update Data'>
                            </td>
                        </tr>
                    </form>
                </table>            
            ";

            echo $view_user_update;

        }else{
            return  "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                <strong>Password Error</strong> Password not Match...!
                <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                <span aria-hidden='true'>&times;</span>
                </button>
        </div>";
        }
    }


    function update_data_to_table($username, $address, $nic, $dob, $mobile){
        $con = Connection();
        $login_email = strval($_SESSION['LoginSession']);

        $update_user = "UPDATE user_tbl SET username = '$username', user_address='$address', nic = '$nic', dob = '$dob', mobile_no = '$mobile' WHERE email = '$login_email'";
        $update_user_result = mysqli_query($con, $update_user);
    }

    function techer_access(){
        $con = Connection();

        $login_email = strval($_SESSION['LoginSession']);

        $select_access = "SELECT * FROM user_tbl WHERE email = '$login_email'";
        $select_access_result = mysqli_query($con, $select_access);
        $select_access_row = mysqli_fetch_assoc($select_access_result);

        if($select_access_row['user_type'] != 'teacher'){
            header("location:../views/logout.php");
        }
    }

    function add_question($question, $op1, $op2, $op3, $op4, $cop){
        $con = Connection();
        $login_email = strval($_SESSION['LoginSession']);

        if(empty($question)){
            return  "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                <strong>Question</strong> Qestion Can not be Empty...!
                <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                <span aria-hidden='true'>&times;</span>
                </button>
        </div>";
        }
        if(empty($op1)){
            return  "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                <strong>Option 1 </strong> Option 1 Can not be Empty...!
                <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                <span aria-hidden='true'>&times;</span>
                </button>
        </div>";
        }
        if(empty($op2)){
            return  "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                <strong>Option 2 </strong> Option 2 Can not be Empty...!
                <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                <span aria-hidden='true'>&times;</span>
                </button>
        </div>";
        }
        if(empty($op3)){
            return  "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                <strong>Option 3 </strong> Option 3 Can not be Empty...!
                <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                <span aria-hidden='true'>&times;</span>
                </button>
        </div>";
        }
        if(empty($op4)){
            return  "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                <strong>Option 4 </strong> Option 4 Can not be Empty...!
                <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                <span aria-hidden='true'>&times;</span>
                </button>
        </div>";
        }
        if(empty($cop)){
            return  "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                <strong>Correct Answer </strong> Correct Answer Can not be Empty...!
                <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                <span aria-hidden='true'>&times;</span>
                </button>
        </div>";
        }

        $check_question = "SELECT * FROM selection_test WHERE question = '$question'";



    }

?>
