<?
	include "common/common_header.php";
	include "common/dbconnect.php";

	$no 	= $_POST["t_no"];
	$t_page = $_POST["t_page"];
	
	$query ="select a.no, a.title, a.content, a.attach, b.name, a.reg_date, a.shop_name, ".
			"a.price_code, DATE_ADD(NOW(), INTERVAL 2 DAY) as maybeday, FORMAT(a.price , 0) as price, a.stuff_number from h_shop a, h_member b ".
			"where a.reg_id = b.id and a.no='$no' ";
	$result = mysqli_query($connect,$query);

	$row = mysqli_fetch_array($result);
	
	/* 한글로 요일 표시 및 현재 시간에서 2일 뒤 */
	$yoil_text_set = array("일","월","화","수","목","금","토");
	$yoil = $yoil_text_set[date('w', strtotime($row['maybeday']))];
	$month = date("m", strtotime($row['maybeday']));
	$day = date("d", strtotime($row['maybeday']));   

	/*textarea 줄바꿈 처리 */
	$content=$row['content']; //row에서 content를 빼낸 뒤 $content로 변환해 준다.
	$t_content = nl2br($content); /* 빼준 content를 nl2br($content)로 처리하여 줄바꿈을 인식 시킨뒤 t_content로 바꿔준 뒤 <?=$t_content?>로 사용하면 된다. */
?>		

<script>
	function goUpdate(){
		shop.method="post";
		shop.action="shop_update.php";
		shop.submit();
	}
	function goDelete(){
		if(confirm("정말 삭제하시겠습니까?")){
		shop.method="post";
		shop.action="db_shop_delete.php";
		shop.submit();
		}
	}
	function goBack(){
		goBackPage.method ="post";
		goBackPage.action ="shop_list.php";
		goBackPage.submit();
	}


	// 아래 수량 카운트로 교체함

	/*물건 수량 카운트 및 카운트에 따른 가격 변환 */ 

	// function count(type)  { // +,- 여부
	// 	// 결과를 표시할 element
	// 	var count = document.getElementById('price_num').value; //input 상자의 값을 count에 넣는다.
	// 	//porm이 있을 경우 formName.price_num.value 로 가져온다. ex) mem.point.value;
	// 	//porm이 없을 경우 document.getElementById('price_num').value 이런식으로 가져올수 있다. input 상자의 id가 price_num
	// 	//alert(count);
		
	// 	// 더하기/빼기
	// 	if(type === 'plus') {
	// 		count = Number(count) + 1; //var는 문자로 인식하기 때문에 더하기 위해서 Number로 int로 바꿔준다.
	// 		if(count > 50){ count = 50;
	// 			alert("수량은 50개 까지만 구입가능합니다.")
	// 		}	
	// 	//alert(count);
	// 	}else if(type === 'minus')  {	
	// 		count = Number(count) - 1;
	// 		if(count < 1) count = 1; // 1 이하로 내려갈 경우 1로 바꿔준다.
	// 	}

	// 	/*물건 수량에 따른 제품 총합값 변환 */
	// 	var total_price = document.getElementById('total_price_ori').value; //콤마 들어간 숫자값 // 원래 상품 가격 hidden으로 숨겨놓음
	// 	/* total_price_ori 를 사용하지 않으면 500*2 해서 1000이 되었다면 total_price 값이 1000 이 되어 1000*3 이 되어버리기 때문에 total_price_ori로 total_price의 값을
	// 	500 원으로 초기화 시키고 *(숫자)를 해준다.*/
		
	// 	total_price = total_price.replace(",", ""); //콤마가 있으면 계산이 안되기 때문에 콤마 있는 total_price 의 콤마 제거해서 다시 total_price 에 넣는다.

	// 	total_price = Number(total_price)*Number(count); //물건 금액에 카운트 숫자값을 곱해준다.
		
	// 	var total_price = total_price.toLocaleString(); // 콤마 제거 숫자값에 다시 ,를 해준다.

	// 	document.getElementById('total_price').value = total_price; //더해진 값을 다시 input 상자에 넣어준다.

	// 	/*물건 수량 */
	// 	document.getElementById('price_num').value = count; //더해진 값을 다시 input 상자에 넣어준다.
