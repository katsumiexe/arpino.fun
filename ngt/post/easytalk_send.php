<?
include_once('../library/sql_post.php');

$cast_name		=$_POST['cast_name'];
$send			=$_POST['send'];
$log			=$_POST['log'];
$sid			=$_POST['sid'];
$img_code		=$_POST['img_code'];

$customer_id	=$_POST['customer_id'];
$customer_name	=$_POST['customer_name'];
$customer_mail	=$_POST['customer_mail'];

$now_dat		=date("Y.m.d H:i");

$n0=($cast_data["id"] % 720)+1;
$n1=rand(1, 720);
$n2=rand(1, 720);
$n3=rand(1, 720);
$n4=($customer_id % 720)+1;
$n5=rand(1, 9);

$ssid_key.=$rnd[$n0].$rnd[$n1].$rnd[$n2].$rnd[$n3].$rnd[$n4].$dec[$n5][$send];
if($send==1){
	$sql	 ="INSERT INTO wp01_0ssid";
	$sql	.="(ssid,cast_id,customer_id,`date`,`mail`)";
	$sql	.="VALUES";
	$sql	.="('{$ssid_key}','{$cast_data["id"]}','{$customer_id}','{$now}','{$customer_mail}')";
	mysqli_query($mysqli,$sql);

//------------------------------------------------

	mb_language("Japanese"); 
	mb_internal_encoding("UTF-8");

	$to			=$customer_mail;
	$title		="[Night Party]".$cast_name."さんより";

	$from_mail	="info@arpino.fun";
	$from		="NightParty";
	$header = '';
	$header .= "Content-Type: text/plain \r\n";
	$header .= "Return-Path: " . $from_mail . " \r\n";
	$header .= "From: " . $from ."<".$from_mail.">\r\n";
//	$header .= "Sender: " . $from ."\r\n";
	$header .= "Reply-To: " . $from_mail . " \r\n";
	$header .= "Organization: " . $from_name . " \r\n";
	$header .= "X-Sender: " . $from_mail . " \r\n";
	$header .= "X-Priority: 3 \r\n";

	if(!$customer_name){
	$body	.=$customer_name."様\n\n";
	}

	$body	.=$cast_name."さんからのメッセージが届いています\n";
	$body	.="下記のURLから内容をご確認ください。\n";
	$body	.="https://arpino.fun/ngt/easytalk.php?ss=".$ssid_key."\n\n\n";

	$body	.="===========================\n";
	$body	.="Night Party\n";
	$body	.="https://arpino.fun/wp\n";
	$body	.="080-1111-1111\n";
	$body	.="info@piyo-piyo.work\n";
	mb_send_mail($to, $title, $body, $header);
//------------------------------------------------

}else{
	$sql	 ="SELECT cast_id, customer_id FROM wp01_0ssid";
	$sql	.=" WHERE ssid='{$sid}'";
	$sql	.=" LIMIT 1";

	if($result = mysqli_query($mysqli,$sql)){
		$row = mysqli_fetch_assoc($result);

		$customer_id=$row["customer_id"];
		$cast_id	=$row["cast_id"];
	}
}


if($img_code){
	$link	="../img/cast/{$box_no}/m/{$ssid_key}.png";
	$link2	="../img/{$ssid_key}.png";
	$img2	=imagecreatetruecolor(600,600);
	$img	=imagecreatefromstring(base64_decode($img_code));
	ImageCopyResampled($img2, $img, 0, 0, 0, 0, 600, 600, 600, 600);
	imagepng($img2,$link);

	if(imagepng($img2,$link2)){
	echo "true!!!!";
	}else{
	echo "FAiL!!!!";
	}
	$img_key=$ssid_key;
}

$sql	 ="INSERT INTO wp01_0easytalk";
$sql	.="(send_date,customer_id,cast_id,send_flg,log,img)";
$sql	.="VALUES";
$sql	.="('{$now}','{$customer_id}','{$$cast_data["id"]}','{$send}','{$log}','{$img_key}')";

mysqli_query($mysqli,$sql);
$log=str_replace("\n","<br>",$log);

$dat.="<div class=\"mail_box_b\">";		
$dat.="<div class=\"mail_box_log_{$send} bg\">";		
$dat.="<div class=\"mail_box_log_in\">";		
$dat.=$log;		
$dat.="</div>";

if($img_code){
$link=substr($link,1);
$dat.="<img src=\"{$link}\" class=\"mail_box_stamp\">";		
}
$dat.="</div>";
$dat.="<span class=\"mail_box_date_b\"><span class=\"midoku\">未読</span>　{$now_dat}</span>";		
$dat.="</div>";

echo $dat;
exit();
?>
