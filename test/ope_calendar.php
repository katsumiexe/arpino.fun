<?

$now		=date("Y-m-d H:i:s");
$now_ymd	=date("Ymd",);
$now_ymd_2	=date("Ymd",time()+86400);
$now_ymd_3	=date("Ymd",time()+172800);

$week[0]="（日）";
$week[1]="（月）";
$week[2]="（火）";
$week[3]="（水）";
$week[4]="（木）";
$week[5]="（金）";
$week[6]="（土）";

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
		$dd="<span class=\"deadday\">締切日</span>";

	}elseif($day_id == $now_ymd){
		$dd="";
		$week_color.=" now";
		$week_title.=" now2";
	}else{
		$dd="";
	}

	if($n>$month_w[$s] && $n<=$month_w[$s]+$month_e[$s]){
		$c_inc.="<td id=\"d{$day_id}\" week=\"{$week[$n_week]}\" class=\"calendar_d day_{$week_color}\">";
		$c_inc.="<span class=\"day_ttl ttl_{$week_title}\">{$tmp_days}</span>";
		$c_inc.=$dd;
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
.body {
	margin: 0;
	padding: 0;
	line-height:1.2;
	color:#333;
	background:#fafafa;
	font-size:3.2vw;
	font-family:Verdana, "ＭＳ Ｐゴシック", sans-serif;
	text-align:center;
	width:100vw;
}



@font-face {
	font-family: at_icon;
}

.calendar{
	width:100vw;
	border-collapse		:collapse;
	border				:0.5vw solid #303030;
	border-spacing		:0;
	table-layout		:fixed;
}

.calendar_m{
	height			:12vw;
	text-align		:center;
	border			:none;
	font-size		:0;
	background		:#e8dBc5;
	vertical-align	:bottom;
}


.calendar_w{
	text-align		:center;
	height			:5vw;
	line-height		:5vw;
	border			:0.5vw solid #604020;
	font-size		:4vw;
	font-weight:600;
}

.calendar_d{
	position		:relative;
	height			:20vw;
	text-align		:left;
	border			:0.5vw solid #604020;
	vertical-align	:top;
}

.day_1{
	background:#ffe8f0;
}

.day_2{
	background:#f0f8ff;
}

.day_0{
	background:#fffaf0;
}

.day_ttl{
	position		:absolute;
	top				:0;
	left			:0;	
	display			:inline-block;
	height			:5vw;
	line-height		:4vw;	
	width			:5.5vw;
	font-size		:3vw;
	border-radius:	0 0 3vw 0;
	text-align		:center;
	font-weight		:600;
}

.ttl_1{
	color			:#fafafa;
	background		:#ffc0c0;
	text-shadow		:1px 1px 0 #800000;
	box-shadow		:1px 1px 0 #800000;
}

.ttl_2{
	color			:#fafafa;
	background		:#80d0ff;
	text-shadow		:1px 1px 0 #000080;
	box-shadow		:1px 1px 0 #000080;
}

.ttl_0{
	color			:#fafafa;
	background		:#C7BBA5;
	text-shadow		:1px 1px 0 #604020;
	box-shadow		:1px 1px 0 #604020;
}

.dead{
	background:#ff6060;
}

.calendar_d:hover{
	background:#ffffc0;
}

.now{
	box-shadow:1vw -1vw 0 rgba(180,80,250,1) inset,-1vw 1vw 0 rgba(180,80,250,1) inset; 
}

.month_m{
	font-size	:8vw;
	font-weight	:800;
	color		:#fafafa;
	text-shadow	:1px 1px 0 #604020;
}

.month_y{
	font-size:4.5vw;
	font-weight:800;
	color:#fafafa;
	text-shadow	:1px 1px 0 #604020;
}

.month_next,.month_back{
	font-size:4.5vw;
	font-weight:800;
	color:#fafafa;
	text-shadow	:1px 1px 0 #604020;
}


.back{
	display:none;
	position:fixed;
	top		:-5vh;
	left	:-5vw;
	width	:110vw;
	height	:110vh;
	background:rgba(100,100,100,0.6);
}
.cal_detail{
	position:absolute;
	top:100vh;
	left:0;
	right:0;
	border:1px solid #303030;
	box-shadow:1vw 1vw 1vw rgba(20,20,20,0.5);
	border-radius:3vw;	
	width:90vw;
	height:80vh;
	margin:auto;
	text-align:center;
	background:#fff8f0;
}

.cal_detail_config{
	display		:inline-block;
	width		:15vw;
	height		:7vw;
	line-height	:7vw;
	font-size	:6vw;
	color		:#303030;
	text-align:left;
}

.cal_detail_close{
	display		:inline-block;
	width		:15vw;
	height		:7vw;
	line-height	:7vw;
	font-size	:6vw;
	color		:#303030;
	text-align:right;
}

.cal_detail_ttl{
	display		:inline-block;
	width		:50vw;
	height		:7vw;
	line-height	:7vw;
	margin		:2vw auto 1vw auto;
	border-bottom:1vw solid #604020;
	font-size	:4vw;
	font-weight	:800;
	color		:#604020;
	text-align:center;
}
.sch_box{
	display:inline-block;
	height		:5vw;
	margin		:0 auto;
	font-size	:0;
	text-align:center;
}

.sch{
	width		:2vw;
	height		:3vw;
	background	:#f000f0;
	border		:1px solid #303030;
	font-size	:1vw;
}
.cal_detail_memo1{
	display		:inline-block;
	width		:75vw;
	border		:0.5vw solid #303030;
	margin		:1vw auto;
	padding		:2vw;
	background	:#fafafa;	
	text-align	:left;

}
.cal_detail_memo2{
	position	:relative;
	display		:inline-block;
	width		:80vw;
	margin		:0 auto;
}
.cal_detail_memo_txt{
	position		:absolute;
	top				:0;
	left			:0;
	
	margin			:1vw auto;
    border			:1px solid #303030;
    transform		:scale(0.8,0.8);
    transform-origin:top left;
    width			:100vw;
    height			:calc(100vh - 114vw);
    height			:70vw;
    resize			:none;
    background		:#fafafa;
    font-size		:4.5vw;
    color			:#303030;
}

.deadday{
	display		:inline-block;
	position	:absolute;
	bottom		:1vw;
	left		:0;
	right		:0;
	margin		:auto;
	background	:#fafafa;
	border		:1px solid #303030;
	padding		:0.5vw;
	font-size	:3vw;
	width		:11vw;
	text-align	:center;
	color		:#d00000;
	font-weight:700;
}

/*-------------------------------------------------------------------*/
@media screen and (min-width: 560px) {


}
</style>

<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1/i18n/jquery.ui.datepicker-ja.min.js"></script>
<script src="./js/jquery.ui.touch-punch.min.js"></script>
<script>
$(function(){ 


	$('.day_0,.day_1,.day_2').on('click', function(){
       $('.back').fadeIn(200);
       $('.cal_detail').animate({'top':'10vh'},200);
		console.log($(this).attr('id'));
		Tmp_y=$(this).attr('id').substr(1,4);
		Tmp_m=$(this).attr('id').substr(5,2);
		Tmp_d=$(this).attr('id').substr(7,2);
		Tmp_w=$(this).attr('week');
		Tmp_d=Tmp_y	+'年'+Tmp_m	+'月'+Tmp_d	+'日'+Tmp_w;

		$('.cal_detail_ttl').text(Tmp_d);

    });

	$('.cal_detail_close').on('click', function(){
       $('.back').fadeOut(200);
       $('.cal_detail').animate({'top':'100vh'},200);
    });


});
</script>
</head>
<body class="body">
	<table class="calendar">
		<tr>
			<td class="calendar_m" colspan="2"><span class="month_back">＜8月</span></td>
			<td class="calendar_m" colspan="3"><span class="month_m"><?=$month_m?>月</span><span class="month_y"><?=$month_y?>年</span></td>
			<td class="calendar_m" colspan="2"><span class="month_next">9月＞</span></td>
		</tr>
		<tr>
			<td class="calendar_w ttl_1">日</td>
			<td class="calendar_w ttl_0">月</td>
			<td class="calendar_w ttl_0">火</td>
			<td class="calendar_w ttl_0">水</td>
			<td class="calendar_w ttl_0">木</td>
			<td class="calendar_w ttl_0">金</td>
			<td class="calendar_w ttl_2">土</td>
			<?=$c_inc?>
		</tr>
	</table>

<div class="back">
	<div class="cal_detail">
		<span class="cal_detail_config">■</span>
		<span class="cal_detail_ttl">2020年09月06日（日）</span>
		<span class="cal_detail_close">×</span>
		<div class="cal_detail_memo1">
		メール鑑定　
		</div>


		<div class="cal_detail_memo2">
			<textarea class="cal_detail_memo_txt"></textarea>
		</div>
	</div>
</div>
</body>
</html>
