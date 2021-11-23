<?
	include "common/common_header.php";
	include "common/dbconnect.php";

	$query ="select a.no,a.title,a.attach,a.reg_id, date_format(a.reg_date,'%Y-%m-%d') as format_date, a.reg_date, b.name, a.hit  from h_notice a, h_member b ".
			"where a.reg_id = b.id order by no desc";
	$result = mysqli_query($connect,$query);
										
	$count = mysqli_num_rows($result); 
?>
		<!--  header end -->
		<script>
			function goView(no){
				notice.t_no.value=no;
				notice.method="post";
				notice.action="notice_view.php";
				notice.submit();
			}
		</script>
		<form name="notice">
			<input type="hidden" name="t_no">
		</form>
		<!-- sub page start -->
		<div class="notice">
			<div class="sub-notice">
			<h2 class="color"><a href="notice_list.php"><i class="fas fa-check"></i> NOTICE</a></h2>	
			<h2><a href="/qna/qna_list.php"> QnA</a></h2>
			<h2><a href="/faq/faq_list.php"> FAQ</a></h2>	
			<h2><a href="/news/news_list.php"> NEWS</a></h2>	
			</div>
			
			<!-- table start-->
			<div class="table-box">
				<table class="table">
					<caption>공지사항 - 번호, 제목, 첨부, 작성일, 조회수</caption>
					<colgroup>
						<col width="5%">
						<col width="*">
						<col width="7%">
						<col width="10%">
						<col width="5%">
					</colgroup>
					
					<thead>
						<tr>
							<th scope="col">번호</th>
							<th scope="col">제목</th>
							<th scope="col">작성자</th>
							<th scope="col">작성일</th>
							<th scope="col">조회수</th>
						</tr>
					</thead>
					
					<tbody>
					<?for($k=0;$k<$count;$k++){ //압축되어있는 놈을 한줄씩한줄씩 뺴서 로우에 담는다
						$row = mysqli_fetch_array($result);
					?>	
						<tr>
						<td><?=$row["no"]?></td>
						<td class="txt"><a href="javascript:goView('<?=$row["no"]?>')"><?=$row["title"]?></a></td>
						<td><?=$row["name"]?></td>
						<td><?=$row["format_date"]?></td>
						<td><?=$row["hit"]?></td>
						</tr>
					<?}?>
					</tbody>
				</table>
			</div>
			
			<div class="page-number">
				<a href="#" class="icon"><i class="fas fa-arrow-circle-left fa-lg"></i></a>
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









