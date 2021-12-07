<?php
    session_start();
    include "common/dbconnect.php";

    $title = addslashes($_POST["t_title"]); //addslashes();는  '' , "" 같은 특수문자도 db에 넣을 수 있게 해준다.
    $content = addslashes($_POST["t_content"]);
    $reg_id = $_SESSION["session_id"];
    $reg_date_time = date("y-m-d h:i:s", time());

    $callProcedure = "call faq_save_procedure('$title','$content','$reg_id','$reg_date_time') "; //실행시키는 것이 아닌 문자열로만 집어 넣었다. $result = mysqli_query($connect, $query); 처럼
    $stmt = mysqli_prepare($connect, $callProcedure); //prepare를 실행시키기전 준비과정
    $result = mysqli_stmt_execute($stmt);

    if($result == 1) $msg ="등록되었습니다.";
    else $msg ="등록 실패";
    
?>
<script>
    alert("<?=$msg?>");
    location.href="faq_list.php";
</script>