<?
include_once("./library/session.php");
$date=date("Y-m-d H:i:s");

$log_id		=$_POST["log_id"];
$name		=$_POST["name"];

$sql=" UPDATE `score_data` SET";
$sql.=" `name`='{$name}'";
$sql.=" WHERE `id`='{$log_id}'";
mysqli_query($mysqli,$sql);
echo $sql;
?>
