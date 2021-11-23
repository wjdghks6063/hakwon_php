<?php
    include "common/dbconnect.php";
    $id       = $_POST["t_id"];
    $password = $_POST["t_password"];

    $query ="select name from h_member ".
            "where id ='$id' ".
            "and password ='$password' ";
    $result = mysqli_query($connect, $query);
    $row    = mysqli_fetch_array($result);
    $name   = $row["name"];

    if($name) {
        session_start();
        $_SESSION["session_name"]=$name; /*"session_name"은 내가 정할수 있음 */
        $_SESSION["session_id"]=$id;
        if($id =="manager" || $id =="aaa") {
            $_SESSION["session_level"]="top";
        }   
        $msg ="$name 님 환영합니다.";
        $url ="/";
    } else {
        $msg ="아이디 또는 비밀번호가 일치하지 않습니다.";
        $url ="login.php";
    }
?>
<script>
    alert("<?=$msg?>");
    location.href="<?=$url?>";
</script>