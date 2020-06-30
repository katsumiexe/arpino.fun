<?
include_once("./library/session.php");
$date=date("Y-m-01 00:00:00",time()+86400);
$sql="INSERT INTO score_data (`date`,`name`,`unit`,`level`,`score`) VALUES";
for($s=0;$s<3;$s++){
	for($n=1;$n<11;$n++){
		$k=11-$n;
		$sql.="('{$date}','名無し王子','{$n}','{$s}','{$k}'),";
	}
}
$sql=substr($sql,0,-1);
mysqli_query($mysqli,$sql);
echo date("Y-m-d H:i:s");
?>

