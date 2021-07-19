<?
include_once('../../library/sql_post.php');
$id		=$_POST['id'];

$sql ="SELECT cast_id, status FROM `wp01_0notice_ck`";
$sql.=" WHERE notice_id='{$id}'";
if($result = mysqli_query($mysqli,$sql)){
	while($row = mysqli_fetch_assoc($result)){
		$dat[$row["cast_id"]]=$row["status"];
	}
}

echo json_encode($dat);
exit();
?>
