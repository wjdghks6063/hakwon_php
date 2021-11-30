<?

	include "common/dbconnect.php";
	include "common/common_header.php";
	$no = $_POST["t_no"];
	$query ="select a.title, a.content, a.attach, ".
			" b.name, a.reg_id, a.reg_date ".
			" from h_notice a, h_member b ".
			" where a.reg_id = b.id ".
			" and a.no = $no";
	$result = mysqli_query($connect,$query);
	$row    = mysqli_fetch_array($result);

	
	
	
	if($session_level != 'top'){
?>		
		<script>
			alert("관리자 화면 입니다.");
			location.href="/";
		</script>
<?	
	}
?>
		<!--  header end -->
		
		
		<!-- sub page start -->
		<div class="notice">
			<div class="sub-notice">
			<h2><span><i class="fas fa-edit"></i> NOTICE-write</span></h2>	
			</div>
			
			<div class="notice-write">
			
			<form name="notice" enctype="multipart/form-data">
				<input type="hidden" name="t_no" value="<?=$no?>">
					<h2 class="readonly">제목, 첨부파일, 내용을 작성합니다</h2>
				
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
								<td><input type="text" name="t_title" value="<?=htmlspecialchars($row["title"])?>" id="title" class="title" placeholder="제목을 입력해주세요"></td>
							</tr>
							
							<tr>
								<th><label for="cont">내용</label></th>
								<td><textarea type="cont" name="t_content" id="cont" class="cont" placeholder="내용을 입력해주세요"><?=$row["content"]?></textarea>
							</tr>

							<style>	
								/*미리 보기 이미지 */	
								.img img{
									width:200px;
								}
							</style>		

							<tr>
								<th><label for="file">파일 첨부</label></th>
								<td style="text-align:left;padding-left:30px">
									<p class="img"><img src="/file_room/notice/<?=$row["attach"]?>"></img></p>
									<?=$row["attach"]?>&nbsp;&nbsp;&nbsp;
<!--									삭제
									<input type="checkbox" name="t_del_attach" value="<?=$row['attach']?>">
-->									
									<input type="hidden" name="t_ori_attach" value="<?=$row['attach']?>">
									<br>									
									<input type="file" name="t_attach" class="file" id="file">
								</td>
							</tr>
							
							<tr>
								<td colspan="2">
								<input type="button" onclick="goUpdate()" value="수정저장" class="btn" >
								<input type="button" onclick="location.href='notice_list.php'" value="목록" class="btn">
								</td>
							</tr>

							</table>
					</fieldset>
				</form>
			</div>
			

		
		<!--  footer start  -->
<?
	include "common/common_footer.php";
?>
		</div>
	
	
		<script>
			function goUpdate(){
				if(checkValue(notice.t_title,"제목 입력!")) return;
				if(checkValue(notice.t_content,"내용 입력!")) return;
				//if(checkValue(notice.t_attach,"첨부 이미지 선택!")) return;
				
				var fileName = notice.t_attach.value;
				if(fileName !=""){
					var pathFileName = fileName.lastIndexOf(".")+1;    //확장자 제외한 경로+파일명
					var extension = (fileName.substr(pathFileName)).toLowerCase();	//확장자명
					//파일명.확장자
					if(extension != "jpg" && extension != "gif" && extension != "png"){
						alert(extension +" 형식 파일은 업로드 안됩니다.이미지 파일만 가능!");
						return;
					}		
				}	
		// 첨부 용량 체크		
				var file = notice.t_attach;
				if(file.value !=""){
					// 사이즈체크
					//var maxSize  = 2 * 1024 * 1024   // 2MB
					var maxSize  = 1024 * 1024 * 4;    // 1MB
					var fileSize = 0;

					// 브라우저 확인
					var browser=navigator.appName;
					// 익스플로러일 경우
					if (browser=="Microsoft Internet Explorer"){
						var oas = new ActiveXObject("Scripting.FileSystemObject");
						fileSize = oas.getFile(file.value).size;
					}else {
					// 익스플로러가 아닐경우
						fileSize = file.files[0].size;
					}
					if(fileSize > maxSize){
						alert("첨부파일 사이즈는 4MB 이내로 등록 가능합니다.    ");
						return;
					}	
				}
				notice.method="post";
				notice.action="db_notice_update.php";
				notice.submit();
			}
		</script>
	
	</body>
</html>









