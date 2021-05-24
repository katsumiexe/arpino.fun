<?
$mysqli = mysqli_connect("localhost", "tiltowait_tmpl", "kk1941", "tiltowait_tmpl");
if(!$mysqli){
	$msg="接続エラー";
	die("接続エラー");
}
mysqli_set_charset($mysqli,'UTF-8'); 

$now		=date("Y-m-d H:i:s");
$now_8		=date("Ymd");
$now_w		=date("w");
$now_count	=date("t");
$now_month	=date("Y-m-01 00:00:00");

?>
