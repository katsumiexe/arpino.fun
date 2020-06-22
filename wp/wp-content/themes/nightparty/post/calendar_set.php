<?
/*
カレンダースライドセット処理
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

$week_tag[0]="c1";
$week_tag[1]="c2";
$week_tag[2]="c2";
$week_tag[3]="c2";
$week_tag[4]="c2";
$week_tag[5]="c2";
$week_tag[6]="c3";

$week_tag2[0]="ca1";
$week_tag2[1]="ca2";
$week_tag2[2]="ca2";
$week_tag2[3]="ca2";
$week_tag2[4]="ca2";
$week_tag2[5]="ca2";
$week_tag2[6]="ca3";

$week_start=get_option("start_of_week")+0;

$holiday	= file_get_contents("https://katsumiexe.github.io/pages/holiday.json");
$ob_holiday = json_decode($holiday,true);

$c_month	=$_POST["c_month"];
$pre		=$_POST["pre"];
$cast_id	=$_POST["cast_id"];

if($pre == 1){
	$cal["date"]	=date("Y-m-01",strtotime($c_month)-86400);
	$c_month		=date("Y-m-01",strtotime($c_month)-3456000);

	$sc_st=str_replace('-','',$c_month);
	$sc_ed=str_replace('-','',$cal["date"]);

}else{
	$cal["date"]	=date("Y-m-01",strtotime($c_month)+3456000);
	$c_month		=date("Y-m-01",strtotime($c_month)+6912000);

	$sc_st=str_replace('-','',$c_month);
	$sc_ed=date("Ym01",strtotime($c_month)+3456000);
}

$b_month=substr($c_month,4,4);

$sql	 ="SELECT * FROM wp01_0customer";
$sql	.=" WHERE cast_id='{$cast_id}'";
$sql	.=" AND birth_day LIKE '%{$b_month}%'";
$sql	.=" AND del='0'";

$cal["sql"]=$sql;

$dat = $wpdb->get_results($sql,ARRAY_A );
foreach($dat as $tmp){
	$birth=str_replace("-","",$tmp["birth_day"]);
	$birth=substr($c_month,0,4).substr($birth,4,4);
	$birth_dat[$birth]="n1";
	$cal["sql"].="□".$birth;
}

$sql	 ="SELECT * FROM wp01_0schedule";
$sql	.=" WHERE cast_id='{$cast_id}'";
$sql	.=" AND sche_date>='{$sc_st}'";
$sql	.=" AND sche_date<'{$sc_ed}'";
/*$sql	.=" AND (`stime` IS NOT NULL AND `etime` IS NOT NULL)";*/

$dat = $wpdb->get_results($sql,ARRAY_A );


foreach($dat as $tmp){
	if($tmp["stime"] && $tmp["etime"]){;
		$sch_dat[$tmp["sche_date"]]="n2";
	}else{
		$sch_dat[$tmp["sche_date"]]="";
	}
}


$now_month	=date("m",strtotime($c_month));
$t			=date("t",strtotime($c_month));
$wk			=$week_start-date("w",strtotime($c_month));
if($wk>0) $wk-=7;

$st			=strtotime($c_month)+($wk*86400);
$v_year		=substr($c_month,0,4)."年";
$v_month	=substr($c_month,5,2)."月";

$cal["html"].="<table class=\"cal_table\"><tr>";
$cal["html"].="<td class=\"cal_top\" colspan=\"1\"></td>";
$cal["html"].="<td class=\"cal_top\" colspan=\"1\"><span id=\"prev\" class=\"cal_prev\"></span></td>";
$cal["html"].="<td class=\"cal_top\" colspan=\"3\"><span class=\"v_year\">{$v_year}</span><span class=\"v_month\">{$v_month}</span></td>";
$cal["html"].="<td class=\"cal_top\" colspan=\"1\"><span id=\"next\" class=\"cal_next\"></span></td>";
$cal["html"].="<td class=\"cal_top\" colspan=\"1\"></td>";
$cal["html"].="</tr><tr>";

for($s=0;$s<7;$s++){
	$w=($s+$week_start) % 7;
	$cal["html"].="<td class=\"cal_td {$week_tag[$w]}\">{$week[$w]}</td>";
}

for($m=0; $m<42;$m++){
	$tmp_ymd	=date("Ymd",$st+($m*86400));
	$tmp_month	=date("m",$st+($m*86400));
	$tmp_day	=date("d",$st+($m*86400));
	$tmp_week	=date("w",$st+($m*86400));

	$tmp_w		=$m % 7;
	if($tmp_w==0){

		if($now_month<$tmp_month){
			break 1;

		}else{
			$cal["html"].="</tr><tr>";
		}
	}

	if($ob_holiday[$tmp_ymd]){
		$tmp_week=0;
	}

	if($now_month!=$tmp_month){
		$day_tag=" outof";

	}else{
		$day_tag=" nowmonth";
	}
	$cal["html"].="<td id=\"{$tmp_ymd}\" class=\"cal_td cc{$tmp_week}\">";
	$cal["html"].="<span class=\"dy{$tmp_week}{$day_tag} cc{$tmp_week}\">{$tmp_day}</span>";
	$cal["html"].="<span class=\"cal_i1 {$birth_dat[$tmp_ymd]}\"></span>";
	$cal["html"].="<span class=\"cal_i2 {$sch_dat[$tmp_ymd]}\"></span>";
	$cal["html"].="<span class=\"cal_i3 {$memo_dat[$tmp_ymd]}\"></span>";
	$cal["html"].="</td>";
}

$cal["html"].="</tr>";
$cal["html"].="</table>";

echo json_encode($cal);
exit();
?>

