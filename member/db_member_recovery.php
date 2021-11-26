<?include "common/dbconnect.php";


$id = $_POST["t_id"];

$query="update h_member set exit_yn ='n', exit_date= null where id = '$id' ";
$result = mysqli_query($connect,$query);
if($result == 1) $msg ="복구되었습니다.";
else $msg ="복구 실패";
?>

<script>    
    alert("<?=$msg?>");
    location.href="/info/exit_list.php";
</script>