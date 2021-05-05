<?
/*
画像登録処理
*/

include_once('../../library/sql_post.php');
$c_id		=$_POST["c_id"];
$imgurl		=$_POST["imgurl"];

if($imgurl){
	$sql_log ="UPDATE wp01_0customer SET";
	$sql_log.=" `face`=''";
	$sql_log.=" WHERE id='{$c_id}'";
	mysqli_query($mysqli,$sql)0;

$link="../img/cast/".$tmp_dir."/c/".$imgurl;

unlink($link);
echo "./img/customer_no_img.png?t=".time();
}
exit()
?>
