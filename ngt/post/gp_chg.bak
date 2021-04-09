<?
include_once('../library/sql_cast.php');
$name		=$_POST["name"];
$sort		=$_POST["sort"];

$sql =" UPDATE wp01_0customer_group SET";
$sql.=" tag='{$name}'";
$sql.=" WHERE sort='{$sort}'";
$sql.=" AND cast_id='{$cast_data["id"]}'";
mysqli_query($mysqli,$sql);
exit();
?>
