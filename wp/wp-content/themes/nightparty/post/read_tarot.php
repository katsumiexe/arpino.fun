<?
$_SESSION["time"]=time()+32400;;
ini_set('display_errors',1);
require_once ("../../../../wp-load.php");
global $wpdb;
$jst=time()+32400;
$now_8=date("Ymd",$jst-($start_time*3600));
$link=get_template_directory_uri();

$tarot_id0	=$_POST["tarot_id0"];
$tarot_id1	=$_POST["tarot_id1"];
$tarot_id2	=$_POST["tarot_id2"];

$n_r0		=$_POST["n_r0"];
$n_r1		=$_POST["n_r1"];
$n_r2		=$_POST["n_r2"];

$sql	 ="SELECT * FROM tarot_data";
$sql	 .=" WHERE (tarot_id='{$tarot_id0}' && n_r='{$n_r0}' && result='0')";
$sql	 .=" OR (tarot_id='{$tarot_id1}' && n_r='{$n_r1}' && result='1')";
$sql	 .=" OR (tarot_id='{$tarot_id2}' && n_r='{$n_r2}' && result='2')";
$sql1 = $wpdb->get_results($sql,ARRAY_A );

foreach($sql1 as $a1){
	$dat[$a1["result"]]=str_replace("\n","<br>",$a1["tarot_log"]);
}

echo json_encode($dat);
exit();
?>
