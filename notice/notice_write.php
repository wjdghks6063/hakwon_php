<?
	include "common/common_header.php";
	
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
<script type="text/javascript">
	$(function(){					
		function readImage(input) {
		    // 인풋 태그에 파일이 있는 경우
		    if(input.files && input.files[0]) {
		        // 이미지 파일인지 검사 (생략)
		        // FileReader 인스턴스 생성
		        const reader = new FileReader()
		        // 이미지가 로드가 된 경우
		        reader.onload = e => {
		            const previewImage = document.getElementById("preview-image")
		            previewImage.src = e.target.result;
		        }
		        // reader가 이미지 읽도록 하기
		        reader.readAsDataURL(input.files[0])
		    } else {
		    	// 이미지 안올렸으면
				$("#preview-image").attr('src','');
				$("#preview-image").css("display","none");
		    }
		}
		// input file에 change 이벤트 부여
		const inputImage = document.getElementById("input-image");
		inputImage.addEventListener("change", e => {
			$("#preview-image").css("display","block");
		    readImage(e.target)
		})	
	});	
	</script>
	<style>
	#preview-image{display:none;}
	</style>		
		
		<!-- sub page start -->
		<div class="notice">
			<div class="sub-notice">
			<h2><span><i class="fas fa-edit"></i> NOTICE-write</span></h2>	
			</div>
			
			<div class="notice-write">
			
			<form name="notice" enctype="multipart/form-data">
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
								<td><input type="text" name="t_title" id="title" class="title" placeholder="제목을 입력해주세요"></td>
							</tr>
							
							<tr>
								<th><label for="cont">내용</label></th>
								<td><textarea type="cont" name="t_content" id="cont" class="cont" placeholder="내용을 입력해주세요"></textarea>
							</tr>
							
							<tr>
								<th><label for="file">파일 첨부</label></th>
								<td>
									<!--이미지 미리 보기 -->
									<img style="width: 200px;" id="preview-image" >
									<input type="file" name="t_attach" class="file" id="input-image"></label></td>
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
<?
	include "common/common_footer.php";
?>
		</div>
	
	
		<script>
			function goSave(){
				if(checkValue(notice.t_title,"제목 입력!")) return;
				if(checkValue(notice.t_content,"내용 입력!")) return;
				if(checkValue(notice.t_attach,"첨부 이미지 선택!")) return;
				
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
				notice.action="db_notice_save.php";
				notice.submit();
			}
		</script>
	
	</body>
</html>









