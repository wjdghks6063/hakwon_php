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

	$query =" SELECT a.no, b.orderno, b.id, a.title, a.attach, b.price_code, b.price, b.price_num, b.reg_date, a.shop_name, b.exception FROM h_shop a, h_buy_list b ".
			"where a.price_code = b.price_code ".
			"and id = '$session_id' ".
			"and exception = 'n' ".
			"order by orderno desc ".
			"limit $start, $end ";
	$result = mysqli_query($connect,$query);
										
	$count = mysqli_num_rows($result); 

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
		if(confirm("선택한 상품을 장바구니에서 제외 하시겠습니까?")){
			delete_form.t_orderno.value= orderno;
			delete_form.method="post";
			delete_form.action="db_buy_list_one_delete.php";
			delete_form.submit();
		}
	}
	function goCheckDelete(){
		if(typeof(notiArr.elements['t_check[]'].length)!="undefined"){ //type이 undefined 가 아닌 경우 실행 / 배열이 돌기 때문에 type은 number가 나온다. 
			var chkCount =0; //체크 카운트 생성
			var len = notiArr.elements['t_check[]'].length; //배열의 길이 (숫자로 표시)
				for(var k=0;k<len;k++){
					if(notiArr.elements['t_check[]'][k].checked==true){ //배열의 체크값 만큼 카운트가 1씩 올라간다. ex) 2개 체크시 +2
                        chkCount++;
                    }
                }
				if(chkCount==0){ //배열에 체크가 없는 경우 /카운트 0
                    alert("상품을 선택해 주세요.");
                    return;
                }
		}else{
			if(notiArr.elements['t_check[]'].checked==false){ //1개밖에 존재하지않아 배열이 없는 경우엔 배열인 [k]을 빼고 체크 여부가 false(비체크) 인 경우
				alert("상품을 선택해 주세요.");
				return;
			}
		}
			
		if(confirm("선택한 상품들을 장바구니에서 제외 하시겠습니까?")){
			notiArr.method="post";
			notiArr.action="db_check_delete_buy_list.php";
			notiArr.submit();
		}
	}
</script>

<form name="delete_form">
	<input type="hidden" name="t_orderno">
</form>

<form name="view">
	<input type="hidden" name="t_no">
</form>

<form name ="pageForm">
	<input type="hidden" name="t_page">
</form>

		<!-- sub page start -->
		<div class="notice">
			<div class="sub-notice">
			<h2><a href="/info/myinfo_view.php">캐쉬 충전</a></h2>	
			<h2><a href="/basket/basket_list.php">장바구니</a></h2>
			<h2 class="color"><a href="/basket/buy_list.php"> <i class="fas fa-check"></i>상품 구매 내역</a></h2>	
			</div>
			
			<!-- table start-->
			<div class="table-box">
				<table class="table">
					<caption>공지사항 - 번호, 제목, 첨부, 작성일, 조회수</caption>
					<colgroup>
						<col width="4%">
						<col width="8%">
						<col width="*%">
						<col width="7%">
						<col width="12%">
						<col width="10%">
						<col width="12%">
                        <col width="5%">
					</colgroup>
					
					<thead>
						<tr>
						<th scope="col"><input type="checkbox" id="cbx_chkAll" autocomplete="off"></th>
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
						<input type="hidden" name="t_orderno[]" value="<?=$row["orderno"]?>"> <!--제품 번호-->
						<input type="hidden" name="t_price_code[]" value="<?=$row["price_code"]?>">	<!--제품 코드-->
					<tr>
						<td><input type="checkbox" name="t_check[]" id="t_check" size="3" value="<?=$row["orderno"]?>" autocomplete="off"></td>	<!--autocomplete="off" 자동완성기능 해제 /페이지 뒤로 이동 눌를시 체크 상태 해제를 위해 넣음 -->		
						<td><a href="javascript:goView('<?=$row["no"]?>')"><span class="img"><img class="mini_img" src="/file_room/shop/<?=$row["attach"]?>" alt="shop1"></span></a></td>
						<td><a href="javascript:goView('<?=$row["no"]?>')"><?=$row["title"]?></td>
						<td><?=$row["price_num"]?></td>
						<td><?=number_format($row["price"])?><br><br><?=number_format($row["price_num"]*$row["price"])?></td><!--number_format으로 숫자값에 ,를 찍어준다.-->
						<td><?=$row["reg_date"]?></td>
						<td><?=$row["shop_name"]?></td>
						<td><a href="javascript:goDelete('<?=$row["orderno"]?>')"><i class="fas fa-trash"></i></a></td>
				<?}?>
			</form>	
					</tr>

					<script>
						
						$(document).ready(function() {
							$("#cbx_chkAll").click(function() { //<input type="checkbox" id="cbx_chkAll"> 가 체크 될 때 작동한다.
								if($("#cbx_chkAll").is(":checked")) $(".table input[id=t_check]").prop("checked", true); // 전체 체크가 체크 되었다면 input type 이름이 t_check인 것들은 checked 값이 ture(체크)가 된다.
								else $(".table input[id=t_check]").prop("checked", false); //input id가 중복 된다면 범위를 지정할수도 있다. .table input[id=t_check] 이런식으로 테이블 범위로만  한정할 수도 있다.
							});
							
							$(".table input[id=t_check]").click(function() { //input name으로 줬었는데 checkbox가 배열로 바뀌면서 name=t_check 나 t_check[] 둘다 인식하지 못해 id로 바꿔줌
								var total = $(".table input[id=t_check]").length;
								var checked = $(".table input[id=t_check]:checked").length;

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
			</div>
		
		</div>
		
		
		
		<!--  footer start  -->
	<?
		include "common/common_footer.php";
	?>
		</div>
	
	
	
	</body>
</html>

