<?

	include "common/dbconnect.php";
	include "common/common_header.php";
	$id = $_POST["t_id"];
	$query ="select id, password, name, ".
			"mobile, email_1, email_2, ".
			"address_1, address_2, point, level ".
			"from h_member ".
			"where id = '$id' ";
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
		
		<script type="text/javascript" language="javascript"> //닉네임 중복 버튼 및 글자로 표시
			$(document).ready(function(){ 
				$("#checkID").click(function(){ 					
					var urlLocation="/member/memberCheckId.php"; //member servlet 요청 /php는 서블릿이 없으니 memberCheckId.php을 만들어준다.
					var id = mem.t_id.value;
					var params="t_id="+id;  // id값의 변수를 넘긴다.
					
					if(id ==""){
						alert("ID를 입력해 주세요.");
						mem.t_id.focus();
						return;
					}

					if(mem.t_id.value.length < 3){
						alert("ID는 3글자부터 생성 가능합니다.")
						mem.t_id.focus();
						return;
					}
		
					
					$.ajax({
						type : "POST",
						url : urlLocation, // "Member" 직접 값을 넣어도 된다.
						data: params, // "t_gubun=idCheck&t_id="+id; 직접 값을 넣어도 된다.
						dataType : "text",
						error : function(){
							alert('통신실패!!');
						},
						success : function(data){
						/*	alert("통신 데이터 값" + data);
							
							아래의 아이디 중복검사 버튼의 idcheck 부분 정보 
						<label for="id"><input type="text" name="t_id" class="id" placeholder="아이디"></label>
								<input type="button" value="✔ 중복검사" name="idcheck" id="checkID" onClick="" style="cursor:pointer">
								<span id = "idResult"></span>
								<input type ="hidden" name="idCheck_yn">
								<input type ="hidden" name="idCheck_value">
						*/
						
							$("#idResult").html(data);
							if($.trim(data) =="사용불가"){ //date의 글자는 memberCheckId.php의 msg ="이미 사용중인 ID입니다."와 같아야 적용된다.
								$("#idResult").css("color","red"); //글자색
								mem.idCheck_yn.value ="no"; //사용 가능여부
								mem.idCheck_value.value =""; // 아이디
							} else {
								$("#idResult").css("color","green");
								mem.idCheck_yn.value ="yes";
								mem.idCheck_value.value =id;
							}	 
						}
					});
				});
			});
		</script> 

		<!-- sub page start -->
		<div class="notice">
		<div class="sub-notice">
			<h2><a href="/info/myinfo_view.php">MY INFO</a></h2>	
			<h2 class="color"><a href="/info/info_list.php"><i class="fas fa-check"></i>MEMBER INFO</a></h2>
			<h2><a href="/info/exit_list.php">EXIT INFO</a></h2>	
			</div>
			
		<!--join start-->
			<div class="join-box">
			
			<form class="join" name="mem" >
				<fieldset>
						<ul class="id_pw">
							<li class ="">
								<i class="fas fa-id-card-alt fa-2x"></i>
								<label for="id"><input type="text" name="t_id" class="id" value="<?=$row["id"]?>" placeholder="아이디"></label>
								<input type="button" value="✔ 중복검사" name="idcheck" id="checkID" onClick="" style="cursor:pointer"> &nbsp&nbsp

								<span id = "idResult"></span>
								<input type ="hidden" name="t_ori_id" value="<?=$row["id"]?>">
								<input type ="hidden" name="idCheck_yn">
								<input type ="hidden" name="idCheck_value">

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
								<label for="phone"><input type="text" name="t_mobile" value="<?=$row["mobile"]?>" placeholder="연락처 ex)010-3423-2534" class="phone" 
										oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" /></label>
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
								<a><i class="fas fa-won-sign"></i><input type="text" name="t_point" value="<?=$row["point"]?>" id="point" class="point" placeholder="point"
										oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1')" </a> <!-- 숫자 외 값 들어오기 막기 -->
								<input type='button' onclick='count("100")' value='+ 100'/ class="orange">
								<input type='button' onclick='count("1000")' value='+ 1000'/ class="orange">
								<input type='button' onclick='count("10000")' value='+ 10000'/ class="orange">
								<input type='button' onclick='count("50000")'value='+ 50000'/ class="orange">
							</li>

							<li>
							<i class="fas fa-chess-queen"></i><input type="text" name="t_level" value="<?=$row["level"]?>" class="level" readonly>
								<select name="leveltype" onchange="levelChange()" class="email"> <!-- onchange=""는 셀렉트 값이 변할때마다 실행된다. -->
									<option value="">등급 변경</option>
									<option value="nomal">nomal</option>
									<option value="top">top</option>
									
								</select>
							</li>
							<li>
						</ul>
							
						<ul class="check">
							<p>문자, 이메일을 통한 상품 및 이벤트 정보 수신에 동의 합니다</p>
							<li>
								<label for="agree"><input type="radio" name="t_info_yn" id="t_info_yn_1" value="y" checked> 1년 정보유지</label>
								<label for="agree2"><input type="radio" name="t_info_yn" id="t_info_yn_2" value="n"> 탈퇴시까지 정보유지</label>
							</li>
						</ul>
						
						<ul class="signup">
						<input type="button" value="✔ UPDATE" onClick="goUpdate()">
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

			function emailChange(){ //이메일 버튼
				var e = mem.emailtype.value; /*오른쪽이 왼쪽에 대입됨 */
				mem.t_email_2.value = e;
			}

			function addressChange(){ //주소 버튼
				var a = mem.addresstype.value; /*오른쪽이 왼쪽에 대입됨 */
				mem.t_address_1.value = a;
			}

			function levelChange(){		//등급변경
				var l = mem.leveltype.value; /*오른쪽이 왼쪽에 대입됨 */
				mem.t_level.value = l;
			}

			function count(type)  {
				// 결과를 표시할 element
				const resultElement = mem.point.value;
				
				// 현재 화면에 표시된 값
				let number = Number(resultElement);
				
				// 더하기
				if(type === '100') {
					number = parseInt(resultElement) + 100;
				}else if(type === '1000')  {
					number = parseInt(resultElement) + 1000;
				}else if(type === '10000')  {
					number = parseInt(resultElement) + 10000;
				}else if(type === '50000')  {
					number = parseInt(resultElement) + 50000;
				}
				total_price = total_price.toLocaleString();
				mem.point.value = number;
			}
/* 버튼으로 숫자 더하기 원본

<input type='button'
    onclick='count("plus")'
    value='+'/>
<input type='button'
    onclick='count("minus")'
    value='-'/>
<div id='result'>0</div>

			function count(type)  {
				// 결과를 표시할 element
				const resultElement = document.getElementById('result');
				
				// 현재 화면에 표시된 값
				let number = resultElement.innerText;
				
				// 더하기/빼기
				if(type === 'plus') {
					number = parseInt(number) + 1;
				}else if(type === 'minus')  {
					number = parseInt(number) - 1;
				}
				
				// 결과 출력
				resultElement.innerText = number;
			}
*/
			function goUpdate() {
				
				if(checkValue(mem.t_id,"아이디를 입력해주세요.")) return;
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

				if(checkValue(mem.t_level,"등급을 설정해주세요.")) return;

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
				mem.action="db_info_update.php";
				mem.submit();
				}
			}			
			
		</script>				
	
	</body>
</html>









