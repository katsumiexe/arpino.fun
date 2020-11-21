<?
/*
EasyTalk_customer_send
*/
require_once ("./post_inc.php");

$log	=$_POST['log'];
$sid	=$_POST['sid'];
$img	=$_POST['img'];
$now	=date("Y-m-d H:i:s",$jst);
$now_dat=date("Y.m.d H:i",$jst);

$sql	 ="SELECT cast_id,customer_id FROM wp01_0ssid";
$sql	.=" WHERE ssid='{$sid}'";
$tmp	 = $wpdb->get_row($sql,ARRAY_A);


$sql	 ="INSERT INTO wp01_0castmail";
$sql	.="(send_date,customer_id,cast_id,send_flg,log,img_1)";
$sql	.="VALUES";
$sql	.="('{$now}','{$tmp["customer_id"]}','{$tmp["cast_id"]}','2','{$log}','{$img}')";
$wpdb->query($sql);

$dat="<div class=\"mail_box_b\">";		
$dat.="<div class=\"mail_box_log_2 bg\">";		
$dat.=$log;		
$dat.="</div>";
$dat.="<span class=\"mail_box_date_b\"><span class=\"midoku\">未読</span>　{$now_dat}</span>";		
$dat.="</div>";
echo $dat;
exit();
?>
