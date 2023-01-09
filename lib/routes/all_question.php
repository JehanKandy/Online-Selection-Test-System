<link rel="stylesheet" href="../../css/style.css">

<?php 
    if(empty($_SESSION['LoginSession'])){
        header("location:../views/login.php");
    }
    
    admin_access();
    techer_access();
?>

<div class="all-question">
    <div class="title">All Questions</div>
    <hr>
</div>

<div class="table-responsive-lg">
    <table class="table">
        <thead>
            <tr>
                <th>Question</th>
                <th>Add User</th>
                <th>Status</th>
                <th>Pending Status</th>
                <th>Add Date</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php view_all_questions(); ?>
        </tbody>
    </table>
</div>




<script src="../../js/script.js"></script>
