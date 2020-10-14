<?php
$mysqli = mysqli_connect("localhost", "tiltowait_db", "kk1941", "tiltowait_db");
if(!$mysqli){
	$msg="接続エラー";
	die("接続エラー");
}
mysqli_set_charset($mysqli,'UTF-8'); 

$h_day=$_POST["h_day"];
$pri[1]=800; 
$pri[2]=1000; 
$pri[3]=1200; 
$pri[4]=1200; 

if($h_day){
	$h_time=$_POST["h_time"];
	$ps1=$_POST["ps1"];
	$ps2=$_POST["ps2"];
	$ps3=$_POST["ps3"];
	$ps4=$_POST["ps4"];
	$now=date("Y-m-d H:i:s");
	$sql="INSERT INTO order_data(submit_date,order_day, order_time)";
	$sql.=" VALUES('{$now}','2020-10-{$h_day}','{$h_time}')";
	mysqli_query($mysqli,$sql);
	$tmp_auto=mysqli_insert_id($mysqli);	

	$sql="INSERT INTO order_detail(order_id,name, cnt,price) VALUES";
	if($ps1>0){
		$price=$pri[1]*$ps1;
		$sql.="('{$tmp_auto}','商品1','{$ps1}','{$price}'),";
	}	

	if($ps2>0){
		$price=$pri[2]*$ps2;
		$sql.="('{$tmp_auto}','商品2','{$ps2}','{$price}'),";
	}	

	if($ps3>0){
		$price=$pri[3]*$ps3;
		$sql.="('{$tmp_auto}','商品3','{$ps3}','{$price}'),";
	}	

	if($ps4>0){
		$price=$pri[4]*$ps4;
		$sql.="('{$tmp_auto}','商品4','{$ps3}','{$price}'),";
	}	
	$sql=substr($sql,0,-1);
	mysqli_query($mysqli,$sql);
}else{

$month=date("Ym");
$days=date("d");
$v_month=date("Y年m月",strtotime($month."01"));
$p_month=date("Ym",strtotime($month."01")-86400);
$n_month=date("Ym",strtotime($month."01")+3456000);
$month_w=date("w",strtotime($month."01"))-1;
$month_e=date("t",strtotime($month."01"));
$month_max=ceil(($month_w+$month_e)/7)*7;

for($n=0;$n<$month_max ;$n++){
	if($n % 7 == 0){
		$c_inc.="</tr><tr>";
	}
	$tmp_days=$n-$month_w;
	if($n>$month_w && $n<=$month_w+$month_e){
		$ky=$month."00"+$tmp_days;
		$c_inc.="<td id=\"d_{$tmp_days}\" class=\"calendar_d";
		if($days==$tmp_days){
			$c_inc.=" calendar_t";
		}
		$c_inc.="\">{$tmp_days}</td>";

	}else{
		$c_inc.="<td class=\"calendar_d\"></td>";
	}
}

$from_mail		="noreply@piyo-piyo.work";
if($step==2){
	$from_name	= $from_mail;
	$subject	= "お問合せメール";
	$ret		= "-f ".$from_mail;

	$body="以下の内容でお問合せ承りました\r\n\r\n";
	$body.="名前{$ask_name}\r\n";
	$body.="カナ{$ask_kana}\r\n";
	$body.="郵便{$ask_zip}\r\n";
	$body.="住所{$ask_address1}{$ask_address2}\r\n";
	$body.="{$ask_comment}\r\n";

	$head  = "From: " . mb_encode_mimeheader($from_name,"ISO-2022-JP") . "<{$from_mail}> \r\n";
	$head .= "Content-type: text/plane; charset=UTF-8";
	$head = "From: {$from_mail}" . "\r\n";

	mb_send_mail($staff_mail, $subject, $body, $head);


	$subject	= "メールアドレス登録";
	$ret		= "-f ".$from_mail;

	$body ="{$ask_name}様\r\n";
	$body.="メールアドレスの登録を承りました\r\n";
	$body.="※当メールへの返信はできません。\r\n\r\n";

	$head  = "From: " . mb_encode_mimeheader($from_name,"ISO-2022-JP") . "<{$from_mail}> \r\n";
	$head .= "Content-type: text/plane; charset=UTF-8";
	$head = "From: {$from_mail}" . "\r\n";
	mb_send_mail($ask_mail, $subject, $body, $head);

	$now=date("Y-m-d H:i:s");
	$sql="INSERT INTO zlog_20200509 (regist_time,user_id,user_name,user_kana,user_mail)";
	$sql.=" VALUES ('{$now}','{$ask_id}','{$ask_name}','{$ask_kana}','{$ask_mail}')";
	mysqli_query($mysqli,$sql);
}
}

?>
<!DOCTYPE HTML>
<html lang="ja">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta http-equiv="Content-Style-Type" content="text/css">
<meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0">

