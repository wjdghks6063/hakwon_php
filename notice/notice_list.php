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

	$query ="select a.no,a.title,a.attach,a.reg_id, date_format(a.reg_date,'%Y-%m-%d') as format_date, a.reg_date, b.name, a.hit  from h_notice a, h_member b ".
			"where a.reg_id = b.id order by no desc ".
			"limit $start, $end ";
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
	function goPage(pageNumber){		
		pageForm.t_page.value = pageNumber;
		pageForm.method ="post";
		pageForm.action ="notice_list.php";
		pageForm.submit();
	}
</script>

<form name="notice">
	<input type="hidden" name="t_no">
	<input type="hidden" name="t_page" value="<?=$t_page?>">
</form>

<form name ="pageForm">
	<input type="hidden" name="t_page">
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









