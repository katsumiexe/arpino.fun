<?
$mysqli = mysqli_connect("localhost", "tiltowait_aigis", "kk1941", "tiltowait_aigis");
if(!$mysqli){
	$msg="接続エラー";
	die("接続エラー");
}
mysqli_set_charset($mysqli,'UTF-8'); 

$sql.="SELECT * FROM card_data";
$dat0 = mysqli_query($mysqli,$sql);
while($dat1 = mysqli_fetch_assoc($dat0)){
	$card[$dat1["id"]]=$dat;
}

$sql ="SELECT * FROM unit_data";
$dat_a0 = mysqli_query($mysqli,$sql);
while($dat_a1 = mysqli_fetch_assoc($dat_a0)){
	$unit[$dat_a1["id"]]=$dat_a1;
}

$sql ="SELECT * FROM status_data";
$dat_b0 = mysqli_query($mysqli,$sql);
while($dat_b1 = mysqli_fetch_assoc($dat_b0)){
	$status[$dat_b1["id"]]=$dat_b1;
}

?>
