<?
	include "common/common_header.php";
	include "common/dbconnect.php";

	$no 	= $_POST["t_no"];
	$t_page = $_POST["t_page"];
	
	$query ="select a.no, a.title, a.content, a.attach, b.name, a.reg_date, a.hit from h_news a, h_member b ".
			"where a.reg_id = b.id and a.no='$no' ";
	$result = mysqli_query($connect,$query);

	$row = mysqli_fetch_array($result);

?>		

<script>
	function goUpdate(){
		news.method="post";
		news.action="news_update.php";
		news.submit();
	}
	function goDelete(){
		if(confirm("정말 삭제하시겠습니까?")){
		news.method="post";
		news.action="db_news_delete.php";
		news.submit();
		}
	}
	function goBack(){
		goBackPage.method ="post";
		goBackPage.action ="news_list.php";
		goBackPage.submit();
	}

	
	function count(type)  {
			// 결과를 표시할 element
			const resultElement = mem.point.value;
			
			// 현재 화면에 표시된 값
			let number = Number(resultElement);
			
			// 더하기
			if(type === '100') {
				number = parseInt(resultElement) + 100;
			}else if(type === '1000')  {
				number = parseInt(resultElement) + 1000;
			}else if(type === '10000')  {
				number = parseInt(resultElement) + 10000;
			}else if(type === '50000')  {
				number = parseInt(resultElement) + 50000;
			}
			
			mem.point.value = number;
		}
</script>
		<!--  header end -->
<form name="news">
	<input type="hidden" name="t_no" value="<?=$no?>">
	<input type="hidden" name="t_page" value="<?=$t_page?>">
	<input type="hidden" name="t_attach" value="<?=$row['attach']?>">
</form>

<form name ="goBackPage">
	<input type="hidden" name="t_page" value="<?=$t_page?>">
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
			<div class="contnews">
				<h3><?=$row["title"]?><br>
					<span> <?=$row["name"]?> | <?=$row["reg_date"]?> | 조회수 <?=$row["hit"]?> </span></h3>
					<span class="img"><img src="/file_room/news/<?=$row["attach"]?>" alt="뉴스1" class="img" ">	
									<div class="prod-buy-quantity">
									<div class="prod-buy__quantity">
										<div class="prod-quantity__form" name="count">
											<input type="text" value="1" class="prod-quantity__input" id="point" maxlength="6" autocomplete="off" 
												oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1')"> <!-- 숫자 외 값 들어오기 막기 -->
											<div style="display:table-cell;vertical-align:top;">
												<button class="prod-quantity__plus" type="button" onclick='count("plus")' value='+ 1'>수량더하기</button>
												<button class="prod-quantity__minus" type="button" onclick='count("minus")'>수량빼기</button>
												<div id='result'>1</div>
												
											</div>
										</div>
									</div>
									
									</div>
					</span>	

				<p class="txt">
				<?=$row["content"]?>
				</p>
			</div>

			
			<div class="list1">
			<?if($session_level == 'top'){?>	
				<a href="javascript:goUpdate()">수정</a>&nbsp;&nbsp; <!--이전화면-->
				<a href="javascript:goDelete()">삭제</a>&nbsp;&nbsp; <!--이전화면-->
			<?}?>
				<a href="javascript:goBack()">목록</a>&nbsp;&nbsp; <!--이전화면-->
			</div>
		</div>
		
		</div>
		
		
		
		<!--  footer start  -->
		<?
			include "common/common_footer.php";
		?>
		</div>
	
	
	
	</body>
</html>









