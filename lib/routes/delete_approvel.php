<?php include("../layouts/header.php"); ?>
<link rel="stylesheet" href="../../css/style.css">
<?php include("../layouts/nav_loged.php"); ?>

<?php 
    if(empty($_SESSION['LoginSession'])){
        header("location:../views/login.php");
    }
    
    admin_access();

?>

<div class="delete-approvel">
    <div class="container">
        <div class="title">Delete Approval : <?php delet_user_email();?></div>
        <hr>
        <div class="body">
            <?php delete_user_data(); ?>
        </div>
    </div>
</div>

<script src="../../js/script.js"></script>
<?php include("../layouts/footer.php"); ?>
