<?
/*
Itemchg
*/

require_once ("./post_inc.php");
require_once ("./inc_code.php");

$cast_id	=$_POST["cast_id"];
$sort		=$_POST["sort"];
$cds		=$_POST["cds"];
$clr		=$_POST["clr"];
$name		=$_POST["name"];
$price		=$_POST["price"];

if($cds){
	$sort	=str_replace("i_div","",$sort);
	$app	=" item_icon='{$cds}'";

}elseif($clr){
	$sort	=str_replace("c_div","",$sort);
	$app	=" item_color='{$clr}'";

}elseif($price){
	$app	=" price='{$price}'";

}elseif($name){
	$app	=" item_name='{$name}'";
}


$sql =" UPDATE wp01_0cast_log_table SET";
$sql.=$app;
$sql.=" WHERE sort='{$sort}'";
$sql.=" AND cast_id='{$cast_id}'";
$wpdb->query($sql);
echo $sql;
exit();
?>
