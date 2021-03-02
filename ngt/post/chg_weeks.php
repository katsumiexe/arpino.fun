<?
/*
スケジュールスライドセット処理
*/
include_once('../library/sql_cast.php');

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

if($pre ==1){
	$base_day			=$_POST["base_day"]-604800;
	$add_day			=$base_day;

	$base_day_sql		=date("Ymd",$add_day);
	$base_day_ed_sql	=date("Ymd",$add_day+86400*7);
	
	$sql	 ="SELECT * FROM wp01_0schedule";
	$sql	.=" WHERE cast_id='{$cast_data["id"]}'";
	$sql	.=" AND sche_date>='{$base_day_sql}'";
	$sql	.=" AND sche_date<'{$base_day_ed_sql}'";

	$dat = $wpdb->get_results($sql,ARRAY_A );
	foreach($dat as $tmp2){


		$stime[$tmp2["sche_date"]]		=$tmp2["stime"];
		$etime[$tmp2["sche_date"]]		=$tmp2["etime"];
	}

}else{
	$base_day			=$_POST["base_day"]+86400*7;
	$add_day			=$_POST["base_day"]+86400*21;

	$base_day_sql		=date("Ymd",$add_day);
	$base_day_ed_sql	=date("Ymd",$add_day+86400*7);

	$sql	 ="SELECT * FROM wp01_0schedule";
	$sql	.=" WHERE cast_id='{$cast_data["id"]}'";
	$sql	.=" AND sche_date>='{$base_day_sql}'";
	$sql	.=" AND sche_date<'{$base_day_ed_sql}'";
	$sql	.=" ORDER BY id ASC";

	if($result = mysqli_query($mysqli,$sql)){
		while($row = mysqli_fetch_assoc($result)){
			$stime[$row["sche_date"]]		=$row["stime"];
			$etime[$row["sche_date"]]		=$row["etime"];
		}
	}
}

$cal["st"]=$sql;
$cal["date"]=$base_day;

$sql ="SELECT * FROM wp01_0sch_table";
$sql.=" ORDER BY sort ASC";
if($result = mysqli_query($mysqli,$sql)){
	while($row = mysqli_fetch_assoc($result)){
		$sche_table_name[$tmp["in_out"]][$tmp["sort"]]	=$tmp["name"];
		$sche_table_time[$tmp["in_out"]][$tmp["sort"]]	=$tmp["time"];
	}
}

$week_start=date("w",$base_day);

for($n=0;$n<7;$n++){
	$tmp_wk=($n+$week_start)%7;
	$tmp_date=date("m月d日",$add_day+86400*$n);

	$cal["html"].="<div class=\"cal_list\">";
	$cal["html"].="<div class=\"cal_day {$week_tag2[$tmp_wk]}\">{$tmp_date}({$week[$tmp_wk]})</div>";

if($base_now>$add_day+86400*$n){
	$cal["html"].="<div class=\"d_sch_time_in\">";
	$cal["html"].= $stime[date("Ymd",$add_day+86400*$n)];
	$cal["html"].="</div>";
	$cal["html"].="<div class=\"d_sch_time_out\">";
	$cal["html"].= $etime[date("Ymd",$add_day+86400*$n)];
	$cal["html"].="</div>";

}else{
	$cal["html"].="<select id=\"sel_in{$n}\" class=\"sch_time_in\">";
	$cal["html"].="<option class=\"sel_txt\"></option>";
	for($s=0;$s<count($sche_table_name["in"]);$s++){
		$cal["html"].="<option class=\"sel_txt\" value=\"{$sche_table_name["in"][$s]}\"";
		if($stime[date("Ymd",$add_day+86400*$n)]===$sche_table_name["in"][$s]){
			$cal["html"].= " selected=\"selected\"";
		}
		$cal["html"].= ">";
		$cal["html"].= "{$sche_table_name["in"][$s]}</option>";
	}

	$cal["html"].="</select>";
	$cal["html"].="<select id=\"sel_out{$n}\" class=\"sch_time_out\">";
	$cal["html"].="<option class=\"sel_txt\"></option>";

	for($s=0;$s<count($sche_table_name["out"]);$s++){
		$cal["html"].="<option class=\"sel_txt\" value=\"{$sche_table_name["out"][$s]}\"";
		if($etime[date("Ymd",$add_day+86400*$n)]===$sche_table_name["out"][$s]){
			$cal["html"].= " selected=\"selected\"";
		}
		$cal["html"].= ">";
		$cal["html"].= "{$sche_table_name["out"][$s]}</option>";
	}
	$cal["html"].="</select>";
}
	$cal["html"].="</div>";
}
echo json_encode($cal);
exit();
?>
