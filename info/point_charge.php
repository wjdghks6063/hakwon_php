<?
	include "common/common_header.php";
	include "common/dbconnect.php";

/**************************page setting********************************/
/*pagingSetting.php와 같은 변수명으로 사용해야 작동 하기 때문에 양쪽의 변수명을 맞춰준다. */

	$countTotal ="select * from h_point where id ='$session_id' "; /*페이지를 정할 db 명 */ 
	$countOnePage = "10"; // 한 페이지당 보여줄 목록 수 (?)행 보여주겠다.
	$perblock = 5;		 // 한 페이지당 보여줄 페이지 번호 수 < 1 2 3 4 5 >

	include "common/pagingSetting.php"; //변수명들을 넣어줘야 작동되기 때문에 변수명 아래쪽에 include 해준다.
	$t_page =$_POST['t_page']; // view에 갔다가 목록이나 뒤로 가기를 했을 때 현재 페이징 넘버로 가질 수 있게 해준다.
/**********************************************************************/

	$query ="SELECT a.no, a.id, a.title, a.use_point, a.reg_date, a.use_list FROM h_point a, h_member b ".
			"where a.id = b.id ".
			"and a.id = '$session_id' ".
			"order by no desc ".
			"limit $start, $end ";
	$result = mysqli_query($connect,$query);	
	$count = mysqli_num_rows($result); 

	$pointquery ="SELECT a.point from h_member a ".
				"where id ='$session_id' ";

	$pointresult = mysqli_query($connect,$pointquery);
	$point = mysqli_fetch_array($pointresult);

?>		


		<!--  header end -->
<script>
	function goPage(pageNumber){		
		pageForm.t_page.value = pageNumber;
		pageForm.method ="post";
		pageForm.action ="exit_list.php";
		pageForm.submit();
	}
</script>

<form name ="pageForm">
	<input type="hidden" name="t_page">
</form>

		<!-- sub page start -->
		<div class="notice">
			<div class="sub-notice">
				<h2><a href="/info/myinfo_view.php">내 정보</a></h2>
				<h2 class="color"><a href="/info/point_charge.php"><i class="fas fa-check"></i>포인트 충전,내역</a></h2>
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
						<col width="*%">
						<col width="15%">
						<col width="12%">
					</colgroup>

