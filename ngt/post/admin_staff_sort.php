<?
include_once('../library/sql_post.php');
$list		=$_POST['list'];
foreach($list as $a1 => $a2){
	$a1++;
	$a2=str_replace('tr_','',$a2);
	$sql="UPDATE wp01_0cast SET";
	$sql.=" cast_sort='{$a1}'";
	$sql.=" WHERE id={$a2}";
	mysqli_query($mysqli,$sql);
}
exit();
?>
