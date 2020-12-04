<?php
function mailer($from, $from_name, $to, $title, $body){


	$mailer->From     = $from;
	$mailer->FromName = mb_convert_encoding($from_name,"UTF-8","AUTO");
	$mailer->Subject  = mb_convert_encoding($title,"UTF-8","AUTO");
	$mailer->Body     = mb_convert_encoding($body,"UTF-8","AUTO");
	$mailer->AddAddress($to);

	if($mailer->Send()){
	}else{
		$sql="INSERT INTO mail_error_log (`date`,`log_no`,`to_mail`)";
		$sql.=" VALUES('{$date}','regist.php','{$me_mail}');";
		mysqli_query($mysqli,$sql);
	}
}
?>
