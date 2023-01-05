<?php include("../layouts/header.php"); ?>
<link rel="stylesheet" href="../../css/style.css">
<?php include("../layouts/nav_loged.php"); ?>

<?php 
    if(empty($_SESSION['LoginSession'])){
        header("location:../views/login.php");
    }
?>

<div class="std-content">
    <div class="container">
        <div class="title">Welcome Come to Online Selection Test</div>
        <hr>

        <div class="body">
            <h3>Studnet details</h3>
        
        
            <!--
                code of update user data only using one php page
                -------- Begin ------------------------

                * can user for any user type (user, admin)
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
                        <li>the exam will conduct 2 houres</li>
                        <li>After 2 hours the answers will submit automatically</li>
                        <li>After you answered to the exam you must click the finish button to get marks</li>
                    </ul>

                    <a href="exam.php"><button class="btn btn-danger">Attempt to the Exam</button></a>
                    
                </div>
                <hr>
            </div>

            <div class="result-view">
                <div class="title">Your Result</div>

                <div class="body">
                    
                </div>
            </div>

        </div>
    </div>
</div>

<?php include("../layouts/footer.php"); ?>
