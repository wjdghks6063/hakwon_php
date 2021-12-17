<?
    session_start();
    include "common/dbconnect.php";
    
    $orderno = $_POST["t_orderno"];
    $check = $_POST["t_check"];

    $id      = $_SESSION["session_id"];
    $price_code = $_POST["t_price_code"];
    $price = $_POST["t_price"];
    $price_num = $_POST["t_price_num"];
    
    $count= count($orderno);  //count는 기존 메서드이고 거기에 행렬을 넣으면 행수까줌


    for($k=0;$k<$count;$k++){
        if($check[$k]){
            $callProcedure = "call basket_buy_procedure('$id', '$price_code[$k]', $price[$k], $price_num[$k], DATE_FORMAT(now(), '%Y-%m-%d'))" ; //실행시키는 것이 아닌 문자열로만 집어 넣었다. $result = mysqli_query($connect, $query); 처럼
            $stmt = mysqli_prepare($connect, $callProcedure); //prepare를 실행시키기전 준비과정
            $result = mysqli_stmt_execute($stmt);
        }
    }
    echo $callProcedure;

    if($result == 1) $msg ="등록되었습니다.";
    else $msg ="등록 실패";
    
?>
<script>
    alert("<?=$msg?>");
    location.href="basket_list.php";
</script>

