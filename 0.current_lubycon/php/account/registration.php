<?php
	require_once '../database/database_class.php';
    require_once "../class/regex_class.php";

    $regex_vali = new regex_validate;

	$db = new Database();

	// password encryption -> using bycrypt
	$hash = password_hash($_POST['pass'], PASSWORD_DEFAULT);
    
	//regular expression
	$mail_vali = "/^[0-9a-zA-Z]([\-.\w]*[0-9a-zA-Z\-_+])*@([0-9a-zA-Z][\-\w]*[0-9a-zA-Z]\.)+[a-zA-Z]{2,9}$/";	
	// email validation check
	$pass_vali[0] = "/[^0-9]/";
	$pass_vali[1] = "/[`;',.\/~!@\#$%<>^&*\()\-=+_\¡¯]/";
	$nick_vali = "/^[A-Za-z0-9+]*$/";	//only english & number

	//confirm password
	$confirm_pass = ($regex_vali->pass_check($_POST['pass']) && $regex_vali->sametext_check($_POST['pass'],$_POST['repass'])); // insert 2 value 1:pass 2:repass

	//confirm email
	$confirm_email = $regex_vali->email_check($_POST['email']);

	//confirm nickname
	$confirm_nick = $regex_vali->nickname_check($_POST['nick']);

	//email validation check
	($confirm_email==true)?$email_validation = true : $email_validation = false;

	//password validation check
	($confirm_pass == true) ? $pass_validation = true : $pass_validation = false;

	//nickname validation check
	($confirm_nick === true)? $nick_validation=true : $nick_validation=false;

	//term validation check
	($_POST['terms_check'] == "on") ? $terms_validation = true : $terms_validation = false;

	//private plicy validation check
	($_POST['private_check'] == "on")?$private_validation = true : $private_validation = false;

	//newsletter
	(isset($_POST['email_send_check']))? $newsletter = 'true' : $newsletter = 'false';

	if($email_validation && $pass_validation && $nick_validation && $private_validation && $terms_validation){
		
		$feed = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"; 
		$size = 6;
		$rand_str=null;
		
		for ($i=0; $i < $size; $i++){
			$rand_str .= substr($feed, rand(0, strlen($feed)-1), 1);
		}   

		$db->query = "insert into userbasic(email,nick,pass,date,termCheck, policyCheck, subscription, validationToken)values('".$_POST['email']."', '".$_POST['nick']."', '".$hash."', '".date('Y-m-d H:i:s')."', '".'true'."', '".'true'."', '".$newsletter."', '".$rand_str."')";

		//'".$_POST['country_code']."',
		$db->askQuery();
		echo (mysql_error($db->database)."<br/>");
		if(!$db->result){
			echo "회원가입에 실패하였습니다. 5초 후에 이전 페이지로 이동합니다.";
			$db->disconnectDb();
			sleep(5);
			//echo("<script>history.back();</script>");
		}
		else{
			
			//google smtp mailer start		
			
			$DOCUMENT_ROOT = $_SERVER['DOCUMENT_ROOT'];
			$fromaddress = "Lubycon@gmail.com";
			$toaddress = $_POST['email'];
			$subject = "Confirmation Mail for Lubycon account";

			function sendMail($fromaddress, $toaddress, $subject){
			date_default_timezone_set('Etc/UTC');
		
			require '../PHPMailer/PHPMailerAutoload.php';

			$mail = new PHPMailer;
			$mail->isSMTP();
			$mail->CharSet='UTF-8';
			//$mail->SMTPDebug=1;
			//$mail->Debugoutput='html';
			$mail->Host='smtp.gmail.com';
			$mail->SMTPSecure='ssl';
			$mail->Port=465;
			$mail->SMTPAuth=true;
			$mail->Username=$fromaddress;
			$mail->Password="hmdwdgdhkr2015";
			$mail->setFrom($fromaddress,$fromaddress);
			$mail->addAddress($toaddress,$toaddress);
			$mail->Subject=$subject;
			$mail->msgHTML(file_get_contents('./mail_for_resist.php/?Token="'.$rand_str.'"'));
			$mail->Altbody='This is a plain-text message body';
		
			if(!$mail->send()){
				echo "Mailer Error : ".$mail->ErrorInfo;
			}
		}
	
		sendMail($fromaddress, $toaddress, $subject);

		//redirecting
		echo('./mail_for_resist.php/?Token="'.$rand_str.'"');
		//'<script>document.location.href="./waiting_for_resisting.php"</script>'  
		exit;
		}
	}
	else{
		echo "registration fail back to the website.";
		sleep(5);
		//echo("<script>history.back();</script>");
		exit;
	}
?>