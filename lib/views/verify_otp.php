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
            <i class="fas fa-key"></i> Verify OTP
        </div>
        <div class="body">
            <?php 
                if(isset($_POST['verify_otp'])){
                    $result = verify_otp(md5($_POST['check_otp']));
                    echo $result;
                }
            
            ?>

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
