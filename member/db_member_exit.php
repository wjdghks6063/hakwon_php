<?include "common/dbconnect.php";


$id = $_POST["t_id"];
$exit_date_time = date("y-m-d H:i:s",time());

session_start();
    $session_name = $_SESSION["session_name"];

$query="update h_member set exit_yn ='y', exit_date='$exit_date_time' where id = '$id' ";
$result = mysqli_query($connect,$query);
if($result == 1){ 
    $msg ="회원 탈퇴되었습니다.";
    session_destroy();
}else{ 
    $msg ="탈퇴 실패";
}

echo $id;
?>

<script>    
    alert("<?=$session_name?>님 <?=$msg?>");
    location.href="/";
</script>