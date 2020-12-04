<?
/*
BlogSet
*/

require_once ("./post_inc.php");
require_once ("./inc_code.php");

$cast_id	=$_POST["cast_id"];
$name		=$_POST["item_name"];
$chglist	=$_POST["chglist"];



for($n=0;$n<count($chglist);$n++){
	$tmp=str_replace("i","",$chglist[$n]);
	$sql=" UPDATE wp01_0cast_log_table SET";





}
echo $dat["html"];
exit();
?>
