<?
include_once("./library/session.php");
$myid	=$_POST["myid"];

$now=date("Y-m-d H:i:s",time()-3600);
$sql	 ="SELECT id, `date`, sort,	name,face,turn,unit FROM pvp_data";
$sql	.=" WHERE turn='0'";
//$sql	.=" AND `date`>'{$now;}'";
$sql	.=" ORDER BY sort ASC";
$sql	.=" LIMIT 5";
$n=0;
if($res0 = mysqli_query($mysqli,$sql)){
	while($row0 = mysqli_fetch_assoc($res0)){
		$dat[$n]=$row0;
		if($myid == $row0["id"]){
			$dat[$n]["img"]="./img/unit/unit_{$row0["unit"]}.png";	
		}else{
			$dat[$n]["img"]="./img/chr/chr{$row0["face"]}.png";	
		}
		$n++;
	}
}



$dat[0]["id"]=$dat[0]["id"]+0;
echo json_encode($dat);
exit();
?>

