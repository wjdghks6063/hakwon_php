<? 
// 기본 인클루드 
$g4_path = "../../.."; 
include "../common/dbconnect.php";
include_once("$g4_path/common.php"); 

// 변수 처리 
$gr_id = $_POST["gr_id"]; 
$bo_table = $_POST["bo_table"]; 
$wr_id = $_POST["wr_id"]; 
$star = $_POST["star"]; 
if($member["mb_id"]) $mb_id = $member["mb_id"]; 
else $mb_id = $_SERVER["REMOTE_ADDR"]; 

// 필요한 값이 넘어왔는지 
if(!$_POST["gr_id"]) die("그룹 값이 없음"); 
if(!$_POST["bo_table"]) die("게시판 값이 없음"); 
if(!$_POST["wr_id"]) die("글 번호가 없음"); 
if(!$_POST["star"]) die("별점이 넘어오지 않음"); 

// 글 내용 가져오기 
$sql = "select mb_id, wr_ip from `g4_write_$bo_table` where wr_id='$wr_id'"; 
$write = $sql_fetch($sql); 

// 없는 글이면 
if(!$write) die("없는 글이거나 삭제된 글입니다."); 

// 내 글이면 
$s_name = "자신의 글은 추천할 수 없습니다."; 
if($write["mb_id"]==$mb_id || $write["wr_ip"]==$mb_id) die($s_name); 
//if($write[mb_id]==$mb_id || $write[wr_ip]==$mb_id) die("자신의 글은 추천할 수 없습니다."); 

// 기존 별점 가져오기 
$sql = "select * from m3rating where bo_table='$bo_table' AND wr_id='$wr_id'"; 
$rating = $sql_fetch($sql); 

// 기존 별점 있으면 
if($rating) { 
// 이미 참가한 경우 
$s_name_alert = "이미 점수를 주셨습니다"; 
if(strpos(",".$rating["star_list"].",", ",".$mb_id.",")!==false) die($s_name_alert);
 // 참가하지 않은 경우 별점을 추가한다. 
$star_average = (array_sum(explode(",",$rating["star_data"]))+$star)/(sizeof(explode(",",$rating["star_data"]))+1);
$sql = "update m3rating set bo_table='$bo_table', wr_id='$wr_id', star_average='$star_average', star_data=CONCAT(star_data, ',$star'), star_list=CONCAT(star_list, ',$mb_id') where gr_id='$gr_id' AND bo_table='$bo_table' AND wr_id='$wr_id'";
} 
// 기존 별점이 없으면 
else { 
$sql = "insert into m3rating set gr_id='$gr_id', bo_table='$bo_table', wr_id='$wr_id', star_average='$star', star_data='$star', star_list='$mb_id'";
} 

// 실행하기 
$sql_query($sql); 

// 완료 
$s_name_end = "{$star}점이 반영되었습니다"; 
die($s_name_end); 
?> 