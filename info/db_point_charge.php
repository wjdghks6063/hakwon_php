<?
    include "common/dbconnect.php";

    $no = $_POST["t_no"];

    $password = $_POST["t_password_1"];
    $name = $_POST["t_name"];

    $query=" update h_point a set ".
            "use_list ='buy' ".
            "where no = '$no' " ;
    echo $query;
    $result = mysqli_query($connect,$query);
    if($result ==1) $msg = "수정되었습니다";
    else $msg="수정실패";

?>
<script>    
    alert("<?=$msg?>");
    location.href="point_charge_waiting.php";
</script>