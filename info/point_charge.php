<?
	include "common/common_header.php";
	include "common/dbconnect.php";

/**************************page setting********************************/
/*pagingSetting.php와 같은 변수명으로 사용해야 작동 하기 때문에 양쪽의 변수명을 맞춰준다. */

	$countTotal =" select * from h_member "; /*페이지를 정할 db 명 */ 
	$countOnePage = "10"; // 한 페이지당 보여줄 목록 수 (?)행 보여주겠다.
	$perblock = 5;		 // 한 페이지당 보여줄 페이지 번호 수 < 1 2 3 4 5 >

	include "common/pagingSetting.php"; //변수명들을 넣어줘야 작동되기 때문에 변수명 아래쪽에 include 해준다.
	$t_page =$_POST['t_page']; // view에 갔다가 목록이나 뒤로 가기를 했을 때 현재 페이징 넘버로 가질 수 있게 해준다.
/**********************************************************************/

	$query ="select id, name, email_1, email_2, date_format(exit_date,'%Y-%m-%d') as exit_date, FORMAT(point , 0) as point, exit_yn, level from  h_member ".
			"where exit_yn ='y' order by reg_date desc ".
			"limit $start, $end ";
	$result = mysqli_query($connect,$query);
										
	$count = mysqli_num_rows($result); 

?>		


		<!--  header end -->
<script>
	function goView(id){
		info.t_id.value=id;
		info.method="post";
		info.action="info_view.php";
		info.submit();
	}
	function goPage(pageNumber){		
		pageForm.t_page.value = pageNumber;
		pageForm.method ="post";
		pageForm.action ="exit_list.php";
		pageForm.submit();
	}
	function goDelete(id){
		if(confirm("정말 삭제하시겠습니까?")){
		info.t_id.value=id;
		info.method="post";
		info.action="/member/db_member_delete.php";
		info.submit();
		}
	}
	function goRecovery(id){
		if(confirm("정말 복구하시겠습니까?")){
		info.t_id.value=id;
		info.method="post";
		info.action="/member/db_member_recovery.php";
		info.submit();
		}
	}
</script>

<form name="info">
	<input type="hidden" name="t_id" value="<?=$id?>">
	<input type="hidden" name="t_page" value="<?=$t_page?>">
</form>

<form name ="pageForm">
	<input type="hidden" name="t_page">
</form>

		<!-- sub page start -->
		<div class="notice">
			<div class="sub-notice">
				<h2><a href="/info/myinfo_view.php">내 정보</a></h2>
				<h2 class="color"><a href="/info/point_charge.php"><i class="fas fa-check"></i>포인트 충전</a></h2>
				<h2><a href="/info/info_list.php">포인트 사용 내역</a></h2>
			<?	if($session_level == 'top') { ?>
				<h2><a href="/info/info_list.php">회원 정보</a></h2>
				<h2><a href="/info/exit_list.php">탈퇴 정보</a></h2>	
			<?	} ?>
			</div>
			
			<!-- table start-->
			<div class="table-box">
				<table class="table">
					<caption>공지사항 - 번호, 제목, 첨부, 작성일, 조회수</caption>
					<colgroup>
						<col width="12%">
						<col width="12%">
						<col width="*%">
						<col width="15%">
						<col width="12%">
						<col width="10%">
						<col width="10%">
						<col width="10%">
					</colgroup>
					
					<thead>
						<tr>
							<th scope="col">id</th>
							<th scope="col">성함</th>
							<th scope="col">이메일</th>
							<th scope="col">회원 탈퇴일</th>
							<th scope="col">등급</th>
							<th scope="col">포인트</th>
							<th scope="col">계정 복구</th>
							<th scope="col">계정 탈퇴</th>
						</tr>
					</thead>
					
					<tbody>
			<?for($k=0;$k<$count;$k++){ //압축되어있는 놈을 한줄씩한줄씩 뺴서 로우에 담는다
						$row = mysqli_fetch_array($result);
			?>	
				<?if($row["exit_yn"] == 'n'){ ?>	
					<!-- 회원 탈퇴한 회원은 표시하지 않는다. -->
					<?}else{?>
					<tr>
						<td><?=$row["id"]?></td>		
						<td><a href="javascript:goView('<?=$row["id"]?>')"><?=$row["name"]?></a></td>
						<td><?=$row["email_1"]?>@<?=$row["email_2"]?></td>
						<td><?=$row["exit_date"]?></td>
				<?if($row["level"] == 'top'){ ?>	
						<td><span style="color:#FF0000"><?=$row["level"]?></span></a></td>
				<?}else{?>
						<td><?=$row["level"]?></td>
				<?}?>	
						<td><?=$row["point"]?></td>
				<?if($session_level == 'top'){ ?>
						<td><a href="javascript:goRecovery('<?=$row["id"]?>')"><span class="complet">계정 복구</span></a></td>
						<td><a href="javascript:goDelete('<?=$row["id"]?>')"><span class="waiting">계정 삭제</span></a></td>
				<?}?>

				<?}?>
			<?}?>
					</tr>	
					</tbody>
				</table>
			</div>