<!--보유 포인트 -->	<div style="float: right; padding: 0px 10px 20px; font: size 14px;">내 포인트 : <?= number_format($point['point'])?> \</div>

					<thead>
						<tr>
							<th scope="col">요청 사항</th>
							<th scope="col">이용 내역</th>
							<th scope="col">이용 일자</th>
							<th scope="col">포인트</th>
						</tr>
					</thead>
					
					<tbody>
	<?for($k=0;$k<$count;$k++){ //압축되어있는 놈을 한줄씩한줄씩 뺴서 로우에 담는다
		$row = mysqli_fetch_array($result);
	?>	
					<tr>
				<?if($row["use_list"] == 'buy'){ ?>	
						<td><span style="color:#77c16e"><?=$row["use_list"]?></span></td>
				<?}else if($row["use_list"] == 'sell'){?>
						<td><span style="color:#FF0000"><?=$row["use_list"]?></span></td>
				<?}else{?>
						<td><span style="color: #ccc;"><?=$row["use_list"]?></span></td>	
				<?}?>

						<td>상품 구매 : <?=$row["title"]?></td>
						<td><?=$row["reg_date"]?></td>

				<?if($row["use_list"] == 'buy'){ ?>	
						<td><span style="color:#77c16e">+ <?=$row["use_point"]?></span></td>
				<?}else if($row["use_list"] == 'sell'){?>
						<td><span style="color:#FF0000">- <?=$row["use_point"]?></span></td>
				<?}else{?>
						<td><span style="color: #ccc;">(+ <?=$row["use_point"]?>)</span></td>	
				<?}?>	
					</tr>
					
	<?}?>		
					</tbody>
				</table>
			</div>

			<div id="my_modal">
				<a class="modal_close_btn">x</a> <!--닫기 버튼-->
			<form name="point_shop">
				<input type="hidden" name="t_id"> <!--id값을 넘겨준다.-->
				<div class ="all_point">
				<ul>
					<a href="javascript:buy_btn()" value='+ 1000' id="1000btn">
					<li>	
						<div class="point_btn">
							<span class="point">1,000</span><span class="small"> P</span>
						</div>
						<p>1,000 \</p>
					</li>
					</a>
					<a href="javascript:buy_btn()" id="5000btn">
					<li>
						<div class="point_btn">
							<span class="point">5,000</span><span class="small"> P</span>
						</div>
						<p>5,000 \</p>
					</li>
					</a>
					<a href="javascript:buy_btn()" id="10000btn">
					<li>
						<div class="point_btn">
							<span class="point2">10,000</span><span class="small"> P</span>
						</div>
						<p>10,000 \</p>
					</li>
					</a>
					<a href="javascript:buy_btn()" id="50000btn">
					<li>
						<div class="point_btn">
							<span class="point2">50,000</span><span class="small"> P</span>
						</div>
						<p>50,000 \</p>
					</li>
					</a>
				</ul>
				</div>
				<div class="maybe-btn">
					<input type="hidden" id="point" name="t_use_point" value="">
					<span style="float: right;">충전 포인트: <span id="charge_point">0</span> P</span>
				</div>
				<div class="maybe-btn">
					<input type="hidden" id="full_point" name="t_now_point" value="<?=$row['point']?>">
					<input type="hidden" id="fix_full_point" value="<?=$point['point']?>">
					<span style="float: right;">충전 후 포인트: <span id="fully_charged"><?=number_format($row["point"])?></span> P</span>
				</div>
			</form>
	
			<a href="javascript:goSave('<?=$session_id?>')" class="cash_charge_btn" style="cursor: pointer;"><!--결제 버튼-->
				<div class ="charge_btn">
					결제 하기 
				</div>
			</a>

			</div>
			<div class="page-number">			
				<span class="btn-write" id="popup_open_btn">충전 요청</span>
			</div>

			<script>
				$(document).ready(function () {
					$("#1000btn").click(function(){ // #1000btn 버튼을 클릭 하면 작동한다.
						$("#5000btn").children("li").css("border", "3px solid #ccc"); //버튼들의 색상을 #ccc로 바꾼다.
						$("#10000btn").children("li").css("border", "3px solid #ccc");
						$("#50000btn").children("li").css("border", "3px solid #ccc");

						$(this).children("li").css("border", "3px solid red"); //클릭한 버튼의 색상은 빨간테를 두른다.
						$("#point").val(1000).trigger('change'); //hidden 충전 포인트의  value가 1000으로 바뀐다.
					});
					$("#5000btn").click(function() {
						$("#1000btn").children("li").css("border", "3px solid #ccc");
						$("#10000btn").children("li").css("border", "3px solid #ccc");
						$("#50000btn").children("li").css("border", "3px solid #ccc");

						$(this).children("li").css("border", "3px solid red");
						$("#point").val(5000).trigger('change'); //hidden 충전 포인트의 value가 5000으로 바뀐다.
					});
					$("#10000btn").click(function() {
						$("#5000btn").children("li").css("border", "3px solid #ccc");
						$("#1000btn").children("li").css("border", "3px solid #ccc");
						$("#50000btn").children("li").css("border", "3px solid #ccc");

						$(this).children("li").css("border", "3px solid red");
						$("#point").val(10000).trigger('change'); //hidden 충전 포인트의 value가 10000으로 바뀐다.
					});
					$("#50000btn").click(function() {
						$("#5000btn").children("li").css("border", "3px solid #ccc");
						$("#1000btn").children("li").css("border", "3px solid #ccc");
						$("#10000btn").children("li").css("border", "3px solid #ccc");

						$(this).children("li").css("border", "3px solid red");
						$("#point").val(50000).trigger('change'); //hidden 충전 포인트의 value가 50000으로 바뀐다.
					});

					$("#point").change(function() { //충전 포인트의 값이 바뀔때 작동한다.
						$("#charge_point").html(Number($(this).val()).toLocaleString()); //hidden 충전 포인트 값이 span 충전포인트(보여지는 값)의 값으로 자동으로 ,를 찍어서 들어간다. ex) 1000 =  1,000
						var full_point = Number($("#fix_full_point").val()) + Number($("#point").val()); //var = full_point 를 만들고 안에 포인트 값 fix_full_point에 충전할 금액을 더한다.
						$("#fully_charged").html(full_point.toLocaleString()); // 충전 후 포인트의 span 값인 #fully_charged 에 자동콤마처리를 해서 넣어준다.(html은 change 와 비슷하다.)
						$("#full_point").val(full_point).trigger('change'); 
						// hidden 값인 id= full_point에 value를 var = full_point 값으로 바꿔준다. // var = full_point에 fix_full_point를 full_point로 바꾸면 계속 금액이 더해지지만 hidden으로 원래 값에서 더하기를 처리해서 더하기를 방지함
					});

				});

				function goSave(id) {
					if(checkValue(point_shop.t_use_point,"충전포인트를 클릭해주세요.")) return;
					point_shop.t_id.value = id;
					point_shop.method ="post";
					point_shop.action ="db_point_save.php";
					point_shop.submit();
				}


			</script>
<style>
#my_modal { display: none; width: 600px; height:600px; padding: 20px 60px; background-color: #fefefe; border: 1px solid #888; border-radius: 3px;}
#my_modal .modal_close_btn { position: absolute; top: 10px; right: 20px; cursor: pointer;}
#my_modal .all_point{ width:100%; height:180px;  margin-top:20px;}
#my_modal li{ width: 110px; height: 150px; border: solid #ccc 3px; float:left; margin: 0px 3px; color: #d3c7c7; background-color: #f3f3f3; font-family: "Nanum Gothic",sans-serif; font-size: 24px;}
#my_modal li .point_btn{ width: 104px; height: 60px; padding-top: 20px; color:black; background-color:#ffffff;}
#my_modal li .point{text-align: center; margin-left: 15px;}
#my_modal li .point2{ text-align: center; margin-left: 8px;}
#my_modal li .small{ text-align: center; margin: 0; font-size: 18px; font-family: "Nanum Gothic",sans-serif;}
#my_modal li p{ text-align: center; margin-top: 10px;}
#my_modal .charge_btn {width: 460px; height: 60px; bottom: 10px; margin-top: 50px; padding: 20px; background-color: #d3c7c7; text-align: center;}	
#my_modal .cash_charge_btn { font-size: 22px;}
#my_modal .maybe-btn { width: 460px; height: 80px; padding: 30px 5px; font-size: 25px; margin-top: 15px; border: 1px solid #d3c7c7;}			
</style>						

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









