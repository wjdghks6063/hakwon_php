<?php
    include "common/dbconnect.php";
    $id = $_POST["t_id"];
    $query ="select count(*) as count from h_member ".
            "where id ='$id' ";
    $result = mysqli_query($connect, $query);
    $row    = mysqli_fetch_array($result); /*1줄이어도 풀어줘야 쓸수 있다. */
    $count  = $row["count"];
    if($count == '1') echo "사용불가";
    else echo "사용가능";
?>