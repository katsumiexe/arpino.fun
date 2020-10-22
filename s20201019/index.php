<?
$now_y=date("Y")+0;
$now_m=date("m")+0;
$now_d=date("d")+0;

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
$(function(){ 
	$('.ad').on('change',function(){
		Tmp=$(this).val();
		$('.yy').hide();	
		$('#y'+Tmp).show();	
	});

	$('#set').on('click',function(){
		Tmp=$('.ad').val();
		$('.ans_box').slideUp(100);
		$.post({
			url:'calendar.php',
			data:{
				'yy':$('#y'+Tmp).val(),
				'mm':$('.mm').val(),
				'dd':$('.dd').val(),
			},
			dataType: 'json',

		}).done(function(data, textStatus, jqXHR){
			console.log(data);
			$('.ans_box').slideDown(300).html(data.html);
			$('.dd').val(data.t);
		});
	});
});
</script>
<style>

.ans_box{
	display:none;
	margin		:0 auto;	
	display		:block;
	width		:550px;
	background	:#f8f0ff;
	text-align	:center;
}
.calc_box{
	position	:relative;
	display		:block;
	margin		:0 auto;
	width		:550px;
	height		:40px;
	line-height	:40px;
	background	:#e8e0ff;
	text-align	:center;
	font-size	:0;
}

.ad{
	position	:absolute;
	top			:0;
	bottom		:0;
	left		:5px;
	margin		:auto;
	height		:30px;
	width		:60px;
	font-size	:16px;
}

.yy{
	position	:absolute;
	top			:0;
	bottom		:0;
	left		:70px;
	margin		:auto;

	display		:none;
	height		:30px;
	width		:70px;
	font-size	:16px;
}


.mm{
	position	:absolute;
	top			:0;
	bottom		:0;
	left		:150px;
	margin		:auto;
	height		:30px;
	width		:50px;
	font-size	:16px;
}

.dd{
	position	:absolute;
	top			:0;
	bottom		:0;
	left		:205px;
	margin		:auto;
	height		:30px;
	width		:50px;
	font-size	:16px;
}

.set{
	position	:absolute;
	top			:0;
	bottom		:0;
	left		:260px;
	margin		:auto;
	height		:28px;
	width		:50px;
	font-size	:16px;
}
.ymd{
	display		:inline-block
	width		:30px;
	height		:24px;
	line-height	:24px;
	font-weight	:600;
}
.ans_a{
	display		:inline-flex;
	width		:100%;
	background	:#fafafa;
	border-bottom:2px solid #6080a0;
	font-size	:0;
	height		:40px;
	line-height	:40px;
	text-align	:left;
}

.ans_1{
	padding:2px 5px;
	display:inline-block;
	flex-basis:240px;
	font-size:14px;
}

.ans_2{
	padding:2px 5px;
	display:inline-block;
	flex-basis:130px;
	font-size:14px;
}
.ans_3{
	padding:2px 5px;
	display:inline-block;
	flex-basis:130px;
	font-size:14px;
}
.ans_4{
	padding:2px 5px;
	display:inline-block;
	flex-basis:40px;
	font-size:14px;
}

#y0{
	display:inline-block;
}
</style>
</head>
<body>
<div class="calc_box">
<select class="ad">
<option value="0">西暦</option>
<option value="1">令和</option>
<option value="2">平成</option>
<option value="3">昭和</option>
</select>

<select id="y0" class="yy">
<?for($n=1930;$n<date("Y")+21;$n++){?>
<option value="<?=$n?>"<?if($now_y==$n){?> selected="selected"<?}?>><?=$n?></option><?}?>
</select>

<!--■令和-->
<select id="y1" class="yy">
<option value="2019">元</option>
<?for($n=2020;$n<date("Y")+21;$n++){?>
<option value="<?=$n?>"<?if($now_y==$n){?> selected="selected"<?}?>><?print($n-2018)?></option><?}?>
</select>

<!--■平成-->
<select id="y2" class="yy">
<option value="1989">元</option>
<?for($n=1990;$n<2020;$n++){?>
<option value="<?=$n?>"><?print($n-1988)?></option><?}?>
</select>

<!--■昭和-->
<select id="y3" class="yy">
<option value="1926">元</option>
<?for($n=1927;$n<1990;$n++){?>
<option value="<?=$n?>"><?print($n-1925)?></option><?}?>
</select>


<span class="ymd">年</span>
<select class="mm">
<?for($n=1;$n<13;$n++){?>
<option value="<?=$n?>"<?if($now_m==$n){?> selected="selected"<?}?>><?=$n?></option><?}?>
</select>
<span class="ymd">月</span>

<select class="dd">
<?for($n=1;$n<32;$n++){?>
<option value="<?=$n?>"<?if($now_d==$n){?> selected="selected"<?}?>><?=$n?></option><?}?>
</select>
<span class="ymd">日</span>
<button id="set" type="button" class="set">計算</button>
</div>
<div class="ans_box">
</div>
</body>
</html>
