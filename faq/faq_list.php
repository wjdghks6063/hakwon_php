<?
	include "common/common_header.php";
	include "common/dbconnect.php";

	$query ="select a.title,a.content from h_faq a, h_member b ".
			"where a.reg_id = b.id order by orderno asc ";
	$result = mysqli_query($connect,$query);
								
	$count = mysqli_num_rows($result);
?>
		<!--  header end -->
		<script>
			function goUpdate(){
				pageForm.method ="post";
				pageForm.action ="faq_update.php";
				pageForm.submit();
			}

			function goPage(pageNumber){		
				pageForm.t_page.value = pageNumber;
				pageForm.method ="post";
				pageForm.action ="faq_list.php";
				pageForm.submit();
			}
		</script>
<form name ="pageForm">
	<input type="hidden" name="t_page" value="<?=$t_page?>">
</form>
		
		<!-- sub page start -->
		<div class="notice">
			<div class="sub-notice">
			<h2><a href="/notice/notice_list.php">NOTICE</a></h2>	
			<h2><a href="/qna/qna_list.php"> QnA</a></h2>
			<h2 class="color"><a href="faq_list.php"><i class="fas fa-check"></i> FAQ</a></h2>	
			<h2><a href="/shop/shop_list.php"> SHOP</a></h2>	
			</div>
			
			<!-- fqa start-->
			<div class="faq-box">
				<?for($k=0;$k<$count;$k++){ //압축되어있는 놈을 한줄씩한줄씩 뺴서 로우에 담는다
							$row = mysqli_fetch_array($result);
				?>	
					<button class="accordion"> ▶ <?=$row["title"]?></button>
					<div class="text">
						<p><?=$row["content"]?></p>
					</div>
				<?}?>
			</div>	

		<div class="page-number1">
	<!--페이징 시 2페이지의 숫자값이 계속 변경됨 오류 해결 실패 <? include "common/pagingDisplay.php"; ?>	 -->
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
				<a href="javascript:goUpdate()" class="btn-write1">수정</a>
				<a href="faq_write.php" class="btn-write2">글쓰기</a>
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
		</script>
	
	</body>
</html>
