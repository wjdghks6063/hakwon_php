<?	
	include "common/common_header.php";
    include "common/dbconnect.php";

    $no = $_POST["t_no"];
    $query="select a.q_title, a.q_content, b.name, a.q_reg_id, a.q_reg_date, a.secret from h_qna a, h_member b where a.q_reg_id = b.id and a.no=$no" ;
    $result = mysqli_query($connect,$query);
	$row = mysqli_fetch_array($result);
	if($session_level != 'top') {
?>
		<script>
			alert("관리자 화면 입니다.");
			location.href="/";
		</script>
<?	} ?>
		<!--  header end -->
		
		
		<!-- sub page start -->
        <style>

            </style>
		<div class="notice">
			<div class="sub-notice">
			<h2><span><i class="fas fa-edit"></i>Qna-write</span></h2>	
			</div>
			
			<div class="notice-write">
			
			<form name="qna" enctype="multipart/form-data">
                <input type="hidden" name="t_no" value="<?=$no?>"
				
					<fieldset>
						<legend>공지사항 글쓰기</legend>
						
						<table class="table">
							<caption>공지사항 글쓰기</caption>
							<colgroup>
								<col width="20%">
								<col width="*">
							</colgroup>
							
							<tr>
								<th><label for="title">제목</label></th>
								<td><input type="text" name="q_title" value="<?=$row["q_title"]?>" class="title" placeholder="제목을 입력해주세요" readonly></td>
							</tr>
							
							<tr>
								<th><label for="cont">내용</label></th>
								<td><textarea type="cont" name="q_content" value="<?=$row["q_content"]?>" class="cont" style="resize:none" readonly><?=$row["q_content"]?></textarea>
							</tr>	
							<tr>
								<th><label for="cont">답변 내용</label></th>
								<td><textarea type="cont" name="a_content" class="cont" style="resize:none"></textarea>
							</tr>		
							<tr>
								<td colspan="2">
								<input type="button" onClick="goAnswerSave()" value="저장" class="btn" >
								<input type="button" onclick="location.href='qna_list.php'" value="목록" class="btn">
								</td>
							</tr>

							</table>
					</fieldset>
			</form>
			</div>
			

		
		<!--  footer start  -->
	<?include "common/common_footer.php"?>
		</div>
	
	
		<script>
			function goAnswerSave() {
                if(checkValue(qna.a_content,"답변 내용을 입력해 주세요!")) return;
                qna.method="post";
                qna.action="db_qna_answerUpdate.php";
                qna.submit();
            }
		</script>
	
	</body>
</html>









