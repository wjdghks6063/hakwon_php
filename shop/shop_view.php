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

	/*물건 수량 카운트 및 카운트에 따른 가격 변환 */

	function count(type)  { // +,- 여부
		// 결과를 표시할 element
		var count = document.getElementById('price_num').value; //input 상자의 값을 count에 넣는다.
		//porm이 있을 경우 formName.price_num.value 로 가져온다. ex) mem.point.value;
		//porm이 없을 경우 document.getElementById('price_num').value 이런식으로 가져올수 있다. input 상자의 id가 price_num
		//alert(count);
		
		// 더하기/빼기
		if(type === 'plus') {
			count = Number(count) + 1; //var는 문자로 인식하기 때문에 더하기 위해서 Number로 int로 바꿔준다.
			if(count > 50){ count = 50;
				alert("수량은 50개 까지만 구입가능합니다.")
			}	
		//alert(count);
		}else if(type === 'minus')  {	
			count = Number(count) - 1;
			if(count < 1) count = 1; // 1 이하로 내려갈 경우 1로 바꿔준다.
		}

		/*물건 수량에 따른 제품 총합값 변환 */
		var total_price = document.getElementById('total_price_ori').value; //콤마 들어간 숫자값 // 원래 상품 가격 hidden으로 숨겨놓음
		/* total_price_ori 를 사용하지 않으면 500*2 해서 1000이 되었다면 total_price 값이 1000 이 되어 1000*3 이 되어버리기 때문에 total_price_ori로 total_price의 값을
		500 원으로 초기화 시키고 *(숫자)를 해준다.*/
		
		total_price = total_price.replace(",", ""); //콤마가 있으면 계산이 안되기 때문에 콤마 있는 total_price 의 콤마 제거해서 다시 total_price 에 넣는다.

		total_price = Number(total_price)*Number(count); //물건 금액에 카운트 숫자값을 곱해준다.
		
		var total_price = total_price.toLocaleString(); // 콤마 제거 숫자값에 다시 ,를 해준다.

		document.getElementById('total_price').value = total_price; //더해진 값을 다시 input 상자에 넣어준다.

		/*물건 수량 */
		document.getElementById('price_num').value = count; //더해진 값을 다시 input 상자에 넣어준다.
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
						<span class="maybedaybig"> 배송 예정일자 :</span> <span class="maybeday"> <?=$month?>-<?=$day?>-<?=$yoil?> 도착 예정</span>
					</div>
					<span class="total_price">	
					<h3><input type="text" name="total_price" id="total_price" value="<?=$row["price"]?>" readonly><span>원</span></h3>
					<!--상품 가격에 곱하기를 하면 곱해진 값에 곱하기를 하기때문에 원래 상품가격을 hidden 으로 만들어둔다.-->
					<input type="hidden" id="total_price_ori" value="<?=$row["price"]?>">
					</span>

					<!-- -->
					<div class="prod-sale-price  wow-coupon-discount ">
						<span class="total-price" name="total_price" id="total_price" >
							<?=$row["price"]?><span class="priceunit">원
						</span>
					</div>
					<script type="text/javascript">
						$(document).ready(function() {    

						$("#total_cost").text($("#total_cost_value").val()); 

						});

					</script>

						$("#total_price").text(<?=$row["price"]?>); 

					<div class="stuff_number"><span> 현재 수량: <?=$row["stuff_number"]?> 개</span></div>
					
					
				<p class="txt"><?=$t_content?></p>
				
					<!-- 상품 구매 버튼 -->
					<div class="prod-buy-quantity-and-footer">
						<div class="prod-buy-quantity">
							<div class="prod-buy__quantity" style="width: 50px;" >
								<div class="prod-quantity__form">
									<input type="text" name="price" id="price_num" value="1" class="prod-quantity__input" maxlength="50" autocomplete="off"
										oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1')">
								<div style="display:table-cell;vertical-align:top;">
									<button class="prod-quantity__plus" type="button" onclick='count("plus")' >수량더하기</button>
									<button class="prod-quantity__minus" type="button" onclick='count("minus")' >수량빼기</button>
								</div>
								</div>

							</div>
							<!-- 장바구니 구매 버튼 -->
						</div>

					<div class="prod-buy-footer ">
						<div class="prod-order-data" style="display:none;"></div>
						<div class="prod-onetime-order">
							<button class="prod-cart-btn"">
								장바구니 담기
							</button>
							<button class="prod-buy-btn">
								<span class="prod-buy-btn__txt">바로구매</span>
							</button>
						</div>

						<div class="prod-buy-quantity-and-footer__oos-or-unavailable" style="display: none;">
							품절
						</div>
					</div>
			
					</div>
							
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