<script src="../js/jquery-3.2.1.min.js"></script>
<script src="../js/jquery-ui.min.js"></script>
<script src="https://ajaxzip3.github.io/ajaxzip3.js" charset="UTF-8"></script>
<script src="../js/jquery.autoKana.js"></script>
<script>
var Err=0;
$(function(){ 
var pri=[0,800,1000,1200,1200];

	$.fn.autoKana('#name', '#kana', {
		katakana : true
	});

	$('#send').on('click',function(){
		Err=0;
		if($('#name').val()==''){
			$('#name').css('background','#d00000');
			$('#name_err').show();
			Err=1;
		}

		if($('#id').val()==''){
			$('#id').css('background','#d00000');
			$('#id_err').show();
			Err=1;
		}

		if($('#kana').val()==''){
			$('#kana').css('background','#d00000');
			$('#kana_err').show();
			Err=1;
		}

		if($('#mail').val()==''){
			$('#mail').css('background','#d00000');
			$('#mail_err').show();
			Err=1;
		}

		if(Err == 0){
			$('#send_form').submit();
		}
	});


	$('.lv3').on('change',function(){
		Tmp=$(this).attr('id').replace('ps','');
		$('#c'+Tmp).text($(this).val());
		$('#p'+Tmp).text($(this).val()*pri[Tmp]);
	});

	$('.calendar_d').on('click',function(){
		$('.calendar_d').removeClass('calendar_t');
		$(this).addClass('calendar_t');
		$('.result_day').text($(this).text());
		$('#h_day').val($(this).text());
	});

	$('.time').on('click',function(){
		$('.time').removeClass('time_sel');
		$(this).addClass('time_sel');
		$('.result_time').text($(this).text());
		$('#h_time').val($(this).text());
	});

	$('#send_ok').on('click',function(){
		$('#send_form').submit();
	});

	$('#send_ng').on('click',function(){
		$('#step').val('');
		$('#send_form').submit();
	});

	$('#name').on('keyup',function(){
		$('#kana').css('background','#ffffff');
		$('#kana_err').hide();
	});

	$('.text').on('keyup',function(){
		Err=$(this).attr("id")+"_err";
		$(this).css('background','#ffffff');
		$("#"+Err).hide();
	});
});
</script>
<style>

.body{
	width:100%;
	max-width:600px;
	text-align:center;
	background:#fafafa;
}

.lv{
	border			:1px solid #903000;
	border-radius	:5px;
	background		:#fafafa;
	position		:relative;
	display			:inline-block;
	width			:200px;
	height			:300px;
}

.lv1{
	position	:absolute;
	top			:5px;
	left		:0;
	right		:0;
	margin		:auto;
	width		:180px;
	height		:30px;
	line-height	:30px;
	font-size	:16px;
	background	:#f903000;
	font-color	:#fafafa;
}

.sample_img{
	position	:absolute;
	top			:50px;
	left		:0;
	right		:0;
	margin		:auto;
	width		:180px;
	height		:180px;
}

.lv2{
	position	:absolute;
	top			:250px;
	left		:20px;
	width		:80px;
	height		:30px;
	line-height	:30px;
	font-size	:16px;
	background	:#f9060ff;
	font-color	:#fafafa;
}

.lv3{
	position	:absolute;
	top			:250px;
	right		:20px;
	width		:80px;
	height		:30px;
	line-height	:30px;
	font-size	:16px;
}

.time_box{
	display			:inline-flex;
	width			:250px;
	height			:170px;	
	background		:#eeeeee;
	flex-wrap		: wrap;
	margin:10px;
}


.time{
	display			:inline-block;
	border			:1px solid #303030;
	background		:#fafafa;
	border-radius	:5px;
	text-align		:center;
	line-height		:30px;
	height			:30px;
	color			:#303030;
	flex-basis		:120px;
	margin			:1px;
	cursor:pointer;
}
.calendar{
	width			:300px;
	border-collapse	:collapse;
	table-layout	:fixed;
	background		:#fafafa;
	background		:#302520;
	margin			:15px;
}

.calendar_m{
	text-align		:center;
	height			:25px;
	line-height		:25px;
	font-size		:16px;
	border			:1px solid #c8b880;
	background		:#c8b880;
	color			:#302520;
	font-weight		:800;
}

.calendar_n{
	text-align		:center;
	height			:25px;
	line-height		:25px;
	font-size		:20px;
	border			:1px solid #c8b880;
	color			:#302520;
	background		:#c8b880;
	font-family		:at_icon;
	cursor			:pointer;
}

.calendar_w{
	text-align		:center;
	border			:1px solid #c8b880;
	height			:25px;
	line-height		:25px;
	font-size		:16px;
	color			:#c8b880;
	background		:#fafafa;
}

.calendar_d{
	position		:relative;
	text-align		:center;
	border			:1px solid #c8b880;
	height			:35px;
	line-height		:35px;
	background		:#fafafa;
}

