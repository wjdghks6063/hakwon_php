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

	$query ="SELECT b.no, b.id, a.title, a.attach, b.price_code, b.price, b.price_num, b.reg_date, a.shop_name FROM h_shop a, h_buy_list b ".
			"where a.price_code = b.price_code ".
			"order by no desc ".
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
		pageForm.action ="basket_list.php";
		pageForm.submit();
	}
	function goExit(id){
		info.t_id.value=id;
		info.method="post";
		info.action="/member/db_top_exit.php";
		info.submit();
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
			<h2><a href="/info/myinfo_view.php">캐쉬 충전</a></h2>	
			<h2><a href="/basket/basket_list.php">장바구니</a></h2>
			<h2 class="color"><a href="/basket/basket_buy_list.php"> <i class="fas fa-check"></i>상품 구매 내역</a></h2>	
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
							<th scope="col"><input type="checkbox"></th>
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
			<?for($k=0;$k<$count;$k++){ //압축되어있는 놈을 한줄씩한줄씩 뺴서 로우에 담는다
						$row = mysqli_fetch_array($result);
			?>	
					<tr>
						<td><input type="checkbox"></td>		
						<td><a href="javascript:goView('<?=$row["id"]?>')"><span class="img"><img class="mini_img" src="/file_room/shop/<?=$row["attach"]?>" alt="shop1"></span></a></td>
						<td><a href="javascript:goView('<?=$row["id"]?>')"><?=$row["title"]?></td>
						<td><?=$row["price_num"]?></td>
						<td><?=$row["price"]?></td>
						<td><?=$row["reg_date"]?></td>
						<td><?=$row["shop_name"]?></td>
						<td><a href="javascript:goExit('<?=$row["id"]?>')"><i class="fas fa-trash"></i></a></td>
			<?}?>
					</tr>
<!--  전체 체크 해제                 
                    <div class='checkbox_group'>
                        <input type="checkbox" id="check_all">
                        <label for="check_all">전체 선택</label>
                        <br>
                        <input type="checkbox" id="iphone">
                        <label for="iphone">아이폰</label>
                        <br>
                        <input type="checkbox" id="ipad">
                        <label for="ipad">아이패드</label>
                        <br>
                        <input type="checkbox" id="macbook">
                        <label for="macbook">맥북</label>
                        <br>
                        <input type="checkbox" id="airpod">
                        <label for="airpod">에어팟</label>
                    </div>

                    <script>
                        $(".checkbox_group").on("click", "#check_all", function () {
                            var checked = $(this).is(":checked");

                            if(checked){
                                $(this).siblings('input').prop("checked", true);
                            } else {
                                $(this).siblings('input').prop("checked", false);
                            }
                            });

                            $(".checkbox_group").on('click', 'input:not(#check_all)', function () {
                            var is_checked = true;
                            $(".checkbox_group input:not(#check_all)").each(function() {
                                is_checked =  is_checked && $(this).is(":checked");
                            })
                            $("#check_all").prop("checked", is_checked)
                            });
                    </script>
-->
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
                <a href="javascript:goUpdate()" class="btn-write1">삭제</a>
				<span style="background-color: green;"><a href="faq_write.php" class="btn-write2">구매</a>
			</div>
		
		</div>
		
		
		
		<!--  footer start  -->
	<?
		include "common/common_footer.php";
	?>
		</div>
	
	
	
	</body>
</html>

