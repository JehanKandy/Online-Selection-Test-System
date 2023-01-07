<?php include("../layouts/header.php"); ?>
<link rel="stylesheet" href="../../css/style.css">
<?php include("../layouts/nav_loged.php"); ?>

<?php 
    if(empty($_SESSION['LoginSession'])){
        header("location:../views/login.php");
    }
    
    techer_access();
?>

<div class="add-question">
    <div class="container">
        <div class="title">
            Add Question
        </div>
        <div class="body">

        </div>
    </div>
</div>



<script src="../../js/script.js"></script>
<?php include("../layouts/footer.php"); ?>