//	}
		
</script>

<script type="text/javascript">

$(document).ready(function() {    

	$('#plus').click(function(){ //plus 버튼을 눌르면 작동 된다.

		var count = document.getElementById('price_num').value; //input 상자의 값을 count에 넣는다.
		//porm이 있을 경우 formName.price_num.value 로 가져온다. ex) mem.point.value;
		//porm이 없을 경우 document.getElementById('price_num').value 이런식으로 가져올수 있다. input 상자의 id가 price_num
		//alert(count);
		
		// 더하기/빼기
			count = Number(count) + 1; //var는 문자로 인식하기 때문에 더하기 위해서 Number로 int로 바꿔준다.
			if(count > <?=$row["stuff_number"]?>){ 
				alert("최대 수량 이상으로는 구매하실 수 없습니다.")
			}else{
				var total_price = document.getElementById('total_price_ori').value; //total_price 의 값은 물건 1개 가격
					//alert(count);
					document.getElementById('price_num').value = count; //더해진 값을 다시 input 상자에 넣어준다.

					total_price = total_price.replace(",", ""); //콤마가 있으면 계산이 안되기 때문에 콤마 있는 total_price 의 콤마 제거해서 다시 total_price 에 넣는다.

					total_price = Number(total_price)*Number(count); //물건 금액에 카운트 숫자값을 곱해준다.

					var total_price = total_price.toLocaleString(); // 콤마 제거 숫자값에 다시 ,를 해준다.

					document.getElementById('total_price').value = total_price; //더해진 값을 다시 input 상자에 넣어준다.

					$("#span_total_price").text(total_price); //span 안에 input 의 값을 넣어준다.
			}	
		//alert(count);
		
	});

	$('#minus').click(function(){ // 마이너스 버튼을 누르면 작동한다.

		var count = document.getElementById('price_num').value; //input 상자의 값을 count에 넣는다.
		//porm이 있을 경우 formName.price_num.value 로 가져온다. ex) mem.point.value;
		//porm이 없을 경우 document.getElementById('price_num').value 이런식으로 가져올수 있다. input 상자의 id가 price_num
		//alert(count);
		
			// 더하기/빼기
			count = Number(count) - 1; //var는 문자로 인식하기 때문에 더하기 위해서 Number로 int로 바꿔준다.
				if(count < 1){ count = 1;
		
				}else{
					var total_price = document.getElementById('total_price_ori').value; //total_price는 물건 1개 가격
						//alert(count);
						document.getElementById('price_num').value = count; //더해진 값을 다시 input 상자에 넣어준다.

						total_price = total_price.replace(",", ""); //콤마가 있으면 계산이 안되기 때문에 콤마 있는 total_price 의 콤마 제거해서 다시 total_price 에 넣는다.

						total_price = Number(total_price)*Number(count); //물건 금액에 카운트 숫자값을 곱해준다.

						var total_price = total_price.toLocaleString(); // 콤마 제거 숫자값에 다시 ,를 해준다.

						document.getElementById('total_price').value = total_price; //더해진 값을 다시 input 상자에 넣어준다.

						$("#span_total_price").text(total_price); //span 안에 input 의 값을 넣어준다.
				}	
			//alert(count);
	});

	$("#price_num").keyup(function(){ //키보드 키를 누를 때 작동한다. //물건 수량
		
		var count = document.getElementById('price_num').value; //input 상자의 값을 count에 넣는다. count에 물건 수량 value 값을 넣는다.
		var total_price = document.getElementById('total_price_ori').value; // 물건 1개 값. 

			if(count == "0"){ count = 1; //물건 수량 칸의 값이 빈칸이거나 0인 경우 수량을 1로 바꾼다.
				document.getElementById('price_num').value = count; //바꾼 수량 값 1을 수량 입력칸에 넣어준다.
				
				document.getElementById('total_price').value = total_price; //물건 가격란에 var total_price 값인 1개 가격을 넣어준다.

				$("#span_total_price").text(total_price); //span 안에 input 의 값을 넣어준다.
			
			}if(count == ""){ count = 1; // input이 공백인 경우 수량의 value 값은 1인 상태로 한다. 하지만 input 박스 안은 표시값을 넘겨주지 않아 공백으로 보이게 처리한다.

			}else{

				document.getElementById('price_num').value = count; //더해진 값을 다시 input 상자에 넣어준다.
				total_price = total_price.replace(",", ""); //콤마가 있으면 계산이 안되기 때문에 콤마 있는 total_price 의 콤마 제거해서 다시 total_price 에 넣는다.
				total_price = Number(total_price)*Number(count); //물건 금액에 카운트 숫자값을 곱해준다.

				var total_price = total_price.toLocaleString(); // 콤마 제거 숫자값에 다시 ,를 해준다.
				document.getElementById('total_price').value = total_price; //더해진 값을 다시 input 상자에 넣어준다.
				$("#span_total_price").text(total_price); //span 안에 input 의 값을 넣어준다.
			}	
	});

	$("#price_num").blur(function(){ //input 안의 포커스가 해제 될 때 작동한다. //물건 수량
		
		var count = document.getElementById('price_num').value; //input 상자의 값을 count에 넣는다. count에 물건 수량 value 값을 넣는다.
		var total_price = document.getElementById('total_price_ori').value; // 물건 1개 값. 
		
			if(count == ""){ count = 1; //물건 수량 칸의 값이 빈칸인 경우 포커스가 해제되면 1이 된다.
				document.getElementById('price_num').value = count; //바꾼 수량 값 1을 수량 입력칸에 넣어준다.
				
				document.getElementById('total_price').value = total_price; //물건 가격란에 var total_price 값인 1개 가격을 넣어준다.

				$("#span_total_price").text(total_price); //span 안에 input 의 값을 넣어준다.
			}
	});

});

