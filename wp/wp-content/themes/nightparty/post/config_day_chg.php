<?
/*
day_chg
*/

require_once ("./post_inc.php");
require_once ("./inc_code.php");

$cast_id	=$_POST["cast_id"];
$times		=$_POST["times"]+0;

$sql =" UPDATE wp01_0cast SET";
$sql.=" times_st='{$times}'";
$sql.=" WHERE id='{$cast_id}'";
$wpdb->query($sql);
echo $sql;
exit();
?>
