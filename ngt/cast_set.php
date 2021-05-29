<?php 
include_once('./library/sql.php');

$st=20210601;
$cnt=30;
$sql_a=" INSERT INTO wp01_0schedule(`date`,`sche_date`,`cast_id`,`stime`,`etime`) VALUES";


$sql=" SELECT * FROM wp01_0sch_table";
if($result = mysqli_query($mysqli,$sql)){
	while($row = mysqli_fetch_assoc($result)){
		$t_table[$row["in_out"]][$row["sort"]]=$row["name"];
	}
}

$sql=" SELECT id, genji FROM wp01_0cast";
$sql.=" WHERE cast_status=0";
$sql.=" AND id>0";
$sql.=" AND genji IS NOT NULL";
$sql.=" ORDER BY cast_sort ASC";

if($result = mysqli_query($mysqli,$sql)){
	while($row = mysqli_fetch_assoc($result)){

		for($n=0;$n<$cnt;$n++){
			$sch8=date("Ymd",strtotime($st)+(86400*$n));
			$t0=($row["id"]+$n) % 5;

			if($t0 > 0){
				$t1=rand(0,5);
				$t2=rand(7,10);
				$sql_b.="('{$now}','{$sch8}','{$row["id"]}','{$t_table["in"][$t1]}','{$t_table["out"][$t2]}'),";
			}
		}

		$sql_b=substr($sql_b,0,-1);
		mysqli_query($mysqli,$sql_a.$sql_b);
		$sql_b="";
	}
}
?>
<html lang="ja">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Night-party</title>
</head>
<body>
<div style="font-size:16px;">
■<?=time()?>
</div>
</body>
</html>

