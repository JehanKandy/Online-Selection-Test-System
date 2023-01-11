<?php include("../layouts/header.php"); ?>
<link rel="stylesheet" href="../../css/style.css">
<?php include("../layouts/nav_loged.php"); ?>

<?php 
    if(empty($_SESSION['LoginSession'])){
        header("location:../views/login.php");
    }
    
    admin_access();

?>

<div class="view-question">
    <div class="container">
        <div class="title">View Question</div>
        <hr>
        <a href="admin.php"><button class="btn btn-primary">Back</button></a>
    </div>
</div>


<script src="../../js/script.js"></script>
<?php include("../layouts/footer.php"); ?>
