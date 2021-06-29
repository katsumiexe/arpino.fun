<?
include_once('../../library/sql_post.php');
$list		=$_POST['list'];
$group		=$_POST['group'];

if($group == "staff_sort"){
	foreach($list as $a1 => $a2){
		$n++;
		$a2=str_replace('tr_','',$a2);
		$sql="UPDATE wp01_0cast SET";
		$sql.=" cast_sort='{$n}'";
		$sql.=" WHERE id={$a2}";
		mysqli_query($mysqli,$sql);
	}

}elseif($group == "event_sort"){
	foreach($list as $a1 => $a2){
		$n++;
		$a2=str_replace('sort_item','',$a2);
		$sql="UPDATE wp01_0contents SET";
		$sql.=" sort='{$n}'";
		$sql.=" WHERE id={$a2}";
		mysqli_query($mysqli,$sql);
	}
}


exit();
?>
