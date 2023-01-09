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

    function admin_access(){
        $con = Connection();

        $login_email = strval($_SESSION['LoginSession']);

        $select_access = "SELECT * FROM user_tbl WHERE email = '$login_email'";
        $select_access_result = mysqli_query($con, $select_access);
        $select_access_row = mysqli_fetch_assoc($select_access_result);

        if($select_access_row['user_type'] != 'admin'){
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
        if($cop >= 4){
            return  "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                    <strong>Error </strong> Wrong Option...!
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                    <span aria-hidden='true'>&times;</span>
                    </button>
            </div>";
        }

        $check_question = "SELECT * FROM question_tbl WHERE question = '$question'";
        $check_question_result = mysqli_query($con, $check_question);
        $check_question_nor = mysqli_num_rows($check_question_result);

        $add_username = "SELECT * FROM user_tbl WHERE email = '$login_email'";
        $add_username_result = mysqli_query($con, $add_username);
        $add_username_row = mysqli_fetch_assoc($add_username_result);

        $add_user = $add_username_row['username'];

        if($check_question_nor > 0){
            return  "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                    <strong>Question Answer </strong> Question Already Added...!
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                    <span aria-hidden='true'>&times;</span>
                    </button>
            </div>";
        }
        else{
            $insert_question = "INSERT INTO question_tbl(question,option1,option2,option3,option4,correct_option,question_status,question_panding,add_date,add_user)VALUES('$question','$op1','$op2','$op3','$op4','$cop',0,1,NOW(),'$add_user')";
            $insert_question_result = mysqli_query($con, $insert_question);

            if(!$insert_question_result){
                return  "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                        <strong>ERROR </strong> Error While adding data to database...!
                        <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                        <span aria-hidden='true'>&times;</span>
                        </button>
                </div>";
            }else{
                return  "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                        <strong>Successful </strong> Question Added Successfully...!
                        <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                        <span aria-hidden='true'>&times;</span>
                        </button>
                </div>";
            }
        }
    }

    function view_add_question(){
        $con = Connection();

        $select_question = "SELECT * FROM question_tbl";
        $select_question_result = mysqli_query($con, $select_question);

        while($question_row = mysqli_fetch_assoc($select_question_result)){
            $question_data = "
                <tr>
                    <td>".$question_row['question']."</td>
                    <td>".$question_row['add_user']."</td>
                    <td>".$question_row['add_date']."</td>
                    ";
                        if($question_row['question_status'] == 1){
                            $question_data .= "<td><h4><span class='badge badge-success'>Active</span></h4></td>";
                        }
                        elseif($question_row['question_status'] == 0){
                            $question_data .= "<td><h4><span class='badge badge-danger'>Deactive</span></h4></td>";
                        }

                        if($question_row['question_panding'] == 0){
                            $question_data .= "<td><h4><span class='badge badge-success'>Approved</span></h4></td>";
                        }
                        elseif($question_row['question_panding'] == 1){
                            $question_data .= "<td><h4><span class='badge badge-danger'>Still Pending</span></h4></td>";
                        }

            $question_data .= "                    
                    <td>
                        <a href='view_question.php?id=".$question_row['id']."'><button class='btn btn-success'>View</button></a>
                    </td>
                </tr>";

            echo $question_data;
        }
    }

    function view_all_users(){
        $con = Connection();

        $login_email = strval($_SESSION['LoginSession']);

        $select_user = "SELECT * FROM user_tbl";
        $select_user_result = mysqli_query($con, $select_user);

        while($user_row = mysqli_fetch_assoc($select_user_result)){
            $all_user = "
                <tr>
                    <td>".$user_row['username']."</td>
                    <td>".$user_row['email']."</td>";

                if($user_row['user_type'] == 'admin'){
                    $all_user .= "<td><h4><span class='badge badge-warning'>Admin</span></h4></td>";
                }
                elseif($user_row['user_type'] == 'teacher'){
                    $all_user .= "<td><h4><span class='badge badge-warning'>Teacher</span></h4></td>";
                }
                elseif($user_row['user_type'] == 'student'){
                    $all_user .= "<td><h4><span class='badge badge-warning'>Student</span></h4></td>";
                }
 
                if($user_row['is_active'] == 1){
                    $all_user .="<td><h4><span class='badge badge-success'>Active</span></h4></td>";
                }
                elseif($user_row['is_active'] == 0){
                    $all_user .="<td><h4><span class='badge badge-danger'>Deactive</span></h4></td>";
                }


                if($user_row['is_pending'] == 1){
                    $all_user .="<td><h4><span class='badge badge-danger'>Still Pending</span></h4></td>";
                }
                elseif($user_row['is_pending'] == 0){
                    $all_user .="<td><h4><span class='badge badge-success'>Approved</span></h4></td>";
                }
            

                if($user_row['email'] == $login_email){
                    $all_user .="
                        <td>
                            <span style='color:red;'>Loged User</span>
                        </td>";
                }
                else{
                    $all_user .="
                    <td>
                        <a href='view_user.php?id=".$user_row['email']."'><button class='btn btn-primary'>View</button></a>
                    </td>
                ";
                }


            echo $all_user;
        }
    }

    function view_user_email(){
        $con = Connection();

        $id = $_GET['id'];
        $_SESSION['UserID'] = $id;

        echo $id;
    }

    function user_data(){
        $con = Connection();

        $id = strval($_SESSION['UserID']);


        $user_data_sql = "SELECT * FROM user_tbl WHERE email = '$id'";
        $user_data_sql_result = mysqli_query($con,$user_data_sql);
        $user_data_row = mysqli_fetch_assoc($user_data_sql_result);

        $user_data_view = "
            <a href='admin.php'><button class='btn btn-primary' style='margin-top:10px; margin-bottom:30px;'>Back</button></a>
            
            <p> Username :  </p>
            <input type='text' value='".$user_data_row['username']."' class='form-control' disabled> <br>

            <p> Email :  </p>
            <input type='email' value='".$user_data_row['email']."' class='form-control' disabled> <br>

            <p> Address :  </p>
            <input type='text' value='".$user_data_row['user_address']."' class='form-control' disabled> <br>

            <p> NIC :  </p>
            <input type='text' value='".$user_data_row['nic']."' class='form-control' disabled> <br>
            
            <p> Data of Birth :  </p>
            <input type='text' value='".$user_data_row['dob']."' class='form-control' disabled> <br>

            <p> Mobile Number :  </p>
            <input type='text' value='".$user_data_row['mobile_no']."' class='form-control' disabled> <br>
        ";

        if($user_data_row['is_active'] == 1){
            $user_data_view .="
                <p> User Status : </p>
                    <h4><span class='badge badge-success'>Active User</span></h4>
                <form action='' method='POST'>
                    <input type='hidden' value='0' name='to_deactive'>
                    <input type='submit' name='to_deactive_form' class='btn btn-danger' value='To Dactive'>
                </form>    
            ";
        }
        elseif($user_data_row['is_active'] == 0){
            $user_data_view .="
                <p> User Status : </p>
                    <h4><span class='badge badge-danger'>Deactive User</span></h4>
                <form action='' method='POST'>
                    <input type='hidden' value='1' name='to_active'>
                    <input type='submit' name='to_active_form' class='btn btn-success' value='To Active'>
                </form>    
            ";
        }

        if($user_data_row['is_pending'] == 0){
            $user_data_view .="
                <p> User Status : </p>
                    <h4><span class='badge badge-success'>Approved User</span></h4>
                <form action='' method='POST'>
                    <input type='hidden' value='1' name='to_pending'>
                    <input type='submit' name='to_pending_form' class='btn btn-info' value='To Pending'>
                </form>    
            ";
        }
        elseif($user_data_row['is_pending'] == 1){
            $user_data_view .="
                <p> User Status : </p>
                    <h4><span class='badge badge-info'>Still Pending User</span></h4>
                <form action='' method='POST'>
                    <input type='hidden' value='0' name='to_approved'>
                    <input type='submit' name='to_approved_form' class='btn btn-success' value='To Approved'>
                </form>    
            ";
        }


        echo $user_data_view;
    }

    function to_deactive_user($value){
        $con = Connection();

        $id = strval($_SESSION['UserID']);

        $update_user = "UPDATE user_tbl SET is_active = '$value' WHERE email='$id'";
        $update_user_result = mysqli_query($con, $update_user);

        if(!$update_user_result){
            return  "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                    <strong>Process Error </strong> Can not Process Task...!
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                    <span aria-hidden='true'>&times;</span>
                    </button>
            </div>";
        }
        else{
            return  "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                    <strong>Successful </strong> User Uppdate Sucessfully...!
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                    <span aria-hidden='true'>&times;</span>
                    </button>
            </div>";
        }
    }

    function to_active_user($value){
        $con = Connection();

        $id = strval($_SESSION['UserID']);

        $update_user = "UPDATE user_tbl SET is_active = '$value' WHERE email='$id'";
        $update_user_result = mysqli_query($con, $update_user);

        if(!$update_user_result){
            return  "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                    <strong>Process Error </strong> Can not Process Task...!
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                    <span aria-hidden='true'>&times;</span>
                    </button>
            </div>";
        }
        else{
            return  "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                    <strong>Successful </strong> User Uppdate Sucessfully...!
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                    <span aria-hidden='true'>&times;</span>
                    </button>
            </div>";
        }
    }
    

    function to_pending_user($value){
        $con = Connection();
    }

    function to_apprived_user($value){
        $con = Connection();
    }

?>
