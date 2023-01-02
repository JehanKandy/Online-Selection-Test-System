<?php include("../layouts/header.php"); ?>
<link rel="stylesheet" href="../../css/style.css">

<div class="container">
    <div class="login-content">
        <div class="title">
            <i class="fas fa-key"></i> Verify OTP
        </div>
        <div class="body">
            <form action="<?php echo($_SERVER['PHP_SELF']); ?>" method="POST">
                <p class="form-text">Enter OTP : </p>
                <input type="number" name="check_otp" id="" class="form-input">

                <input type="submit" value="Verify OTP" name="verify_otp" class="btn btn-primary" style="margin-top: 10px;">
            </form>            
        </div>
    </div>
</div>

<script src="../../js/script.js"></script>
<?php include("../layouts/footer.php"); ?>