function checkcount(obj) { //onkeyup="checkcount(this)" 으로 키값이 들어 올때마다 이 funtion을 실행한다.
	var co = obj.value; //obj = input 상자의 value
	var maxco = document.getElementById('maxcount').value; //<input type="hidden" id="maxcount" value="<?=$row["stuff_number"]?>">으로 최대수량 value를 가져온다.
	if(Number(co) > Number(maxco)){ //구매 수량이 최대 물건 수량을 넘기면
		document.getElementById('price_num').value = maxco; //물건 수량의 value는 최대 수량이 된다.
		alert("최대 수량 이상으로는 구매하실 수 없습니다.")
	}
	//alert(maxco);
}
</script>

		<!--  header end -->
<form name="shop">
	<input type="hidden" name="t_no" value="<?=$no?>">
	<input type="hidden" name="t_page" value="<?=$t_page?>">
	<input type="hidden" name="t_attach" value="<?=$row['attach']?>">
</form>

<form name ="goBackPage">
	<input type="hidden" name="t_page" value="<?=$t_page?>">
</form>		
		
		<!-- sub page start -->
		<div class="notice">
			<div class="sub-notice">
			<h2><a href="/notice/notice_list.php">NOTICE</a></h2>	
			<h2><a href="/qna/qna_list.php"> QnA</a></h2>
			<h2><a href="/faq/faq_list.php"> FAQ</a></h2>	
			<h2 class="color"><a href="shop_list.php"><i class="fas fa-check"></i> SHOP</a></h2>	
			</div>
			
			<!-- sub-news start-->			
			<div class="contnews">
				<!--상품 사진-->
					<span class="img"><img src="/file_room/shop/<?=$row["attach"]?>" alt="뉴스1" class="img" "></span>	
					<!--상품 상세 설명란 -->
				<div class ="price-box">
					<h3><?=$row["title"]?><br>
					<span> <?=$row["shop_name"]?> | <?=$row["reg_date"]?> | </span></h3><br>
					<span><? include("shop/_m3rating.php"); //별점평가?></span><br>
					<div class="maybeday">	
						<span class="maybedaybig"> 배송 예정일자 :</span> <span class="maybeday"> <?=$month?>-<?=$day?>-( <?=$yoil?> ) 도착 예정</span>
					</div>
					<span class="total_price">
					<!--input type의 값을 span으로 불러와 사용하기 떄문에 inputtype을 만들어 숨겨둔다. -->		
						<input type="hidden" name="total_price" id="total_price" value="<?=$row["price"]?>">
					<!--상품 가격에 곱하기를 하면 곱해진 값에 곱하기를 하기때문에 원래 상품가격을 hidden 으로 만들어둔다.-->
					<input type="hidden" id="total_price_ori" value="<?=$row["price"]?>">
					</span>

					<div class="prod-sale-price  wow-coupon-discount ">
						<h3><span class="total-price" name="total_price" id="span_total_price" ><?=$row["price"]?>	
						</span><span class="won" id="won">원 </span></h3>
					</div>
				
					<div class="stuff_number"><span> 현재 수량: <?=$row["stuff_number"]?> 개</span></div>
					<!--전체 수량-->
					<input type="hidden" id="maxcount" value="<?=$row["stuff_number"]?>">
					
				<p class="txt"><?=$t_content?></p>
				
					<!-- 상품 구매 버튼 -->
					<div class="prod-buy-quantity-and-footer">
						<div class="prod-buy-quantity">
							<div class="prod-buy__quantity" style="width: 50px;" >
								<div class="prod-quantity__form"> <!--checkcount(this) this는 input 상자를 말한다. -->
									<input type="text" onkeyup="checkcount(this)" name="price" id="price_num" value="1" class="prod-quantity__input" maxlength="50" autocomplete="off"
										oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1')">
								<div style="display:table-cell;vertical-align:top;">
									<button class="prod-quantity__plus" id="plus" type="button" onclick='count("plus")' >수량더하기</button>
									<button class="prod-quantity__minus" id="minus" type="button" onclick='count("minus")' >수량빼기</button>
								</div>

								</div>

							</div>
						</div>
					<!-- 장바구니, 구매 버튼 -->
					<div class="prod-buy-footer ">
						<div class="prod-order-data" style="display:none;"></div>
						<div class="prod-onetime-order">
							<button class="prod-cart-btn" id="prod-cart-btn"">
								<i class="fas fa-cart-arrow-down"></i> 장바구니 담기
							</button>
							<button class="prod-buy-btn" id="prod-buy-btn">
								<span class="prod-buy-btn__txt">바로구매</span>
							</button>
						</div>

						<div class="prod-buy-quantity-and-footer__oos-or-unavailable" style="display: none;">
							품절
						</div>
					</div>
			
					</div>

					<script type="text/javascript" language="javascript">
						$(document).ready(function(){
							$('#prod-cart-btn').click(function(){ //클릭시 장바구니에 담아진다.
								
								var id = "<?=$session_id?>"; //common_header 값을 불러다 쓴다.
								
								var t_price_code = "<?=$row["price_code"]?>"; // query문의 물건 코드값을 가져온다.
								
								var t_price = $("#total_price_ori").val(); //css 처럼 $("#total_price_ori") id의 value값을 가져온다.
								var t_price = t_price.replace(",", ""); // db에 집어넣을것이기 때문에 ,를 제거 작업해준다.
								
								var t_price_num = $("#price_num").val(); //css 처럼 id="price_num"의 value를 가져온다.

								var t_price_name = "<?=$row["title"]?>";

								var stuff_number = "<?=$row["stuff_number"]?>";

								if(stuff_number == 0){
									alert("품절입니다.");
									return;
								}

								if(id ==""){
									alert("로그인 후 이용 가능합니다.");
									return;
								}

								$.ajax({
									type : "POST",
									/*async: false 속성이 추가  jQuery의 Ajax호출은 async: true가 기본이며, 이 속성을 기입하지 않는다면 기본적으로 비동기식으로 동작하게 됩니다. 
									하지만 이 속성을 false로 설정하게되면 동기식방식으로 
									이제 ajax를 호출하여 서버에서 응답을 기다렸다가 응답을 모두 완료한 후 다음 로직을 실행하는 동기식으로 변경한 것입니다.*/

									async: false, // 이걸 사용 하면 반복문 돌듯이 한번에 var들이 실행되지 않고 var id 를 받고 다시 위에서부터 내려온다.									
									url : "db_pushBasket.php",
									data: "t_id="+id+"&t_price_code="+t_price_code+"&t_price="+t_price+"&t_price_num="+t_price_num+"&t_price_name="+t_price_name,
									error : function(){
										alert('통신실패!!');
									},
									success : function(data){
										alert(data) ;
										$("#dataArea").html(data) ;
									}
									
								});
							

							});
						

							$('#prod-buy-btn').click(function(){ //클릭시 장바구니에 상품을 담고 장바구니로 이동한다.
								
								var id = "<?=$session_id?>"; //common_header 값을 불러다 쓴다.
								
								var t_price_code = "<?=$row["price_code"]?>"; // query문의 물건 코드값을 가져온다.
								
								var t_price = $("#total_price_ori").val(); //css 처럼 $("#total_price_ori") id의 value값을 가져온다.
								var t_price = t_price.replace(",", ""); // db에 집어넣을것이기 때문에 ,를 제거 작업해준다.
								
								var t_price_num = $("#price_num").val(); //css 처럼 id="price_num"의 value를 가져온다.

								var t_price_name = "<?=$row["title"]?>";

								var stuff_number = "<?=$row["stuff_number"]?>";

								if(stuff_number == 0){
									alert("품절입니다.");
									return;
								}

								if(id ==""){
									alert("로그인 후 이용 가능합니다.");
									return;
								}

								$.ajax({
									type : "POST",
									/*async: false 속성이 추가  jQuery의 Ajax호출은 async: true가 기본이며, 이 속성을 기입하지 않는다면 기본적으로 비동기식으로 동작하게 됩니다. 
									하지만 이 속성을 false로 설정하게되면 동기식방식으로 
									이제 ajax를 호출하여 서버에서 응답을 기다렸다가 응답을 모두 완료한 후 다음 로직을 실행하는 동기식으로 변경한 것입니다.*/

									async: false, // 이걸 사용 하면 반복문 돌듯이 한번에 var들이 실행되지 않고 var id 를 받고 다시 위에서부터 내려온다.									
									url : "db_goBasket.php",
									data: "t_id="+id+"&t_price_code="+t_price_code+"&t_price="+t_price+"&t_price_num="+t_price_num+"&t_price_name="+t_price_name,
									error : function(){
										alert('통신실패!!');
									},
									success : function(data){
										location.href="/basket/basket_list.php";
										$("#dataArea").html(data) ;
									}
									
								});
							

							});
						});


					</script>

							
				</div>	
			</div>

			
			<div class="list1">
			<?if($session_level == 'top'){?>	
				<a href="javascript:goUpdate()">수정</a>&nbsp;&nbsp; <!--이전화면-->
				<a href="javascript:goDelete()">삭제</a>&nbsp;&nbsp; <!--이전화면-->
			<?}?>
				<a href="javascript:goBack()">목록</a>&nbsp;&nbsp; <!--이전화면-->
			</div>
		</div>
		
		</div>
		
		
		
		<!--  footer start  -->
		<?
			include "common/common_footer.php";
		?>
		</div>
	
	
	
	</body>
</html>









