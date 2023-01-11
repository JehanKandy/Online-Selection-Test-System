<?php include("../layouts/header.php"); ?>
<link rel="stylesheet" href="../../css/style.css">
<?php include("../layouts/nav_loged.php"); ?>

<?php 
    if(empty($_SESSION['LoginSession'])){
        header("location:../views/login.php");
    }
    
    admin_access();

?>


<div class="view-user">
    <div class="container">
        <div class="title"> User : <?php view_user_email(); ?></div>
        <hr>
        
        <?php 
            if(isset($_POST['to_deactive_form'])){
                $result = to_deactive_user($_POST['to_deactive']);
                echo $result;
            }
            elseif(isset($_POST['to_active_form'])){
                $result = to_active_user($_POST['to_active']);
                echo $result;
            }
            elseif(isset($_POST['to_pending_form'])){
                $result = to_pending_user($_POST['to_pending']);
                echo $result;
            }
            elseif(isset($_POST['to_approved_form'])){
                $result = to_apprived_user($_POST['to_approved']);
                echo $result;
            }

            
            
        ?>

        <div class="body">
            <?php user_data(); ?>
        </div>
    </div>
</div>

<script src="../../js/script.js"></script>
<?php include("../layouts/footer.php"); ?>
