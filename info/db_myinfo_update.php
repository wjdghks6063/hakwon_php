<?
    include "common/dbconnect.php";

    $id = $_POST["t_id"];
    $password = $_POST["t_password_1"];
    $name = $_POST["t_name"];
    $mobile = $_POST["t_mobile"];
    $email_1 = $_POST["t_email_1"];
    $email_2 = $_POST["t_email_2"];
    $address_1 = $_POST["t_address_1"];
    $address_2 = $_POST["t_address_2"];
    $info_yn = $_POST["t_info_yn"];



    $query=" update h_member set password='$password', name='$name', ".
            "mobile='$mobile', email_1='$email_1', email_2='$email_2', address_1='$address_1', ".
            "address_2='$address_2', info_yn='$info_yn' where id = '$id' ";
    echo $query;
    $result = mysqli_query($connect,$query);
    if($result ==1) $msg = "수정되었습니다";
    else $msg="수정실패";

?>
<script>    
    alert("<?=$msg?>");
    location.href="info_list.php";
</script>