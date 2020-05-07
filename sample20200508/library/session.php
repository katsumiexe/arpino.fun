<?
$mysqli = mysqli_connect("localhost", "tiltowait_tmpl", "kk1941", "tiltowait_tmpl");
if(!$mysqli){
	$msg="接続エラー";
	die("接続エラー");
}
mysqli_set_charset($mysqli,'UTF-8'); 
?>
