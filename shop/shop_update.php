<?	include "common/common_header.php";
    include "common/dbconnect.php";

    $no = $_POST["t_no"];
	$t_page = $_POST["t_page"];

    $query="select a.title, a.content, a.attach, b.name,a.reg_id, a.reg_date from h_shop a, h_member b where a.reg_id = b.id and a.no='$no'";
    $result = mysqli_query($connect,$query);
	$row = mysqli_fetch_array($result);
    if($session_level !="top"){
	
		echo $t_page;
		echo $no;	
?>
    <script>
    alert("관리자전용 화면입니다.");
    </script>
    
<?}?>


		
		<!--  header end -->
		
		
		<!-- sub page start -->
        <style>

            </style>
		<div class="notice">
			<div class="sub-notice">
			<h2><span><i class="fas fa-edit"></i> shop-write</span></h2>	
			</div>
			
			<div class="notice-write">
			
			<form name="shop" enctype="multipart/form-data">
                <input type="hidden" name="t_no" value="<?=$no?>"
				<input type="hidden" name="t_page" value="<?=$t_page?>">

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
								<th><label for="title">상품 명</label></th>
								<td><input type="text" name="t_title" value="<?=htmlspecialchars($row["title"])?>" class="title" placeholder="상품 명을 입력해주세요"></td>
							</tr>
							
							<tr>
								<th><label for="cont">상세 정보</label></th>
								<td><textarea type="cont" name="t_content" value="<?=$row["content"]?>" class="cont"><?=$row["content"]?></textarea>
							</tr>
						<style>
                            .img img{
                                width:500px;
                                height:300px;
                            }
                        </style>	
							<tr>
								<th><label for="file">파일 첨부</label></th>

								<td style="text-align:left; padding-left:30px;">&nbsp;&nbsp; 
                                <p class="img"><img src="/file_room/shop/<?=$row["attach"]?>"></img></p>
                                <?=$row["attach"]?> 
								<!--삭제 <input type="checkbox" name="t_del_attach" value="<?=$row['attach']?>"> -->
                                <input type="hidden" name="t_ori_attach" value="<?=$row['attach']?>">
                                <br>
                                <input type="file" name="t_attach" class="file" id="file"></label></td>
                            </tr>

							<tr>
								<th><label for="file">파일 첨부</label></th>
								<td><div class="imgs_wrap" style="text-align:center;">
									<h2 class="imgs_wrap_h2" style="color: #aaa;top: 50px;position: relative;">
			
									<b>이미지 미리보기</b></h2>
								</div>
									<a href="javascript:void(0)" onclick="file_upload();" class="btn-_default" style="width: 150; height: 45px; cursor: pointer; border: 1px solid black;">이미지 첨부</a>
									<input type="file" id="input_imgs" multiple name="t_attach1" style="display:none" onchange="javascript:document.getElementById('fileName').value = this.value" />
							<!--	<input type="file" name="t_attach" class="file_upload" id="file"></label></td> -->
							</tr>

							<tr>
								<td colspan="2">
								<input type="button" onClick="goSave()" value="수정" class="btn" >
								<input type="button" onclick="location.href='shop_list.php'" value="목록" class="btn">
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

				var file = shop.t_attach;
		var fileMaxSize  = 5;
		if(file.value !=""){
			// 사이즈체크
			var maxSize  = 1024 * 1024 * fileMaxSize;  
			//var maxSize  = 10; 10바이트  
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
			//alert("파일사이즈 : "+ fileSize);

			if(fileSize > maxSize){
				alert(" 첨부파일 사이즈는 "+fileMaxSize+"MB 이내로 등록 가능합니다. ");
				return;
			}	
		}			var fileName = shop.t_attach.value;
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
	
		var file = shop.t_attach;
		var fileMaxSize  = 5;
		if(file.value !=""){
			// 사이즈체크
			var maxSize  = 1024 * 1024 * fileMaxSize;  
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
			//alert("파일사이즈 : "+ fileSize);

			if(fileSize > maxSize){
				alert(" 첨부파일 사이즈는 "+fileMaxSize+"MB 이내로 등록 가능합니다. ");
				return;
			}	
		}
                if(checkValue(shop.t_title,"제목입력!")) return;
                if(checkValue(shop.t_content,"내용입력!")) return;
                shop.method="post";
                shop.action="db_shop_update.php";
                shop.submit();
            }
		</script>

		<script>

		var sel_files = new Array();
		var h2_html = "<h2 class=\"imgs_wrap_h2\" style=\"color: #aaa;top: 50px; position: relative;\"><b>이미지 미리보기</b></h2>";

		$(document).ready(function() {
			$("#input_imgs").on("change", file_handler);
		}); 

		function file_upload() 
		{
			$("#input_imgs").trigger('click');
		}

		function file_handler(e) 
		{
			var files = e.target.files;
			var filesArr = Array.prototype.slice.call(files);

			filesArr.forEach(function(file) {
			
				if(!file.type.match("image.*"))
				{
					alert("확장자는 이미지 파일만 가능합니다.");
					return;
				}

				var data = new FormData();

				for(var i=0; i<sel_files.length; i++) 
				{	
					var name = i;
					data.append(name, sel_files[i]);
				}

				data.append("image_count", sel_files.length);
				
				if(sel_files.length > 0){
					alert("한개의 사진만 첨부 가능합니다.");
					return;
				}

				var f_reader = new FileReader();
				var index = sel_files.length;
				f_reader.onload = function(e) {
					var delete_html = "<div class=\"wrap_div_img\" id=\"img_id_"+index+"\" style=\"display: inline-block\">" +
										"<button type=\"button\" class=\"close AClass\" style=\"\" onclick=\"delete_img("+index+")\"><span><i class=\"far fa-trash-alt\" aria-hidden=\"true\"></i></span></button>"+
										"<img src=\"" + e.target.result + "\" ><input type=\"text\" id=\"fileName\"  name=\"fileName\" ></a>"+
										"</div>";
					$(".imgs_wrap").append(delete_html);
					$(".imgs_wrap_h2").remove();
					$(".imgs_wrap").css("text-align", "");
				}
				sel_files.push(file);
				f_reader.readAsDataURL(file);
			});
		}

		function delete_img(index) 
		{
			sel_files.splice(index, 1);
			$("#img_id_"+index).remove();
			if( sel_files.length == 0 )
			{
				$(".imgs_wrap").append(h2_html);
				$(".imgs_wrap").css("text-align", "center");
			}
		}
		/*
		function file_submit()  goSave에 기능 넣어둠
		{
			var data = new FormData();

			for(var i=0; i<sel_files.length; i++) 
			{	
				var name = i;
				data.append(name, sel_files[i]);
			}

			data.append("image_count", sel_files.length);
			if(sel_files.length < 1) 
			{
				alert("파일을 선택해주세요.")
				return;
			}else if(sel_files.length > 1){
				alert("한개의 사진만 첨부 가능합니다.");
				return;
			}

			//실시간으로 할게 아니기 때문에 필요없음
			$.ajax({
				url: "./upload_cnt.php",
				type: 'POST',
				data: data,
				cache: false,
				contentType: false,
				processData: false,
				success: function (response) { alert(response); },
				error: function () { fx_alert("서버와의 연결에 문제가 있습니다. 잠시후 다시 시도해 주세요."); }
			});
			
		}
		*/
		</script>
	
	</body>
</html>









