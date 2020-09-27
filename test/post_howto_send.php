<?
$idcode	=$_POST["idcode"];
$edcode	=$_POST["edcode"];
$q		=$_POST["q"];
$a		=$_POST["a"];
$now	=date("Y-m-d H:i:s");

if($edcode == 0 || $edcode == 5){
	$sql="INSERT INTO howto_log(`date`,`idcode`,`q1`,`q2`,`q3`,`q4`,`q5`,`q6`,`q7`,`a1`,`a2`,`a3`,`a4`,`a5`,`a6`,`a7`,`a8`)";
	$sql.=" VALUES('{$now}','{$idcode}','{$q[1]}','{$q[2]}','{$q[3]}','{$q[4]}','{$q[5]}','{$q[6]}','{$q[7]}','{$a[1]}','{$a[2]}','{$a[3]}','{$a[4]}','{$a[5]}','{$a[6]}','{$a[7]}','{$q[8]}')";

}

?>
