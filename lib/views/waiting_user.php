<?php include("../layouts/header.php"); ?>
<link rel="stylesheet" href="../../css/style.css">
<?php include("../functon/function.php"); ?>

<div class="container">
    <div class="login-content">
        <div class="title">
            <i class="fas fa-user-clock"></i> Account Pending
        </div>
        <div class="body">
            HI...! <?php view_username(); ?> <br>
            <div class="waiting-msg">
                Your account approval is still pending <br>

                <a href="login.php" style="text-decoration: none;"><button class="btn btn-primary waiting-btn">Back to Login</button></a>
            </div>
        </div>
    </div>
</div>

<script src="../../js/script.js"></script>
<?php include("../layouts/footer.php"); ?>
