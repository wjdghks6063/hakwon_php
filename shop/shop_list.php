<?
	include "common/common_header.php";
	include "common/dbconnect.php";

/**************************page setting********************************/
	/*pagingSetting.php와 같은 변수명으로 사용해야 작동 하기 때문에 양쪽의 변수명을 맞춰준다. */

	$countTotal =" select * from h_shop "; /*페이지를 정할 db 명 */ 
	$countOnePage = "9"; // 한 페이지당 보여줄 목록 수 (?)행 보여주겠다.
	$perblock = 5;		 // 한 페이지당 보여줄 페이지 번호 수 < 1 2 3 4 5 >

	include "common/pagingSetting.php"; //변수명들을 넣어줘야 작동되기 때문에 변수명 아래쪽에 include 해준다.
	$t_page =$_POST['t_page']; // view에 갔다가 목록이나 뒤로 가기를 했을 때 현재 페이징 넘버로 가질 수 있게 해준다.
/**********************************************************************/

	$query ="select no, title, attach from h_shop order by no desc ";
	$result = mysqli_query($connect,$query);
										
	$count = mysqli_num_rows($result); 
?>
		
		<!--  header end -->

<script>
	function goView(no){
		shop.t_no.value=no;
		shop.method="post";
		shop.action="shop_view.php";
		shop.submit();
	}
	function goPage(pageNumber){		
		pageForm.t_page.value = pageNumber;
		pageForm.method ="post";
		pageForm.action ="shop_list.php";
		pageForm.submit();
	}
</script>

<form name="shop">
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
			<h2><a href="/qna/qna_list.php"> QnA</a></h2>
			<h2><a href="/faq/faq_list.php"> FAQ</a></h2>	
			<h2 class="color"><a href="shop_list.php"><i class="fas fa-check"></i> SHOP</a></h2>	
			</div>
			
			<!-- sub-news start-->
			<div class="news-box">

			<?for($k=0;$k<$count;$k++){ //압축되어있는 놈을 한줄씩한줄씩 뺴서 로우에 담는다
						$row = mysqli_fetch_array($result);
			?>	
				<ul class="news">
					<li>
						<a href="javascript:goView('<?=$row["no"]?>')">
							<span class="img"><img src="/file_room/shop/<?=$row["attach"]?>" alt="shop1"></span>
							<p><?=$row["title"]?></p>
		
							<span class="size-up"></span>
						</a>
					</li>	
				</ul>
			<?}?>	
				
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
				<a href="shop_write.php" class="btn-write">글쓰기</a>
			
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









