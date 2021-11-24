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
		notice.method="post";
		notice.action="notice_update.php";
		notice.submit();
	}
	function goDelete(){
		if(confirm("정말 삭제하시겠습니까?")){
		notice.method="post";
		notice.action="db_notice_delete.php";
		notice.submit();
		}
	}
	function goBack(){
		goBackPage.method ="post";
		goBackPage.action ="news_list.php";
		goBackPage.submit();
	}
</script>
		<!--  header end -->
<form name="notice">
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
					<span class="img"><img src="/file_room/news/<?=$row["attach"]?>" alt="뉴스1" style="float:left; width:500px; height:500px; border:1px solid #EAEAEA; "></span>
				<p class="txt">
				<?=$row["content"]?>
				</p>
			</div>

			
			<div class="list">
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









