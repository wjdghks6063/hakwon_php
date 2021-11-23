<?include "common/dbconnect.php";


$no = $_POST["t_no"];
$del_file = $_POST["t_attach"];
$attach_dir =$_SERVER["DOCUMENT_ROOT"]."/file_room/notice/"; 
$tf = unlink($attach_dir.iconv("UTF-8","CP949",$del_file)); 

$msg="정상적으로 처리되지않았습니다. 다시 시도해 주세요.";

if($tf==1){
    $query="delete from h_notice where no =$no";
    $result = mysqli_query($connect,$query);
        if($result==1){
            $msg="정상적으로 처리 되었습니다.";
        }
}
?>

<script>    
    alert("<?=$msg?>");
    location.href="notice_list.php";
</script>