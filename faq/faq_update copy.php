<?
	include "common/common_header.php";
	include "common/dbconnect.php";
	
	$query ="select a.no,a.title,a.content,a.reg_id,a.reg_date from h_faq a, h_member b ".
			"where a.reg_id = b.id order by no desc";
	$result = mysqli_query($connect,$query);
								
	$count = mysqli_num_rows($result);
?>
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
				<?for($k=0;$k<$count;$k++){ //압축되어있는 놈을 한줄씩한줄씩 뺴서 로우에 담는다
							$row = mysqli_fetch_array($result);
				?>	
				<input type="hidden" name="t_no" value="<?=$row['no']?>"> 
				<!--button을 누를경우 지정한 이벤트 외 추가로 페이지가 reload되는 경우 버튼 type의 기본값이 submit이기 때문에
					해결방법으로는 버튼에 type="button"을 부여하던가 form 태그를 div로 대체하면 된다.-->		
					<button class="accordion" type="button"> ▶ <input type="text" name="t_title" value="<?=$row["title"]?>" class="title" placeholder="제목을 입력해주세요"
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
				<?}?>
			</form>

			<form name="faq_update">
				<input type="hidden" name="t_no">
				<input type="hidden" name="t_title">
				<input type="hidden" name="t_content">
			</form>
			
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
			$(document).ready(function() {
				$(".accordion").click(function() {
					$(".text").not($(this).next().slideToggle(250)).slideUp();
					$(this).siblings().removeClass("active");	
					$(this).toggleClass("active");	
				});
			});

			function goUpdate(indx,no){
				if(Object.prototype.toString.call(faq.t_title) == "[object RadioNodeList]"){
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
