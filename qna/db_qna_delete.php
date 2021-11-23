<?include "common/dbconnect.php";


$no = $_POST["t_no"];

$query="delete from h_qna where no =$no";
$result = mysqli_query($connect,$query);
if($result == 1) $msg ="삭제되었습니다.";
else $msg ="삭제 실패";
?>

<script>    
    alert("<?=$msg?>");
    location.href="qna_list.php";
</script>