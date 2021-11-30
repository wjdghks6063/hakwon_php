<?
	include "common/common_header.php";
	include "common/dbconnect.php";

	$no 	= $_POST["t_no"];
	$t_page = $_POST["t_page"];
	
	$query ="select a.no, a.title, a.content, a.attach, b.name, a.reg_date, a.shop_name, ".
			"a.price_code, DATE_ADD(NOW(), INTERVAL 2 DAY) as maybeday from h_shop a, h_member b ".
			"where a.reg_id = b.id and a.no='$no'; ";
	$result = mysqli_query($connect,$query);

	$row = mysqli_fetch_array($result);

	/* 한글로 요일 표시 및 현재 시간에서 2일 뒤 */
	$yoil_text_set = array("일","월","화","수","목","금","토");
	$yoil = $yoil_text_set[date('w', strtotime($row['maybeday']))];
	$month = date("m", strtotime($row['maybeday']));
	$day = date("d", strtotime($row['maybeday']));   

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
			
			mem.point.value = number;
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
					<span> <?=$row["shop_name"]?> | <?=$row["reg_date"]?> | </span></h3>
					<span class="maybedaybig"> 배송 예정일자 :</span> <span class="maybeday"> <?=$month?>-<?=$day?>-<?=$yoil?> 도착 예정</span>
					<? include("shop/_m3rating.php"); //별점평가?>
					
				<p class="txt"><?=$row["content"]?></p>
				
					<!-- 상품 구매 버튼 -->
					<div class="prod-buy-quantity-and-footer">
						<div class="prod-buy-quantity">
							<div class="prod-buy__quantity">
								<div class="prod-quantity__form">
									<input type="text" value="1" class="prod-quantity__input" maxlength="6" autocomplete="off"
										oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1')">
								<div style="display:table-cell;vertical-align:top;">
									<button class="prod-quantity__plus" type="button">수량빼기</button>
									<button class="prod-quantity__minus" type="button" disabled="">수량더하기</button>
								</div>
								</div>
							</div>
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









