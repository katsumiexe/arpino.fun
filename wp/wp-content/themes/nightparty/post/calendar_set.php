<?
/*
カレンダースライドセット処理
*/
ini_set('display_errors',1);
require_once ("../../../../wp-load.php");
global $wpdb;

$holiday	= file_get_contents("https://katsumiexe.github.io/pages/holiday.json");
$ob_holiday = json_decode($holiday,true);

$c_month=$_POST["c_month"];
$pre=$_POST["pre"];

if($pre == 1){
$c_month=date("Y-m-01",str($c_month)-86400);

}else{
$c_month=date("Y-m-01",str($c_month)+3456000);

}

$now_month=date("m",strtotime($c_month));
$t=date("t",strtotime($c_month));
$wk=$week_start-date("w",strtotime($c_month));
if($wk>0) $wk-=7;
$st=strtotime($c_month)+($wk*86400);
$v_year	=substr($c_month,0,4)."年";
$v_month=substr($c_month,5,2)."月";

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
			$cal.="</tr><tr>";
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
	$cal.="<td id=\"{$tmp_ymd}\" class=\"cal_td cc{$tmp_week}\">";
	$cal.="<span class=\"dy{$tmp_week}{$day_tag} cc{$tmp_week}\">{$tmp_day}</span>";
	$cal.="<span class=\"cal_i1 n1\"></span>";
	$cal.="<span class=\"cal_i2\"></span>";
	$cal.="<span class=\"cal_i3\"></span>";
	$cal.="</td>";
}
?>
<table class="cal_table">
<tr>
<td class="cal_top" colspan="1"></td>
<td class="cal_top" colspan="1"><span id="prev" class="cal_prev"></span></td>
<td class="cal_top" colspan="3"><span class="v_year"><?PHP ECHO $v_year?></span><span class="v_month"><?PHP ECHO $v_month?></span></td>
<td class="cal_top" colspan="1"><span id="next" class="cal_next"></span></td>
<td class="cal_top" colspan="1"></td>
</tr>
<tr>
<?
for($s=0;$s<7;$s++){
$w=($s+$week_start) % 7;
?>
<td class="cal_td <?PHP ECHO $week_tag[$w]?>"><?PHP ECHO $week[$w]?></td>
<? } ?>
<?PHP ECHO $cal[$c]?>
</tr>
</table>
