<?
	session_start();
	include "common/dbconnect.php";
	
	$no = $_POST["t_no"];
    $t_page = $_POST["t_page"];
	
	$attach_dir =$_SERVER["DOCUMENT_ROOT"]."/file_room/shop/";
	$attach_name = $_FILES["t_attach"]["name"];
	$attach_tmp_name = $_FILES["t_attach"]["tmp_name"];	
	//첨부했으면 
	if($attach_name){
		// 기존 첨부파일 삭제
		$del_file = $_POST["t_ori_attach"];
		$tf = unlink($attach_dir.iconv("UTF-8","CP949",$del_file));

		// 새로운 첨부파일
		$attach_db_name = $no."_".$attach_name;
		$attach_name = iconv("UTF-8","CP949",$attach_name);
		$attach_name = $no."_".$attach_name;
		$full_attach_info = $attach_dir.$attach_name;
		$attach_result = move_uploaded_file($attach_tmp_name,$full_attach_info);
	} else {
		$attach_db_name = $_POST["t_ori_attach"];
	}	
		$title 	 = addslashes($_POST["t_title"]); //addslashes();는  '' , "" 같은 특수문자도 db에 넣을 수 있게 해준다.
		$content = addslashes($_POST["t_content"]);
		$reg_id  = $_SESSION["session_id"];
		$stuff_number = $_POST["t_stuff_number"];
		$reg_date_time = date("Y-m-d H:i:s", time());	
		
		$query ="update h_shop ".
				" set title='$title', ".
				" 	content='$content', ".
				"   attach='$attach_db_name', ".
				"   stuff_number='$stuff_number', ".
				"   reg_id ='$reg_id', ".
				"   reg_date='$reg_date_time' ".
				" where no = $no";
		$result = mysqli_query($connect, $query);
		if($result == 1) $msg ="수정되었습니다.";	
		else $msg="수정실패~";		

        /*  $queryMax ="select max(no)+1 as maxno from h_notice";
        $resultMax = mysqli_query($connect,$queryMax);
        $rowMax = mysqli_fetch_array($resultMax);
        $maxNo = $rowMax["maxno"];
        session_start();

        $attach_dir =$_SERVER["DOCUMENT_ROOT"]."/file_room/notice/"; //c:/apache24/htodcs/file_room/noice랑 같은 말이다.
        $attach_name = $_FILES["t_attach"]["name"];   //t_attach는 파라미터값 name은 파일명으로 내마음대로 할 수 있는게 아님 이 값이 attach_name에 들어가는것임
        $attach_tmp_name = $_FILES["t_attach"]["tmp_name"];   //일단 이 주소게 옮겨놓고 내가 지정한 폴더로 옮기는 작업이 필요한 단계

        $attach_db_name = $maxNo."_".$attach_name; //DB에 저장되는거

        $attach_name = iconv("UTF-8","CP949",$attach_name);
        $attach_name =  $maxNo."_".$attach_name;  //폴더에 저장되는거
        $full_attach_info = $attach_dir.$attach_name;

        $attach_result=
            move_uploaded_file($attach_tmp_name,$full_attach_info);

        echo "=====================attach_name : ".$attach_name ."<br>";
        echo "=====================attach_tmp_name : ".$attach_tmp_name ."<br>";
        echo "======================full_attach_info :" .$full_attach_info ."<br>";
        echo "=======================attach_result : " .$attach_result ."<br>";

        $title = $_POST["t_title"];
        $content = $_POST["t_content"];
        $reg_id = $_SESSION["session_id"];
        $reg_date_time = date("y-m-d h:i:s", time());

        $query = "insert into h_notice (no,title,content,attach,reg_id,reg_date) values('$maxNo','$title','$content','$attach_db_name','$reg_id','$reg_date_time')";
        echo $query;
        $result = mysqli_query($connect,$query);
        if($result==1) $msg = "등록되었습니다";
        else $msg="등록실패";
        */

?>
<script>
	alert("<?=$msg?>");
	location.href="shop_list.php";
</script>
