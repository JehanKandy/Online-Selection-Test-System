<?php include("../layouts/header.php"); ?>
<link rel="stylesheet" href="../../css/style.css">

<?php 
    include("../functon/function.php");

    if(empty($_SESSION['resetPass'])){
        header("location:login.php");
    }
?>

<div class="container">
    <div class="login-content">
        <div class="title">
            <i class="fas fa-key"></i> Update Password
        </div>
        <div class="body">
            <?php 
                if(isset($_POST['update_pass'])){
                    $result = update_password($_POST['pass_username'], $_POST['pass_email'], md5($_POST['pass_pass']), md5($_POST['pass_cpass']));
                    echo $result;
                }
            
            ?>
            <form action="<?php echo($_SERVER['PHP_SELF']); ?>" method="POST">
                <p class="form-text">Username : </p>
                <input type="text" name="pass_username" id="" class="form-input">

                <p class="form-text">Email : </p>
                <input type="email" name="pass_email" id="" class="form-input">
        
                <p class="form-text">Password : </p>
                <input type="password" name="pass_pass" id="" class="form-input">

                <p class="form-text">Confirm Password : </p>
                <input type="password" name="pass_cpass" id="" class="form-input">

                <input type="submit" value="Update Password" name="update_pass" class="btn btn-success btn-lg btn-block" style="margin-top: 10px;">
            </form>
        </div>
    </div>
</div>


<script src="../../js/script.js"></script>
<?php include("../layouts/footer.php"); ?>