<style>
#my_modal {
	display: none;
	width: 600px;
	height:600px;
	padding: 20px 60px;
	background-color: #fefefe;
	border: 1px solid #888;
	border-radius: 3px;
}

#my_modal .modal_close_btn {
	position: absolute;
	top: 10px;
	right: 20px;
}

#my_modal .all_point{
	width:100%;
	height:180px; 
	margin-top:20px;
}

#my_modal li{
	width: 110px; 
	height: 150px; 
	border: solid 3px; 
	float:left; 
	margin: 0px 3px; 
	color: #d3c7c7; 
	background-color: #f3f3f3;
	font-family: "Nanum Gothic",sans-serif;
    font-size: 24px;
}
#my_modal li .point_btn{
	width: 104px; 
	height: 60px; 
	padding-top: 20px; 
	color:black; 
	background-color:#ffffff;
}
#my_modal li p{
	text-align: center;
	margin-top: 10px;
}
#my_modal .charge_btn {
	width: 100%;
	text-align: center;
}	
#my_modal .cash_charge_btn {
	position: absolute;
	bottom: 30px;
}			
</style>			
			<div id="my_modal">
				<a class="modal_close_btn">x</a> <!--닫기 버튼-->

				<div class ="all_point">
				<ul>
					<li>
						<div class="point_btn">
							<p>1,000 P </p>
						</div>
						<p>1,000</p>
					</li>
					<li>
						<div class="point_btn">
							<p>5,000 P</p>
						</div>
						<p>5,000</p>
					</li>
					<li>
						<div class="point_btn">
							<p>10,000 P</p>
						</div>
						<p>10,000</p>
					</li>
					<li>
						<div class="point_btn">
							<p>50,000 P</p>
						</div>
						<p>50,000</p>
					</li>
				</ul>
				</div>
				<div class style="width:100%">
					<span style="float: right;">충전 예상금액: 5000 \</span>
				</div>
			<div class ="charge_btn">
				<a class="cash_charge_btn">결제하기</a> <!--닫기 버튼-->
			</div>


			</div>
			
			<button id="popup_open_btn">팝업창 띄어 줘염</button>

			
<script>
            function modal(id) {
                var zIndex = 9999;
                var modal = document.getElementById(id);

                // 모달 div 뒤에 희끄무레한 레이어
                var bg = document.createElement('div');
                bg.setStyle({
                    position: 'fixed',
                    zIndex: zIndex,
                    left: '0px',
                    top: '0px',
                    width: '100%',
                    height: '100%',
                    overflow: 'auto',
                    // 레이어 색갈은 여기서 바꾸면 됨
                    backgroundColor: 'rgba(0,0,0,0.4)'
                });
                document.body.append(bg);

                // 닫기 버튼 처리, 시꺼먼 레이어와 모달 div 지우기
                modal.querySelector('.modal_close_btn').addEventListener('click', function() {
                    bg.remove();
                    modal.style.display = 'none';
                });

                modal.setStyle({
                    position: 'fixed',
                    display: 'block',
                    boxShadow: '0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19)',

                    // 시꺼먼 레이어 보다 한칸 위에 보이기
                    zIndex: zIndex + 1,

                    // div center 정렬
                    top: '50%',
                    left: '50%',
                    transform: 'translate(-50%, -50%)',
                    msTransform: 'translate(-50%, -50%)',
                    webkitTransform: 'translate(-50%, -50%)'
                });
            }

            // Element 에 style 한번에 오브젝트로 설정하는 함수 추가
            Element.prototype.setStyle = function(styles) {
                for (var k in styles) this.style[k] = styles[k];
                return this;
            };

            document.getElementById('popup_open_btn').addEventListener('click', function() {
                // 모달창 띄우기
                modal('my_modal');
            });
</script>

			<div class="page-number1">
		<?	include "common/pagingDisplay.php"; ?>	
			</div>
		
		</div>
		
		<!--  footer start  -->
	<?
		include "common/common_footer.php";
	?>
		</div>
	
	
	
	</body>
</html>









