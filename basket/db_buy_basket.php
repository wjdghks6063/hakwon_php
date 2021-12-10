<?
    include "common/common_header.php";
    include "common/dbconnect.php";
        
    $orderno = $_POST["t_orderno"];
    $check = $_POST["t_check"];
    $price_num = $_POST["t_price_num"];
    $price_code = $_POST["t_price_code"];
    $price = $_POST["t_price"];

    $count= count($orderno);  //count는 기존 메서드이고 거기에 행렬을 넣으면 행수까줌


    for($k=0;$k<$count;$k++){
        if($check[$k]){
    
            echo "===$check[$k]====$orderno[$k]==$price_code[$k]===$price_num[$k]====$price[$k]<br>";
                //update aaa set 재고 = 재고-$amountArr[$k] where ~;
        }
    }

    echo "orderno : $orderno <br>";
    echo " check : $check <br>";
    echo "price_num : $price_num <br>";
    echo "price_code : $price_code <br>";
    
?>
<script>    