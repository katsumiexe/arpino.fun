<?
/*
スケジュールスライドセット処理
*/
ini_set('display_errors',1);
require_once ("../../../../wp-load.php");
global $wpdb;

$week[0]="日";
$week[1]="月";
$week[2]="火";
$week[3]="水";
$week[4]="木";
$week[5]="金";
$week[6]="土";

$week_tag2[0]="ca1";
$week_tag2[1]="ca2";
$week_tag2[2]="ca2";
$week_tag2[3]="ca2";
$week_tag2[4]="ca2";
$week_tag2[5]="ca2";
$week_tag2[6]="ca3";

$pre		=$_POST["pre"];

if($pre) ==1{
	$base_day_ed	=$_POST["base_day"];
	$base_day		=$_POST["base_day"]-604800;

	$base_day_sql=date("Y-m-d",$base_day);
	$base_day_ed_sql=date("Y-m-d",$base_day_ed);
	
	$sql	 ="SELECT * FROM wp01_0schedule";
	$sql	.=" WHERE cast_id={$_SESSION["id"]}";
	$sql	.=" AND sche_date>='{$base_day_sql}'";
	$sql	.=" AND sche_date<'{$base_day_ed_sql}'";

	$dat = $wpdb->get_results($sql,ARRAY_A );
	foreach($dat as $tmp2){
		$stime[$tmp2["sche_date"]]		=$tmp2["stime"];
		$etime[$tmp2["sche_date"]]		=$tmp2["etime"];
	}

}else{
	$base_day_ed		=$_POST["base_day"]+1209600;
	$base_day			=$_POST["base_day"]+604800;

	$base_day_sql=date("Y-m-d",$base_day);
	$base_day_ed_sql=date("Y-m-d",$base_day_ed);

	$sql	 ="SELECT * FROM wp01_0schedule";
	$sql	.=" WHERE cast_id={$_SESSION["id"]}";
	$sql	.=" AND sche_date>='{$base_day_sql}'";
	$sql	.=" AND sche_date<'{$base_day_ed_sql}'";

	$dat = $wpdb->get_results($sql,ARRAY_A );
	foreach($dat as $tmp2){
		$stime[$tmp2["sche_date"]]		=$tmp2["stime"];
		$etime[$tmp2["sche_date"]]		=$tmp2["etime"];
	}
}
$cal["date"]=$base_day;


$sql ="SELECT * FROM wp01_0sch_table";
$sql.=" ORDER BY sort ASC";
$dat = $wpdb->get_results($sql,ARRAY_A );
foreach($dat as $tmp){
	$sche_table_name[$tmp["in_out"]][$tmp["sort"]]	=$tmp["name"];
	$sche_table_time[$tmp["in_out"]][$tmp["sort"]]	=$tmp["time"];
}

$week_start=date("w",$base_day);

for($n=0;$n<7;$n++){
	$tmp_wk=($n+$week_start)%7;
	$tmp_date=date("m月d日",$base_day+86400*$n);

$cal["html"].="<div class=\"cal_list\">";
$cal["html"].="<div class=\"cal_day {$week_tag2[$tmp_wk]}\">{$tmp_date}({$week[$tmp_wk]})</div>";

$cal["html"].="<select id=\"sel_in{$n}\" class=\"sch_time_in\">";
$cal["html"].="<option class=\"sel_txt\"></option>";
for($s=0;$s<count($sche_table_name["in"]);$s++){
$cal["html"].="<option class=\"sel_txt\" value=\"{$sche_table_name["in"][$s]}\"";
if($stime[date("Ymd",$base_day+86400*$n)]===$sche_table_name["in"][$s]){
$cal["html"].= selected="selected";
}
$cal["html"].= ">";
$cal["html"].= "{$sche_table_name["in"][$s]}</option>";
}
$cal["html"].="</select>";
$cal["html"].="<select id=\"sel_out{$n}\" class=\"sch_time_in\">";
$cal["html"].="<option class=\"sel_txt\"></option>";
for($s=0;$s<count($sche_table_name["out"]);$s++){
$cal["html"].="<option class=\"sel_txt\" value=\"{$sche_table_name["in"][$s]}\"";
if($stime[date("Ymd",$base_day+86400*$n)]===$sche_table_name["in"][$s]){
$cal["html"].= selected="selected";
}
$cal["html"].= ">";
$cal["html"].= "{$sche_table_name["out"][$s]}</option>";
}
$cal["html"].="</select>";
$cal["html"].="<div class=\"cal_log\"></div></div>";
}
echo json_encode($cal);
exit();
?>
