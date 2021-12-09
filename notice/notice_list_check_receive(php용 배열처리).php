<?

$amountArr = $_POST["t_amount"];
$noArr = $_POST["t_no"];

$count= count($amountArr);  //count는 기존 메서드이고 거기에 행렬을 넣으면 행수까줌


for($k=0;$k<$count;$k++){
    if($noArr[$k]){

        echo "=======$amountArr[$k]===$noArr[$k]===<br>";
            //update aaa set 재고 = 재고-$amountArr[$k] where ~;
    }
}
//$result = $noArr[0];
//echo $no; 
//echo $co; 
echo $result;
?>
