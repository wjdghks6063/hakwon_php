<?
    include "common/common_header.php";
    include "common/dbconnect.php";

        $no            = $_POST["t_no"];
        $title         = $_POST["t_title"];
        $content       = $_POST["t_content"];

        $reg_id        = $_SESSION["session_id"];
        $reg_date_time = date("y-m-d H:i:s",time());

        $query="update h_faq set title ='$title', content='$content', ".
                "reg_id='$reg_id', reg_date='$reg_date_time' where no = $no";
        echo $query;
        $result = mysqli_query($connect,$query);
        if($result ==1) $msg = "수정되었습니다";
        else $msg="수정실패";
    
?>
<script>    
    alert("<?=$msg?>");
    location.href="faq_list.php";
</script>