<?
	$host ="localhost";
	$dbname ="fullstack";
	$user ="fstack";
	$password ="1234";
	
	$connect = new mysqli($host,$user,$password,$dbname);
	if($connect){
//		echo "접속 성공~";
	}else {
		echo "접속 실패";
	}
?>