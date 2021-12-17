<?
    include "common/dbconnect.php";

    $no = $_POST["t_no"];
    $id = $_POST["t_id"];
    $use_point = $_POST["t_use_point"];

    $callProcedure = "call buy_point_procedure('$id', '$no', $use_point ); "; //실행시키는 것이 아닌 문자열로만 집어 넣었다. $result = mysqli_query($connect, $query); 처럼
    $stmt = mysqli_prepare($connect, $callProcedure); //prepare를 실행시키기전 준비과정
    $result = mysqli_stmt_execute($stmt);

    echo $callProcedure;

    if($result == 1) $msg ="등록되었습니다.";
    else $msg ="등록 실패";

?>
<script>    
    alert("<?=$msg?>");
    location.href="point_charge_waiting.php";
</script>