<link rel="stylesheet" href="../../css/style.css">
<?php include("../layouts/nav_loged.php"); ?>

<?php 
    if(empty($_SESSION['LoginSession'])){
        header("location:../views/login.php");
    }
    
    techer_access();
?>



<script src="../../js/script.js"></script>
<?php include("../layouts/footer.php"); ?>
