<?php
    session_start();
    include "common/dbconnect.php";

    $queryMax ="select max(no)+1 as maxno from h_faq "; /*파일명이 중복일시 삭제시에 오류가 생길수 있으므로 파일명에 게시글 번호를 부여해주려한다. */
    $resultMax = mysqli_query($connect, $queryMax);
    $rowMax = mysqli_fetch_array($resultMax);
    
    if(!$rowMax['maxno']) { //게시글이 하나도 없어서 번호가 없을 시 1번으로 주고 빈칸이 아닐시 기존번호 N +1 로 작동
        $maxNo = '1';
    } else {
        $maxNo = $rowMax['maxno'];
    }
    
    $title = addslashes($_POST["t_title"]); //addslashes();는  '' , "" 같은 특수문자도 db에 넣을 수 있게 해준다.
    $content = addslashes($_POST["t_content"]);
    $reg_id = $_SESSION["session_id"];
    $reg_date_time = date("y-m-d h:i:s", time());

    $query ="insert into h_faq ".
    "(no,title,content,reg_id,reg_date) ".
    "values ".
    "('$maxNo','$title','$content','$reg_id','$reg_date_time') ";

        echo $query;
        
    $result = mysqli_query($connect, $query);
    if($result == 1) $msg ="등록되었습니다.";
    else $msg ="등록 실패";
    
?>
<script>
    alert("<?=$msg?>");
    location.href="faq_list.php";
</script>