<?php
	include "common/common_header.php";
?>
	
		
		<!--  header end -->
		
		
		<!-- sub page start -->
		<div class="notice"> <!--이름 수정 금지-->
			<div class="sub-notice">
			<h2><span><i class="fas fa-edit"></i> FAQ-write</span></h2>	
			</div>
			
			<div class="qna-write">
			
			<form name="faq" enctype="multipart/form-data">
					<h2 class="readonly">제목, 내용을 작성합니다</h2>
				
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
								<td><input type="text" name="t_title" id="title" class="title" placeholder="제목을 입력해주세요"></td>
							</tr>
							
							<tr>
								<th><label for="cont">내용</label></th>
								<td><textarea type="cont" name="t_content" id="cont" class="cont" placeholder="내용을 입력해주세요"></textarea>
							</tr>					
							<tr>
								<td colspan="2">
								<input type="button" onclick="goSave()" value="전송" class="btn" >
								<input type="button" onclick="javascript:history.back();" value="목록" class="btn">
								</td>
							</tr>

							</table>
					</fieldset>
				</form>
			</div>
			

		
		<!--  footer start  -->
		<?	include "common/common_footer.php";	?>	
		</div>
	
	
		<script>
			function goSave() {
				if(checkValue(faq.t_title,"제목을 입력해주세요.")) return;
				if(checkValue(faq.t_content,"내용을 입력해주세요.")) return;
				faq.method="post";
				faq.action="db_faq_save_proceduer.php"
				faq.submit();
			}
		</script>
	
	</body>
</html>









