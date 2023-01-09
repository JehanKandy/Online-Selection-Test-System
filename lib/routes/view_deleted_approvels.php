<?php include("../layouts/header.php"); ?>
<link rel="stylesheet" href="../../css/style.css">
<?php include("../layouts/nav_loged.php"); ?>

<?php 
    if(empty($_SESSION['LoginSession'])){
        header("location:../views/login.php");
    }
    
    admin_access();

?>

<div class="deleted-approvels">
    <div class="container">
        <div class="title">Deleted Approvals</div>
    
        <div class="body">
            <a href="admin.php"><button class="btn btn-primary" style="margin: 30px 0 30px 0;">Back</button></a>

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
        </div>
    </div>
</div>

<script src="../../js/script.js"></script>
<?php include("../layouts/footer.php"); ?>
