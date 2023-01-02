<?php include("../layouts/header.php"); ?>
<link rel="stylesheet" href="../../css/style.css">

<div class="container">
    <div class="login-content">
        <div class="title">
            <i class="fas fa-user-plus"></i> Register Here
        </div>
        <div class="body">
            <form action="<?php echo($_SERVER['PHP_SELF']); ?>" method="POST" name="reg_form" onsubmit="return valodateReg();">
                <p class="form-text" id="regUser">Username :</p>
                <input type="text" name="uername" id="Userreg" class="form-input">

                <p class="form-text" id="regEmail">Email :</p>
                <input type="email" name="email" id="Useremail" class="form-input">

                <p class="form-text" id="regpass">Password : </p>
                <input type="password" name="pass" id="Userpass" class="form-input">

                <p class="form-text" id="regcpass">Confirm Password</p>
                <input type="password" id="Usercpass" class="form-input">

                <p style="margin-top: 15px;"><input type="reset" value="Clear" class="btn btn-secondary"><input type="submit" value="Sign Up" class="btn btn-success"></p>
            </form>
        </div>
    </div>
</div>


<script src="../../js/script.js"></script>
<?php include("../layouts/footer.php"); ?>