<?
    include "common/dbconnect.php";
    $id = $_POST["t_id"];
    $password = $_POST["t_password_1"];
    $name = $_POST["t_name"];
    $mobile = $_POST["t_mobile"];
    $email_1 = $_POST["t_email_1"];
    $email_2 = $_POST["t_email_2"];
    $info_yn = $_POST["t_info_yn"];
    $reg_date_time = date("y-m-d h:i:s", time());

    $query = "insert into h_member ".
    "(id,password,name,mobile,email_1,email_2,info_yn,reg_date) ".
    "values ".
    "('$id','$password','$name','$mobile','$email_1','$email_2','$info_yn','$reg_date_time')";
    
    $result = mysqli_query($connect,$query);
    
    if($result == 1)$msg = $name." 님 회원가입 되었습니다.";
    else $msg = "회원가입이 정상처리 되지 않았습니다. 다시 시도해 주세요.";

echo $query;   
?>
<script>
    alert("<?=$msg?>");
    location.href="/";
</script>