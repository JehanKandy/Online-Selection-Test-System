<?php include("../layouts/header.php"); ?>
<link rel="stylesheet" href="../../css/">

<div class="container">
    <div class="login-content">
        <div class="title">
            <i class="fas fa-key"></i> Get OTP
        </div>
        <div class="body">
            <?php 
                include("../functon/function.php");

                if(isset($_POST['get_otp'])){
                    $result = request_otp($_POST['otp_username'], $_POST['otp_email']);
                    echo $result;
                }           
            ?>

            <form action="<?php echo($_SERVER['PHP_SLEF']); ?>" method="POST">
                <p class="form-text">Username : </p>
                <input type="text" name="otp_username" id="" class="form-input">

                <p class="form-text">Password : </p>
                <input type="email" name="otp_email" id="" class="form-input">

                <input type="submit" value="Request OTP" class="btn btn-primary" name="get_otp" style="margin-top: 10px;">
            </form>
        </div>
    </div>
</div>


<script src="../../js/script.js"></script>
<?php include("../layouts/footer.php"); ?>
