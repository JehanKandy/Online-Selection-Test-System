<?php include("../layouts/header.php"); ?>
<link rel="stylesheet" href="../../css/style.css">
<?php include("../layouts/nav_loged.php"); ?>

<?php 
    if(empty($_SESSION['LoginSession'])){
        header("location:../views/login.php");
    }
    
    admin_access();
?>

<div class="table-responsive-lg">
    <table class="table">
        <thead>
            <tr>
                <th>Username</th>
                <th>Email</th>
                <th>Delete Date</th>
            </tr>
        </thead>
        <tbody>
            <?php all_deleted_approvels(); ?>
        </tbody>
    </table>
</div>




<script src="../../js/script.js"></script>
<?php include("../layouts/footer.php"); ?>
