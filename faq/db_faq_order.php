<?php
    include "../common/dbconnect.php";

    $i = 0; //변수 생성
    foreach($_POST['drag'] as $value) { // li id="drag" 에 value 로 개별마다 프라이 머리 키 값 생성
        $query = "UPDATE h_faq SET orderno = $i WHERE no = '$value'";
        mysqli_query($connect, $query);
        $i++;
    }