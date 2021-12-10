<?
	include "common/common_header.php";
	include "common/dbconnect.php";

/**************************page setting********************************/
/*pagingSetting.php와 같은 변수명으로 사용해야 작동 하기 때문에 양쪽의 변수명을 맞춰준다. */

	$countTotal =" select * from h_basket "; /*페이지를 정할 db 명 */ 
	$countOnePage = "10"; // 한 페이지당 보여줄 목록 수 (?)행 보여주겠다.
	$perblock = 5;		 // 한 페이지당 보여줄 페이지 번호 수 < 1 2 3 4 5 >

	include "common/pagingSetting.php"; //변수명들을 넣어줘야 작동되기 때문에 변수명 아래쪽에 include 해준다.
	$t_page =$_POST['t_page']; // view에 갔다가 목록이나 뒤로 가기를 했을 때 현재 페이징 넘버로 가질 수 있게 해준다.
/**********************************************************************/

	$query ="SELECT a.no, a.attach, a.title, b.price_num, b.price, b.reg_date, a.shop_name, a.stuff_number, b.price_code, b.orderno, b.id FROM h_shop a, h_basket b ".
			"where a.price_code = b.price_code ".
			"and b.id = '$session_id' ".
			"order by orderno desc ".
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
	function goView(no){
		view.t_no.value=no;
		view.method="post";
		view.action="/shop/shop_view.php";
		view.submit();
	}
	function goPage(pageNumber){		
		pageForm.t_page.value = pageNumber;
		pageForm.method ="post";
		pageForm.action ="basket_list.php";
		pageForm.submit();
	}
	function goDelete(orderno){
		if(confirm("장바구니에서 제외 하시겠습니까?")){
			price_form.t_orderno.value=orderno;
			price_form.method="post";
			price_form.action="db_basket_delete.php";
			price_form.submit();
		}
	}
	function goCheckDelete(){
		if(confirm("선택한 상품을 장바구니에서 제외 하시겠습니까?")){
			price_form.t_orderno.value=orderno;
			price_form.method="post";
			price_form.action="db_basket_delete.php";
	//		price_form.submit();
		}
	}
	function goCheckbuy(){
		if(confirm("선택한 상품을 구매 하시겠습니까?")){
			notiArr.method="post";
			notiArr.action="db_buy_basket.php";
			notiArr.submit();
		}
	}

	function goUpdateHit(index){ //goUpdateHit('<?=$k?>') 로 몇번째 자리의 번호를 받아온다.

		var ff = notiArr.t_check;
		
		var gubun = Object.prototype.toString.call(ff); //명령어에 배열 반복 돌리는것(value)를 넣어준다.
			alert(gubun);
		//배열일 경우 ex)같은 이름을 가진게 2개 이상 있을 떄 [object RadioNodeList] // 배열이 아닐 때 ex)같은 이름이 1개만 있을 때 [object HTMLInputElement]
		if(gubun == "[object RadioNodeList]"){ //gubun에 [object RadioNodeList] = 같은 이름을 가진 배열이 2개 이상 돌 때
//			alert("배열이다");
		
		//	alert(notiArr.t_check[index].checked); //체크 여부 테스트
		/*notiArr.t_check[index]의 값을 넘겨주는것이 아니라 .checked로 체크 여부로 조회한다. */

		
		if(notiArr.t_check[index].checked == true) { //체크 하여 ture로 나온 경우 value 값을 y로 준다.
			notiArr.t_check[index].value = 'y';
		}else{
			notiArr.t_check[index].value = 'n';	// 체크 되지 않아 false로 나온 경우 value값을 n으로 준다.
		}
	
		//	alert(notiArr.t_check[index].value); // check 여부에 따라 y,n으로 표시된다.
			
			var check = notiArr.t_check[index].value; //배열인 경우 번호값을 넣어줘서 몇번쨰 자리의 값인지 찾아준다. 
			var orderno = notiArr.t_orderno[index].value;
			var price_num = notiArr.t_price_num[index].value;

			//테스트
		//	alert("상품 리스트 번호 : "+orderno);
		//	alert("체크 여부 : "+check); 
		//	alert("상품 수량 : "+price_num);
			
		//	hitForm.t_no.value=no;

			price_form.t_check.value= check; 
			price_form.t_orderno.value= orderno;
			price_form.t_price_num.value= price_num;

		} else{ //하나만 있을 때

		
			//	alert(notiArr.t_check.checked); true,false 구분
			if(notiArr.t_check.checked == true) { //체크 하여 ture로 나온 경우 value 값을 y로 준다.
				notiArr.t_check.value = 'y';
			}else{
				notiArr.t_check.value = 'n';	// 체크 되지 않아 false로 나온 경우 value값을 n으로 준다.
			}
		

			var check = notiArr.t_check.value; 
			var orderno = notiArr.t_orderno.value;
			var price_num = notiArr.t_price_num.value; //번호가 1개라 배열이 없는 경우는 [index]로 자리를 찾지 않는다.
			
			price_form.t_check.value= check; 
			price_form.t_orderno.value= orderno;
			price_form.t_price_num.value= price_num;
			
		//	alert(check); 
		//	alert(orderno);
		//	alert(price_num);
		}
		
		price_form.method="post";
		price_form.action="/notice/db_notice_hitupdate.php";
		price_form.submit();
	}
