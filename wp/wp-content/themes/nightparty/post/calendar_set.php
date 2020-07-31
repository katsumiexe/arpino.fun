<?
/*
カレンダースライドセット処理
*/
require_once ("./post_inc.php");

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

}elseif($pre == 2){
	$cal["date"]	=date("Y-m-01",strtotime($c_month)+3456000);
	$c_month		=date("Y-m-01",strtotime($c_month)+6912000);
}

	$sc_st=str_replace('-','',$c_month);
	$sc_ed=date("Ym01",strtotime($c_month)+3456000);

/*
$b_month=substr($c_month,4,4);
$sql	 ="SELECT * FROM wp01_0customer";
$sql	.=" WHERE cast_id='{$cast_id}'";
$sql	.=" AND birth_day LIKE '%{$b_month}%'";
$sql	.=" AND del='0'";

$dat = $wpdb->get_results($sql,ARRAY_A );
	foreach($dat as $tmp){
	$birth=str_replace("-","",$tmp["birth_day"]);
	$birth=substr($c_month,0,4).substr($birth,4,4);
	$birth_dat[$birth]="n1";
	$cal_app.="<input class=\"cal_b_{$birth}\" type=\"hidden\" value=\"{$tmp["nickname"]}\">";
}
*/

$b_month=substr($c_month,4,4);
$sql	 ="SELECT * FROM wp01_0customer";
$sql	.=" WHERE cast_id='{$cast_id}'";
$sql	.=" AND birth_day LIKE '%{$b_month}%'";
$sql	.=" AND del='0'";

$dat = $wpdb->get_results($sql,ARRAY_A );
foreach($dat as $tmp){
	$birth=str_replace("-","",$tmp["birth_day"]);
	$birth_y	=substr($birth,0,4);
	$birth_m	=substr($birth,4,2);
	$birth_d	=substr($birth,6,2);
	$birth_dat[$birth_m.$birth_d]="n1";
	$birth_hidden[$birth_d].="<span class='days_icon'></span>{$tmp["nickname"]}<br>";
}

foreach($birth_hidden as $a1 => $a2){
	$birth_app.="<input class=\"cal_b_{$birth_m}{$a1}\" type=\"hidden\" value=\"{$a2}\">";
}

$sql	 ="SELECT * FROM wp01_0schedule";
$sql	.=" WHERE cast_id='{$cast_id}'";
$sql	.=" AND sche_date>='{$sc_st}'";
$sql	.=" AND sche_date<'{$sc_ed}'";
/*$sql	.=" AND (`stime` IS NOT NULL AND `etime` IS NOT NULL)";*/

$cal["sql"]=$sql;
$dat = $wpdb->get_results($sql,ARRAY_A );
foreach($dat as $tmp){
	if($tmp["stime"] && $tmp["etime"]){;
		$sch_dat[$tmp["sche_date"]]="n2";
		$h_sch[$tmp["sche_date"]]="{$tmp["stime"]}-{$tmp["etime"]}";

	}else{
		$sch_dat[$tmp["sche_date"]]="";
		$h_sch[$tmp["sche_date"]]="";
	}
}

foreach($h_sch as $a1 => $a2){
	$cal_app.="<input class=\"cal_s_{$a1}\" type=\"hidden\" value=\"{$a2}\">";
}

$sql	 ="SELECT * FROM wp01_0schedule_memo";
$sql	.=" WHERE cast_id='{$cast_id}'";
$sql	.=" AND date_8>='{$sc_st}'";
$sql	.=" AND date_8<'{$sc_ed}'";
$sql	.=" AND `log` IS NOT NULL";
$dat = $wpdb->get_results($sql,ARRAY_A );

foreach($dat as $tmp){
	if(trim($tmp["log"])){
		$memo_dat[$tmp["date_8"]]="n3";
		$cal_app.="<input class=\"cal_m_{$tmp["date_8"]}\" type=\"hidden\" value=\"{$tmp["log"]}\">";
	}
}

$now_month	=date("Ym",strtotime($c_month));
$t			=date("t",strtotime($c_month));
$wk			=$week_start-date("w",strtotime($c_month));
if($wk>0) $wk-=7;

$st			=strtotime($c_month)+($wk*86400);
$v_year		=substr($c_month,0,4)."年";
$v_month	=substr($c_month,5,2)."月";

$cal["html"].="<table class=\"cal_table\"><tr>";
$cal["html"].="<td class=\"cal_top\" colspan=\"7\">";
$cal["html"].="<span class=\"cal_prev\"></span>";
$cal["html"].="<span class=\"cal_table_ym\"><span class=\"v_year\">{$v_year}</span><span class=\"v_month\">{$v_month}</span></span>";
$cal["html"].="<span class=\"cal_next\"></span>";
$cal["html"].="<span id=\"para{$tmp_ymd}\">";
$cal["html"].=$cal_app;
$cal["html"].=$birth_app;
$cal["html"].=$memo_app;
$cal["html"].="</span>";

$cal["html"].="</td>";
$cal["html"].="</tr><tr>";

for($s=0;$s<7;$s++){
	$w=($s+$week_start) % 7;
	$cal["html"].="<td class=\"cal_td {$week_tag[$w]}\">{$week[$w]}</td>";
}

$m_limit=42;
for($m=0; $m<$m_limit;$m++){
	$tmp_ymd	=date("Ymd",$st+($m*86400));
	$tmp_md		=date("md",$st+($m*86400));
	$tmp_month	=date("Ym",$st+($m*86400));
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

	if($tmp_ymd ==date("Ymd",$jst)){
		$tmp_week=7;

	}elseif($ob_holiday[$tmp_ymd]){
		$tmp_week=0;
	}

	if($now_month!=$tmp_month){
		$day_tag=" outof";

	}else{
		$day_tag=" nowmonth";
	}
	$cal["html"].="<td id=\"c{$tmp_ymd}\" week=\"{$week[$tmp_w]}\" class=\"cal_td cc{$tmp_week}\">";
	$cal["html"].="<span class=\"dy{$tmp_week}{$day_tag} cc{$tmp_week}\">{$tmp_day}</span>";
	$cal["html"].="<span class=\"cal_i1 {$birth_dat[$tmp_md]}\"></span>";
	$cal["html"].="<span class=\"cal_i2 {$sch_dat[$tmp_ymd]}\"></span>";
	$cal["html"].="<span class=\"cal_i3 {$memo_dat[$tmp_ymd]}\"></span>";
	$cal["html"].="<span class=\"cal_i4 {$memo_dat[$tmp_ymd]}\"></span>";
	$cal["html"].="</td>";
}

$cal["html"].="</tr>";
$cal["html"].="</table>";

echo json_encode($cal);
exit();
?>
