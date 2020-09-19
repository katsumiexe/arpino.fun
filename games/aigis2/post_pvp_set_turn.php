<?
include_once("./library/session.php");

$now=date("Y-m-d H:i:s");
$host		=$_POST["host"];
$turn		=$_POST["turn"];
$bet		=$_POST["item"];
$log_id		=$_POST["log_id"];
$sql	 ="INSERT INTO pvp_data(`date`, `host`, `code`,  `name`, `unit`,  `turn`,  `item`)";
$sql	.=" VALUES('{$now}', '{$host}', '{$log_id}', '{$nickname}', '{$unit}', '{$turn}', '{$item}')";
mysqli_query($mysqli,$sql);
?>
