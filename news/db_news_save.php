<?php
    include "../common/dbconnect.php";
    session_start();

    $queryMax ="select max(no)+1 as maxno from h_news "; /* 게시글 번호 생성 */
    $resultMax = mysqli_query($connect, $queryMax);
    $rowMax = mysqli_fetch_array($resultMax);
    
    if(!$rowMax['maxno']) { //게시글이 하나도 없어서 번호가 없을 시 1번으로 주고 빈칸이 아닐시 기존번호 N +1 로 작동
        $maxNo = 1;
    } else {
        $maxNo = $rowMax['maxno'];
    }

    $attach_dir =$_SERVER["DOCUMENT_ROOT"]."/file_room/news/"; /*$_SERVER["DOCUMENT_ROOT"]의 뜻은 apache까지의 경로다. = //C:Apache24/htdocs 란 말과 같다. */
    /*그래서 위에 것을 표현하면 //C:Apache24/htdocs/file_room/notice 와 같다.*/
    $attach_name = $_FILES["t_attach"]["name"]; /*첨부파일 명*/  /*[]첫번째 괄호는 보내주는 input상자 이름 []2번째 상자는 첫번째에서 넘어오는 input상자안의 파일 이름 */
    $attach_tmp_name = $_FILES["t_attach"]["tmp_name"]; 
    /*temp파일은 임시파일로 file_room/notice로 보내주기전에 C:\Windows\Temp에 파일을 먼저 보내준 뒤 file_room/notice로 보내준다. 보내주고 나면 자동으로 사라진다.*/

    $attach_db_name = $maxNo."_".$attach_name; /*파일명 중복으로 인한 문제 방지를 위해 게시글 번호 및 파일명으로 저장 */ 
    /* 아래의 iconv("UTF-8","CP949",$attach_name);를 작업하면 $attach_name의 이름이 깨지기 때문에 $attach_db_name을 만들어 기존 이름을 남겨두고 
        query에 넣을땐 $attach_name가 아니라  $attach_db_name 이름으로 넣는다.*/

    $attach_name = iconv("UTF-8","CP949",$attach_name); /*한글 꺠짐 방지 및 파일명*/ /*여기서 글자를 변경해주게 되면 한글이 변경되서 db안에 들어가지 못한다. */
    $attach_name = $maxNo."_".$attach_name; /*한글 깨짐 방지 후에 변한 파일명 앞에 게시글 번호 부여 */

    $full_attach_info   = $attach_dir.$attach_name;   /*첨부파일의 경로/ 첨부파일의 이름  */

    $attach_result =
        move_uploaded_file($attach_tmp_name,$full_attach_info); /* move_uploaded_file()은 서버로 전송된 파일을 저장할 때 사용하는 함수입니다.*/

/*        
    echo "====attach_name : ".$attach_name."<br>";
    echo "====attach_tmp_name : ".$attach_tmp_name."<br>";  
    echo "====full_attach_info : ".$full_attach_info."<br>";
    echo "====attach_result : ".$attach_result."<br>";
*/
    $title = $_POST["t_title"];
    $content = $_POST["t_content"];
    $reg_id = $_SESSION["session_id"];
    $reg_date_time = date("y-m-d h:i:s", time());

    $query ="insert into h_news ".
        "(no,title,content,attach, reg_id,reg_date) ".
        "values ".
        "($maxNo,'$title','$content','$attach_db_name','$reg_id','$reg_date_time')";

        echo $query;
    $result = mysqli_query($connect, $query);
    if($result == 1) $msg ="등록되었습니다.";
    else $msg ="등록 실패";
    
?>
<script>
    alert("<?=$msg?>");
    location.href="news_list.php";
</script>