</script>
<form name="view">
	<input type="hidden" name="t_no">
</form>

<form name="price_form">
	<input type="hidden" name="t_check">
	<input type="hidden" name="t_orderno">
	<input type="hidden" name="t_price_num">
</form>

<form name ="pageForm">
	<input type="hidden" name="t_page">
</form>

		<!-- sub page start -->
		<div class="notice">
			<div class="sub-notice">
			<h2><a href="/info/myinfo_view.php">캐쉬 충전</a></h2>	
			<h2 class="color"><a href="/basket/basket_list.php"> <i class="fas fa-check"></i>장바구니</a></h2>
			<h2><a href="/basket/basket_buy_list.php">상품 구매 내역</a></h2>	
			</div>
			
			<!-- table start-->
		<div style="float: right; padding: 20px 50px; font: size 14px;">내 포인트 : <?=$point['point']?> \</div>
			<div class="table-box">
				<table class="table">
					<caption>공지사항 - 번호, 제목, 첨부, 작성일, 조회수</caption>
					<colgroup>
						<col width="4%">
						<col width="8%">
						<col width="*%">
						<col width="8%">
						<col width="12%">
						<col width="10%">
						<col width="12%">
                        <col width="5%">
					</colgroup>
					
					<thead>
						<tr>
							<th scope="col"><input type="checkbox" id="cbx_chkAll"></th>
							<th scope="col">사진</th>
							<th scope="col">제품명</th>
							<th scope="col">구매 수량</th>
							<th scope="col">금액</th>
							<th scope="col">담은시간</th>
                            <th scope="col">상호명</th>
							<th scope="col">제거</th>
						</tr>
					</thead>
					
					<tbody>
			<form name ="notiArr">	
				<?for($k=0;$k<$count;$k++){ //압축되어있는 놈을 한줄씩한줄씩 뺴서 로우에 담는다
						$row = mysqli_fetch_array($result);
				?>	
					<tr>
						<td>
							<input type="hidden" name="t_orderno" value="<?=$row["orderno"]?>">
							<input type="hidden" name="t_price_num" value="<?=$row["price_num"]?>">
							<input type="hidden" name="t_price_code" value="<?=$row["price_code"]?>">
							<input type="checkbox" name="t_check" size="3">
							<button type="button" onclick="goUpdateHit('<?=$k?>')">Hit update</button> <!--k는 for($k=0;$k<$count;$k++) 의 카운트 숫자 / 몇번째 자리인가 -->
						</td>		
						<td><a href="javascript:goView('<?=$row["no"]?>')"><span class="img"><img class="mini_img" src="/file_room/shop/<?=$row["attach"]?>" alt="shop1"></span></a></td>
						<td><a href="javascript:goView('<?=$row["no"]?>')"><?=$row["title"]?></td>
						<td><?=$row["price_num"]?></td>
						<td><?=number_format($row["price_num"]*$row["price"])?></td><!--number_format으로 숫자값에 ,를 찍어준다.-->
						<td><?=$row["reg_date"]?></td>
						<td><?=$row["shop_name"]?></td>
						<td><a href="javascript:goDelete('<?=$row["orderno"]?>')"><i class="fas fa-trash"></i></a></td>
			<?}?>
			</form>
					</tr>

                    <script>
						
						$(document).ready(function() {
							$("#cbx_chkAll").click(function() { //<input type="checkbox" id="cbx_chkAll"> 가 체크 될 때 작동한다.
								if($("#cbx_chkAll").is(":checked")) $(".table input[name=t_check]").prop("checked", true); // 전체 체크가 체크 되었다면 input type 이름이 t_check인 것들은 checked 값이 ture(체크)가 된다.
								else $(".table input[name=t_check]").prop("checked", false); //input name이 중복 된다면 범위를 지정할수도 있다. .table input[name=t_chkbox] 이런식으로 테이블 범위로만  한정할 수도 있다.
							});
							
							$(".table input[name=t_check]").click(function() {
								var total = $(".table input[name=t_check]").length;
								var checked = $(".table input[name=t_check]:checked").length;

								if(total != checked) $("#cbx_chkAll").prop("checked", false);
								else $("#cbx_chkAll").prop("checked", true); 
							});
						});

                    </script>

					</tbody>
				</table>
			</div>
			
			<div class="page-number1">
		<?	include "common/pagingDisplay.php"; ?>	
<!--			<a href="#" class="icon"><i class="fas fa-arrow-circle-left fa-lg"></i></a>
				<a href="#" class="on">1</a>
				<a href="#">2</a>
				<a href="#">3</a>
				<a href="#">4</a>
				<a href="#">5</a>
				<a href="#">6</a>
				<a href="#">7</a>
				<a href="#">8</a>
				<a href="#">9</a>
				<a href="#" class="more">…</a>
				<a href="#" class="icon"><i class="fas fa-arrow-circle-right fa-lg"></i></a>
-->			
			</div>
			<div class="page-number">
                <a href="javascript:goCheckDelete()" class="btn-write1">삭제</a>
				<span style="background-color: green;"><a href="javascript:goCheckbuy()" class="btn-write2">구매</a>
			</div>
		
		</div>
		
		
		
		<!--  footer start  -->
	<?
		include "common/common_footer.php";
	?>
		</div>
	
	
	
	</body>
</html>

