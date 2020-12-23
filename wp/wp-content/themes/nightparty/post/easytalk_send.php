<?


require_once ("./post_inc.php");
$cast_id		=$_POST['cast_id'];
$cast_name		=$_POST['genji'];
$log			=$_POST['log'];
$sid			=$_POST['sid'];
$img			=$_POST['img'];
$send			=$_POST['send'];

$customer_id	=$_POST['customer_id'];
$customer_name	=$_POST['customer_name'];
$customer_mail	=$_POST['customer_mail'];

$now	=date("Y-m-d H:i:s",$jst);
$now_dat=date("Y.m.d H:i",$jst);

if($send==1){
	$n0=($cast_id % 720)+1;
	$n1=rand(1, 720);
	$n2=rand(1, 720);
	$n3=rand(1, 720);
	$n4=($customer_id % 720)+1;

	$sql	 ="SELECT `key` FROM wp01_0encode";
	$sql	.=" WHERE id IN('{$n0}','{$n1}','{$n2}','{$n3}','{$n4}')";
	$tmp	 = $wpdb->get_results($sql,ARRAY_A);
	foreach($tmp as $a1){
		$enc.=$a1["key"];
	}

	$sql	 ="INSERT INTO wp01_0ssid";
	$sql	.="(ssid,cast_id,customer_id,`date`,`mail`)";
	$sql	.="VALUES";
	$sql	.="('{$enc}','{$cast_id}','{$customer_id}','{$now}','{$customer_mail}')";
	$wpdb->query($sql);

//------------------------------------------------
	mb_language("Japanese"); 
	mb_internal_encoding("UTF-8");

	$from	="From: counterpost2016@gmail.com";
	$title	=$cast_name."より(EasyTalk)";
	$to		=$customer_mail;
	$header	= "From: info@piyo-piyo.work";
	
	if(!$customer_name){
	$body	.=$customer_name."様\n\n";
	}

	$body	.=$cast_name."さんからのメッセージが届いています\n";
	$body	.="下記のURLから内容をご確認ください。\n";
	$body	.="https://arpino.fun/wp/easytalk/?ss=".$enc."\n\n\n";

	$body	.="===========================\n";
	$body	.="Piyo-Piyo.work\n";
	$body	.="https:arpino.fun/wp\n";
	$body	.="080-1111-1111\n";
	$body	.="info@piyo-piyo.work\n";

	mb_send_mail($to, $title, $body, $header);

//------------------------------------------------

}else{
	$sql	 ="SELECT cast_id, customer_id FROM wp01_0ssid";
	$sql	.=" WHERE ssid='{$sid}'";
	$sql	.=" LIMIT 1";
	$ssid		=$wpdb->get_row($sql,ARRAY_A);

	$customer_id=$ssid["customer_id"];
	$cast_id	=$ssid["cast_id"];
}

$sql	 ="INSERT INTO wp01_0castmail";
$sql	.="(send_date,customer_id,cast_id,send_flg,log,img_1)";
$sql	.="VALUES";
$sql	.="('{$now}','{$customer_id}','{$cast_id}','{$send}','{$log}','{$img}')";
$wpdb->query($sql);

$log=str_replace("\n","<br>",$log);

$dat.="<div class=\"mail_box_b\">";		
$dat.="<div class=\"mail_box_log_2 bg\">";		
$dat.=$log;		
$dat.="</div>";
$dat.="<span class=\"mail_box_date_b\"><span class=\"midoku\">未読</span>　{$now_dat}</span>";		
$dat.="</div>";

echo $dat;
exit();
?>
