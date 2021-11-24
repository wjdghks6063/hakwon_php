<?
	include "common/common_header.php";
	include "common/dbconnect.php";

	$t_page = $_POST["t_page"];

/**************************page setting********************************/
/*pagingSetting.php와 같은 변수명으로 사용해야 작동 하기 때문에 양쪽의 변수명을 맞춰준다. */

	$countTotal =" select * from h_faq "; /*페이지를 정할 db 명 */ 
	$countOnePage = "5"; // 한 페이지당 보여줄 목록 수 (?)행 보여주겠다.
	$perblock = 5;		 // 한 페이지당 보여줄 페이지 번호 수 < 1 2 3 4 5 >

	include "common/pagingSetting.php"; //변수명들을 넣어줘야 작동되기 때문에 변수명 아래쪽에 include 해준다.
	$t_page =$_POST['t_page']; // view에 갔다가 목록이나 뒤로 가기를 했을 때 현재 페이징 넘버로 가질 수 있게 해준다.
/**********************************************************************/		
	
	$query ="select a.no,a.title,a.content,a.reg_id,a.reg_date from h_faq a, h_member b ".
			"where a.reg_id = b.id order by orderno asc ".
			"limit $start, $end ";
	$result = mysqli_query($connect,$query);
								
	$count = mysqli_num_rows($result);
?>
	<link rel="stylesheet" href="//code.jquery.com/ui/1.13.0/themes/base/jquery-ui.css"> <!-- 목록 이동 jquery 3개 필요 -->
	<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
	<script src="https://code.jquery.com/ui/1.13.0/jquery-ui.js"></script>
		<!--  header end -->
		
		
		<!-- sub page start -->
		
		
		<div class="notice">
			<div class="sub-notice">
			<h2><a href="/notice/notice_list.php">NOTICE</a></h2>	
			<h2><a href="/qna/qna_list.php"> QnA</a></h2>
			<h2 class="color"><a href="faq_list.php"><i class="fas fa-check"></i> FAQ</a></h2>	
			<h2><a href="/news/news_list.php"> NEWS</a></h2>	
			</div>	
			<!-- fqa start-->
			<div class="faq-box">
				

			<form name ="faq">		
				<ul id="sortable"> <!-- ul 리스트 id -->
				<?for($k=0;$k<$count;$k++){ //압축되어있는 놈을 한줄씩한줄씩 뺴서 로우에 담는다
							$row = mysqli_fetch_array($result);
				?>	
				<input type="hidden" name="t_no" value="<?=$row['no']?>"> 
				<!--button을 누를경우 지정한 이벤트 외 추가로 페이지가 reload되는 경우 버튼 type의 기본값이 submit이기 때문에
					해결방법으로는 버튼에 type="button"을 부여하던가 form 태그를 div로 대체하면 된다.-->		
					<li id="drag-<?=$row['no']?>">
						<button class="accordion" type="button"> <i class="fas fa-arrows-alt-v"></i> ▶ <input type="text" name="t_title" value="<?=$row["title"]?>" class="title" placeholder="제목을 입력해주세요"
						style ="width: 80%; height: 30px; margin: 0px; border: none; font-family: Nanum Barun Gothic; font-size: 15px;"></button>
						<div class="text2">
							<span><?=$row["reg_id"]?>/<?=$row["reg_date"]?></span>
							<p><textarea name="t_content" value="<?=$row["content"]?>" style="margin: 0px; height: 100px; width: 1045px; resize:none;"><?=$row["content"]?></textarea></p>
							<tr>
									<td colspan="2">
									<input type="button" onClick="goUpdate('<?=$k?>','<?=$row["no"]?>')" value="수정" class="btn_right" >
									<input type="button" onclick="goDelete('<?=$row["no"]?>')" value="삭제" class="btn_right">
									</td>
							</tr>
						</div>
					</li>				
				<?}?>
				</ul>
			</form>

			<form name="faq_update">
				<input type="hidden" name="t_no">
				<input type="hidden" name="t_title">
				<input type="hidden" name="t_content">
			</form>
			
		<div class="page-number">
		
			<?if($session_level == 'top'){?>	
				<a href="faq_list.php" class="btn-write">목록</a>
				<a href="faq_write.php" class="btn-write1">글쓰기</a>
			<?}?>
			</div>
			
		</div>
		<!-- notice css end -->
		
		
		<!--  footer start  -->
	<?
		include "common/common_footer.php";
	?>
		</div>
		

		<script>
			$(document).ready(function() { //버튼 클릭시 아래로 창 내려오게 해줌
				$(".accordion").click(function() {
					$(".text").not($(this).next().slideToggle(250)).slideUp();
					$(this).siblings().removeClass("active");	
					$(this).toggleClass("active");	
				});

				$("#sortable").sortable({ //드래그 하여 목록 이동
					update: function(event, ui) { //ui를 업데이트 한다.
						var data = $(this).sortable('serialize'); //this는 #sortable , ui = sortable('serialize') 로 목록을 직렬화 한다.

/*		이 방법은 실시간으로 새로고침을 하지 않는다.		

						$.ajax({
							type: "post", //어떤 type
							url: "db_faq_order.php", //보내줄 php
							data: data
							
		이 방법은 실시간으로 새로 고침을 하기 때문에 주소창이 깜빡이지만 바꾼 현재위치의 번호값을 인식하기 때문에 정상적으로 작동한다.*/ 
						$.ajax({
							type: "post", //어떤 type
							url: "db_faq_order.php", //보내줄 php
							data: data,             
							success: function() {
								location.reload();
							}
						});
						
					}
				});
			});

			function goUpdate(indx,no){ //indx 는 배열 숫자 몇번째 위치인지 확인
				if(Object.prototype.toString.call(faq.t_title) == "[object RadioNodeList]"){ //반복문 돌림
					var title = faq.t_title[indx].value;
					var content = faq.t_content[indx].value;
					faq_update.t_no.value = no;
					faq_update.t_title.value = title;
					faq_update.t_content.value = content;
				//	faq.result_title.value = title;
				} else {
					faq_update.t_no.value = no;
					faq_update.t_title.value = faq.t_title.value;
					faq_update.t_content.value = faq.t_content.value;;
				}

				faq_update.method="post";
				faq_update.action="db_faq_update.php";
				faq_update.submit();
			}

			function goDelete(no){
				if(confirm("정말 삭제하시겠습니까?")){
				faq.t_no.value=no;
				faq.method="post";
				faq.action="db_faq_delete.php";
				faq.submit();
				}
			}
		</script>
	
	</body>
</html>
