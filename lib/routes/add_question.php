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
            <?php 
                if(isset($_POST['add_question'])){
                    $result = add_question($_POST['question'], $_POST['option1'], $_POST['option2'], $_POST['option3'], $_POST['option4'], $_POST['canswer']);
                    echo $result;
                }
            ?>

            <form action="<?php echo($_SERVER['PHP_SELF']); ?>" method="POST" name="question_form">
                <p class="form-text">Question</p>
                <textarea class="form-control" rows="3" name="question" id="question"></textarea>
                <p id="errorQues"></p>

                <p class="form-text">Options</p>
                
                <ol class="question-option">
                    <li><p><input type="text" name="option1" id="op1" class="form-control"></li></p>
                    <p id="op1Error"></p>
                    <li><p><input type="text" name="option2" id="op2" class="form-control"></li></p>
                    <p id="op2Error"></p>
                    <li><p><input type="text" name="option3" id="op3" class="form-control"></li></p>
                    <p id="op3Error"></p>
                    <li><p><input type="text" name="option4" id="op4" class="form-control"></li></p>
                    <p id="op4Error"></p>
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
