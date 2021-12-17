<?
	include "common/common_header.php";
	include "common/dbconnect.php";

/**************************page setting********************************/
/*pagingSetting.php와 같은 변수명으로 사용해야 작동 하기 때문에 양쪽의 변수명을 맞춰준다. */

	$countTotal =" select * from h_member where exit_yn='y' "; /*페이지를 정할 db 명 */ 
	$countOnePage = "10"; // 한 페이지당 보여줄 목록 수 (?)행 보여주겠다.
	$perblock = 5;		 // 한 페이지당 보여줄 페이지 번호 수 < 1 2 3 4 5 >

	include "common/pagingSetting.php"; //변수명들을 넣어줘야 작동되기 때문에 변수명 아래쪽에 include 해준다.
	$t_page =$_POST['t_page']; // view에 갔다가 목록이나 뒤로 가기를 했을 때 현재 페이징 넘버로 가질 수 있게 해준다.
/**********************************************************************/

	$query ="SELECT a.no, b.name, a.id, a.title, a.use_point, b.point, a.reg_date, a.use_list FROM h_point a, h_member b ".
			"where a.id = b.id ".
			"and use_list = 'waiting' ".
			"order by no desc ".
			"limit $start, $end ";
	$result = mysqli_query($connect,$query);
										
	$count = mysqli_num_rows($result); 

	if($session_level != 'top'){
?>		
	<script>
		alert("관리자 화면 입니다.");
		location.href="/";
	</script>
<?	
	}
?>	
		<!--  header end -->
<script>
	function goView(id){
		info.t_id.value=id;
		info.method="post";
		info.action="info_view.php";
		info.submit();
	}
	function goPage(pageNumber){		
		pageForm.t_page.value = pageNumber;
		pageForm.method ="post";
		pageForm.action ="exit_list.php";
		pageForm.submit();
	}
	function goCharge(no,id,use_point){
		if(confirm("포인트를 충전시키겠습니까?")){
		gocharge.t_no.value= no;
		gocharge.t_id.value= id;
		gocharge.t_use_point.value= use_point;
		gocharge.method="post";
		gocharge.action="db_point_charge.php";
		gocharge.submit();
		}
	}
</script>

<form name="gocharge">
	<input type="hidden" name="t_no" >
	<input type="hidden" name="t_id" >
	<input type="hidden" name="t_use_point">
</form>

<form name ="pageForm">
	<input type="hidden" name="t_page">
</form>

		<!-- sub page start -->
		<div class="notice">
			<div class="sub-notice">
			<h2><a href="/info/myinfo_view.php">내 정보</a></h2>	
		<?	if($session_level == 'top') { ?>
			<h2><a href="/info/info_list.php">회원 정보</a></h2>
			<h2><a href="/info/exit_list.php">탈퇴 정보</a></h2>
			<h2 class="color"><a href="/info/point_charge_waiting.php"><i class="fas fa-check"></i>충전 요청</a></h2>	
		<?	} ?>
			</div>
			
			<!-- table start-->
			<div class="table-box">
				<table class="table">
					<caption>공지사항 - 번호, 제목, 첨부, 작성일, 조회수</caption>
					<colgroup>
						<col width="12%">
						<col width="10%">
						<col width="*%">
						<col width="15%">
						<col width="12%">
						<col width="12%">
						<col width="8%">
					</colgroup>
					
					<thead>
					<tr>
						<th scope="col">id</th>
						<th scope="col">이름</th>
						<th scope="col">요청 내역</th>
						<th scope="col">요청 일자</th>
						<th scope="col">현재 포인트</th>
						<th scope="col">충전 요청 포인트</th>
						<th scope="col">충전</th>
					</tr>
					</thead>
					
					<tbody>
			<?for($k=0;$k<$count;$k++){ //압축되어있는 놈을 한줄씩한줄씩 뺴서 로우에 담는다
						$row = mysqli_fetch_array($result);
			?>	
					<tr>
						<td><?=$row["id"]?></td>		
						<td><a href="javascript:goView('<?=$row["id"]?>')"><?=$row["name"]?></a></td>
						<td><?=$row["title"]?></td>
						<td><?=$row["reg_date"]?></td>
						<td><?=$row["point"]?></td>
						<td>+ <?=$row["use_point"]?></td>
				<?if($session_level == 'top'){ ?>
						<td><a href="javascript:goCharge('<?=$row["no"]?>','<?=$row["id"]?>','<?=$row["use_point"]?>') "><span class="complet">충전</span></a></td>
				<?}?>

			<?}?>
					</tr>	
					</tbody>
				</table>
			</div>
			
			<div class="page-number1">
		<?	include "common/pagingDisplay.php"; ?>	
<!--			<a href="#" class="icon"><i class="fas fa-arrow-circle-left fa-lg"></i></a>
				<a href="#" class="on">1</a>
				<a href="#">2</a>
				<a href="#">3</a>
				<a href="#">4</a>
				<a href="#">5</a>
				<a href="#">6</a>
				<a href="#">7</a>
				<a href="#">8</a>
				<a href="#">9</a>
				<a href="#" class="more">…</a>
				<a href="#" class="icon"><i class="fas fa-arrow-circle-right fa-lg"></i></a>
-->			
			</div>
		
		</div>
		
		<!--  footer start  -->
	<?
		include "common/common_footer.php";
	?>
		</div>
	
	
	
	</body>
</html>









