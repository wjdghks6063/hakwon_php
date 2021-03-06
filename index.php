<?php
	session_start();
	$_session_name = $_SESSION["session_name"];
	$_session_id = $_SESSION["session_id"];
	$_session_level = $_SESSION["session_level"];
?>
<!doctype html>
<html lang="ko">
	<title>이정환</title>
		<meta charset="utf-8">
		<link href="css/common.css" rel="stylesheet">
		<link href="css/el.css" rel="stylesheet">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.9/css/all.css">
		<script src="js/jquery-3.3.1.min.js"></script>
		
	<body>
		<!-- skip navigation -->
		<dl id="access">
			<dt>바로가기 및 건너띄기 링크</dt>
			<dd><a href="#contents">본문바로가기</a></dd>
			<dd><a href="#navigation">주메뉴 바로가기</a></dd>
		</dl>
		<hr>
		
		<div id="big-box">
			<header>
			<div id="header">
				<div class="nav">
						<ul class="nav-menu">
							<li><a href="sub1.html">ABOUT EL WIDE</a></li>
							<li><a href="sub2.html">MUSIC</a></li>
							<li><a href="sub3.html">MEDIA</a></li>
							<li><a href="sub4.html">CULTURE</a></li>
							<li><a href="/notice/notice_list.php">NOTICE</a></li>
						</ul>
				<div class="logo">
					<h1 class="el-logo"><a href="/"><img src="images/elwide-logo.svg" width="88" height="88"></a></h1>
				</div>
				<div class="side-bar">
					<div class="side-menu">
						<ul>
							<li><a href="http://www.facebook.com/elmusickorea" target="_blank"><i class="fab fa-facebook-f"></i></a></li>
							<li><a href="https://blog.naver.com/elmusicstudio" target="_blank"><i class="fab fa-blogger-b"> </i></a></li>
							<li><a href="https://www.youtube.com/channel/UCkoJ_TsGn-WqDVWEzGnhfcA"target="_blank"
							><i class="fab fa-youtube"> </i></a></li>
							<?if($_session_level == 'top' && $_session_name){?>
								<li><a href="/info/info_list.php"><i class="fas fa-search"> </i></a></li>
							<?	}else if($_session_name){?>
								<li><a href="/info/myinfo_view.php"><i class="fas fa-search"> </i></a></li>
							<?	} ?>
							<? if($_session_name) {?>
								<li><a href="/basket/basket_list.php"><i class="fas fa-cart-arrow-down" title="장바구니"> </i></a></li>	
								<li><a href="/member/logout.php"><i class="fas fa-sign-out-alt"></i></a></li>
							<? } else {?>	
								<li><a href="/member/login.php"><i class="fas fa-user"></i></a></li>
							<? } ?>
						</ul>
					</div>
					<div class="side-text">
						<ul>
						<? if($_session_name) {?>
							<li><span style='color:black'><?=$_session_name?></span>님 환영합니다.</li>
						<? } else {?>	
							<li>CONNECT WITH WIDE</li>
						<? } ?>	
						</ul>
					</div>
				</div>
				</div>
			</div>
			</header>
		</div>
		
		<!--  header end -->
		
		<section id="main-visual">
			
				<section class="main-photo">
					<p class="main1"><a href="sub2.html"></a></p>
					<p class="main2"><a href="sub3.html"></a></p>
					<p class="main3"><a href="sub4.html"></a></p>
				</section>
				
				<section class="main-text">
					<div class="references">
						<h2><span>ABO</span>UT EL WIDE</h2>
						<ul class="small-refer1">
							<li>이엘 와이드는 즐거움의 가치를 창조하는 문화콘텐츠 기업으로<br>
							건강하고 유익한 콘텐츠를 통해 대한민국 대중문화를 선도합니다.</li>
							<li class="plus"><a href="sub-notice.html" "alt="공지사항"> Notice &nbsp &nbsp > </a></li>
							<li class="plus"><a href="sub-contact.html" "alt="콘택트"> contact &nbsp &nbsp > </a></li>
						</ul>
					</div> 
					
					<div class="references">
						<div class="padding">
						<h2><span>CON</span>TACT</h2>
						<ul class="small-refer2">
							<li>이엘와이드코퍼레이션</li>
							<li>03924. 서울 마포구 월드컵북로56길 12 트루텍빌딩 10층<br>
								<span class="f-s11">10F, Trutec Building, 12, World Cup buk-ro 56-gil, Mapo-gu, Seoul, South Korea</span><br>
								+82 2 6931 5012</li>
							<li><a href="email" alt="이메일주소">contact@elwide.com</a></li>
						</ul>
						</div>
					</div>
					
					<div class="references">				
						<h2><span>MAP</span></h2>
						<ul class="small-refer3">
							<li><a href="sub-contact.html" alt="지도"></a></li>
						</ul>
					</div>
				</section>
		</section>
		
				<!-- section end  -->
				
				<?
					include "common/common_footer.php";
				?>
	
	
	
	</body>
</html>









