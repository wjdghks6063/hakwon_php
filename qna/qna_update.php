<?	
	include "common/common_header.php";
    include "common/dbconnect.php";

    $no = $_POST["t_no"];
    $query="select a.q_title, a.q_content, b.name, a.q_reg_id, a.q_reg_date, a.secret from h_qna a, h_member b where a.q_reg_id = b.id and a.no=$no" ;
    $result = mysqli_query($connect,$query);
	$row = mysqli_fetch_array($result);
?>
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
								<!--<?=htmlspecialchars($row["q_title"])?> 는 ""가 들어가면 문자가 짤리는걸 막아준다. 예) $row["q_title"] 의 문장을 풀면 "안녕하세요."라고 했을 때
								""안의 문자만 표시해준다. 문장안에 기호로 " "안녕"하세요 "라고 하면 " "에서 문장이 끝나기 떄문에 나머지가 출력되지 않기 때문에 htmlspecialchars로 처리해준다.
								htmlspecialchars는 input type="text"에서만 써주면 된다. textarea는 자동으로 인식하기 때문에 써주지 않아도 된다.-->
								<td><input type="text" name="q_title" value="<?=htmlspecialchars($row["q_title"])?>" class="title" placeholder="제목을 입력해주세요"></td>
							</tr>
							
							<tr>
								<th><label for="cont">내용</label></th>
								<td><textarea type="cont" name="q_content" value="<?=$row["q_content"]?>" class="cont"><?=$row["q_content"]?></textarea>
							</tr>
							<tr>
								<th>공개 여부</th>
								<td class="checkbox">
									<i class="fas fa-lock-open"></i> &nbsp
									<div class="toggle">
									<input type="checkbox" name="secret" id="toggle1" value="y" <?if($row["secret"] == 'y') echo "checked";?> >
									<label for="toggle1"></label>
									</div>
									&nbsp <i class="fas fa-lock"></i>
								</td>
							</tr>			
							<tr>
								<td colspan="2">
								<input type="button" onClick="goSave()" value="수정" class="btn" >
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
			function goSave() {
                if(checkValue(qna.q_title,"제목을 입력해 주세요!")) return;
                if(checkValue(qna.q_content,"내용을 입력해 주세요!")) return;
                qna.method="post";
                qna.action="db_qna_update.php";
                qna.submit();
            }
		</script>
	
	</body>
</html>









