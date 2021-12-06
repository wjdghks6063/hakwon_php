<?
	include "common/dbconnect.php";
	$id 		= $_POST["t_id"];
	$mobile 	= $_POST["t_mobile"];
	
	$query ="select name,password,email_1,email_2 from h_member ".
			" where id ='$id' ".
			" and mobile='$mobile'";
	$result = mysqli_query($connect, $query);
	$row    = mysqli_fetch_array($result);
	
	$name   	= $row["name"];
	$password   = $row["password"];
	$email_1   = $row["email_1"];
	$email_2   = $row["email_2"];
	
	$toEmail = $email_1."@".$email_2;

	if($name){
	
		require_once($_SERVER["DOCUMENT_ROOT"]."/PHPMailer/class.phpmailer.php"); 
		require_once($_SERVER["DOCUMENT_ROOT"]."/PHPMailer/PHPMailerAutoload.php"); 

		$mail = new PHPMailer(); // the true param means it will throw exceptions on errors, which we need to catch 
		$mail->IsSMTP(); // telling the class to use SMTP 
		try { 
			$mail->Host = "smtp.naver.com"; // email 보낼때 사용할 서버를 지정 
			$mail->SMTPAuth = true; 		// SMTP 인증을 사용함 
			$mail->Port = 465; 				// email 보낼때 사용할 포트를 지정 
			$mail->SMTPSecure = "ssl"; 		// SSL을 사용함 
			$mail->Username = "naver 아이디"; 			// 보내는 사람 naver 계정 
			$mail->Password = "naver 비밀번호"; 			// 보내는 사람 naver 패스워드 
			$mail->SetFrom("보내는주소", "보내는이름"); 	// 보내는 사람 email 주소와 표시될 이름 (표시될 이름은 생략가능) 
			$mail->AddAddress($toEmail); 			// 받을 사람 email 주소와 표시될 이름 (표시될 이름은 생략가능) 
			$mail->Subject = "비밀번호를 보내드립니다."; 				// 메일 제목 
			$mail->MsgHTML("회원님의 비밀번호는 <h3>$password</h3> 입니다."); 	// 메일 내용 (HTML 형식도 되고 그냥 일반 텍스트도 사용 가능함) 

			if($mail->Send()){ 
					$msg ="비밀번호가 메일로 발송 되었습니다.";
			}else{
					$msg ="메일 발송 오류~~";
			}	
		} catch (phpmailerException $e) { 
			echo $e->errorMessage(); //Pretty error messages from PHPMailer 
		} catch (Exception $e) { 
			echo $e->getMessage(); //Boring error messages from anything else! 
		}	
		$url ="login.php";	
	
	} else {
		$msg ="아이디 또는 연락처가 맞지 않습니다.";
		$url ="find_password.php";
	}
?>
<script>
	alert("<?=$msg?>");
	location.href="<?=$url?>";
</script>