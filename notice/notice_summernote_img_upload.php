<?
if ($_FILES['file']['name']) {
    if (!$_FILES['file']['error']) {
        $temp = explode(".", $_FILES["file"]["name"]);
        $newfilename = round(microtime(true)).'.'.end($temp); //파일명을 현재 시간의 초로 업로드 해준다.
        $destinationFilePath = $_SERVER["DOCUMENT_ROOT"].'/file_room/notice_summer_image/'.$newfilename;
        if (!move_uploaded_file($_FILES['file']['tmp_name'], $destinationFilePath)) {
            echo $errorImgFile;
        }
        else{
			$destinationFilePath = '/file_room/notice_summer_image/'.$newfilename;
            echo $destinationFilePath;
        }
    }
    else {
        echo  $message = '파일 에러 발생!: ' . $_FILES['file']['error'];
    }
}
?>