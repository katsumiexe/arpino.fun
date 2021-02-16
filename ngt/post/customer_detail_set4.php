<?
/*
memo1セット
*/
require_once("./post_inc.php");

$c_id	=$_POST["c_id"];
$cast_id=$_POST["cast_id"];
$item	=$_POST["item"];
$value	=$_POST["value"];

$sql_log ="UPDATE wp01_0customer_list SET";
$sql_log .=" comm='{$value}'";
$sql_log .=" WHERE cast_id={$cast_id}";
$sql_log .=" AND customer_id={$c_id}";
$sql_log .=" AND item='{$item}'";

echo($sql_log);
$wpdb->query($sql_log);
exit();
?>
