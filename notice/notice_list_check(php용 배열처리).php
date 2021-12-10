<? //배열넘기기 프로젝트

   include "common/common_header.php";
   include "common/dbconnect.php";
   
      $countTotal =" select * from h_notice "; /*페이지를 정할 db 명 */ 
      $countOnePage = "5"; // 한 페이지당 보여줄 목록 수 (?)행 보여주겠다.
      $perblock = 5;       // 한 페이지당 보여줄 페이지 번호 수 < 1 2 3 4 5 >   if($session_level !="top"){


      include "common/pagingSetting.php"; //변수명들을 넣어줘야 작동되기 때문에 변수명 아래쪽에 include 해준다.
      $t_page =$_POST["t_page"]; // view에 갔다가 목록이나 뒤로 가기를 했을 때 현재 페이징 넘버로 가질 수 있게 해준다.
   

   $query ="select a.no,a.title,a.attach,a.reg_id, date_format(a.reg_date,'%Y-%m-%d') as format_date, a.reg_date, b.name, a.hit  from h_notice a, h_member b ".
         "where a.reg_id = b.id order by no desc  limit $start, $end";
   $result = mysqli_query($connect,$query);
                              //여러행이면 여기서 풀면 안됨.반복문 쓸꺼임 밑에서
   $count = mysqli_num_rows($result); //앞축되어있는 놈 몇행인지 카운트세서 반복문 돌거
