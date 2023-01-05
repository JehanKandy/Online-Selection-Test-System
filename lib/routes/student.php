<?php include("../layouts/header.php"); ?>
<link rel="stylesheet" href="../../css/style.css">

<?php 
    include("../functon/function.php");

    if($_SESSION['LoginSession']){
        header("location:../views/logout.php");
    }
?>




<?php include("../layouts/footer.php"); ?>