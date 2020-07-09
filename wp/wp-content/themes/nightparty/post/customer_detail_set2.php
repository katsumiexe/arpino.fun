<?
/*

誕生日変更
*/
ini_set('display_errors',1);

require_once ("../../../../wp-load.php");
global $wpdb;

$c_id	=$_POST["c_id"];
$id		=$_POST["id"];
$yy		=$_POST["yy"];
$mm		=$_POST["mm"];
$dd		=$_POST["dd"];
$ag		=$_POST["ag"];

if($id == "customer_group"){
	$app=" c_group='{$param}'";

}elseif($id == "customer_detail_name"){
	$app=" `name`='{$param}'";

}elseif($id == "customer_detail_nick"){
	$app=" `nickname`='{$param}'";
}

$sql_log ="UPDATE wp01_0customer SET";
$sql_log .=$app;
$sql_log .=" WHERE id={$c_id}";
$wpdb->query($sql_log);

echo($sql_log);

exit();
?>
