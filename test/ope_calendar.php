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

/*
$mysqli = mysqli_connect("210.150.110.204", "blue_db", "0909", "blue_db");
if($mysqli){
	mysqli_set_charset($mysqli,'SJIS'); 

*/

/*--■祝日カレンダー--*/
$holiday	= file_get_contents("https://katsumiexe.github.io/pages/holiday.json");
$ob_holiday = json_decode($holiday,true);

$c_month=$_POST["c_month"];
if(!$c_month) $c_month=date("Y-m-01");

/*
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
*/

$calendar[1]	=$c_month;
$month_w[1]		=date("w",strtotime($calendar[1]))-1;
$month_e[1]		=date("t",strtotime($calendar[1]));
$month_ym[1]	=date("Ym",strtotime($calendar[1]));

$s=1;
$month_max		=ceil(($month_w[1]+$month_e[1])/7)*7;
$month_y		=substr($c_month,0,4);
$month_m		=substr($c_month,5,2);

echo "■";
echo $c_month;
echo $month_max;

/*
$idcode="411000001";
$sql	="select * FROM ope_calendar";
$sql .=" WHERE idcode='{$idcode}'";
$sql .=" AND ymd LIKE '{$month_y}{$month_m}%'";
$sql .=" AND memo !=''";
//$sql .=" AND base ='{$page}'";
$sql .=" ORDER BY ymd ASC, hi ASC";

if($res = mysqli_query($mysqli,$sql)){
	while($des = mysqli_fetch_assoc($res)){
		$dat[$des["Ymd"]][]=$des;
	}
}
*/

for($n=0;$n<$month_max ;$n++){


	$tmp_days=$n-$month_w[1];
	$day_id=$month_ym[1]*100+$tmp_days;
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
/*
		$dd="<span class=\"deadday\">締切日</span>";
*/
	}elseif($day_id == $now_ymd){
		$dd="";
		$week_color.=" now";
		$week_title.=" now2";
	}else{
		$dd="";
	}

	if($n>$month_w[1] && $n<=$month_w[1]+$month_e[1]){

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
		$c_inc.=$dd;
		$c_inc.=$s_cnt;
		$c_inc.="</td>";

	}else{
		$c_inc.="<td class=\"calendar_d\"></td>";
	}
}

//}
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

.body {
	margin			: 0;
	padding			: 0;
	line-height		:1.2;
	color			:#333;
	background		:#fafafa;
	font-size		:0;
	font-family		:Verdana, "ＭＳ Ｐゴシック", sans-serif;
	text-align		:center;
	width			:100vw;
}


.main_box{
	display		:inline-block;
	position	:fixed;
	top			:0;
	left		:0;
	width		:100vw;
	height		:100vh;
	background:#ffe0fa;
}

.calendar{
	width:100vw;
	border-collapse		:collapse;
	border				:0.5vw solid #303030;
	border-spacing		:0;
	table-layout		:fixed;
}

.calendar_m{
	height			:10vw;
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
	height			:12vw;
	text-align		:left;
	border			:0.5vw solid #604020;
	vertical-align	:top;
	background:#fafafa;
}

