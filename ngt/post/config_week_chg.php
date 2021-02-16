<?
/*
weekchg
*/

require_once ("./post_inc.php");
require_once ("./inc_code.php");

$cast_id	=$_POST["cast_id"];
$week		=$_POST["week"];


$sql =" UPDATE wp01_0cast SET";
$sql.=" week_st='{$week}'";
$sql.=" WHERE id='{$cast_id}'";
$wpdb->query($sql);
echo $sql;
exit();
?>
