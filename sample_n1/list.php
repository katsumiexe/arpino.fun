<?php
$mysqli = mysqli_connect("localhost", "tiltowait_db", "kk1941", "tiltowait_db");
if(!$mysqli){
	$msg="接続エラー";
	die("接続エラー");
}
mysqli_set_charset($mysqli,'UTF-8'); 

$h_day=$_POST["h_day"];
$pri[1]=800; 
$pri[2]=1000; 
$pri[3]=1200; 
$pri[4]=1200; 
$p=0;
$sql="SELECT * FROM order_data";
if($dat0 = mysqli_query($mysqli,$sql)){
	while($dat1 = mysqli_fetch_assoc($dat0)){
		$main_data[$p]=$dat1;
		$sql="SELECT * FROM order_detail";
		$sql.=" WHERE order_id={$dat1["id"]}";

		$h=0;

		if($dat2 = mysqli_query($mysqli,$sql)){
			while($dat3 = mysqli_fetch_assoc($dat2)){
				$name[$dat1["id"]][$h]=$dat3["name"];
				$cnt[$dat1["id"]][$h]=$dat3["cnt"];
				$price[$dat1["id"]][$h]=$dat3["price"];
			$h++;
			}
		}
		$p++;
	}
}
?>
<!DOCTYPE HTML>
<html lang="ja">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta http-equiv="Content-Style-Type" content="text/css">
<meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0">
<style>

table{
	border:1px solid #303030;
	border-collapse: collapse;
	width:200px;

}

td{
	border:1px solid #303030;
	padding:5px;
}
</style>
</head>
<body class="body">
<?for($n=0;$n<count($main_data);$n++){?>
<table>
<tr>
<td>日</td><td><?=$main_data[$n]["order_day"]?></td>
</tr><tr>
<td>時間</td><td><?=$main_data[$n]["order_time"]?></td>
</tr>
</table>
<table>
<?for($s=0;$s<count($name[$main_data[$n]["id"]]);$s++){?>
<tr>
<td><?=$name[$main_data[$n]["id"]][$s]?></td>
<td><?=$cnt[$main_data[$n]["id"]][$s]?></td>
<td><?=$price[$main_data[$n]["id"]][$s]?></td>
</tr>
<?}?>
</table>
<br>
<?}?>

</body>
</html>
