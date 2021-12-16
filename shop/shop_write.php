<?php
	include "common/common_header.php";

	if($session_level != 'top') {
?>
		<script>
			alert("관리자 화면 입니다.");
			location.href="/";
		</script>
<?	} ?>

		<!--  header end -->
		
		
		<!-- sub page start -->
		<div class="notice">
			<div class="sub-notice">
			<h2><span><i class="fas fa-edit"></i> shop-write</span></h2>	
			</div>
			
			<div class="notice-write">
			
			<form name="shop" enctype="multipart/form-data">
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
								<td><input type="text" name="t_title" id="title" class="title" placeholder="제목을 입력해주세요"></td>
							</tr>
							
							<tr>
								<th><label for="cont">상세 정보</label></th>
								<td><textarea type="cont" name="t_content" id="cont" class="cont" placeholder="내용을 입력해주세요"></textarea>
							</tr>

							<tr>
								<th><label for="title">제품 수량</label></th>
								<td><input type="text" name="t_stuff_number" id="number" class="number" placeholder="수량을 입력해주세요."
									oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1')"></td>
							</tr>
							<tr>
								<th><label for="title">제품 가격</label></th>
								<td><input type="text" name="t_price" id="number" class="number" placeholder="가격을 입력해주세요."
									oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1')"></td>
							</tr>
							<tr>
								<th><label for="title">회사 명</label></th>
								<td><input type="text" name="t_shop_name" id="number" class="number" placeholder="회사 상호명을 입력해주세요."></td>
							</tr>
							<tr>
								<th><label for="title">일련 번호</label></th>
								<td><input type="text" name="t_price_code" id="number" class="number" placeholder="일련번호를 입력해주세요."></td>
							</tr>
							
							<tr>
								<th><label for="file">파일 첨부</label></th>
								<td><div class="imgs_wrap" style="text-align:center;">
									<h2 class="imgs_wrap_h2" style="color: #aaa;top: 50px;position: relative;"><b>이미지 미리보기</b></h2>
								</div>
									<a href="javascript:void(0)" onclick="file_upload();" class="btn-_default" style="width: 150; height: 45px; cursor: pointer; border: 1px solid black;">이미지 첨부</a>
									<input type="file" id="input_imgs" multiple name="t_attach" style="display:none" />
							<!--	<input type="file" name="t_attach" class="file_upload" id="file"></label></td> -->
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
				var data = new FormData();

					for(var i=0; i<sel_files.length; i++) 
					{	
						var name = i;
						data.append(name, sel_files[i]);
					}

					data.append("image_count", sel_files.length);
					if(sel_files.length < 1)  // 파일이 아무것도 없을때 0
					{
						alert("파일을 선택해주세요.")
						return;
					}else if(sel_files.length > 1){ //파일이 2개이상 들어 갔을 때
						alert("한개의 사진만 첨부 가능합니다.");
						return;
					}
				
				if(checkValue(shop.t_title,"제목을 입력해주세요.")) return;
				if(checkValue(shop.t_content,"상세정보를 입력해주세요.")) return;
				if(checkValue(shop.t_stuff_number,"수량을 입력해주세요.")) return;
				if(checkValue(shop.t_price,"가격을 입력해주세요.")) return;
				if(checkValue(shop.t_shop_name,"상호를 입력해주세요.")) return;
				if(checkValue(shop.t_price_code,"제품코드를 입력해주세요.")) return;
				shop.method="post";
				shop.action="db_shop_save.php";
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

				var f_reader = new FileReader();
				var index = sel_files.length;
				f_reader.onload = function(e) {
					var delete_html = "<div class=\"wrap_div_img\" id=\"img_id_"+index+"\" style=\"display: inline-block\">" +
										"<button type=\"button\" class=\"close AClass\" style=\"\" onclick=\"delete_img("+index+")\"><span><i class=\"far fa-trash-alt\" aria-hidden=\"true\"></i></span></button>"+
										"<img src=\"" + e.target.result + "\" ></a>"+
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
