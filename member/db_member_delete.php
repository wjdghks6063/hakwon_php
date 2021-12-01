<?include "common/dbconnect.php";


$id = $_POST["t_id"];

$query="delete from h_member where no =$id";
$result = mysqli_query($connect,$query);
if($result == 1) $msg ="삭제되었습니다.";
else $msg ="삭제 실패";
?>

<script>    
    alert("<?=$msg?>");
//    location.href="/info/exit_list.php";
</script>