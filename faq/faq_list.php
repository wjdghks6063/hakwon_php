<?
	include "common/common_header.php";
	include "common/dbconnect.php";
	
	$query ="select a.title,a.content from h_faq a, h_member b ".
			"where a.reg_id = b.id order by no desc";
	$result = mysqli_query($connect,$query);
								
	$count = mysqli_num_rows($result);
?>
		<!--  header end -->
		<script>
			function goView(no){
				faq.t_no.value=no;
				faq.method="post";
				faq.action="notice_view.php";
				notice.submit();
			}
		</script>
		<form name="notice">
			<input type="hidden" name="t_no">
		</form>
		
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
				<?for($k=0;$k<$count;$k++){ //압축되어있는 놈을 한줄씩한줄씩 뺴서 로우에 담는다
							$row = mysqli_fetch_array($result);
				?>	
					<button class="accordion"> ▶ <?=$row["title"]?></button>
					<div class="text">
						<p><?=$row["content"]?></p>
					</div>
				<?}?>
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
				<a href="faq_update.php" class="btn-write">수정</a>
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
