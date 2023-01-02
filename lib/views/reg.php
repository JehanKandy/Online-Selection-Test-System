<?php include("../layouts/header.php"); ?>
<link rel="stylesheet" href="../../css/style.css">

<div class="container">
    <div class="login-content">
        <div class="title">
            <i class="fas fa-user-alt"></i> Login Here
        </div>
        <div class="body">
            <form action="<?php echo($_SERVER['PHP_SELF']); ?>" method="POST" name="reg_form" onsubmit="return valodateReg();">
                <p class="form-text" id="regUser">Username :</p>
        
            </form>
        </div>
    </div>
</div>


<script src="../../js/script.js"></script>
<?php include("../layouts/footer.php"); ?>
