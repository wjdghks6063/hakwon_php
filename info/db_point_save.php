<?php
    session_start();
    include "common/dbconnect.php";

    $queryMax ="select max(no)+1 as maxno from h_point "; /*파일명이 중복일시 삭제시에 오류가 생길수 있으므로 파일명에 게시글 번호를 부여해주려한다. */
    $resultMax = mysqli_query($connect, $queryMax);
    $rowMax = mysqli_fetch_array($resultMax);
    
    if(!$rowMax['maxno']) { //게시글이 하나도 없어서 번호가 없을 시 1번으로 주고 빈칸이 아닐시 기존번호 N +1 로 작동
        $maxNo = '1';
    } else {
        $maxNo = $rowMax['maxno'];
    }
    
    $id = $_POST["t_id"];
    $use_point = $_POST["t_use_point"];
    $now_point = $_POST["t_now_point"];
    $reg_date_time = date("y-m-d h:i:s", time());

    $query ="insert into h_point ".
    "(no, id, title, use_point, now_point, reg_date, use_list) ".
    "values ".
    "('$maxNo','$id','포인트 충전 이용','$use_point','$now_point','$reg_date_time','waiting') ";

        echo $query;
        
    $result = mysqli_query($connect, $query);
    if($result == 1) $msg ="등록되었습니다.";
    else $msg ="등록 실패";
    
?>
<script>
    alert("<?=$msg?>");
    location.href="/info/point_charge.php";
</script>