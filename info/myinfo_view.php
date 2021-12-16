<?

	include "common/dbconnect.php";
	include "common/common_header.php";
	$id = $_SESSION["session_id"];
	$query ="select id, password, name, ".
			"mobile, email_1, email_2, ".
			"address_1, address_2, FORMAT(point , 0) as point ".
			"from h_member ".
			"where id = '$id' ";
	$result = mysqli_query($connect,$query);
	$row    = mysqli_fetch_array($result);
	
?>	
		<!--  header end -->
<form name="exit">
	<input type="hidden" name="t_id" value="<?=$id?>" ">
</form>		

		<!-- sub page start -->
		<div class="notice">
			<div class="sub-notice">
				<h2 class="color"><a href="/info/myinfo_view.php"><i class="fas fa-check"></i>내 정보</a></h2>
			<?	if($session_level != 'top') { ?>	
				<h2><a href="/info/point_charge.php">포인트 충전,내역</a></h2>
			<?	} ?>	
			<?	if($session_level == 'top') { ?>
				<h2><a href="/info/info_list.php">회원 정보</a></h2>
				<h2><a href="/info/exit_list.php">탈퇴 정보</a></h2>
				<h2><a href="/info/point_charge_waiting.php">충전 요청</a></h2>
			<?	} ?>
			</div>
			
		<!--join start-->
			<div class="join-box">
			
			<form class="join" name="mem" >
				<fieldset>
						<ul class="id_pw">
							<li class ="">
								<i class="fas fa-id-card-alt fa-2x"></i>
								<label for="id"><input type="text" name="t_id" class="" value="<?=$row["id"]?>" placeholder="아이디" readonly></label>
							</li>
							<li>	
								<i class="fas fa-unlock-alt fa-2x" ></i>
								<label for="pw"><input type="password" name="t_password_1" value="<?=$row["password"]?>" placeholder="비밀번호"></label>
							</li>	
							<li>	
								<i class="fas fa-lock fa-2x"></i>
								<label for="re_pw"><input type="password" name="t_password_2" value="<?=$row["password"]?>" placeholder="비밀번호 재확인"></label>
							</li>
						</ul>
						
						<ul class="name_phone">
							<li>						
								<label for="name"><input type="text" name="t_name" value="<?=$row["name"]?>" placeholder="이름"></label>
							</li>
							<li>
								<label for="phone"><input type="text" name="t_mobile" value="<?=$row["mobile"]?>" placeholder="연락처 ex)010-3423-2534" class="phone"></label>
								<label for="certifi"></label>
								<label for="certifi"></label>
							</li>
							<li>
								<input type="text" name="t_email_1" value="<?=$row["email_1"]?>" class="email">&#64;
								<input type="text" name="t_email_2" value="<?=$row["email_2"]?>" class="email">
								<select name="emailtype" onchange="emailChange()" class="email"> <!-- onchange=""는 셀렉트 값이 변할때마다 실행된다. -->
									<option value="">직접입력</option>
									<option value="naver.com">naver.com</option>
									<option value="daum.net">daum.net</option>
									<option value="gmail.com">gmail.com</option>
								</select>
							</li>
							<li>
								<input type="text" name="t_address_1" value="<?=$row["address_1"]?>" class="address">
								<select name="addresstype" onchange="addressChange()" class="email"> <!-- onchange=""는 셀렉트 값이 변할때마다 실행된다. -->
									<option value="">직접입력</option>
									<option value="서울 특별시">서울 특별시</option>
									<option value="부산 광역시">부산 광역시</option>
									<option value="대구 광역시">대구 광역시</option>
									<option value="인천 광역시">인천 광역시</option>
									<option value="광주 광역시">광주 광역시</option>
									<option value="대전 광역시">대전 광역시</option>
									<option value="울산 광역시">울산 광역시</option>
								</select>
							</li>
							<li>	
								<input type="text" name="t_address_2" value="<?=$row["address_2"]?>" class="" placeholder="상세주소">
							</li>
							<li>	
								<a><i class="fas fa-won-sign"></i><input type="text" name="t_point" value="<?=$row["point"]?>" class="point" placeholder="point" readonly></a>
							</li>
						</ul>
							
						<ul class="check">
							<p>문자, 이메일을 통한 상품 및 이벤트 정보 수신에 동의 합니다</p>
							<li>
								<label for="agree"><input type="radio" name="t_info_yn" id="t_info_yn_1" value="y" checked> 1년 정보유지</label>
								<label for="agree2"><input type="radio" name="t_info_yn" id="t_info_yn_2" value="n"> 탈퇴시까지 정보유지</label>
							</li>
						</ul>
						
						<ul class="signup">
						<input type="button" value="회원탈퇴" style="margin-bottom:10px; background-color: #ED0000;" onClick="goExit()">
						<input type="button" value="정보수정" onClick="goUpdate()">
						</ul>
				</fieldset>
			</form>
			
				<div class="login_img">
					<li class="photo1"> </li>
					<li class="photo2"> </li>
					<li class="photo3"> </li>
					<li class="photo4"> </li>
				</div>
			</div>
		
		
		
		
		<!--  footer start  -->
	<?	include "common/common_footer.php";	?>	
		</div>
	
		<script type="text/javascript"> /*js/common.js에 checkValue라는 공백일시 메세지 출력해주는걸 만들어둠 */

			function emailChange(){
				var e = mem.emailtype.value; /*오른쪽이 왼쪽에 대입됨 */
				mem.t_email_2.value = e;
			}

			function addressChange(){
				var a = mem.addresstype.value; /*오른쪽이 왼쪽에 대입됨 */
				mem.t_address_1.value = a;
			}

			function goExit(){
				if(confirm("정말 탈퇴하시겠습니까?")){	
				exit.method="post";
				exit.action="/member/db_member_exit.php";
				exit.submit();
				}
			}

			function goUpdate() {
				
				if(checkValue(mem.t_password_1,"비밀번호를 입력해주세요.")) return;
				if(checkValue(mem.t_password_2,"비밀번호 확인을 입력해주세요.")) return;

				if(mem.t_password_1.value != mem.t_password_2.value){
					alert("비밀번호가 일치하지 않습니다.");
					mem.t_password_2.focus();
					return;
				}

				if(checkValue(mem.t_name,"이름을 입력해주세요.")) return;
				if(checkValue(mem.t_mobile,"연락처를 입력해주세요.")) return;

				var mo = mem.t_mobile.value;
				var mo2 = mo.replace(/[^0-9]/g,''); /*연락처에서 0~9까지만 인식하고 나머지는 공백으로 처리하겠다. ex -은 입력시 제외됨 /g는 공간안에 모든 글자 란 뜻 */
				if(mo2.length > 11 ) {
					alert("전화번호는 11자리 이내로 입력해 주세요.");
					mem.t_mobile.focus();
					return;
				}
				
				if(checkValue(mem.t_email_1,"이메일을 입력해주세요.")) return;
				if(checkValue(mem.t_email_2,"이메일을 입력해주세요.")) return;

				if(checkValue(mem.t_address_1,"주소를 입력해주세요.")) return;
				if(checkValue(mem.t_address_2,"상세주소를 입력해주세요.")) return;

/*
				if(all.id.value=="") {
					alert("아이디를 입력해주세요");
					all.id.focus();
					return;
					}						
				if(all.pw.value=="") {
					alert("비밀번호를 입력해주세요");
					all.pw.focus();
					return;
					}
				if(all.re_pw.value=="") {
					alert("비밀번호를 재입력해주세요");
					all.re_pw.focus();
					return;
					}
				if(all.name.value=="") {
					alert("이름을 입력해주세요");
					all.name.focus();
					return;
					}
				if(all.phone.value=="") {
					alert("연락받으실 번호를 입력해주세요");
					all.phone.focus();
					return;
					}
				if(all.certifi.value=="") {
					alert("인증번호를 입력해주세요");
					all.certifi.focus();
					return;
					}
				if(all.email1.value=="") {
					alert("이메일을 입력해주세요");
					all.email1.focus();
					return;
					}	
				if(all.email2.value=="") {
					alert("이메일을 입력해주세요");
					all.email2.focus();
					return;
					}	
	*/				
				if(confirm("정보를 수정하시겠습니까?")){

				mem.t_mobile.value = mo2; /* 숫자 외 다른 값이 ex)"-" 들어간걸 지우고 숫자만 남긴걸 다시 mo2에 넣어준다.  */

				mem.method="post";
				mem.action="db_myinfo_update.php";
				mem.submit();
				}
			}			
			
		</script>		
				
	
	</body>
</html>