?>
      <!--  header end -->
      <script>
         function goView(no){
            notice.t_no.value=no;
            notice.method="post";
            notice.action="notice_view.php";
            notice.submit();
         }

         function goPage(pagenumber){
            notice.t_page.value=pagenumber;
            notice.method="post";
            notice.action="notice_list.php";
            notice.submit();
            //얘는 밑에 페이지 디스플레이가 올려다주는 t_page를 통해 pagenumber value값을 shop list에 새로
            // 세팅해주는 아이
         }
         function goArray(){
            if(typeof(notiArr.elements['t_chk[]'].length)=="undefined"){ 
               //배열 아닌경우 체크가 하나도 안됐을 때 안넘기기
               if(notiArr.elements['t_chk[]'].checked==false){
                  alert("주문 선택하시오"); 
                  return; 
               }else{
                  var amount = notiArr.elements['t_amount[]'].value;
                  if(amount < 1 ){
                     alert("정상적인 수량을 입력하세요");
                     notiArr.elements['t_amount[]'].focus();
                     return;
                  }
               }
            }else{
               //배열인경우 체크가 하나도 안됐을 때 안넘기기
               var chkCount=0;
               var len = notiArr.elements['t_chk[]'].length; //배열의 길이
                  for(var k=0;k<len;k++){
                     if(notiArr.elements['t_chk[]'][k].checked==true){
                        chkCount++;
                     }
                  }
                  if(chkCount==0){
                     alert("주문 선택하시오");
                     return;
                  }
                     for(var k=0;k<len;k++){
                        if(notiArr.elements['t_chk[]'][k].checked==true){
                        var amount = notiArr.elements['t_amount[]'][k].value;
                           if(amount < 1 ){
                           alert("정상적인 수량을 입력하세요");
                           notiArr.elements['t_amount[]'][k].focus();
                           return;
               }
            }
         }
            notiArr.method="post";
            notiArr.action="notice_list_check_receive.php";
            notiArr.submit();
         }
      }


         function goProc(order){  //이 자바스크립트는 체크박스 도이ㅓ 이쓴 상품의 순번에 맞는 구분(히든으로 넘겨줄)값을 넣어주기 위해 처리하는 자바스크립트
            
            if(typeof(notiArr.elements['t_chk[]'].length)=="undefined"){ //배열이 아니면~ 처리    if(typeof로 length까지 감싸줘야됨) typeof는 정의되지 않은 것 등 문자열처리가 불가능한 오류 경고 등을 인식하고 처리하는 방법이다
               if(notiArr.elements['t_chk[]'].checked==true){ //체크가 되어있으면 밑에 실행(값넣기)   
                  var no =    notiArr.elements['t_chk[]'].value;  //t_chk박스놈의 순번을 가져와서 no에 담아라 elements를 사용하는 이유는 대괄호(배열)가 된놈에 대해서 작업을 하다보니
                  notiArr.elements['t_no[]'].value=no;  //인풋상자가 t_no인놈한테 11-->(아프론)(no를 넣어야됨) 을 넣겠다 elements를 이용해야된다
               }else{
                  notiArr.elements['t_no[]'].value="";
               }
            }else{
               if(notiArr.elements['t_chk[]'][order].checked==true){ //체크가 되어있으면 밑에 실행(값넣기)   
                  var no =    notiArr.elements['t_chk[]'][order].value;  //t_chk박스놈의 순번을 가져와서 no에 담아라 elements를 사용하는 이유는 대괄호(배열)가 된놈에 대해서 작업을 하다보니
                  notiArr.elements['t_no[]'][order].value=no;  //인풋상자가 t_no인놈한테 11-->(아프론)(no를 넣어야됨) 을 넣겠다 elements를 이용해야된다
                  
               }else{
                  notiArr.elements['t_no[]'][order].value="";
               }
            }
               // notiArr.method="post";
               // notiArr.action="notice_list_jang_receive.php";
               // notiArr.submit();
         }



         //올체크 
            function allCheck(){
               if(typeof(notiArr.elements['t_chk[]'].length)=="undefined"){//배열이냐 아니냐
                  //배열 아닐 때
                  if(notiArr.chkAll.checked==true){
                     notiArr.elements['t_chk[]'].checked=true;
                     var no =    notiArr.elements['t_chk[]'].value;  //t_chk박스놈의 순번을 가져와서 no에 담아라 elements를 사용하는 이유는 대괄호(배열)가 된놈에 대해서 작업을 하다보니
                              notiArr.elements['t_no[]'].value=no;
                  }else{
                     notiArr.elements['t_chk[]'].checked=false;
                     notiArr.elements['t_no[]'].value="";
                  }
               }else{
                  //배열일 때
                  var len = notiArr.elements['t_chk[]'].length; //배열의 길이
                  for(var k=0;k<len;k++){
                     if(notiArr.chkAll.checked==true){
                        notiArr.elements['t_chk[]'][k].checked=true;
                        var no =    notiArr.elements['t_chk[]'][k].value;  //t_chk박스놈의 순번을 가져와서 no에 담아라 elements를 사용하는 이유는 대괄호(배열)가 된놈에 대해서 작업을 하다보니
                                 notiArr.elements['t_no[]'][k].value=no;  
                     }else{
                        notiArr.elements['t_chk[]'][k].checked=false;
                        notiArr.elements['t_no[]'][k].value="";
                     }
                  }
               }
            }
      </script>
      <form name="notice">
         <input type="hidden" name="t_no">
         <input type="hidden" name="t_page">
      </form>
      <!-- sub page start -->
      <div class="notice">
         <div class="sub-notice">
         <h2 class="color"><a href="notice_list.php"><i class="fas fa-check"></i> NOTICE</a></h2>   
         <h2><a href="../qna/qna_list.php"> QnA</a></h2>
         <h2><a href="../faq/faq_list.php"> FAQ</a></h2>   
         <h2><a href="../news/news_list.php"> NEWS</a></h2>   
         <h2><a href="../shop/shop_list.php"> SHOP</a></h2>   
         </div>
         
         <!-- table start-->
         <div class="table-box">
            <table class="table">
               <caption>공지사항 - 번호, 제목, 첨부, 작성일, 조회수</caption>
               <colgroup>
                  <col width="5%">
                  <col width="*">
                  <col width="7%">
                  <col width="10%">
                  <col width="5%">
               </colgroup>
               <form name="notiArr">
               <thead>
                  <tr>
                     <th scope="col"><input type="checkbox" name="chkAll" onchange="allCheck()"></th>
                     <th scope="col">제목</th>
                     <th scope="col">작성자</th>
                     <th scope="col">작성일</th>
                     <th scope="col">조회수</th>
                  </tr>
               </thead>
               
               <tbody>
               <?for($k=0;$k<$count;$k++){ //압축되어있는 놈을 한줄씩한줄씩 뺴서 로우에 담는다
                  $row = mysqli_fetch_array($result);
                  ?>   
                  <tr>
               
                  <td><input type="checkbox" onchange="goProc('<?=$k?>')" name="t_chk[]" value="<?=$row["no"]?>"></td> <!--체크박스 값이 바뀌면 뭔가 하는게 onchange-->
                     <td class="txt">
                        <input type="number" name="t_amount[]" size="3"> <!--네임에 t_no[]배열처리해줘야 배열로받을수있따 -->
                        <input type="text" name="t_no[]" size="3"> <!--배열놈-->
                        <a href="javascript:goView('<?=$row["no"]?>')"><?=$row["title"]?></a>
                  
                     </td>
                  <td><?=$row["name"]?></td>
                  <td><?=$row["format_date"]?></td>
                  <td><?=$row["hit"]?></td>
                  </tr>
                  <?}?>
               </tbody>
               </form>
            </table>
         </div>
         
         <div class="page-number">
         <?   include "common/pagingDisplay.php"; ?>   <br>
         <?if($session_level == "top"){?>   
            <a href="javascript:goArray()" class="btn-write">배열처리</a>
         
         <?}?>
         </div>
      
      
      
      
      <!--  footer start  -->
   <?
      include "common/common_footer.php";
   ?>
      </div>
   
   
   
   </body>
</html>






