<?include "common/dbconnect.php";


$orderno = $_POST["t_orderno"];

$query ="UPDATE h_buy_list SET exception = 'y' WHERE orderno = '$orderno' ";
$result = mysqli_query($connect,$query);
if($result == 1) $msg ="정상 처리 되었습니다.";
else $msg ="정상 처리 되지 않았습니다. 다시 시도해 주세요.";
?>

<script>    
    alert("<?=$msg?>");
    location.href="basket_list.php";
</script>