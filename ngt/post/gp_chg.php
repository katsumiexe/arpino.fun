<?
/*
Itemchg
*/

require_once ("./post_inc.php");
require_once ("./inc_code.php");

$cast_id	=$_POST["cast_id"];
$name		=$_POST["name"];
$sort		=$_POST["sort"];

$sql =" UPDATE wp01_0customer_group SET";
$sql.=" tag='{$name}'";
$sql.=" WHERE sort='{$sort}'";
$sql.=" AND cast_id='{$cast_id}'";
$wpdb->query($sql);
echo $sql;
exit();
?>
