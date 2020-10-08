<?
/*
weekchg
*/

require_once ("./post_inc.php");
require_once ("./inc_code.php");

$cast_id	=$_POST["cast_id"];
$week		=$_POST["week"];
$times		=$_POST["times"];


if($week){
	$app	=" week_st='{$week}'";

}elseif($times){
	$app	=" times_st='{$times}'";

}

$sql =" UPDATE wp01_0cast SET";
$sql.=$app;
$sql.=" WHERE id='{$cast_id}'";
$wpdb->query($sql);
echo $sql;
exit();
?>
