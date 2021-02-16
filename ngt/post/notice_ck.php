<?
/*
お知らせ見た処理
*/
require_once ("./post_inc.php");
$now=date("Y-m-d H:i:s",$jst);


ini_set('display_errors',1);
require_once ("../../../../wp-load.php");
global $wpdb;

$n_id	=$_POST["n_id"];
$cast_id=$_POST["cast_id"];

$sql	 ="UPDATE wp01_0notice_ck SET";
$sql	.=" status='2'";
$sql	.=" WHERE cast_id='{$cast_id}'";
$sql	.=" AND notice_id='{$n_id}'";
$wpdb->query($sql);
?>
