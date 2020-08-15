<?
/*
BlogSet
*/

require_once ("./post_inc.php");
require_once ("./inc_code.php");

$cast_id	=$_POST["cast_id"];

$item_name	=$_POST["item_name"];
$item_icon	=$_POST["item_icon"];
$item_color	=$_POST["item_color"];

$item_price	=$_POST["item_price"];
$chglist	=$_POST["chglist"];


for($n=0;$n<count($chglist);$n++){
	$tmp=str_replace("i","",$chglist[$n]);
	$sql=" UPDATE wp01_0cast_log_table SET";

	$sql.=" item_name='{$item_name[$tmp]}',";
	$sql.=" item_icon='{$item_icon[$tmp]}',";
	$sql.=" item_color='{$item_color[$tmp]}',";
	$sql.=" price='{$item_price[$tmp]}'";

	$sql.=" WHERE cast_id='{$cast_id}'";
	$sql.=" AND sort='{$n}'";
	$wpdb->query($sql);
}

exit();
?>
