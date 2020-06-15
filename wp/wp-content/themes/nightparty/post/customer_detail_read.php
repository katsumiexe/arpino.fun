<?
/*
顧客情報読み込み
ini_set('display_errors',1);
*/
require_once ("../../../../wp-load.php");
global $wpdb;

$c_id=$_POST["c_id"];

$sql	 ="SELECT * FROM wp01_0customer_list";
$sql	 .=" WHERE del=0";
$sql	 .=" AND customer_id='{$c_id}'";
$dat0 = $wpdb->get_results($sql,ARRAY_A );
foreach($dat0 AS $dat1){
	$cas[$dat1["item"]]=$dat1["comm"];
}


$sql	 ="SELECT * FROM wp01_0customer_item";
$sql	 .=" WHERE del=0";
$dat0 = $wpdb->get_results($sql,ARRAY_A );
foreach($dat0 AS $dat1){
	$dat[$dat1["id"]]=$cas[$dat1["id"]];
}



echo json_encode($dat);
exit();
?>

