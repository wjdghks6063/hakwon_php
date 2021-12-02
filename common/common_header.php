<?
	
//	header("Cache-Control: no cache"); //뒤로 가기 누를시 페이지 양식 제출뜨면서 에러 나기 때문에 뒤로 가기 버튼 오류 방지
//	session_cache_limiter("private_no_expire");

	session_start();
	$session_name 	= $_SESSION["session_name"];
	$session_id 	= $_SESSION["session_id"];
	$session_level 	= $_SESSION["session_level"];
?>
<!doctype html>
<html lang="ko">
	<title>이정환</title>
		<meta charset="utf-8">
		<link href="/css/noticewrite.css" rel="stylesheet">
		<link href="/css/common.css" rel="stylesheet">
		<link href="/css/login.css" rel="stylesheet">
		<link href="/css/join.css" rel="stylesheet">
		<link href="/css/sub-notice.css" rel="stylesheet">	
		<link href="/css/notice-cont.css" rel="stylesheet">
		<link href="/css/sub-news.css" rel="stylesheet">
		<link href="/css/sub-news-1.css" rel="stylesheet">
		<link href="/css/sub-faq.css" rel="stylesheet">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.9/css/all.css">
		<script src="/js/jquery-3.3.1.min.js"></script>
		<script src="/js/common.js"></script>
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
					<h1 class="el-logo"><a href="/"><img src="/images/elwide-logo.svg" width="88" height="88"></a></h1>
				</div>
				<div class="side-bar">
					<div class="side-menu">
						<ul>
							<li><a href="http://www.facebook.com/elmusickorea" target="_blank"><i class="fab fa-facebook-f"></i></a></li><!-- target="_blank" 새창으로 열기 -->
							<li><a href="https://blog.naver.com/elmusicstudio" target="_blank"><i class="fab fa-blogger-b"> </i></a></li>
							<li><a href="https://www.youtube.com/channel/UCkoJ_TsGn-WqDVWEzGnhfcA"target="_blank"><i class="fab fa-youtube"> </i></a></li>

							<?	if($session_level == 'top' && $session_name){?>
								<li><a href="/info/info_list.php"><i class="fas fa-search" title="회원 정보"> </i></a></li> <!-- title 태그는 마우스 대고 있으면 텍스트창이 표시-->
							<?	}else if($session_name){?>
								<li><a href="/info/myinfo_view.php"><i class="fas fa-search" title="내 정보"> </i></a></li>
							<?	} ?>
							<?	if($session_name){?>
								<li><a href="/member/logout.php" title="로그아웃">
									<i class="fas fa-sign-out-alt"></i></a></li>
							<?	} else {?>
								<li><a href="/member/login.php" title="로그인"><i class="fas fa-user"></i></a></li>
							<?	}?>	
						
						</ul>
					</div>
					<div class="side-text">
						<ul>
						<?	if($session_name){?>
							<li><span style='color:black'><?=$session_name?></span>님 환영합니다.</li>
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