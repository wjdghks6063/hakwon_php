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

<!-- 서머노트를 위해 추가해야할 부분 -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<script type="text/javascript" src="/js/jquery-3.3.1.min.js"></script>
<link href="/css/summernote-lite.css" rel="stylesheet" >
<script src="/js/summernote-lite.js"></script>
<script src="/lang/summernote-ko-KR.js"></script>
<script src="/js/getsummernote.js"></script>

<script> //썸머노트 스크립트
	$(document).ready(function() {
		$("#summernote").summernote({ //div 창 이름 #summernote
			placeholder:'이미지 선택', //빈 창에 표시될 내용
			width:800, //넓이
			height:400, //높이
			callbacks: {
				onImageUpload:function(files, editor, welEditable){
					for(var i = files.length - 1;i>=0;i--){
						sendFile(files[i], this);
					}
				}
			}
		});
	});

	function sendFile(file, el, welEditable){ //sendFile 는 이미지 업로드다.
		var form_data = new FormData();
		form_data.append('file', file);
		$.ajax({
			data:form_data,
			type:"POST",
			url:'notice_summernote_img_upload.php', //게시판마다 따로 만들어주던 해야한다.
			cache:false,
			contentType:false,
			processData:false,
			success:function(url){
		//		alert(url); 파일 주소명
				$(el).summernote('editor.insertImage', $.trim(url));
			},
			error: function(data) {
				console.log(data);
			}
		});
	}
</script>

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
								<td>
									<input type="hidden" name="t_content">
									<div id="summernote"><?=$row["content"]?></div>
								</td>
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
			//	if(checkValue(notice.t_content,"내용 입력!")) return; 아래에 //썸머노트에 내용입력 있음.
				//if(checkValue(notice.t_attach,"첨부 이미지 선택!")) return;

				//썸머노트
				var summernoteContent = $('#summernote').summernote('code'); //div안의 글자들을 가져와 summernoteContent안에 넣어준다.
				notice.t_content.value = summernoteContent; // summernoteContent의 내용을 t_content로 만들어준다.

				//alert(summernoteContent); 텍스트창에 적용된 style같은걸 볼수 있다.
				if(checkValue(notice.t_content,"내용 입력!")) return; //summernote의 내용을 t_content로 만들어준다.
				// 내용을 저장할 때 보면 스타일까지 다 표기 되기때문에 db를 varchar의 글자제한에 걸릴수 있기 때문에 text로 바꿔준다.
				
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









