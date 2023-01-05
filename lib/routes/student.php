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

            <?php view_all_user_data(); ?>
        
            <form action="<?php echo($_SERVER['PHP_SELF']); ?>" method="POST">
                <input type="hidden" name="update_data" value="1">
                <input type="submit" value="Update Data" name="update_user" class="btn btn-primary" style="margin-top: 15px;">        
            </form>

        </div>
    </div>
</div>

<?php include("../layouts/footer.php"); ?>
