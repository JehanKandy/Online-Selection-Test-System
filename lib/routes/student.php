<?php include("../layouts/header.php"); ?>
<link rel="stylesheet" href="../../css/style.css">
<?php include("../layouts/nav_loged.php"); ?>

<?php 
    include("../functon/function.php");
    if(empty($_SESSION['LoginSession'])){
        header("location:../views/login.php");
    }
?>

<div class="std-content">
    <div class="container">
        <div class="title">Welcome Come to Online Selection Test</div>
        <hr>

        <div class="body">
            <h3>Studnet details</h3>
        
        </div>
    </div>
</div>

<?php include("../layouts/footer.php"); ?>
