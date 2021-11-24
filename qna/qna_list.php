<?
	include "common/common_header.php";
	include "common/dbconnect.php";

/**************************page setting********************************/
/*pagingSetting.php와 같은 변수명으로 사용해야 작동 하기 때문에 양쪽의 변수명을 맞춰준다. */

	$countTotal =" select * from h_qna "; /*페이지를 정할 db */ 
	$countOnePage = "10"; // 한 페이지당 보여줄 목록 수 (?)행 보여주겠다.
	$perblock = 5;		 // 한 페이지당 보여줄 페이지 번호 수 < 1 2 3 4 5 >

	include "common/pagingSetting.php"; //변수명들을 넣어줘야 작동되기 때문에 변수명 아래쪽에 include 해준다.
	$t_page =$_POST['t_page']; // view에 갔다가 목록이나 뒤로 가기를 했을 때 현재 페이징 넘버로 가질 수 있게 해준다.
/**********************************************************************/
	
	$query ="select a.no, a.q_title, a.secret, a.a_content, a.q_reg_id, date_format(a.q_reg_date,'%Y-%m-%d') as format_date, ".
			"b.name, a.hit  from h_qna a, h_member b ".
			"where a.q_reg_id = b.id order by no desc ".
			"limit $start, $end ";
	$result = mysqli_query($connect,$query);
										
	$count = mysqli_num_rows($result); 
?>	
		<!--  header end -->
		<script>
			function goView(no){
				qna.t_no.value=no;
				qna.method="post";
				qna.action="qna_view.php";
				qna.submit();
			}

			function goPage(pageNumber){		
				pageForm.t_page.value = pageNumber;
				pageForm.method ="post";
				pageForm.action ="qna_list.php";
				pageForm.submit();
			}
		</script>

<form name="qna">
	<input type="hidden" name="t_no">
	<input type="hidden" name="t_page" value="<?=$t_page?>">
</form>

<form name ="pageForm">
	<input type="hidden" name="t_page">
</form>

		<!-- sub page start -->
		<div class="notice">
			<div class="sub-notice">
			<h2><a href="/notice/notice_list.php">NOTICE</a></h2>	
			<h2 class="color"><a href="qna_list.php"><i class="fas fa-check"></i> QnA</a></h2>
			<h2><a href="/faq/faq_list.php"> FAQ</a></h2>	
			<h2><a href="/news/news_list.php"> NEWS</a></h2>	
			</div>
			
			<!-- table start-->
			<div class="table-box">
				<table class="table">
					<caption>공지사항 - 번호, 제목, 공개여부, 답변상태, 작성자, 작성일, 조회수</caption>
					<colgroup>
						<col width="7%">
						<col width="*"> 
						<col width="7%">
						<col width="12%">
						<col width="12%">
						<col width="12%">
						<col width="5%">
					</colgroup>
					
					<thead>
						<tr>
							<th scope="col">번호</th>
							<th scope="col">제목</th>
							<th scope="col">공개여부</th>
							<th scope="col">답변상태</th>
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
					<?if($row["secret"] == 'n' || $session_level == 'top' || $session_id == $row["q_reg_id"]){ ?>	
						<td class="txt"><a href="javascript:goView('<?=$row["no"]?>')"><?=$row["q_title"]?></a></td>
					<?}else{?>
						<td class="txt"><span style="color:#BDBDBD"><?=$row["q_title"]?></span></td>
					<?}?>		
					<?if($row["secret"] == 'y'){ ?>
						<td><i class="fas fa-lock"></i></td>
					<?}else{?>
						<td><i class="fas fa-lock-open"></i></td>
					<?}?>
					<?if($row["a_content"]){ ?>
						<td><span class="complet">답변완료</span></td>
					<?}else{?>
						<td><span class="waiting">답변대기</span></td>
					<?}?>
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
<!--				<a href="#" class="icon"><i class="fas fa-arrow-circle-left fa-lg"></i></a>
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
			<?if(!$session_id){?>
				<a href= "/member/login.php" onClick="alert('로그인 후 이용가능합니다.')" class="btn-write">글쓰기</a>
			<?}else{?>	
				<a href="qna_write.php" class="btn-write">글쓰기</a>
			<?}?>	
			</div>
		
		</div>
		
		
		
		<!--  footer start  -->
		<div id="footer">
			<div class="footer-text">
				<ul class="sub-logo">
					<li><a href="/" alt="서브로고">EL WIDE</a></li>
				</ul>
				
				<ul class="copy">
					<li>Copyright ⓒ EL WIDE. All Rights Reserved.</li>
				</ul>
			</div>
		</div>
		</div>
	
	
	
	</body>
</html>

