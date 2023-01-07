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
            <form action="<?php echo($_SERVER['PHP_SELF']); ?>" method="POST">
                <p class="form-text">Question</p>
                <textarea class="form-control" rows="3"></textarea>

                <p class="form-text">Options</p>
                
                <ol class="question-option">
                    <li><p><input type="text" name="option1" id="" class="form-control"></li></p>
                    <li><p><input type="text" name="option2" id="" class="form-control"></li></p>
                    <li><p><input type="text" name="option3" id="" class="form-control"></li></p>
                    <li><p><input type="text" name="option4" id="" class="form-control"></li></p>
                </ol>
            </form>
        </div>
    </div>
</div>



<script src="../../js/script.js"></script>
<?php include("../layouts/footer.php"); ?>
