<?php include("../layouts/header.php"); ?>
<link rel="stylesheet" href="../../css/style.css">

<div class="container">
    <div class="login-content">
        <div class="title">
            <i class="fas fa-user-alt"></i> Login Here
        </div>
        <div class="body">
            <?php 
                include("../functon/function.php");
                if(isset($_POST['login'])){
                    $result = login_user($_POST['username'], md5($_POST['password']));
                    echo $result;
                }
            
            ?>

            <form action="<?php echo($_SERVER['PHP_SELF']); ?>" method="POST" name="login_form" onsubmit="return login_validate();">
                <p class="form-text" id="userText">Username :</p>
                <input type="text" name="username" id="userName" class="form-input">
                <p id="usernameError"></p>

                <p class="form-text" id="PassText">Password :</p>
                <input type="password" name="password" id="passWord" class="form-input">
                <p id="passError"></p>
            
                <input type="submit" value="Login" name="login" class="btn btn-primary login-btn">

            </form>
            <a href="forget_pass.php" style="text-decoration: none; ">Forget Password</a>
            <br> Don't have an account ? <a href="reg.php" style="text-decoration: none;">Sign Up</a>
        </div>
    </div>
</div>


<?php include("../layouts/footer.php"); ?>
<script src="../../js/script.js"></script>
