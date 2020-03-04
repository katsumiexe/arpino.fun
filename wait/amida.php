<?

$w=$_REQUEST["w"];
if(!$w) $w=0;


$dat_ami[0][0]=1;
$dat_ami[0][1]=-1;
$dat_ami[0][2]=1;
$dat_ami[0][3]=-1;

$dat_ami[1][0]=0;
$dat_ami[1][1]=0;
$dat_ami[1][2]=0;
$dat_ami[1][3]=0;

$dat_ami[2][0]=0;
$dat_ami[2][1]=0;
$dat_ami[2][2]=0;
$dat_ami[2][3]=0;

$dat_ami[3][0]=0;
$dat_ami[3][1]=0;
$dat_ami[3][2]=0;
$dat_ami[3][3]=0;

$dat_ami[4][0]=0;
$dat_ami[4][1]=1;
$dat_ami[4][2]=-1;
$dat_ami[4][3]=0;

?>

<html>
<head>
<style>

.a_line{
	display:inline-block;
	position:absolute;
	width:20vw;
	height:12vw;
	border-left:1vw solid #909090;
	box-sizing:border-box;
	z-index:1;
}
.a_line_end{
	border-right:1vw solid #909090;
	z-index:1;
}

.a_line_on{
	border-bottom:1vw solid #909090;
	z-index:1;
}

.discover{
	position:absolute;
	bottom:35vw;
	left:-4vw;
	width:92vw;
	height:40vw;
	z-index:5;
	background:linear-gradient(#c0e0ff,#a0c0ff);
	box-shadow:0.5vw 0.5vw 1vw rgba(60,60,60,0.8);
/*	background:rgba(20,20,255,0.6);*/
}

.b_line{
	display:inline-block;
	position:absolute;
	width:20vw;
	height:0vw;
	border-left:2vw solid #ff0000;
	box-sizing:border-box;
	z-index:2;
}

.c_line{
	display:inline-block;
	position:absolute;
	width:0vw;
	height:12vw;
	border-bottom:2vw solid #ff0000;
	box-sizing:border-box;
	z-index:3;
}

.d_line{
	display		:inline-block;
	position	:absolute;
	width		:0vw;
	height		:12vw;
	border-bottom:2vw solid #ff0000;
	box-sizing	:border-box;
	z-index		:4;
}

.e_line{
	display		:inline-block;
	position	:absolute;
	width		:20vw;
	height		:0vw;
	border-right:2vw solid #ff0000;
	box-sizing	:border-box;
	z-index		:4;
}


.amida_box{
	display		:inline-block;
	position	:relative;
	background	:#fafafa;
	width		:84vw;
	height		:100vw;	
	margin		:0 auto;
}

.box_base{
	position	:absolute;
	top			:10vw;
	left		:0;
	right		:0;
	margin		:auto;
	width		:60vw;
	height		:90vw;
}

.start{
	position	:absolute;
	width		:15vw;
	height		:6vw;
	line-height	:6vw;
	z-index		:4;
	box-shadow	:0.5vw 0.5vw 1vw rgba(80,80,80,0.8);
	font-size	:3.5vw;
	cursor		:pointer;	
	border		:1vw solid #fafafa;
}

.goal_1{
	position	:absolute;
	width		:15vw;
	height		:8vw;
	line-height	:8vw;
	z-index		:4;
	box-shadow	:0.5vw 0.5vw 1vw rgba(80,80,80,0.8);
	font-size	:3.5vw;
	cursor		:pointer;	
	border		:1vw solid #ff3030;
	background	:#fff0f5;
	color		:#ff3030;
	font-weight:600;
}

.goal_2{
	position	:absolute;
	width		:15vw;
	height		:8vw;
	line-height	:8vw;
	z-index		:4;
	box-shadow	:0.5vw 0.5vw 1vw rgba(80,80,80,0.8);
	font-size	:3.5vw;
	cursor		:pointer;	
	border		:1vw solid #a0a0a0;
	background	:#f0f0f0;
	color		:#a0a0a0;
	font-weight:600;
}


#r0{
	top:2vw;
	left:4vw;;
	background:#903090;
}

#r1{
	top:2vw;
	left:24vw;;
	background:#ffa0d0;
}

#r2{
	top:2vw;
	left:44vw;;
	background:#e0f000;
}

#r3{
	top:2vw;
	left:63vw;;
	background:#9090e0;
}


#g0{
	bottom:2vw;
	left:4vw;;
}

#g1{
	bottom:2vw;
	left:24vw;;
}

#g2{
	bottom:2vw;
	left:44vw;;
}

#g3{
	bottom:2vw;
	left:63vw;;
}

.amida_win{
	position:relative;
	display:none;
	width			:84vw;
	background		:#fafafa;
	color			:#606060;
	margin:2vw auto;
}

