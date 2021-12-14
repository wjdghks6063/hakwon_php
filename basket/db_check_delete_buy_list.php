<?
    session_start();
    include "common/dbconnect.php";
    
    $id      = $_SESSION["session_id"];
    $orderno = $_POST["t_orderno"];
    $check = $_POST["t_check"];
    $price_code = $_POST["t_price_code"];

    $count= count($orderno);  //count는 기존 메서드이고 거기에 행렬을 넣으면 행수까줌


    for($k=0;$k<$count;$k++){
        if($check[$k]){
            $query ="UPDATE h_buy_list SET exception = 'y' WHERE orderno = '$orderno[$k]' ";
        
            echo $query;
                
            $result = mysqli_query($connect, $query);
        }
    }

    if($result == 1) $msg ="삭제 되었습니다.";
    else $msg ="삭제 실패";
    
?>
<script>
    alert("<?=$msg?>");
//    location.href="buy_list.php";
</script>

