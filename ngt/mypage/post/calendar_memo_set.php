<?
/*
カレンダーメモセット
*/

include_once('../../library/sql_post.php');
$set_date	=$_POST["set_date"];
$log		=$_POST["log"];

$sql	 ="SELECT id FROM wp01_0schedule_memo";
$sql	.=" WHERE cast_id='{$cast_data["id"]}'";
$sql	.=" AND date_8='{$set_date}'";

if($result = mysqli_query($mysqli,$sql)){
	$row = mysqli_fetch_assoc($result);
	if($row["id"]){
		$sql	 ="UPDATE wp01_0schedule_memo SET";
		$sql	.=" `del`='0',";
		$sql	.=" `log`='{$log}'";
		$sql	.=" WHERE `id`='{$row["id"]}'";
	}else{
		$sql	 ="INSERT INTO wp01_0schedule_memo";
		$sql	.=" (`date_8`,`cast_id`,`log`)";
		$sql	.=" VALUES('{$set_date}','{$cast_data["id"]}','{$log}')";
	}
	mysqli_query($mysqli,$sql);
}

print("<input class=\"cal_m_{$set_date}\" type=\"hidden\" value=\"{$log}\">");
exit()
?>
