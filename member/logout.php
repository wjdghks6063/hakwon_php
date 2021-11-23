<?php
    session_start();
    $session_name = $_SESSION["session_name"];
    session_destroy();
?>
<script>
    alert("<?=$session_name?> 님 로그아웃 되었습니다.");
    location.href="/";
</script>