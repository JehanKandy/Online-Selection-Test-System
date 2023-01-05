<link rel="stylesheet" href="../../css/style.css">
<?php include("../layouts/nav_loged.php"); ?>

<?php 
    if(empty($_SESSION['LoginSession'])){
        header("location:../views/login.php");
    }
    
    techer_access();
?>


<div class="teacher-content">
    <div class="container">
        <div class="title">
            Teacher
        </div>
        <div class="body">

        </div>
    </div>
</div>





<script src="../../js/script.js"></script>
<?php include("../layouts/footer.php"); ?>
