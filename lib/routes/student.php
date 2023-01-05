<link rel="stylesheet" href="../../css/style.css">
<?php include("../layouts/nav_loged.php"); ?>

<?php 
    if(empty($_SESSION['LoginSession'])){
        header("location:../views/login.php");
    }
?>

<div class="std-content">
    <div class="container">
        <div class="title">Welcome to Online Selection Test</div>
        <hr>

        <div class="body">
            <h3>Studnet details</h3>
        
        
            <!--
                code of update user data only using one php page
                -------- Begin ------------------------

                * can use for any user type (user, admin)
             -->

            <?php 
                if(isset($_POST['update_user'])){
                    $result = update_user_value($_POST['update_data']);
                    echo $result;
                }
            ?>

            <?php 
                if(isset($_POST['update_user_data_infor'])){
                    $result = update_data_to_table($_POST['update_username'], $_POST['update_address'], $_POST['update_nic'], $_POST['update_dob'], $_POST['update_mobile']);
                    echo $result;
                }
            
            ?>

            <?php 
                if(isset($_POST['update_user'])){
                    update_user_data();                  

                }
                else{
                    view_all_user_data();

                    ?>                        
                        <form action="<?php echo($_SERVER['PHP_SELF']); ?>" method="POST">
                            <input type="hidden" name="update_data" value="1">
                            <input type="submit" value="Update Data" name="update_user" class="btn btn-primary" style="margin-top: 15px;">        
                        </form>
                    <?php 
                }
            
            ?>

            <!--
                ------- End ------------------------
                code of update user data only using one php page
            -->



            <hr>
            <div class="exam-info">
                <div class="title">
                    *IMPORTANT*
                </div>
                <div class="body">
                    <b>Befor the test, READ THIS carefully,</b>
                    <br>
                    <ul>
                        <li>Student can attempt to the exam only one time.</li>
                        <li>The exam contain 40 MCQ questions</li>
                        <li>the exam will conduct 2 hours </li>
                        <li>After 2 hours the answers will submit automatically</li>
                        <li>After you answered to the exam you must click the finish button to get marks</li>
                        <li><span style="color:red"><b>If you can not answer to the questions within time you can not get marks</b></span></li>
                    </ul>

                    <?php 
                        if(isset($_POST['attempt'])){
                            $_SESSION['examStart'] = time();
                            $_SESSION['examEnd'] = $_SESSION['examStart'] + (10);                            
                            header("location:exam.php");                            
                        }
                    ?>

                    <form action="<?php echo($_SERVER['PHP_SELF']); ?>" method="POST">
                        <input type="submit" value="Attempt to Examination" class="btn btn-danger" name="attempt">
                    </form>
                    
                    

                </div>
                <hr>
            </div>

            <div class="result-view">
                <div class="title">Your Result</div>

                <div class="body">
                    <div class="table-responsive-lg">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Username</th>
                                    <th>Marks</th>
                                    <th>Attempt time</th>
                                    <th>Finish time</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Jehan</td>
                                    <td>40</td>
                                    <td>2023/01/05 23:10:52</td>
                                    <td>2023/01/05 23:10:52</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<?php include("../layouts/footer.php"); ?>
