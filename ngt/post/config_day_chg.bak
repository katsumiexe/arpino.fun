<?
include_once('../library/sql_cast.php');
$times		=$_POST["times"]+0;

$sql =" UPDATE wp01_0cast SET";
$sql.=" times_st='{$times}'";
$sql.=" WHERE id='{$cast_data["id"]}'";
mysqli_query($mysqli,$sql);
exit();
?>
