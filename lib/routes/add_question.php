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
        <a href="teacher.php"><button class="btn btn-primary">Back</button></a>
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

                <p class="form-text">Correct Answer</p>

                <p> 1. Option 1 &nbsp; <input type="radio" name="canswer" id="" value="1"></p>
                <p> 2. Option 2 &nbsp; <input type="radio" name="canswer" id="" value="2"></p>
                <p> 3. Option 3 &nbsp; <input type="radio" name="canswer" id="" value="3"></p>
                <p> 4. Option 4 &nbsp; <input type="radio" name="canswer" id="" value="4"></p>

                <input type="submit" value="Add Question" name="add_question" class="btn btn-success">
            </form>
        </div>
    </div>
</div>


<script src="../../js/script.js"></script>
<?php include("../layouts/footer.php"); ?>
