<?php include("../layouts/header.php"); ?>
<link rel="stylesheet" href="../../css/style.css">

<div class="container">
    <div class="login-content">
        <div class="title">
            <i class="fas fa-user-alt"></i> Login Here
        </div>
        <div class="body">
            <form action="<?php echo($_SERVER["PHP_SELF"]); ?>" method="POST">
                <p class="form-text">Username :</p>
                <input type="text" name="username" id="userName" class="form-input">
                <p id="usernameError"></p>

                <p class="form-text">Password :</p>
                <input type="password" name="password" id="passWord" class="form-input">
                <p id="passError"></p>
            
                <input type="submit" value="Login" name="login" class="btn btn-primary login-btn">

            </form>
            <a href="" style="text-decoration: none; ">Forget Password</a>
            <br> Don't have an account ? <a href="" style="text-decoration: none;">Create One</a>
        </div>
    </div>
</div>


<?php include("../layouts/footer.php"); ?>
<script src="../../js/script.js"></script>
