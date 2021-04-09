<?
/*
お知らせ見た処理
*/
include_once('../library/sql_cast.php');
$n_id	=$_POST["n_id"];

$sql	 ="UPDATE wp01_0notice_ck SET";
$sql	.=" status='2'";
$sql	.=" WHERE cast_id='{$cast_data["id"]}'";
$sql	.=" AND notice_id='{$n_id}'";
mysqli_query($mysqli,$sql);

?>
