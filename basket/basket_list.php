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

	$query ="SELECT a.attach, a.title, b.stuff_number, b.price, a.reg_date, a.shop_name, b.price_code, b.orderno FROM h_shop a, h_basket b ".
            "where a.price_code = b.price_code ".
            "order by orderno desc ".
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
			<h2 class="color"><a href="/basket/basket_list.php"> <i class="fas fa-check"></i>장바구니</a></h2>
			<h2><a href="/basket/basket_buy_list.php">상품 구매 내역</a></h2>	
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
							<th scope="col"><input type="checkbox" name="selected_all"></th>
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
						<td><input type="checkbox" name="selected" value="ROW"></td>		
						<td><a href="javascript:goView('<?=$row["id"]?>')"><span class="img"><img class="mini_img" src="/file_room/shop/<?=$row["attach"]?>" alt="shop1"></span></a></td>
						<td><a href="javascript:goView('<?=$row["id"]?>')"><?=$row["title"]?></td>
						<td><?=$row["stuff_number"]?></td>
						<td><?=$row["price"]?></td>
						<td><?=$row["reg_date"]?></td>
						<td><?=$row["shop_name"]?></td>
						<td><a href="javascript:goExit('<?=$row["id"]?>')"><i class="fas fa-trash"></i></a></td>
			<?}?>
					</tr>

                    <script>
                          //전체 체크박스 클릭시 전부 체크 되고 해제 됨 전체 체크 박스 :"selected_all"
                        $('input[name=selected_all]').on('change', function(){ 
                            $('input[name=selected]').prop('checked', this.checked);
                        });

                        $('input[name=selected]').on('change', function(){ 
                            $('input[name=selected_all]').prop('checked', this.checked);
                        });

   //                     $('input:not[name=selected]').on('change', function(){ 
    //                        $('input[name=selected_all]').prop('checked', this.checked);
    //                    });

/* 방법 2
                        $(document).ready(function(){
                            //최상단 체크박스 클릭
                            $('input[name=selected_all]').click(function(){
                                //클릭되었으면
                                if($('input[name=selected_all]').prop("checked")){
                                    //input태그의 name이 chk인 태그들을 찾아서 checked옵션을 true로 정의
                                    $("input[name=selected]").prop("checked",true);
                                    //클릭이 안되있으면
                                }else{
                                    //input태그의 name이 chk인 태그들을 찾아서 checked옵션을 false로 정의
                                    $("input[name=selected]").prop("checked",false);
                                }
                            })
                        })
*/
                        /**xxxxxxxxxxxxxxxxxxxxxxxx */

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

                        var arr = $('input[name=selected]:checked').serializeArray().map(function(item) { return item.value });
                        //var str = $('input[name=_selected_]:checked').serialize(); // 이건 QueryString 방식으로 

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

