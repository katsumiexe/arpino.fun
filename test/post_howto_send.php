<?
$idcode	=$_POST["idcode"];
$edcode	=$_POST["edcode"];
$q		=$_POST["q"];
$a		=$_POST["a"];
$now	=date("Y-m-d H:i:s");

if($edcode == 0 || $edcode == 5){
	$sql="INSERT INTO howto_log(`date`,`idcode`,`name`,`s1`,`s2`,`s3`,`s4`,`s5`,`s6`,`j1`,`c01`,`c02`,`c03`,`c04`,`c05`,`c06`,`c07`,`c08`)";
	$sql.=" VALUES('{$now}','{$idcode}','{$nick}','{$q[1]}','{$q[2]}','{$q[3]}','{$q[4]}','{$q[5]}','{$q[6]}','{$q[7]}','{$a[1]}','{$a[2]}','{$a[3]}','{$a[4]}','{$a[5]}','{$a[6]}','{$a[7]}','{$q[8]}')";
}

?>
