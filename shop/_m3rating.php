<?
include "../common/dbconnect.php";
// m3rating 별점 매기기 모듈 ver 1.10


// 별점 내용 가져오기
$sql = "select star_average, star_data from `m3rating` where bo_table='$bo_table' AND wr_id='$wr_id'";
$result = mysqli_query($connect, $sql);
$rating = mysqli_fetch_array($result);
$board_skin_path = "..";
if($rating) {
	$rating_count = sizeof(explode(",", $rating["star_data"]));
	$rating_average = sprintf("%.1f", $rating["star_average"]);
}
else {
	$rating_count = 0;
	$rating_average = "0.00";
}
?>
<style>
@import url("../../../webbus01.css");

#m3rate {border-collapse:collapse; margin:0; padding:0; border:0; display:inline;}
#m3rate img {margin:0; padding:0; border:0;}
</style>
<div id="m3rate"><span onMouseOut="m3rate_o()">
<?for($i=1;$i<=floor($rating_average);$i++) {?><img src="<?=$board_skin_path?>/img/s<?=$i%2?"1":"2"?>1.png" name="m3rate_img<?=$i?>" align="absmiddle" id="m3rate_img<?=$i?>" title="<?=$i?>" onClick="m3rate_c('<?=$i?>')" onMouseOver="m3rate_o('<?=$i?>')" /><?}?>
<?for($i=floor($rating_average)+1;$i<=10;$i++) {?><img src="<?=$board_skin_path?>/img/s<?=$i%2?"1":"2"?>0.png" name="m3rate_img<?=$i?>" align="absmiddle" id="m3rate_img<?=$i?>" title="<?=$i?>" onClick="m3rate_c('<?=$i?>')" onMouseOver="m3rate_o('<?=$i?>')" /><?}?></span> 
<span id="m3rate_comment"><font style="font-size:11pt; color:#222222;"><?=$rating_average?></font> <font style="font-size:11pt; color:#666666;">(<?=$rating_count?>명)</font></span><br />
<font style="font-size:11px; font-family:돋움, Verdana, Tahoma; color:#666666;">위의 별을 클릭하면 점수를 주실수 있습니다!</font>
</div>

<script type="text/javascript">
var m3rate_commentarr = Array('<font style="font-size:11pt; color:#222222;">1점</font><font style="font-size:11pt; color:#777777;">/10</font>', '<font style="font-size:11pt; color:#222222;">2점</font><font style="font-size:11pt; color:#777777;">/10</font>점', '<font style="font-size:11pt; color:#222222;">3점</font><font style="font-size:11pt; color:#777777;">/10</font>', '<font style="font-size:11pt; color:#222222;">4점</font><font style="font-size:11pt; color:#777777;">/10</font>', '<font style="font-size:11pt; color:#222222;">5점</font><font style="font-size:11pt; color:#777777;">/10</font>', '<font style="font-size:11pt; color:#222222;">6점</font><font style="font-size:11pt; color:#777777;">/10</font>', '<font style="font-size:11pt; color:#222222;">7점</font><font style="font-size:11pt; color:#777777;">/10</font>', '<font style="font-size:11pt; color:#222222;">8점</font><font style="font-size:11pt; color:#777777;">/10</font>', '<font style="font-size:11pt; color:#222222;">9점</font><font style="font-size:11pt; color:#777777;">/10</font>', '<font style="font-size:11pt; color:#222222;">10점</font><font style="font-size:11pt; color:#777777;">/10</font>');
var m3rate_commentdefault = '<font style="font-size:11pt; color:#222222;"><?=$rating_average?></font><font style="font-size:11pt; color:#777777;">/10</font> <font style="font-size:11pt; color:#555555;">(<?=$rating_count?>명)</font>';
var n = parseInt(<?=$rating_average?>);
function m3rate_o(r) {
	var r_int = parseInt(r);
	// 리셋
	if(!r) {
		for(i=1; i<=n; i++) {
			if(i%2) sr = '<?=$board_skin_path?>/img/s11.png';
			else sr = '<?=$board_skin_path?>/img/s21.png';
			document.getElementById('m3rate_img'+i).src = sr;
		}
		for(i=n+1; i<=10; i++) {
			if(i%2) sr = '<?=$board_skin_path?>/img/s10.png';
			else sr = '<?=$board_skin_path?>/img/s20.png';
			document.getElementById('m3rate_img'+i).src = sr;
		}
		document.getElementById('m3rate_comment').innerHTML = m3rate_commentdefault;
	}
	// 별 그려줌
	else {
		for(i=1; i<=r_int; i++) {
			if(i%2) sr = '<?=$board_skin_path?>/img/s11.png';
			else sr = '<?=$board_skin_path?>/img/s21.png';
			document.getElementById('m3rate_img'+i).src = sr;
		}
		for(i=r_int+1; i<=10; i++) {
			if(i%2) sr = '<?=$board_skin_path?>/img/s10.png';
			else sr = '<?=$board_skin_path?>/img/s20.png';
			document.getElementById('m3rate_img'+i).src = sr;
		}
		document.getElementById('m3rate_comment').innerHTML = m3rate_commentarr[(r_int-1)];
	}
}
function m3rate_c(star) {
	jQuery.ajax({
	type: "POST",
	url: "<?=$board_skin_path?>/__m3rating_update.php",
	data: "gr_id=<?=$board["gr_id"]?>&bo_table=<?=$bo_table?>&wr_id=<?=$wr_id?>&star="+star,
	success: function(msg){
		alert( msg );
	}
	});
}
</script>
