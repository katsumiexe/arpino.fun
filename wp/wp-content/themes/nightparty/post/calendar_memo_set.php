<?
/*
カレンダーメモセット
*/
session_start();
$_SESSION["time"]=time()+32400;;

ini_set('display_errors',1);
require_once ("../../../../wp-load.php");
global $wpdb;

$set_date	=$_POST["set_date"];
$cast_id	=$_POST["cast_id"];
$log		=$_POST["log"];

$sql	 ="SELECT id FROM wp01_0schedule_memo";
$sql	.=" WHERE cast_id='{$cast_id}'";
$sql	.=" AND date_8='{$set_date}'";
$dat = $wpdb->get_results($sql,ARRAY_A );
foreach($dat as $tmp);

if($tmp["id"]){
	$sql	 ="UPDATE wp01_0schedule_memo SET";
	$sql	.=" `del`='0',";
	$sql	.=" `log`='{$log}'";
	$sql	.=" WHERE `id`='{$tmp["id"]}'";
}else{
	$sql	 ="INSERT INTO wp01_0schedule_memo";
	$sql	.=" (`date_8`,`cast_id`,`log`)";
	$sql	.=" VALUES('{$set_date}','{$cast_id}','{$log}')";
}
$wpdb->query($sql);

print("<input class=\"cal_m_{$set_date}\" type=\"hidden\" value=\"{$log}\">");
//print($sql);

exit()
?>
