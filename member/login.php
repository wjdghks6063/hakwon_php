<?php
	include "common/common_header.php";
?>	
		<!--  header end -->
		
		
		<!-- sub page start -->
		<div class="notice">
			<div class="sub-member">
			<h2><span><i class="fas fa-sign-in-alt"></i> LOGIN </span></h2>	
				<p>- 로그인이 필요합니다 -</p>
			</div>
			
		<!--login start-->
			<div class="login-box">
			<form name="mem">
				<fieldset>
					<legend>로그인</legend>
					<div class="left-box"> <!-- placeholder="&nbsp;&nbsp;아이디를 입력하세요" 는 칸 뒤에 흐릿하게 글자 표시 -->
						<p><label for="id" class="readonly">아이디</label>ID &nbsp;&nbsp;&nbsp;<input type="text" name="t_id" class="txt" id="id" placeholder="&nbsp;&nbsp;아이디를 입력하세요"></p>
						<p><label for="password" class="readonly">비밀번호</label>PW &nbsp;<input type="password" name="t_password" class="txt" id="password" placeholder="&nbsp;&nbsp;비밀번호를 입력하세요"></p>
					</div>
					
					<div class="right-box">
						<input type="button" onclick="goLogin()" value="LOGIN" class="log" >
					</div>
					
					<div class="checksave">
						<input type="checkbox" value="1" id="idsave" name="idsave"><label for="idsave">&nbsp;&nbsp;&nbsp;아이디 저장</label>
				
						<input type="checkbox" value="1" id="pwsave" name="pwsave" class="margin"><label for="pwsave">&nbsp;&nbsp;&nbsp;비밀번호 저장</label>
					</div>
						
						<p class="btn">
						<a href="#">ID/PW찾기</a>
						<a href="join.php">회원가입</a>
						</p>
						
				</fieldset>
			</form>
			</div>
		</div>
		
		
		
		<!--  footer start  -->
	<?	include "common/common_footer.php";	?>	
		</div>
	
	
		<script>
		
			function goLogin() {
				if(checkValue(mem.t_id,"아이디를 입력해주세요.")) return;
				if(checkValue(mem.t_password,"비밀번호를 입력해주세요.")) return;
				mem.method="post";
				mem.action="db_member_login.php";
				mem.submit();
			}
		</script>
		
	</body>
</html>









