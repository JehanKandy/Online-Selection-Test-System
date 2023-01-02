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
                <span class="fas fa-user-alt user-ico"></span>
            </form>
        </div>
    </div>
</div>


<?php include("../layouts/footer.php"); ?>
<script src="../../js/script.js"></script>
