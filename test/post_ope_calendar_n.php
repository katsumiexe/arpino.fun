<?
$nowmonth	=$_POST['nowmonth'];
$idcode		=$_POST['idcode'];
$next		=$_POST['next'];
$holiday	= file_get_contents("https://katsumiexe.github.io/pages/holiday.json");
$ob_holiday = json_decode($holiday,true);


if($next == 'next'){
	$month_p=$nowmonth."01";
	$month_t=date("Ym01",strtotime($month_p)+3456000);
	$month_n=date("Ym01",strtotime($month_t)+3456000);
}else{
	$month_n=$nowmonth."01";
	$month_t=date("Ym01",strtotime($month_n)-86400);
	$month_p=date("Ym01",strtotime($month_t)-86400);
}
	$m_p=date("m",strtotime($month_p));
	$m_n=date("m",strtotime($month_n));

$month_w		=date("w",strtotime($month_t))-1;
$month_e		=date("t",strtotime($month_t));
$month_ym		=date("Ym",strtotime($month_t));

$s=1;
$month_max		=ceil(($month_w+$month_e)/7)*7;
$y_t			=substr($month_t,0,4);
$m_t			=substr($month_t,4,2);

$dat["today"]=$month_t;

for($n=0;$n<$month_max;$n++){
	$tmp_days=$n-$month_w;
	$day_id=$month_ym*100+$tmp_days;
	$n_week=$n % 7;

	if($n_week == 0 ||$ob_holiday[$day_id]){
		$week_color="1";
		$week_title="1";

	}elseif($n_week == 6){
		$week_color="2";
		$week_title="2";

	}else{
		$week_color="0";
		$week_title="0";
	}

	if($n_week == 0){
		$c_inc.="</tr><tr>";
	}

	if($tmp_days == 5 || $tmp_days == 20){
		$week_color.=" dead";

		$dd="<span class=\"sch_tag deadday\">スケジュール締切</span>";

	}elseif($day_id == $now_ymd){
		$dd="";
		$week_color.=" now";
		$week_title.=" now2";
	}else{
		$dd="";
	}

	if($n>$month_w && $n<=$month_w+$month_e){

		if(count($dat[$day_id])>0){
			$s_cnt=count($dat[$day_id]);	
			if($s_cnt>9){
				$s_cnt="9+";
			}
			$s_cnt="<span class=\"s_cnt\">{$s_cnt}</span>";
		}else{
			$s_cnt="";
		}

		$c_inc.="<td id=\"d{$day_id}\" week=\"{$week[$n_week]}\" class=\"calendar_d day_{$week_color}\">";
		$c_inc.="<span class=\"day_ttl ttl_{$week_title}\">{$tmp_days}</span>";
		$c_inc.="<span class=\"holiday\">{$ob_holiday[$day_id]}</span>";
		$c_inc.=$s_cnt;
		$c_inc.="<span class=\"sch_empty\"></span>";
		$c_inc.=$dd;
		$c_inc.="<span class=\"sch_tag\">祈願祈祷</span>";
		$c_inc.="</td>";

	}else{
		$c_inc.="<td class=\"calendar_d\"></td>";
	}
}

$dat["hidden"]=$month_ym;

$dat["html"]="<tr>";
$dat["html"].="<td class=\"calendar_m\" colspan=\"2\"><span class=\"month_prev\">＜{$m_p}月</span></td>";

$dat["html"].="<td class=\"calendar_m\" colspan=\"3\"><span class=\"month_m\">{$m_t}月</span><span class=\"month_y\">{$y_t}年</span></td>";
$dat["html"].="<td class=\"calendar_m\" colspan=\"2\"><span class=\"month_next\">{$m_n}月＞</span></td>";

$dat["html"].="</tr><tr>";
$dat["html"].="<td class=\"calendar_w ttl_1\">日</td>";
$dat["html"].="<td class=\"calendar_w ttl_0\">月</td>";
$dat["html"].="<td class=\"calendar_w ttl_0\">火</td>";
$dat["html"].="<td class=\"calendar_w ttl_0\">水</td>";
$dat["html"].="<td class=\"calendar_w ttl_0\">木</td>";
$dat["html"].="<td class=\"calendar_w ttl_0\">金</td>";
$dat["html"].="<td class=\"calendar_w ttl_2\">土</td>";
$dat["html"].="{$c_inc}";
$dat["html"].="</tr>";

echo json_encode($dat);
exit();
?>