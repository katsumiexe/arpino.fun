<?

$now		=date("Y-m-d H:i:s");
$now_ymd	=date("Ymd",);
$now_ymd_2	=date("Ymd",time()+86400);
$now_ymd_3	=date("Ymd",time()+172800);

/*--■祝日カレンダー--*/
$holiday	= file_get_contents("https://katsumiexe.github.io/pages/holiday.json");
$ob_holiday = json_decode($holiday,true);

	$c_month=$_POST["c_month"];
	if(!$c_month) $c_month=date("Y-m-01");

	$calendar[0]=date("Y-m-01",strtotime($c_month)-86400);
	$calendar[1]=$c_month;
	$calendar[2]=date("Y-m-01",strtotime($c_month)+3456000);
	$calendar[3]=date("Y-m-01",strtotime($calendar[2])+3456000);

	$month_ym[0]=date("Ym",strtotime($calendar[0]));	
	$month_ym[1]=date("Ym",strtotime($calendar[1]));	
	$month_ym[2]=date("Ym",strtotime($calendar[2]));	

	$month_w[0]=date("w",strtotime($calendar[0]))-1;
	$month_w[1]=date("w",strtotime($calendar[1]))-1;
	$month_w[2]=date("w",strtotime($calendar[2]))-1;

	$month_e[0]=date("t",strtotime($calendar[0]));
	$month_e[1]=date("t",strtotime($calendar[1]));
	$month_e[2]=date("t",strtotime($calendar[2]));

$s=1;
$month_max=ceil(($month_w[$s]+$month_e[$s])/7)*7;
$month_y=substR($c_month,0,4);
$month_m=substR($c_month,5,2);

for($n=0;$n<$month_max ;$n++){
	$tmp_days=$n-$month_w[$s];
	$day_id=$month_ym[$s]*100+$tmp_days;

	if($n % 7 == 0 ||$ob_holiday[$day_id]){
		$week_color="1";
		$week_title="1";

	}elseif($n % 7 == 6){
		$week_color="2";
		$week_title="2";

	}else{
		$week_color="0";
		$week_title="0";
	}

	if($n % 7 == 0){
		$c_inc.="</tr><tr>";
	}

	if($tmp_days == 5 || $tmp_days == 20){
		$week_color.=" dead";

	}elseif($day_id == $now_ymd){
		$week_color.=" now";
		$week_title.=" now2";
	}

	if($n>$month_w[$s] && $n<=$month_w[$s]+$month_e[$s]){
		$c_inc.="<td id=\"d{$day_id}\" class=\"calendar_d day_{$week_color}\">";
		$c_inc.="<span class=\"day_ttl ttl_{$week_title}\">{$tmp_days}</span>";
		$c_inc.="</td>";

	}else{
		$c_inc.="<td class=\"calendar_d\"></td>";
	}
}
	$now_w=date("w");

	$base_now=strtotime(date("Y-m-d 00:00:00"));
	$base_w=$now_w-$week_start;
	if($base_w<0) $base_w+=7;

	$base_day=$base_now-($base_w+7)*86400;

	$week_st=date("Ymd",$base_day);
	$week_ed=date("Ymd",$base_day+604800);

	$month_st=date("Ymd",strtotime($calendar[0]));
	$month_ed=date("Ymd",strtotime($calendar[3]));
?>
<html lang="ja">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>CastPage</title>
<style>
@font-face {
	font-family: at_icon;
}

.calendar{
	width:100vw;
	border-collapse: collapse;
	border:0.5vw solid #303030;
	border-spacing:0;
}

.calendar_m{
	height			:7vw;
	line-height		:7vw;
	text-align		:center;
	border			:0.5vw solid #C7BBA5;
	font-size		:0;
	background		:#e8dBc5;
}


.calendar_w{
	text-align		:center;
	height			:5vw;
	line-height		:5vw;
	border			:0.5vw solid #C7BBA5;
	font-size		:4vw;
	font-weight:600;
}

.calendar_d{
	height			:20vw;
	text-align		:left;
	border			:0.5vw solid #C7BBA5;
	vertical-align	:top;
}

.day_1{
	background:#ffe8f0;
}

.day_2{
	background:#f0f8ff;
}

.day_0{
	background:#fafffa;
}

.day_ttl{
	display			:inline-block;
	height			:5vw;
	line-height		:4vw;	
	width			:5vw;
	font-size		:3vw;
	border-radius:	0 0 4vw 0;
	text-align		:center;
}

.ttl_1{
	background:#ff9090;
}

.ttl_2{
	background:#9090ff;
}

.ttl_0{
	background:#90ff90;
}

.dead{
	background:#ff6060;
}

.calendar_d:hover{
	background:#ffffc0;
}

.now{
	box-shadow:1vw -1vw 0 rgba(200,80,120,0.5) inset,-1vw 1vw 0 rgba(200,80,120,0.5) inset; 
}

.month_m{
	font-size	:4.5vw;
	font-weight	:800;
	color		:#fafafa;
	text-shadow	:2px 2px 0 #b7aB95;
}


.month_y{
	font-size:3.2vw;
	font-weight:800;
	color:#fafafa;
	text-shadow	:2px 2px 0 #b7aB95;
}

</style>
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1/i18n/jquery.ui.datepicker-ja.min.js"></script>
<script src="./js/jquery.ui.touch-punch.min.js"></script>
<script>
</script>
</head>
<body class="body">
	<table class="calendar">
		<tr>
			<td class="calendar_m" colspan="7"><span class="month_m"><?=$month_m?>月</span><span class="month_y"><?=$month_y?>年</span></td>
		</tr>
		<tr>
			<td class="calendar_w">日</td>
			<td class="calendar_w">月</td>
			<td class="calendar_w">火</td>
			<td class="calendar_w">水</td>
			<td class="calendar_w">木</td>
			<td class="calendar_w">金</td>
			<td class="calendar_w">土</td>
			<?=$c_inc?>
		</tr>
	</table>
</body>
</html>