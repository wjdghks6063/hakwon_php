<?
	include "common/common_header.php";
	include "common/dbconnect.php";
	
	$no 	= $_POST["t_no"];
	$t_page = $_POST["t_page"];

	$queryHit =" update h_qna ".
				"set hit = hit + 1 ".
				" where no = '$no' ";
	mysqli_query($connect, $queryHit);
	
	$query="select a.no, a.q_title, a.q_content, a.q_reg_id, b.name as b_name, a.q_reg_date, a.a_content, a.a_reg_id, c.name as c_name, ".
			"a.a_reg_date from h_qna a left join h_member b on a.q_reg_id=b.id left join h_member c on a.a_reg_id =c.id where a.no = $no" ;
	$result = mysqli_query($connect,$query);
	$row = mysqli_fetch_array($result);
?>
		
		<!--  header end -->
		
		
		<!-- sub page start -->
		<div class="notice">
			<div class="sub-notice">
			<h2><a href="/notice/notice_list.php">NOTICE</a></h2>	
			<h2 class="color"><a href="qna_list.php"> <i class="fas fa-check"></i> QnA</a></h2>
			<h2><a href="/faq/faq_list.php"> FAQ</a></h2>	
			<h2><a href="/news/news_list.php"> NEWS</a></h2>	
			</div>
<style>
	.cont-box .img img{
		width:500px;
	}
	.viewCont{
		white-space:pre-wrap;
		overflow:auto;
		width:800px;
	}
</style>			
		<!-- cont start-->
<form name="qna">
	<input type="hidden" name="t_no" value="<?=$no?>">
</form>

<form name ="goBackPage">
	<input type="hidden" name="t_page" value="<?=$t_page?>">
</form>

		<div class="cont-box">
			<h3><span class="waiting">질문</span> <?=$row["q_title"]?><br>
				<span><?=$row["q_reg_date"]?>/<?=$row["b_name"]?></span></h3>
			<div>
			<div class="viewCont"> <?=$row["q_content"]?></div>
			</div>
		<?if($row["a_content"]){ ?>
			<br><br><br><h3>==============================================================</h3><br>
			<h3><span class="complet">답변</span> re: <?=$row["q_title"]?><br>
				<span><?=$row["a_reg_date"]?>/<?=$row["c_name"]?></span></h3>
			<div>
			<div class="viewCont"> <?=$row["a_content"]?></div>
			</div>
		<?}?>
<!-- 		
			<h4>이엘와이드 음악콘텐츠본부에서 함께 일할 사람을 모집합니다<br>
				이엘와이드와 함께 즐겁게 음악사업을 펼쳐나갈 여러분의 적극적인 지원을 기다립니다.</h4>
			
			<div>
				<dl>모집공고</dl>
					<dt>
					1.모집기간: 2017년 5월 15일 – 6월 9일(금)<br>
					2.모집분야: 홍보팀 신입 0명 경력 0명<br>
					</dt>
					
					<dd>
					모집방법: contact@elwide.com으로 아래 서류를 보내주세요.<br>
					* 이력서 (희망급여 기재)<br>
					* 자기소개서 <br>
					* 제작 or 홍보 기획서<br>  
					√ 이엘와이드 소속 아티스트와 관련하여 자유양식의<br> 기획서/에세이를(택1) 함께 제출해주세요.<br>
					(ex, 음반기획, 공연기획, 음반리뷰, 공연리뷰, 보도자료 등)

					</dd>
			</div>
			
			<div>
				<dl>응시자격</dl>
					<dt>
					1.신입: 만23세 이상(1995년생 이전 출생자) 남, 여 /(남자는 군필자 혹은 면제자)<br>
					2.경력 : 관련분야 최소  2년 이상 유경험자<br>
					</dt>
					
			</div>
			
			<div>
				<dl>담당업무</dl>
					<dt>
					1.SNS 운영, 제안서, 보도자료 작성 등 홍보관련 전반적 업무<br>
					2.앨범기획, 공연기획 등 콘텐츠 기획/진행 업무 보조<br>
					</dt>
					
			</div>
			
			<div>
				<dl>우대사항</dl>
					<dt>
					1.음악산업에 대한 경험 혹은 관련분야에 대한 이해를 갖고 있으신 분<br>
					2.서류작성, 제안서작성, SNS운영 등 관련 경험이 있으신 분<br>
					</dt>
				
			</div> -->
		</div>
			
		<!-- sub button start-->
		
		<div class="list">
			<a href="sub-contact.html">도움</a>&nbsp;
			
		<?if($session_id == $row["q_reg_id"] && !$row["a_content"]) {?>
			<a href="javascript:goUpdate()">수정</a>&nbsp; <!--답변 달리기 전 수정-->
		<?}?>
		<?if($session_id == $row["q_reg_id"] && $row["a_content"]){?>
			<a onClick="alert('답변이 달린 게시글은 수정할 수 없습니다.')" style="cursor:pointer">수정</a>&nbsp; <!--답변 달린 후 수정-->
		<?}?>
		<?if($session_level == 'top' || $session_id == $row["q_reg_id"]){?>
			<a href="javascript:goDelete()">삭제</a>&nbsp; <!--삭제-->
		<?}?>
		<?if($session_level == 'top' && !$row["a_content"]) {?>
			<a href="javascript:goAnswer()">답변</a>&nbsp; <!-- 질문 답변 -->
		<?}?>
		<?if($session_level == 'top' && $row["a_content"]){?>	
			<a href="javascript:goAnswerUpdate()">답변 수정</a>&nbsp; <!-- 질문 답변 수정 -->
			<a href="javascript:goAnswerDelete()">답변 삭제</a>&nbsp; <!-- 질문 답변 삭제 -->
		<?}?>
			<a href="javascript:goBack()">목록</a>&nbsp;&nbsp; <!--이전화면--> <!--이전화면-->
		</div>
		
		
		</div>
		
		<script>
			function goUpdate(){
				qna.method="post";
				qna.action="qna_update.php";
				qna.submit();
			}
			function goDelete(){
				if(confirm("정말 삭제하시겠습니까?")){
				qna.method="post";
				qna.action="db_qna_delete.php";
				qna.submit();
				}
			}
			function goAnswer(){
				qna.method="post";
				qna.action="qna_answersave.php";
				qna.submit();
			}
			function goAnswerUpdate(){
				qna.method="post";
				qna.action="qna_answerupdate.php";
				qna.submit();
			}
			function goAnswerDelete(){
				if(confirm("정말 삭제하시겠습니까?")){
				qna.method="post";
				qna.action="db_qna_answerdelete.php";
				qna.submit();
				}
			}
			function goBack(){
				goBackPage.method ="post";
				goBackPage.action ="qna_list.php";
				goBackPage.submit();
			}
		</script>
		
		<!--  footer start  -->
		<?include "common/common_footer.php" ?>
		</div>
	
	
	
	</body>
	
</html>