.calendar_t, .time_sel{
	background		:#c8b880;

}
.result_top{
	text-align:center;
	background:#906030;
	color:#fafafa;
	height:30px;
	line-height:30px;
	border:1px solid #906030;
}

.result_item{
	width:200px;
	text-align:left;
	padding:5px;
	border:1px solid #906030;
}
.result_cnt{
	width:80px;
	text-align:right;
	padding:5px;
	border:1px solid #906030;
}
.result_price{
	width:200px;
	text-align:right;
	padding:5px;
	border:1px solid #906030;
}

</style>
</head>
<body class="body">
<?if($h_day){?>
送信しました
<?}else{?>
<form id="send_form" method="post" action="index.php">
<table>
<tr>
<td>
<table id="c" class="calendar">
<tr>
	<td id="c_prev" class="calendar_n">≪</td>
	<td class="calendar_m" colspan="5"><?=$v_month?></td>
	<td id="c_next" class="calendar_n">≫</td>
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
</td><td>
<div class="time_box">
<div id="t10" class="time time_sel">10:00-11:00</div>
<div id="t11" class="time">11:00-12:00</div>
<div id="t12" class="time">12:00-13:00</div>
<div id="t13" class="time">13:00-14:00</div>
<div id="t14" class="time">14:00-15:00</div>
<div id="t15" class="time">15:00-16:00</div>
<div id="t16" class="time">16:00-17:00</div>
<div id="t17" class="time">17:00-18:00</div>
<div id="t18" class="time">18:00-19:00</div>
<div id="t19" class="time">19:00-20:00</div>
</div>
</td></tr></table>
<div class="box_1">
<input type="hidden" value="1" name="step">
<div class="lv">
<div class="lv1">商品1</div>
<img src="./img/sample1.png" class="sample_img">
<div class="lv2">800円</div>
<select id="ps1" class="lv3" name="ps1">
<option value="0">0</option>
<option value="1">1</option>
<option value="2">2</option>
<option value="3">3</option>
<option value="4">4</option>
<option value="5">5</option>
<option value="6">6</option>
<option value="7">7</option>
<option value="8">8</option>
<option value="9">9</option>
<option value="10">10</option>
</select>
</div>

<div class="lv">
<div class="lv1">商品2</div>
<img src="./img/sample2.png" class="sample_img">
<div class="lv2">1000円</div>
<select id="ps2" class="lv3" name="ps2">
<option value="0">0</option>
<option value="1">1</option>
<option value="2">2</option>
<option value="3">3</option>
<option value="4">4</option>
<option value="5">5</option>
<option value="6">6</option>
<option value="7">7</option>
<option value="8">8</option>
<option value="9">9</option>
<option value="10">10</option>
</select>
</div>

<div class="lv">
<div class="lv1">商品3</div>
<img src="./img/sample3.png" class="sample_img">
<div class="lv2">1200円</div>
<select id="ps3" class="lv3" name="ps3">
<option value="0">0</option>
<option value="1">1</option>
<option value="2">2</option>
<option value="3">3</option>
<option value="4">4</option>
<option value="5">5</option>
<option value="6">6</option>
<option value="7">7</option>
<option value="8">8</option>
<option value="9">9</option>
<option value="10">10</option>
</select>
</div>

<div class="lv">
<div class="lv1">商品4</div>
<img src="./img/sample4.png" class="sample_img">
<div class="lv2">1200円</div>
<select id="ps4" class="lv3" name="ps4">
<option value="0">0</option>
<option value="1">1</option>
<option value="2">2</option>
<option value="3">3</option>
<option value="4">4</option>
<option value="5">5</option>
<option value="6">6</option>
<option value="7">7</option>
<option value="8">8</option>
<option value="9">9</option>
<option value="10">10</option>
</select>
</div>
</div>

<input id="h_day" type="hidden" name="h_day" value="<?=$days?>">
<input id="h_time" type="hidden" name="h_time" value="10:00-11:00">
<table class="result">
<tr>
<td class="result_top" colspan="3">
10月<span class="result_day"><?=$days?></span>日　
<span class="result_time">10:00-11:00</span>
</td>
<tr>
<td class="result_top">商品名</td>
<td class="result_top">個数</td>
<td class="result_top">金額</td>
</tr>
<tr>
<td class="result_item">商品1</td>
<td id="c1" class="result_cnt">0</td>
<td id="p1" class="result_price">0</td>
</tr>
<tr>
<td class="result_item">商品2</td>
<td id="c2" class="result_cnt">0</td>
<td id="p2" class="result_price">0</td>
</tr>
<tr>
<td class="result_item">商品3</td>
<td id="c3" class="result_cnt">0</td>
<td id="p3" class="result_price">0</td>
</tr>
<tr>
<td class="result_item">商品4</td>
<td id="c4" class="result_cnt">0</td>
<td id="p4" class="result_price">0</td>
</tr>
</table>
<br>
<button type="submit">送信</button>
</form>
<?}?>
</body>
</html>
