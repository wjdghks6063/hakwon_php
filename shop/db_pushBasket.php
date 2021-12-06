<?php
    include "../common/dbconnect.php";

    $queryMax ="select max(orderno)+1 as maxno from h_basket "; /*파일명이 중복일시 삭제시에 오류가 생길수 있으므로 파일명에 게시글 번호를 부여해주려한다. */
    $resultMax = mysqli_query($connect, $queryMax);
    $rowMax = mysqli_fetch_array($resultMax);
    
    if(!$rowMax['maxno']) { //게시글이 하나도 없어서 번호가 없을 시 1번으로 주고 빈칸이 아닐시 기존번호 N +1 로 작동
        $orderNo = 1;
    } else {
        $orderNo = $rowMax['maxno'];
    }

    $id = $_POST["t_id"];
    $price_code = $_POST["t_price_code"];
    $price = $_POST["t_total_price"];
    $price_num = $_POST["t_price_num"];
    $price_name = $_POST["t_price_name"];

    $querySearch ="select price_code from h_basket ";
    $resultSearch = mysqli_query($connect, $querySearch);
    $rowSearch = mysqli_fetch_array($resultSearch);

    $query ="select count(*) as count from h_basket ".
            "where price_code ='$price_code' ";
    $result = mysqli_query($connect, $query);
    $row    = mysqli_fetch_array($result); /*1줄이어도 풀어줘야 쓸수 있다. */
    $count  = $row["count"];

    $query ="INSERT INTO h_basket (orderno, id, price_code, price, stuff_number, price_name) VALUES ($orderNo, '$id', '$price_code', '$price', '$price_num', '$price_name') 
        ON DUPLICATE KEY UPDATE stuff_number = $price_num" ; //ON DUPLICATE KEY UPDATE stuff_number = $price_num" ;
        //stuff_number = stuff_number+$price_num" 는 장바구니의 값에 새로운 값을 더한다. ex) 20+10 = 30; // stuff_number = $price_num 로 하면 기존 20 에서 10으로 수량 교체
        /* 쉽게 풀면 if(pris code){ pk값이 있는 경우
            update query
        }else {  pk이 값이 없는 경우 
            insert query 로 작동한다.
        }
        */
        $result = mysqli_query($connect, $query);
        //$row    = mysqli_fetch_array($result); /*1줄이어도 풀어줘야 쓸수 있다. */
    
    if($count == '0') {
        $msg ="상품이 장바구니에 담겼습니다.";
    } else {
        $msg ="이미 장바구니에 상품이 존재합니다.";
    }
?>
<script>
	<?=$msg?>
</script>