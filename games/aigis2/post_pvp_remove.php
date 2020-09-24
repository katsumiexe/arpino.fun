<?
$now=date("Y-m-d H:i:s",time()-3600);
$myid=$_POST["myid"];
include_once("./library/session.php");

$sql	 ="UPDATE pvp_data SET";
$sql	.=" turn=99";
$sql	.=" WHERE id='{$myid}'";
mysqli_query($mysqli,$sql);


$sql	 ="SELECT id, `date`, sort,	name,face,turn FROM pvp_data";
$sql	.=" WHERE turn='0'";
//$sql	.=" AND `date`>'{$now}'";
$sql	.=" ORDER BY sort ASC";
$sql	.=" LIMIT 5";

if($res0 = mysqli_query($mysqli,$sql)){
	while($row0 = mysqli_fetch_assoc($res0)){
		$dat[]=$row0;
	}
}

$dat[0]["sql"]=$sql;

$dat[0]["id"]=$dat[0]["id"]+0;
echo json_encode($dat);
exit();
?>
