<?php include("../layouts/header.php"); ?>
<link rel="stylesheet" href="../../css/style.css">
<?php include("../layouts/nav_loged.php"); ?>

<?php 
    if(empty($_SESSION['LoginSession'])){
        header("location:../views/login.php");
    }
    
    admin_access();

?>


<div class="admin-content">
    <div class="container">
        <div class="title">Admin</div>
    
    <div class="body">
        <hr>
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

            <div class="all-users">
                <div class="title">All Users</div>
                <div class="body">
                <div class="table-responsive-lg">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Username</th>
                                    <th>Email</th>
                                    <th>User Type</th>
                                    <th>User Stats</th>
                                    <th>Panding Status</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php view_all_users(); ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="../../js/script.js"></script>
<?php include("../layouts/footer.php"); ?>
