<?
	include "common/common_header.php";
	include "common/dbconnect.php";

	$query ="select no, title, attach from h_news order by no desc ";
	$result = mysqli_query($connect,$query);
										
	$count = mysqli_num_rows($result); 
?>
		
		<!--  header end -->

<script>
	function goView(no){
		news.t_no.value=no;
		news.method="post";
		news.action="news_view.php";
		news.submit();
	}
	function goPage(pageNumber){		
		pageForm.t_page.value = pageNumber;
		pageForm.method ="post";
		pageForm.action ="news_list.php";
		pageForm.submit();
	}
</script>

<form name="news">
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
			<h2 class="color"><a href="news_list.php"><i class="fas fa-check"></i> NEWS</a></h2>	
			</div>
			
			<!-- sub-news start-->
			<div class="news-box">

			<?for($k=0;$k<$count;$k++){ //압축되어있는 놈을 한줄씩한줄씩 뺴서 로우에 담는다
						$row = mysqli_fetch_array($result);
			?>	
				<ul class="news">
					<li>
						<a href="javascript:goView('<?=$row["no"]?>')">
							<span class="img"><img src="/file_room/news/<?=$row["attach"]?>" alt="뉴스1"></span>
							<p><?=$row["title"]?></p>
							
							<span class="size-up"></span>
						</a>
					</li>	
				</ul>
			<?}?>	
				
				<ul class="news">
					<li>
						<a href="sub-news-1.html">
							<span class="img"><img src="/images/news4.jpg" alt="뉴스1"></span>
							<p>‘질투의 화신’ 센스만점 OST, 스페셜 앨범 10일 출시</p>
							
							<span class="size-up"></span>
						</a>
					</li>
				</ul>
				
				<ul class="news">
					<li>
						<a href="sub-news-1.html">
							<span class="img"><img src="/images/news5.jpg" alt="뉴스1" ></span>
							<p>싱어송라이터 마이큐(MY Q),<br>
							싱글 앨범 ‘e v e r Y d a y’ 발표</p>
							
							<span class="size-up"></span>
						</a>
					</li>
				</ul>
				
				<ul class="news">
					<li>
						<a href="sub-news-1.html">
							<span class="img"><img src="/images/news6.jpg" alt="뉴스1" ></span>
							<p>‘질투의 화신’ 미공개 OST, 오늘(3일) 정오 기습 발매</p>
							
							<span class="size-up"></span>
						</a>
					</li>
				</ul>
				
				<ul class="news">
					<li>
						<a href="sub-news-1.html">
							<span class="img"><img src="/images/news7.jpg" alt="뉴스1" ></span>
							<p>‘피리부는 사나이’ 두 번째 OST 공개…<br>
							‘두 가지 버전’으로 색다른 재미</p>
							
							<span class="size-up"></span>
						</a>
					</li>
				</ul>
				
				<ul class="news">
					<li>
						<a href="sub-news-1.html">
							<span class="img"><img src="/images/news2.jpg" alt="뉴스1"></span>
							<p>언노운드레스, 감성캐롤 'On Christmas Day’<br>
							16일 정오 발매…'마음을 위로하는 음악’</p>
							
							<span class="size-up"></span>
						</a>
					</li>
				</ul>
				
				<ul class="news">
					<li>
						<a href="sub-news-1.html">
							<span class="img"><img src="/images/news4.jpg" alt="뉴스1"></span>
							<p>‘질투의 화신’ 센스만점 OST, 스페셜 앨범 10일 출시</p>
							
							<span class="size-up"></span>
						</a>
					</li>
				</ul>
				
				<ul class="news">
					<li>
						<a href="sub-news-1.html">
							<span class="img"><img src="/images/news3.jpg" alt="뉴스1"span>
							<p>싱어송라이터 ‘마이큐’, 29일 싱글앨범<br>‘I must be a fool’ 발표</p>
							
							<span class="size-up"></span>
						</a>
					</li>
				</ul>
				
				<ul class="news">
					<li>
						<a href="sub-news-1.html">
							<span class="img"><img src="/images/news5.jpg" alt="뉴스1" ></span>
							<p>싱어송라이터 마이큐(MY Q),<br>
							싱글 앨범 ‘e v e r Y d a y’ 발표</p>
							
							<span class="size-up"></span>
						</a>
					</li>
				</ul>
				
				<ul class="news">
					<li>
						<a href="sub-news-1.html">
							<span class="img"><img src="/images/news6.jpg" alt="뉴스1" ></span>
							<p>‘질투의 화신’ 미공개 OST, 오늘(3일) 정오 기습 발매</p>
							
							<span class="size-up"></span>
						</a>
					</li>
				</ul>
				
				<ul class="news">
					<li>
						<a href="sub-news-1.html">
							<span class="img"><img src="/images/news7.jpg" alt="뉴스1" ></span>
							<p>‘피리부는 사나이’ 두 번째 OST 공개…<br>
							‘두 가지 버전’으로 색다른 재미</p>
							
							<span class="size-up"></span>
						</a>
					</li>
				</ul>
				
				
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
				<a href="news_write.php" class="btn-write1">글쓰기</a>
			<?}?>
		
		</div>
		
		
		
		<!--  footer start  -->
	<?
		include "common/common_footer.php";
	?>
		</div>
	
	
	
	</body>
</html>









