<?
/*
メール既読処理
ini_set('display_errors',1);
*/
require_once ("../../../../wp-load.php");
global $wpdb;
$res_mail_id	=$_POST["res_mail_id"];
$dat=date("Y-m-d H:i:s",time()+32400);
$sql ="UPDATE wp01_0castmail_receive SET watch_date='{$dat}'";
$sql.=" WHERE res_mail_id='1'";
$wpdb->query($sql);
?>
