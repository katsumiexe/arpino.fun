<?
/*
EasyTalk_customer_send
*/

require_once ("./post_inc.php");

$log	=$_POST['log'];
$sid	=$_POST['sid'];
$img	=$_POST['img'];
$send	=$_POST['send'];
$now	=date("Y-m-d H:i:s",$jst);
$now_dat=date("Y.m.d H:i",$jst);

if($send==1){
	$n0=($cast_id % 720)+1;
	$n1=rand(1, 720);
	$n2=rand(1, 720);
	$n3=rand(1, 720);
	$n4=($customer_id % 720)+1;

	$sql	 ="SELECT key FROM wp01_0encode";
	$sql	.=" WHERE id IN('{$n0}','{$n1}','{$n2}','{$n3}','{$n4}')";
	$tmp	 = $wpdb->get_row($sql,ARRAY_A);
	foreach($tmp as $a1){
		$enc.=$a1["key"];
	}

	$sql	 ="INSERT INTO wp01_ssid";
	$sql	.="(ssid,cast_id,customer_id,`date`,mail)";
	$sql	.="VALUES";
	$sql	.="('{$enc}','{$cast_id}','{$customer_id}','{$now}','{$mail}')";
	$wpdb->query($sql);


	$mailer = new PHPMailer();
	$mailer->IsSMTP();

	$mailer->Host		= $host;
	$mailer->CharSet	= 'utf-8';
	$mailer->SMTPAuth	= TRUE;
	$mailer->Username	= $mail_from;
	$mailer->Password	= $mail_pass;
	$mailer->SMTPSecure = 'tls';
	$mailer->Port		= 587;
//	$mailer->SMTPDebug = 2;

	$mailer->From     = $mail_from;
	$mailer->FromName = mb_convert_encoding("写真名刺作成サイト★OnlyMe","UTF-8","AUTO");
	$mailer->Subject  = mb_convert_encoding('会員登録確認',"UTF-8","AUTO");
	$mailer->Body     = mb_convert_encoding($msg,"UTF-8","AUTO");
	$mailer->AddAddress($me_mail);

	if($mailer->Send()){
	}else{
		$sql="INSERT INTO mail_error_log (`date`,`log_no`,`to_mail`)";
		$sql.=" VALUES('{$date}','regist.php','{$me_mail}');";
		mysqli_query($mysqli,$sql);
	}




}

$sql	 ="INSERT INTO wp01_0castmail";
$sql	.="(send_date,customer_id,cast_id,send_flg,log,img_1)";
$sql	.="VALUES";
$sql	.="('{$now}','{$tmp["customer_id"]}','{$tmp["cast_id"]}','{$send}','{$log}','{$img}')";

$wpdb->query($sql);
$log=str_replace("\n","<br>",$log);


$dat="<div class=\"mail_box_b\">";		
$dat.="<div class=\"mail_box_log_2 bg\">";		
$dat.=$log;		
$dat.="</div>";
$dat.="<span class=\"mail_box_date_b\"><span class=\"midoku\">未読</span>　{$now_dat}</span>";		
$dat.="</div>";
echo $dat;
exit();

?>
