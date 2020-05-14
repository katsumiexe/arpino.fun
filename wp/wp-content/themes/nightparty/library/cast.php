<?
global $wpdb; 
$now=date("Ymd",time()-21600);
$now_7=date("Ymd",time()+604800);

$sql ="SELECT * FROM wp01_0cast";
$sql .=" WHERE del=0";
$dat0a = $wpdb->get_results($sql);

foeach($dat0a as $a1){
	$cast[$dat0a["id"]]=$dat0a;
}



$sql ="SELECT * FROM wp01_0schedule";
$sql .=" WHERE del=0";
$sql .=" AND sche_date>='{$now}'";
$sql .=" AND sche_date<'{$now_7}'";
$sql .=" ORDER BY id ASC";

$dat1 = mysqli_query($mysqli,$sql);
while($dat1a = mysqli_fetch_assoc($dat1)){
	$stime[$dat1a["cast_id"]][$dat1a["sche_date"]]=$dat1a["stime"];
	$etime[$dat1a["cast_id"]][$dat1a["sche_date"]]=$dat1a["rtime"];
}
?>

