<?
	include "common/common_header.php";
?>		
		
		<!-- sub page start -->
		<div class="notice">
			<div class="sub-member">
			<h2><span><i class="fas fa-sign-in-alt"></i> 비밀번호 찾기 </span></h2>	
				<p>- 아이디와 연락처가 필요합니다 -</p>
			</div>
			
		<!--login start-->
<!--
login.css 73줄 padding-left:40px; -> 10
.login-box .left-box {width:60%; float:left; margin:20px 0 0 20px; padding-left:10px;}
 -->		
			<div class="login-box">
			<form name="mem">
				<fieldset>
					<legend>로그인</legend>
					<div class="left-box">
						<p><label for="id" class="readonly">아이디</label>ID &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="t_id" class="txt" id="id" placeholder="&nbsp;&nbsp;아이디를 입력하세요" autofocus></p>
						<p><label for="tell" class="readonly">연락처</label>Mobile &nbsp;<input type="password" name="t_mobile" class="txt" id="password" placeholder="&nbsp;&nbsp;연락처를 입력하세요"></p>
					</div>
					
					<div class="right-box">
						<input type="button" onclick="goFind()" value="찾 기" class="log">
					</div>
					

						
						<p class="btn">
						<a href="login.php">로그인</a>
						<a href="join.php">회원가입</a>
						</p>
						
				</fieldset>
			</form>
			</div>
		</div>
		
		
		
		<!--  footer start  -->
<?		include "common/common_footer.php"; ?>
		</div>
	
	
		<script>
			function goFind() {
				if(checkValue(mem.t_id,"아이디 입력!")) return;
				if(checkValue(mem.t_mobile,"연락처 입력!")) return;
				
				var mo = mem.t_mobile.value;
				var mo2 = mo.replace(/[^0-9]/g, '');
				if(mo2.length > 11){
					alert("전화번호는 11자리 이내입니다.");
					mem.t_mobile.focus();
					return;
				}					
				
				mem.t_mobile.value = mo2;
				
				mem.method="post";
				mem.action="db_password_find.php";
				mem.submit();
			}
		</script>
		
	</body>
</html>









