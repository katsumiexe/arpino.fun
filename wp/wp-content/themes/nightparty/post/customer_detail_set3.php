<?
/*
FAVセット
*/
require_once("./post_inc.php");

$c_id	=$_POST["c_id"];
$cast_id=$_POST["cast_id"];
$fav	=$_POST["fav"];

$sql_log ="UPDATE wp01_0customer SET";
$sql_log .=" fav='{$fav}'";
$sql_log .=" WHERE id={$c_id}";

echo($sql_log);
$wpdb->query($sql_log);

exit();
?>
