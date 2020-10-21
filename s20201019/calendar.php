<?

$week[0]="日";
$week[1]="月";
$week[2]="火";
$week[3]="水";
$week[4]="木";
$week[5]="金";
$week[6]="土";


$ck[0]	=$_POST["yy"];
$ck[1]	=substr("0".$_POST["mm"],-2,2);
$ck[2]	=substr("0".$_POST["dd"],-2,2);;

$nj[1]	="初七日（しょなのか）";
$nj[2]	="二七日（ふたなのか）";
$nj[3]	="三七日（みなのか）";
$nj[4]	="四七日（よなのか）";
$nj[5]	="五七日（いつなのか）";
$nj[6]	="六七日（むなのか）";
$nj[7]	="七七日（なななのか）四十九日";

$mj[1]	="百日";

$hj[1]	="一周忌";
$hj[2]	="三回忌";
$hj[6]	="七回忌";
$hj[12]	="十三回忌";
$hj[16]	="十七回忌";
$hj[22]	="二十三回忌";
$hj[24]	="二十五回忌";
$hj[26]	="二十七回忌";

$t=date("t",strtotime($ck[0]."-".$ck[1]."-01 00:00:00"));
if($ck[2]+0>$t+0) $ck[2]=$t;

$base	=strtotime($ck[0]."-".$ck[1]."-".$ck[2]." 00:00:00")-86400;
$base_y	=strtotime($ck[0]."-01-01 00:00:00");

$base_cnt=$base-$base_y+3;

foreach($nj as $n => $a2){
	$t_ymd		=date("Y-m-d",$base+(86400*7*$n));
	$t_yy		=date("Y",$base+(86400*7*$n));
	$t_mm		=date("m",$base+(86400*7*$n));
	$t_dd		=date("d",$base+(86400*7*$n));
	$t_w		=date("w",$base+(86400*7*$n));
	$link		="http://koyomi.zing2.org/api/?mode=d&cnt=1&targetyyyy={$t_yy}&targetmm={$t_mm}&targetdd={$t_dd}";
	$dat_date	=file_get_contents($link);
	$eve		=json_decode($dat_date, true);
	$dat.="<div class=\"ans_a\">";
	$dat.="<span class=\"ans_1\">{$a2}</span>";
	$dat.="<span class=\"ans_2\">{$t_yy}年({$eve["datelist"][$t_ymd]["gengo"]}{$eve["datelist"][$t_ymd]["wareki"]}年)</span>";
	$dat.="<span class=\"ans_3\">{$t_mm}月{$t_dd}日({$week[$t_w]})</span>";
	$dat.="<span class=\"ans_4\">{$eve["datelist"][$t_ymd]["rokuyou"]}</span>";
	$dat.="</div>";
}

	$t_ymd		=date("Y-m-d",$base+(86400*100));
	$t_yy		=date("Y",$base+(86400*100));
	$t_mm		=date("m",$base+(86400*100));
	$t_dd		=date("d",$base+(86400*100));
	$t_w		=date("w",$base+(86400*100));
	$link		="http://koyomi.zing2.org/api/?mode=d&cnt=1&targetyyyy={$t_yy}&targetmm={$t_mm}&targetdd={$t_dd}";
	$dat_date	=file_get_contents($link);
	$eve		=json_decode($dat_date, true);
	$dat.="<div class=\"ans_a\">";
	$dat.="<span class=\"ans_1\">百日</span>";
	$dat.="<span class=\"ans_2\">{$t_yy}年({$eve["datelist"][$t_ymd]["gengo"]}{$eve["datelist"][$t_ymd]["wareki"]}年)</span>";
	$dat.="<span class=\"ans_3\">{$t_mm}月{$t_dd}日({$week[$t_w]})</span>";
	$dat.="<span class=\"ans_4\">{$eve["datelist"][$t_ymd]["rokuyou"]}</span>";
	$dat.="</div>";

foreach($hj as $n => $a2){
	$t_ymd		=$ck[0]+$n."-".$ck[1]."-".$ck[2];

	$t_yy		=substr($t_ymd,0,4);
	$t_mm		=substr($t_ymd,5,2);
	$t_dd		=substr($t_ymd,8,2);

	if($t_yy %4 >0 && $t_mm=="02" && $t_dd=="29"){
		$t_ymd		=$t_yy."-03-01";
		$t_mm		="03";
		$t_dd		="01";
	}

	$t_w		=date("w",strtotime($t_ymd));


	$link		="http://koyomi.zing2.org/api/?mode=d&cnt=1&targetyyyy={$t_yy}&targetmm={$t_mm}&targetdd={$t_dd}";
	$dat_date	=file_get_contents($link);
	$eve		=json_decode($dat_date, true);
	$dat.="<div class=\"ans_a\">";
	$dat.="<span class=\"ans_1\">{$a2}</span>";
	$dat.="<span class=\"ans_2\">{$t_yy}年({$eve["datelist"][$t_ymd]["gengo"]}{$eve["datelist"][$t_ymd]["wareki"]}年)</span>";
	$dat.="<span class=\"ans_3\">{$t_mm}月{$t_dd}日({$week[$t_w]})</span>";
	$dat.="<span class=\"ans_4\">{$eve["datelist"][$t_ymd]["rokuyou"]}</span>";
	$dat.="</div>";
}

$data["n"]	=$t;
$data["t"]	=$ck[2]+0;
$data["html"]=$dat;
echo json_encode($data);

exit()
?>