.amida_lose{
	position:relative;
	display:none;
	width			:84vw;
	background		:linear-gradient(#c0c0c0,#909090);
	color			:#fafafa;
	height			:12vw;
	margin:2vw auto;
}

.lose_1{
	display			:inline-block;
	position		:absolute;
	top				:0.5vw;
	left			:0;
	right			:0;
	margin			:auto;
	font-size		:5.5vw;
	font-weight		:600;
	
}

.lose_2{
	display			:inline-block;
	position		:absolute;
	bottom			:0.5vw;
	left			:0;
	right			:0;
	margin			:auto;
	font-size		:3.6vw;
	
}


</style>
<script src="./js/jquery-3.2.1.min.js"></script>
<script src="./js/jquery.easing.1.3.js"></script>

<script src="https://katsumiexe.github.io/eve_2003/f_amida.js" charset="UTF-8"></script>
<script src="https://ajaxzip3.github.io/ajaxzip3.js" charset="UTF-8"></script>
<script>
var Tm=800;
var Ad=120;

$(function(){
	$('.amida_box').on('click','.sel',function(){
		$(this).css('border-color','#ff0000');
	
		$('.sel').removeClass('sel');
		Tmp=$(this).attr('id').replace("r", "");

		$.ajax({
			url:'post_amida.php',
			data:{"tmp":Tmp,"wn":"<?=$wn?>"},
			dataType: 'json',
			type:'post',

		}).done(function(data, textStatus, jqXHR){
			$('.discover').delay(100).animate({'height':'0vw'},500);
			$('.box_base').html(data.dat);
			Res(Tmp,data.set);

		}).fail(function(jqXHR, textStatus, errorThrown){
			console.log(jqXHR);
		    console.log(textStatus);
		    console.log(errorThrown);
			console.log(jqXHR.status);
		});

	});

	$("#send_add").on('click', function(){
		if($('input[name=addr11]').val()==''){
			alert('住所が入力されていません。');
			return false;
		}else{
			$('#send_form').submit();
		}
	});

	$('a').on('click', function(){
		if( $('#disp').css('display') == 'none' ||'<?=$orz?>' == '1'){
			if(!confirm('このまま離脱されますとプレゼントは無効になりますがよろしいですか')){
				return false;
			}else{
				Tmp=$(this).attr('href');
				$('#links').attr('action',Tmp).submit();
			}
		}else{
			Tmp=$(this).attr('href');
			$('#links').attr('action',Tmp).submit();
		}
	});

	$("#btn_start").on("click", function(){
		$("#btn_start").attr("disabled", "disabled");
		$(".wrapper").animate({'top':'-2160px'},3000,
		function(){;
			$("#disp").delay(1000).show();
		});
	});


});
</script>
</head>

<body style="background:#f0e0ff;text-align:center;">
<div class="amida_box">
	<div id="r0" class="start sel">START</div>
	<div id="r1" class="start sel">START</div>
	<div id="r2" class="start sel">START</div>
	<div id="r3" class="start sel">START</div>
    <div class="box_base">	
    	<?for($s=0;$s<6;$s++){?>
    		<?for($n=0;$n<3;$n++){?>
    	 		<div class="a_line <?if($dat_ami[$s][$n] ==1 ){?> a_line_on<?}?> <?if(($n) ==2){?> a_line_end<?}?>" style="top:<?=$s*12?>vw; left:<?=$n*20?>vw;"></div>
    	 	<?}?>
    	<?}?>
		<?for($s=0;$s<6;$s++){?>
			<?for($n=0;$n<3;$n++){?>
				<div class="b_line" style="top:<?=$s*12?>vw; left:<?=$n*20?>vw;"></div>
			<?}?>
		<?}?>
		<?for($s=0;$s<6;$s++){?>
			<?for($n=0;$n<3;$n++){?>
				<div class="c_line" style="top:<?=$s*12?>vw; left:<?=$n*20?>vw;"></div>
			<?}?>
		<?}?>
		<?for($s=0;$s<6;$s++){?>
			<?for($n=0;$n<3;$n++){?>
				<div class="d_line" style="top:<?=$s*12?>vw; right:<?=40-($n*20)?>vw;"></div>
			<?}?>
		<?}?>
    </div>
	<div class="discover"></div>

	<div id="g0" class="goal_1">当り！</div>
	<div id="g1" class="goal_2">残念…</div>
	<div id="g2" class="goal_2">残念…</div>
	<div id="g3" class="goal_2">残念…</div>
</div>
<div class="amida_win">
	<span style="color:#ff0000;">おめでとうございます♪</span><br>
	<div style="text-align:left; padding:3px 5px">下記に必要事項を記載の上、送信して下さい。</div>
	<table style="text-align:center;margin:0 auto;">

	<form id="send_form" action="./p_slot_ok.php" method="post">
		<input type="hidden" value="<?=$ope_p[0]?>" name="id">
		<tr>
			<td style="padding:2px; text-align:right">お名前</td>
			<td style="padding:1px;text-align:left"><input type="text" name="t_name" size="20"></td>
		</tr>
		<tr>
			<td style="padding:2px; text-align:right">郵便番号</td>
			<td style="padding:1px; text-align:left"><input type="text" name="zip11" size="10" maxlength="8" onKeyUp="AjaxZip3.zip2addr(this,'','addr11','addr11');">(数字7桁)</td>
		</tr>
		<tr>
			<td style="padding:2px; text-align:right">ご住所</td>
			<td style="padding:1px; text-align:left"><input type="text" name="addr11" size="20"></td>
		</tr>
		<tr>
			<td>　</td>
			<td style="padding:1px; text-align:left"><input type="text" name="addr12" size="20"></td>
		</tr>
		<tr>
			<td style="display:inline-block; padding:2px; text-align:right;">備考</td>
			<td style="padding:1px; text-align:left"><textarea cols="18" rows="2" name="t_log" style="overflow-y:scroll;overflow-x:none;"></textarea></td>
		</tr>
	</form>
		<tr>
			<td colspan="2" style="padding:1px; text-align:center"><button id="send_add" type="button" value="送信">送信</button></td>
		</tr>
	</table>
</div>



<div class="amida_lose">
<span class="lose_1">残念……</span>
<span class="lose_2">また挑戦してください</span>
</div>




</body>
</html>
