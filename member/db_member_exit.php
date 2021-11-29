<?include "common/dbconnect.php";


$id = $_POST["t_id"];
$exit_date_time = date("y-m-d H:i:s",time());

$query="update h_member set exit_yn ='y', exit_date='$exit_date_time' where id = '$id' ";
$result = mysqli_query($connect,$query);
if($result == 1) $msg ="탈퇴되었습니다.";
else $msg ="탈퇴 실패";
?>

<script>    
    alert("<?=$msg?>");
    location.href="/info/info_list.php";
</script>