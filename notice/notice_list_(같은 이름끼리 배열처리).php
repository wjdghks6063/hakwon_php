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
	function goUpdateHit(index){ //goUpdateHit('<?=$k?>') 로 몇번째 자리의 번호를 받아온다.
		var ff = notiArr.t_hit;
		var gubun = Object.prototype.toString.call(ff); //명령어에 배열 반복 돌리는것(value)를 넣어준다.
		//배열일 경우 ex)같은 이름을 가진게 2개 이상 있을 떄 [object RadioNodeList] // 배열이 아닐 때 ex)같은 이름이 1개만 있을 때 [object HTMLInputElement]
		if(gubun == "[object RadioNodeList]"){ //gubun에 [object RadioNodeList] = 같은 이름을 가진 배열이 2개 이상 돌 때
//			alert("배열이다");
			var hitValue = notiArr.t_hit[index].value; //배열인 경우 번호값을 넣어줘서 몇번쨰 자리의 값인지 찾아준다.
			var no = notiArr.t_no[index].value;
		//	alert(no);
		//	alert(hitValue);
			hitForm.t_no.value=no;
			hitForm.t_hit.value=hitValue;

		} else{ //하나만 있을 때
			var hitValue = notiArr.t_hit.value; //번호가 1개라 배열이 없는 경우는 [index]로 자리를 찾지 않는다.
			var no = notiArr.t_no.value;
		
			hitForm.t_no.value=no; //form hitForm으로 이름에 value를 넣어서 넘긴다.
			hitForm.t_hit.value=hitValue;
		}
		hitForm.method="post";
		hitForm.action="db_notice_hitupdate.php";
		hitForm.submit();
	}
</script>
<form name="hitForm">
	<input type="hidden" name="t_no">
	<input type="hidden" name="t_hit">
</form>
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
			<h2><a href="/shop/shop_list.php"> SHOP</a></h2>	
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
				<form name ="notiArr">	
					<tbody>
					<?for($k=0;$k<$count;$k++){ //압축되어있는 놈을 한줄씩한줄씩 뺴서 로우에 담는다
						$row = mysqli_fetch_array($result);
					?>	
						<tr>
						<td><?=$row["no"]?></td>
						<td class="txt"><a href="javascript:goView('<?=$row["no"]?>')"><?=$row["title"]?></a>
							<input type="hidden" name="t_no" value="<?=$row["no"]?>">
							<input type="text" name="t_hit" value="<?=$row["hit"]?>" size="3">
							<button type="button" onclick="goUpdateHit('<?=$k?>')">Hit update</button> <!--k는 for($k=0;$k<$count;$k++) 의 카운트 숫자 / 몇번째 자리인가 -->
					
					
						</td>
						<td><?=$row["name"]?></td>
						<td><?=$row["format_date"]?></td>
						<td><?=$row["hit"]?></td>
						</tr>
					<?}?>
					</tbody>
				</form>	
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
				<a href="notice_write_summernote.php" class="btn-write">글쓰기</a>
			
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