.calendar_d:hover{
	background:#ffffc0;
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


.now{
	box-shadow:1vw -1vw 0 rgba(180,80,250,1) inset,-1vw 1vw 0 rgba(180,80,250,1) inset; 
}

.month_m{
	font-size			:7vw;
	font-weight			:800;
	color				:#fafafa;
	text-shadow			:1px 1px 0 #604020;
}

.month_y{
	font-size			:4.5vw;
	font-weight			:800;
	color				:#fafafa;
	text-shadow			:1px 1px 0 #604020;
}

.month_next,.month_prev{
	font-size			:4.5vw;
	font-weight			:800;
	color				:#fafafa;
	text-shadow			:1px 1px 0 #604020;
	cursor				:pointer;
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
	position		:absolute;
	bottom			:11vh;
	left			:0;
	right			:0;
	border			:1px solid #303030;
	width			:98vw;
	height			:calc(100vh - 90vw - 15vh);
	margin			:auto;
	text-align		:center;
}

.cal_detail_top,.cal_detail_mid{
	display			:flex;
	width			:96vw;
	margin			:0.5vw auto;
}
.cal_detail_mid{
	height			:calc(100vh - 100vw - 15vh);
}

.cal_detail_item{
	display			:inline-block;
	flex			:1;
	height			:7vw;
	line-height		:7vw;
	font-size		:6vw;
	color			:#303030;
	text-align		:left;
}

.cal_detail_ttl{
	display			:inline-block;
	width			:52vw;
	flex-basis		:52vw;
	height			:7vw;
	line-height		:7vw;
	border-bottom	:1vw solid #604020;
	font-size		:4vw;
	font-weight		:800;
	color			:#604020;
	text-align		:right;
	padding-right	:1vw;
}

.cal_detail_memo1{
	display		:inline-block;
	flex		:1;
	border		:1px solid #303030;
	margin		:0.5vw;
	padding		:1vw;
	background	:#fafafa;	
	text-align	:left;
}

.cal_detail_memo2{
	position	:relative;
	display		:inline-block;
	flex-basis	:60vw;
	margin		:0.5vw;
	border		:1px solid #303030;
	padding		:1vw;
	background	:#fafafa;	
	text-align	:left;
	overflow-y	:scroll;
}

.memo2_in{
	position	:relative;
	display		:inline-block;
	width		:59vw;
	text-align	:left;
	margin		:0.5vw auto;
	padding-top	:2vw;
}

.memo2_in_time{
	width		:20vw;
	height		:5vw;
	background	:#000080;
	margin-left	:1vw;
}


.cal_detail_memo_txt{
    border			:1px solid #303030;
    background		:#fafafa;
	margin			:0 auto 0 1vw;
    font-size		:3.5vw;
	line-height		:4.5vw;
    color			:#303030;
	display			:inline-block;
	width			:55vw;
	text-align		:left;
	padding:1vw;
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


.memo2_in_del,.memo2_in_fix{
	position		:absolute;
	top				:1vw;
	width			:8vw;
	height			:5.5vw;
	border-radius	:1vw;
	background		:#000060;
}

.memo2_in_del{
	right			:1vw;

}

.memo2_in_fix{
	right			:12vw;
}

.memo{
	position	:fixed;
	z-index		:5;
	height		:68vw;	
	width		:95vw;
	left		:0;
	right		:0;
	top			:120vh;
	margin		:auto;
	background	:linear-gradient(135deg, #f0e0d0, #e0d0a0) ;
	border		:1px solid #303030;
	border-radius:2vw;
	box-shadow:0.5vw 0.5vw 0.5vw rgba(30,30,30,0.5);
}

.memo_sel{
	position	:absolute;
	top			:2vw;
	left		:2vw;
	width		:24vw;
	height		:8vw;
	font-size:5vw;

}

.memo_txt{
	position	:absolute;
	top			:12vw;
	left		:0;
	right		:0;
	margin		:auto;
	width		:90vw;
	height		:40vw;
	font-size	:4.5vw;
	padding		:1vw;
	border		:1px solid #303030;
	resize		:none;
}

.memo_del{
	position	:absolute;
	top			:2vw;
	right		:2vw;
	width		:8vw;
	height		:8vw;
	font-size	:6vw;
}

.memo_set{
	display			:inline-block;
	position		:absolute;
	bottom			:3vw;
	left			:0;
	right			:0;
	margin			:auto;
	width			:43vw;
	height			:11vw;
	background		:#c0a060;
	box-shadow		:0.5vw 1vw 0.5vw rgba(60,60,60,0.65);
	border-radius	:2vw;
}

.memo_set_in{
	display			:inline-block;
	position		:absolute;
	top				:0;
	bottom			:0;
	left			:0;
	right			:0;
	margin			:auto;
	width			:40vw;
	height			:8vw;
	line-height		:8vw;
	font-size		:5vw;
	border			:0.5vw dashed #fafafa;
	border-radius	:2vw;
	text-align		:center;
	color			:	#fafafa;
	font-weight		:800;
//	text-shadow:2px 2px 2px #906000;
}

.memo_set:active{
	bottom			:2.5vw;
	box-shadow		:0.5vw 0.5vw 0.5vw rgba(60,60,60,0.65);
}

.back{
	display		:none;
	position	:fixed;
	top			:-10vh;
	left		:-10vw;
	height		:120vh;
	width		:120vw;	
	background:rgba(200,200,200,0.8);
}

/*-------------------------------------------------------------------*/
@media screen and (min-width: 560px) {

.main_box{
	position	:relative;
	width		:100%;
	max-width	:600px;
	height		:100vh;
}

.calendar{
	width:100%;
	border				:1px solid #303030;
}

.calendar_m{
	height			:50px;
}


.calendar_w{
	height			:30px;
	line-height		:30px;
	border			:1px solid #604020;
	font-size		:18px;
}

.calendar_d{
	height			:100px;
	border			:1px solid #604020;
}

.calendar_d:hover{
	background:#ffffc0;
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
	height			:20px;
	line-height		:20px;	
	width			:30px;
	font-size		:14px;
	border-radius:	0 0 10px 0;
}


.now{
	box-shadow:5px -5px 0 rgba(180,80,250,1) inset,-5px 5px 0 rgba(180,80,250,1) inset; 
}

.month_m{
	font-size			:36px;
}

.month_y{
	font-size			:22px;
}

.month_next,.month_prev{
	font-size			:22px;
}


.cal_detail{
	width			:300px;
	position		:absolute;
	bottom			:auto;
	left			:600px;
	right			:auto;
	top:0;
}


.cal_detail_top,.cal_detail_mid{
	display			:flex;
	width			:480px;
	margin			:10px auto;

}
.cal_detail_mid{
	height			:auto;
}

.cal_detail_item{
	height			:30px;
	line-height		:30px;
	font-size		:22px;
}

.cal_detail_ttl{
	width			:260px;
	flex-basis		:260px;
	height			:30px;
	line-height		:30px;
	border-bottom	:5px solid #604020;
	font-size		:20px;
	padding-right	:10px;
}

.cal_detail_memo1{
	display:none;
}

.cal_detail_memo2{
	position	:relative;
	display		:inline-block;
	margin		:5px;
	padding		:5px;
}

.memo2_in{
	width		:470px;
	margin		:5px auto;
	padding-top	:10px;
}

.memo2_in_time{
	display:inline-block;
	width		:120px;
	height		:30x;
	background	:#000080;
	margin-left	:5px;
}


.cal_detail_memo_txt{
    border			:1px solid #303030;
    background		:#fafafa;
	margin			:0 auto 0 5px;
    font-size		:16px;
	line-height		:22px;
    color			:#303030;
	display			:inline-block;
	width			:420px;
	text-align		:left;
	padding			:5px;
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


.memo2_in_del,.memo2_in_fix{
	position		:absolute;
	top				:5px;
	width			:50px;
	height			:30px;
	border-radius	:10px;
	background		:#000060;
}

.memo2_in_del{
	right			:35px;

}

.memo2_in_fix{
	right			:100px;
}

.memo{
	position	:fixed;
	z-index		:5;
	height		:68vw;	
	width		:95vw;
	left		:0;
	right		:0;
	top			:120vh;
	margin		:auto;
	background	:linear-gradient(135deg, #f0e0d0, #e0d0a0) ;
	border		:1px solid #303030;
	border-radius:2vw;
	box-shadow:0.5vw 0.5vw 0.5vw rgba(30,30,30,0.5);
}

.memo_sel{
	position	:absolute;
	top			:2vw;
	left		:2vw;
	width		:24vw;
	height		:8vw;
	font-size:5vw;

}

.memo_txt{
	position	:absolute;
	top			:12vw;
	left		:0;
	right		:0;
	margin		:auto;
	width		:90vw;
	height		:40vw;
	font-size	:4.5vw;
	padding		:1vw;
	border		:1px solid #303030;
	resize		:none;
}

.memo_del{
	position	:absolute;
	top			:2vw;
	right		:2vw;
	width		:8vw;
	height		:8vw;
	font-size	:6vw;
}

.memo_set{
	display			:inline-block;
	position		:absolute;
	bottom			:3vw;
	left			:0;
	right			:0;
	margin			:auto;
	width			:43vw;
	height			:11vw;
	background		:#c0a060;
	box-shadow		:0.5vw 1vw 0.5vw rgba(60,60,60,0.65);
	border-radius	:2vw;
}

.memo_set_in{
	display			:inline-block;
	position		:absolute;
	top				:0;
	bottom			:0;
	left			:0;
	right			:0;
	margin			:auto;
	width			:40vw;
	height			:8vw;
	line-height		:8vw;
	font-size		:5vw;
	border			:0.5vw dashed #fafafa;
	border-radius	:2vw;
	text-align		:center;
	color			:	#fafafa;
	font-weight		:800;
//	text-shadow:2px 2px 2px #906000;
}

.memo_set:active{
	bottom			:2.5vw;
	box-shadow		:0.5vw 0.5vw 0.5vw rgba(60,60,60,0.65);
}

.back{
	display		:none;
	position	:fixed;
	top			:-10vh;
	left		:-10vw;
	height		:120vh;
	width		:120vw;	
	background:rgba(200,200,200,0.8);
}




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
		Tmp_y=$(this).attr('id').substr(1,4);
		Tmp_m=$(this).attr('id').substr(5,2);
		Tmp_d=$(this).attr('id').substr(7,2);
		Tmp_w=$(this).attr('week');
		Tmp_d=Tmp_y	+'年'+Tmp_m	+'月'+Tmp_d	+'日'+Tmp_w;
		$('.cal_detail_ttl').text(Tmp_d);

		if($(this).hasClass('day_0')){
			$('.cal_detail').addClass('day_0').removeClass('day_1 day_2');

		}else if($(this).hasClass('day_1')){
			$('.cal_detail').addClass('day_1').removeClass('day_0 day_2');

		}else if($(this).hasClass('day_2')){
			$('.cal_detail').addClass('day_2').removeClass('day_1 day_0');
		}
    });


	$('.cal_write').on('click', function(){
		$('.back').fadeIn(200);
		$('.memo').animate({'top':'20vh'},200);
    });

	$('.memo_del').on('click', function(){
		$('.back').fadeOut(200);
		$('.memo').animate({'top':'120vh'},200);
    });

	$('.calendar').on('click','.month_prev', function(){
		$.post({
			url:Dir + "/post_ope_calendar_n.php",
			data:{
				'nowmonth'	:$('#hidden_month').val(),
				'idcode'	:'<?=$idcode?>',
				'next'		:'prev'
			},
		}).done(function(data, textStatus, jqXHR){
			$('.main').html(data);
			$('.calendar').html(data.html);
			$('#hidden_month').val(data.hidden);
		});
    });

	$('.calendar').on('click','.month_next', function(){
		$.post({
			url:Dir + "/post_ope_calendar_n.php",
			data:{
				'nowmonth'	:$('#hidden_month').val(),
				'idcode'	:'<?=$idcode?>',
				'next'		:'next'
			},
		}).done(function(data, textStatus, jqXHR){
			$('.main').html(data);
			$('.calendar').html(data.html);
			$('#hidden_month').val(data.hidden);
		});
    });
});
</script>
</head>

<body class="body">
<div class="main_box">
	<input id="hidden_month "type="hidden" value="<?=$month_y?><?=$month_m?>">
	<table class="calendar">
		<tr>
			<td class="calendar_m" colspan="2"><span class="month_prev">＜8月</span></td>
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

	<div class="cal_detail">
		<div class="cal_detail_top">
			<div class="cal_detail_item"><span class="cal_write">■</span></div>
			<div class="cal_detail_ttl">2020年09月06日（日）</div>
		</div>

		<div class="cal_detail_mid">
			<div class="cal_detail_memo1">
			メール鑑定<br>　
			スケジュール<br>
			</div>
			<div class="cal_detail_memo2">
				<div class="memo2_in">
					<div class="memo2_in_time"></div>
					<div class="memo2_in_del"></div>
					<div class="memo2_in_fix"></div>
					<div class="cal_detail_memo_txt">
					てすてすと<bR>
					てすてすと<bR>
					てすてすと<bR>
					てすてすと<bR>
					てすてすと<bR>
					てすてすと<bR>
					</div>
				</div>
				<div class="memo2_in">
					<div class="memo2_in_time"></div>
					<div class="cal_detail_memo_txt"></div>
				</div>
				<div class="memo2_in">
					<div class="memo2_in_time"></div>
					<div class="cal_detail_memo_txt"></div>
				</div>
				<div class="memo2_in">
					<div class="memo2_in_time"></div>
					<div class="cal_detail_memo_txt"></div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="back">
	<div class="memo">
		<select id="memo_sel" class="memo_sel">
			<?for($n=0;$n<24;$n++){?>
			<?$tmp=substr("0".$n,-2,2)?>
			<option value="<?=$tmp?>00"><?=$tmp?>:00</option>
			<option value="<?=$tmp?>30"><?=$tmp?>:30</option>
			<?}?>
		</select>
		<div class="memo_del">■</div>
		<textarea id="memo_txt" class="memo_txt"></textarea>
		<div class="memo_set"><span class="memo_set_in">登録</span></div>
	</div>
</div>
</body>
</html>
