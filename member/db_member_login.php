<?php
    include "common/dbconnect.php";
    $id       = $_POST["t_id"];
    $password = $_POST["t_password"];

    $query ="select name,level,exit_yn from h_member ".
            "where id ='$id' ".
            "and password ='$password' ";
    $result = mysqli_query($connect, $query);
    $row    = mysqli_fetch_array($result);
    $name   = $row["name"];
    $level   = $row["level"];
    $exit_yn   = $row["exit_yn"];

    if($id && $exit_yn == 'y'){
    $msg ="회원 탈퇴한 계정입니다.";
    $url ="login.php";

    }else if($name && $exit_yn == 'n') {
        session_start();
        $_SESSION["session_name"]=$name; /*"session_name"은 내가 정할수 있음 */
        $_SESSION["session_id"]=$id;
        $_SESSION["session_level"]=$level;   
        $msg ="$name 님 환영합니다.";
        $url ="/";
    
    }else {
        $msg ="아이디 또는 비밀번호가 일치하지 않습니다.";
        $url ="login.php";
    }
    echo $exit_yn
?>
<script>
    alert("<?=$msg?>");
    location.href="<?=$url?>";
</script>