<?
	include "common/common_header.php";
	include "common/dbconnect.php";

/**************************page setting********************************/
/*pagingSetting.php와 같은 변수명으로 사용해야 작동 하기 때문에 양쪽의 변수명을 맞춰준다. */

	$countTotal =" select * from h_notice "; /*페이지를 정할 db 명 */ 
	$countOnePage = "10"; // 한 페이지당 보여줄 목록 수 (?)행 보여주겠다.
	$perblock = 5;		 // 한 페이지당 보여줄 페이지 번호 수 < 1 2 3 4 5 >

	include "common/pagingSetting.php"; //변수명들을 넣어줘야 작동되기 때문에 변수명 아래쪽에 include 해준다.
	$t_page =$_POST['t_page']; // view에 갔다가 목록이나 뒤로 가기를 했을 때 현재 페이징 넘버로 가질 수 있게 해준다.
/**********************************************************************/

	$query ="select id, name, email_1, email_2, date_format(exit_date,'%Y-%m-%d') as exit_date, FORMAT(point , 0) as point, exit_yn, level from  h_member ".
			"where exit_yn ='y' order by reg_date desc ".
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
		pageForm.action ="notice_list.php";
		pageForm.submit();
	}
	function goDelete(id){
		if(confirm("정말 삭제하시겠습니까?")){
		info.t_id.value=id;
		info.method="post";
		info.action="/member/db_member_delete.php";
		info.submit();
		}
	}
	function goRecovery(id){
		if(confirm("정말 복구하시겠습니까?")){
		info.t_id.value=id;
		info.method="post";
		info.action="/member/db_member_recovery.php";
		info.submit();
		}
	}
</script>

<form name="info">
	<input type="hidden" name="t_id" value="<?=$id?>">
	<input type="hidden" name="t_page" value="<?=$t_page?>">
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
			<h2 class="color"><a href="/info/exit_list.php"><i class="fas fa-check"></i>탈퇴 정보</a></h2>	
		<?	} ?>
			</div>
			
			<!-- table start-->
			<div class="table-box">
				<table class="table">
					<caption>공지사항 - 번호, 제목, 첨부, 작성일, 조회수</caption>
					<colgroup>
						<col width="12%">
						<col width="12%">
						<col width="*%">
						<col width="15%">
						<col width="12%">
						<col width="10%">
						<col width="10%">
						<col width="10%">
					</colgroup>
					
					<thead>
						<tr>
							<th scope="col">id</th>
							<th scope="col">성함</th>
							<th scope="col">이메일</th>
							<th scope="col">회원 탈퇴일</th>
							<th scope="col">등급</th>
							<th scope="col">포인트</th>
							<th scope="col">계정 복구</th>
							<th scope="col">계정 탈퇴</th>
						</tr>
					</thead>
					
					<tbody>
			<?for($k=0;$k<$count;$k++){ //압축되어있는 놈을 한줄씩한줄씩 뺴서 로우에 담는다
						$row = mysqli_fetch_array($result);
			?>	
				<?if($row["exit_yn"] == 'n'){ ?>	
					<!-- 회원 탈퇴한 회원은 표시하지 않는다. -->
					<?}else{?>
					<tr>
						<td><?=$row["id"]?></td>		
						<td><a href="javascript:goView('<?=$row["id"]?>')"><?=$row["name"]?></a></td>
						<td><?=$row["email_1"]?>@<?=$row["email_2"]?></td>
						<td><?=$row["exit_date"]?></td>
				<?if($row["level"] == 'top'){ ?>	
						<td><span style="color:#FF0000"><?=$row["level"]?></span></a></td>
				<?}else{?>
						<td><?=$row["level"]?></td>
				<?}?>	
						<td><?=$row["point"]?></td>
				<?if($session_level == 'top'){ ?>
						<td><a href="javascript:goRecovery('<?=$row["id"]?>')"><span class="complet">계정 복구</span></a></td>
						<td><a href="javascript:goDelete('<?=$row["id"]?>')"><span class="waiting">계정 삭제</span></a></td>
				<?}?>

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
			<div class="page-number">
			<?if($session_level == 'top'){?>	
				<a href="notice_write.php" class="btn-write">글쓰기</a>
			
			<?}?>
			</div>
		
		</div>
		
		
		
		<!--  footer start  -->
	<?
		include "common/common_footer.php";
	?>
		</div>
	
	
	
	</body>
</html>









