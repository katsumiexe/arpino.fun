<?
$sql	 ="SELECT * FROM wp01_0charm_table";
$sql	.=" WHERE del=0";
$sql	.=" ORDER BY sort ASC";

if($res = mysqli_query($mysqli,$sql)){
	while($res_a = mysqli_fetch_assoc($res)){
		$charm_table[$res_a["id"]]=$res_a;
	}
}

$sql	 ="SELECT * FROM wp01_0check_main";
$sql	.=" WHERE del=0";
$sql	.=" ORDER BY sort ASC";
if($res1 = mysqli_query($mysqli,$sql)){
	while($res1_a = mysqli_fetch_assoc($res1)){
		$ck_main[$res1_a["id"]]=$res1_a;
	}

	$sql	 ="SELECT * FROM wp01_0check_list";
	$sql	.=" WHERE del=0";
	$sql	.=" ORDER BY host_id ASC, list_sort ASC";

	if($res2 = mysqli_query($mysqli,$sql)){
		while($res2_a = mysqli_fetch_assoc($res2)){
			$ck_list[$res2_a["host_id"]][$res2_a["id"]]=$res2_a["list_title"];
		}
	}
}

?>
<style>
<!--
input[type=text]{
	height:30px;
}

.w000{
	width:100%;
	margin-bottom:5px;
}

.w400{
	width:400px;
}

.w50{
	width:60px;
}

.w40{
	width:40px;
}

.tbox{
	height:100px;
	resize:none;
}
.tbox2{
	height:70px;
	resize:none;
}

td{
	vertical-align:top;
}

.up_box{
	display		:block;
	margin		:10px 20px;
	font-size	:14px;
}

.img_up_box{
	display		:flex;
	justify-content: space-around;
	flex-wrap	:wrap;
	width		:400px;
	height		:650px;
	margin		:10px;
}

.img_up_box_in{
	display		:block;
	background	:#fafafa;
	width		:190px;
	height		:305px;
	position	:relative;
	border:2px solid #906000;
}

.img_up_img{
	display		:inline-block;
	position	:absolute;
	top			:20px;
	left		:20px;
	background	:#009000;
	width		:150px;
	height		:200px;
}

.img_up_comm{
	display		:inline-block;
	position	:absolute;
	top			:240px;
	left		:0;
	background	:#906000;
	width		:190px;
	height		:65px;
}

.img_up_file{
	display		:inline-block;
	background	:linear-gradient(#c0c0c0,#909090);
	position	:absolute;
	top			:7px;
	left		:15px;
	height		:25px;
	line-height	:25px;
	width		:75px;
	font-size	:16px;
	text-align	:center;
	color		:#fafafa;
	overflow	:hidden;
	padding		:0 5px;
	border-radius:3px;
}

.img_up_rote{
	display		:inline-block;
	background	:linear-gradient(#c0c0c0,#909090);
	position	:absolute;
	top			:7px;
	left		:105px;
	height		:25px;
	line-height	:25px;
	width		:20px;
	text-align	:center;
	color		:#fafafa;
	border-radius:3px;
	cursor		:pointer;
}

.img_up_reset{
	display		:inline-block;
	background	:linear-gradient(#c0c0c0,#909090);
	position	:absolute;
	top			:7px;
	left		:130px;
	height		:25px;
	line-height	:25px;
	width		:20px;
	text-align	:center;
	color		:#fafafa;
	border-radius:3px;
	cursor		:pointer;
}

.img_up_del{
	display		:inline-block;
	background	:linear-gradient(#c0c0c0,#909090);
	position	:absolute;
	top			:7px;
	left		:155px;
	height		:25px;
	line-height	:25px;
	width		:20px;
	text-align	:center;
	color		:#fafafa;
	border-radius:3px;
	cursor		:pointer;
}

#staff,#cast{
	display:none;
}

#staff_l{
	border-radius:10px 0 0 10px;
}

#cast_l{
	border-radius:0 10px 10px 0;
}

.c_s_box{
	display				:inline-block;
	height				:30px;
	line-height			:30px;
	width				:180px;
	font-size			:0;
	color				:#fafafa;
	text-align			:left;
	margin 0 50px;
}

.c_s_btn{
	display				: inline-block;
	height				:30px;
	line-height			:30px;
	width				:80px;
	font-size			:16px;
	text-align			:center;
	background			:#cccccc;
	color				:#fafafa;
}

.on_1{
	background:#0000c0;
}

.on_2{
	background:#c00000;
}

.ck_off:checked + label{
	background		:linear-gradient(#c0c0f0,#8080ff);
}

.ck_box{
	display			:inline-block;
	width			:100px;
	margin			:3px;
	padding			:4px;
	border-radius	:5px;
	background		:#c0c0c0;
	color			:#fafafa;
	font-size		:14px;
	text-align		:left;
}

.table_title{
	background		:linear-gradient(#e0e0e0,#d0d0d0);
	padding			:5px;
	font-size		:14px;
}




.img_box_out1{
	position	:absolute;
	background	:rgba(255,255,255,0.6);
	top			:0;
	left		:0;
	width		:20px;
	height		:20px;
	z-index		:5;
}

.img_box_out2{
	position	:absolute;
	background	:rgba(255,255,255,0.6);
	top			:0;
	left		:20px;
	width		:150px;
	height		:20px;
	border-bottom:1px solid #ff0000;
	z-index		:5;
}

.img_box_out3{
	position	:absolute;
	background	:rgba(255,255,255,0.6);
	top			:0;
	right		:0;
	width		:20px;
	height		:20px;
	z-index		:5;
}

.img_box_out4{
	position	:absolute;
	background	:rgba(255,255,255,0.6);
	top			:20px;
	left		:0;
	width		:20px;
	height		:200px;
	border-right:1px solid #ff0000;
	z-index		:5;
}

.img_box_out5{
	position	:absolute;
	background	:rgba(255,255,255,0.6);
	top			:20px;
	right		:0;
	width		:20px;
	height		:200px;
	border-left	:1px solid #ff0000;
	z-index		:5;
}

.img_box_out6{
	position	:absolute;
	background	:rgba(255,255,255,0.6);
	bottom		:0;
	left		:0;
	width		:20px;
	height		:20px;
	z-index		:5;
}

.img_box_out7{
	position	:absolute;
	background	:rgba(255,255,255,0.6);
	bottom		:0;
	left		:20px;
	width		:150px;
	height		:20px;
	border-top	:1px solid #ff0000;
	z-index		:5;
}

.img_box_out8{
	position	:absolute;
	background	:rgba(255,255,255,0.6);
	bottom		:0;
	right		:0;
	width		:20px;
	height		:20px;
	z-index		:5;
}

.cvw_0{
	position	:absolute;
	background	:#f0f0f0;
}

input[type=range] {
	-webkit-appearance:none;
	background		:#f17766;
	height			:6px;
	width			:80px;
	display			:inline-block;
	border			:none;
	margin			:8px 5px;
	border-radius	:0;
}

input[type=range]::-webkit-slider-thumb{
	-webkit-appearance	:none;
	background			:#f17766;
	height				:14px;
	width				:14px;
	border-radius		:50%;
	border				:2px solid #ffffff;
}

input[type=range]::-ms-tooltip{
	display:none;
}

input[type=range]::-moz-range-track{
	height:0;
}

input[type=range]::-moz-range-thumb{
	background		:#f17766;
	height			:14px;
	width			:14px;
	border-radius	:50%;
	border			:2px solid #ffffff;
}

.zoom_mi{
	display				:inline-block;
	height				:20px;
	flex-basis			:15px;
	border				:1px solid #f17766;
	border-radius		:5px 0 0 5px;
	line-height			:20px;
	text-align			:center;
	cursor				:pointer;
	background			:#ffe0f0;
	color				:#f17766;
	font-size			:14px;
	font-weight			:600;
}		

.zoom_pu{
	display				:inline-block;
	height				:20px;
	flex-basis			:15px;
	border				:1px solid #f17766;
	border-radius		:0 5px 5px 0;
	line-height			:20px;
	text-align			:center;
	cursor				:pointer;
	background			:#ffe0f0;
	color				:#f17766;
	font-size			:14px;
	font-weight			:600;
}

.zoom_rg{
	display				:inline-block;
	height				:20px;
	line-height			:20px;
	flex				:1;
	border				:1px solid #f17766;
	background			:#ffe0f0
}

.zoom_box{
	border				:1px solid #f17766;
	color				:#f17766;
	display				:inline-block;
	height				:20px;
	flex-basis			:35px;
	line-height			:20px;
	text-align			:center;
	margin-left			:5px;
	background			:#ffffff;
	font-weight			:600;
	font-size			:14px;
}

.img_box_in{
	position		:absolute;
	top				:0;
	left			:0;
	width			:190px;
	height			:240px;
	overflow		:hidden;
}


.img_box_in3{
	display			:flex;
	flex-wrap		:nowrap;
	font-size		:0;
	position		:absolute;
	top				:38px;
	left			:15px;
	width			:160px;
	height			:25px;
}

.sex_box{
	position		:relative;
	display			:inline-block;
	height			:30px;
	width			:70px;
}

.sex_box_ck{
	position:absolute;
	top:0;
	left:3px;
	bottom:0;
	margin:auto !important; 
}

.sex_box_txt{
	position:absolute;
	display	:inline-block;
	top		:0px;
	left	:25px;
	bottom	:0;
	margin	:auto;
	height:30px;
	line-height:30px;

}

.cvs0{
	width:150px;
	height:200px;

}
.head{
	display			:inline-block;
	position		:fixed;
	top				:0;
	left			:180px;
	width			:calc(100vw - 180px);
	height			:50px;
	background		:#0000d0;
	z-index:10;
}

.foot{
	display			:inline-block;
	position		:fixed;
	bottom			:0;
	left			:180px;
	width			: calc(100vw - 180px);
	height			:30px;
	background		:#00d000;
	z-index:10;

}
.wrap{
	display			:inline-flex;
	margin:50px 0 30px 0;
	width:1200px;

}
-->
</style>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script src="./js/jquery.ui.touch-punch.min.js"></script>
<script src="./js/image.js?_<?=time()?>"></script>
<script>
$(function(){ 
	$('#staff_l').on('click',function () {
		$(this).addClass('on_1');
		$('#cast_l').removeClass('on_2');
		$('.cast_table').fadeOut(100);
	});

	$('#cast_l').on('click',function () {
		$(this).addClass('on_2');
		$('#staff_l').removeClass('on_1');
		$('.cast_table').fadeIn(100);
	});
});
</script>

<header class="head">
<h2>スタッフ登録</h2>
<form action="" method='post' id="my-submenu-form">
<button type='submit' class='button button-primary button-large' name="set" value="保存">保存</button>
<button type='submit' class='button button-primary button-large' name="del" value="削除">削除</button>
<input type="hidden" value="1" name="staff_set">
<div class="c_s_box">
　<input id="staff" value="1" type="radio" name="c_s"><label id="staff_l" for="staff" class="c_s_btn">STAFF</label>
　<input id="cast" value="2" type="radio" name="c_s" checked="checked"><label id="cast_l" for="cast" class="c_s_btn on_2">CAST</label>
</div>
</header>

<div class="wrap">
<div class="main_box">
<table style="width:720px; table-layout: fixed;">
<tr>
<td class="table_title" colspan="3">
STAFF情報
</td>
</tr><tr>
<td>
	<div>名前			</div><input type="text" name="staff_name" class="w000" autocomplete="off">
</td><td>
	<div>フリガナ		</div><input type="text" name="staff_kana" class="w000" autocomplete="off">
</td><td>
	<div>生年月日		</div><input type="text" id="b_yy" name="b_yy" class="w60" value="1990" size="4" maxlength="4" autocomplete="off">年 <input type="text" class="w40" id="b_mm" name="b_mm" value="01" size="2" maxlength="2" autocomplete="off">月 <input type="text" class="w40" id="b_dd" name="b_dd" value="01" size="2" maxlength="2" autocomplete="off">日
</td>
</tr><tr>
<td colspan="2">
	<div>住所			</div><input type="text" name="staff_address" class="w000" autocomplete="off">
</td><td >
	<div>性別			</div>
<span class="sex_box"><input id="sex1" type="radio" name="staff_sex" value="1" class="sex_box_ck"><label for="sex1" class="sex_box_txt">男性</label></span>
<span class="sex_box"><input id="sex2" type="radio" name="staff_sex" value="2" class="sex_box_ck"><label for="sex2" class="sex_box_txt">女性</label></span>
<span class="sex_box"><input id="sex3" type="radio" name="staff_sex" value="3" class="sex_box_ck"><label for="sex3" class="sex_box_txt">他</label></span>
</td>
</tr><tr>
<td>
	<div>電話番号		</div><input type="text" name="staff_tel" class="w000" autocomplete="off">
</td><td>
	<div>メールアドレス	</div><input type="text" name="staff_mail" class="w000" autocomplete="off">
</td><td>
	<div>LINE			</div><input type="text" name="staff_mail" class="w000" autocomplete="off">
</td>
</tr><tr>
<td>
	<div>役職			</div><input type="text" name="staff_position" class="w000" autocomplete="off">
</td><td>
	<div>グループ		</div><input type="text" name="staff_group" class="w000" autocomplete="off">
</td><td>
	<div>ランク			</div><input type="text" name="staff_rank" class="w000" autocomplete="off">
</td>
</tr>
</table>

<table style="width:720px; table-layout: fixed;" class="cast_table">
<tr>
<td class="table_title" colspan="3">
CAST情報
</td>
</tr><tr>
<td>
	<div>CAST名			</div><input id="genji" type="text" name="genji" class="w000" autocomplete="off">
</td><td>
	<div>フリガナ		</div><input type="text" name="genji_kana" class="w000" autocomplete="off">
</td><td>
	<div>入店日		</div>
	<input type="text" id="ctime_yy" name="ctime_yy" class="w60" value="1990" size="4" maxlength="4" autocomplete="off">年 
	<input type="text" id="ctime_mm" name="ctime_mm" class="w40" value="01" size="2" maxlength="2" autocomplete="off">月 
	<input type="text" id="ctime_dd" name="ctime_dd" class="w40" value="01" size="2" maxlength="2" autocomplete="off">日
</td>
</tr><tr>
<td>
	<div>ログインID		</div><input type="text" name="cast_id" class="w000" autocomplete="off">
</td><td>
	<div>ログインPASS	</div><input type="text" name="cast_pass" class="w000" autocomplete="off">
</td><td>
	<div>給与		</div><input type="text" name="cast_pay" class="w000" autocomplete="off">
	</td>
</tr>
</table>

<table style="width:720px;" class="cast_table table-layout: fixed;">
<tr>
	<td class="table_title" colspan="3">NEWS登録</td>
</tr>	
<tr>
	<td style="width:40%;">公開日
	<input type="text" id="news_date_yy" name="news_date_yy" class="w60" value="1990" size="4" maxlength="4" autocomplete="off">年 
	<input type="text" id="news_date_mm" name="news_date_mm" class="w40" value="01" size="2" maxlength="2" autocomplete="off">月 
	<input type="text" id="news_date_dd" name="news_date_dd" class="w40" value="01" size="2" maxlength="2" autocomplete="off">日
	<td colspan="2"><textarea id="news_box" name="news_box" class="w000 tbox2" autocomplete="off">[name]ちゃんが入店します</textarea></td>
</tr>
</table>
<table style="width:720px;" class="cast_table table-layout: fixed;">
<tr>
	<?foreach((array)$charm_table as $a1 => $a2){?>
<td>
	<div><?=$a2["charm"]?></div>
	<?if($a2["style"] == 1){?>
		<textarea name="charm_table[<?=$a2["id"]?>]" class="w000 tbox" autocomplete="off"></textarea>
	<? }else{ ?>
		<input type="text" name="charm_table[<?=$a2["id"]?>]" class="w000" autocomplete="off">
	<? } ?>
</td>
<?if(($cnt+0) % 2 ==1){?>
</tr><tr>
<?}?>
<?$cnt++;?>
	<? } ?>
</tr>
</table>

<?foreach((array)$ck_main as $a1 => $a2){?>
<table style="width:720px;" class="cast_table">
	<tr>
	<td class="table_title">
<span class="table_title cast_table"><?=$a2["title"]?></span>
</td></tr>
	<tr>
	<td>
		<?foreach((array)$ck_list[$a1] as $b1 => $b2){?>
		<input type="checkbox" id="sel_<?=$b1?>" name="options[<?=$b1?>]" class="ck_off" autocomplete="off" style="display:none; value="1">
		<label for="sel_<?=$b1?>" class="ck_box"><?=$b2?></label>
		<?}?>
	</td>
	</tr>
</table>
<? } ?>
</div>

<div class="main_box cast_table">
	<div class="up_box">
	画像の推奨は縦800px×横600pxです。<br>
	縦：横は4:3です。比率が違う場合は自動的にリサイズされます。<br>
	</div>

	<div class="img_up_box">
	<?for($n=0;$n<4;$n++){?>
		<div class="img_up_box_in">
			<div class="img_box_in">
			<canvas id="cvs<?=$n?>" width="	1200px" height="1600px;" class="cvs0"></canvas>
			<div class="img_box_out1"></div>
			<div class="img_box_out2"></div>
			<div class="img_box_out3"></div>
			<div class="img_box_out4"></div>
			<div class="img_box_out5"></div>
			<div class="img_box_out6"></div>
			<div class="img_box_out7"></div>
			<div class="img_box_out8"></div>
			</div>

			<div class="img_up_comm">
				<label for="upd<?=$n?>" class="img_up_file">UPLOAD</label>
				<span id="rote<?=$n?>" type="button" class="img_up_rote">■</span>
				<span id="reset<?=$n?>" type="button" class="img_up_reset">■</span>
				<span id="del<?=$n?>" type="button" class="img_up_del">■</span>
				<div class="img_box_in3">
					<div id="mi<?=$n?>" class="zoom_mi">-</div>
					<div class="zoom_rg"><input id="zoom<?=$n?>" type="range" name="img_z[<?=$n?>]" min="100" max="200" step="1" value="100" class="range_bar"></div>
					<div id="pu<?=$n?>" class="zoom_pu">+</div><div id="zoom_box<?=$n?>" class="zoom_box">100</div>
				</div>
			</div>
		</div>
		<input id="w_<?=$n?>"type="hidden" value="" name="img_w[<?=$n?>]">
		<input id="h_<?=$n?>"type="hidden" value="" name="img_h[<?=$n?>]">
		<input id="c_<?=$n?>"type="hidden" value="" name="img_c[<?=$n?>]">
		<input id="x_<?=$n?>"type="hidden" value="" name="img_x[<?=$n?>]">
		<input id="y_<?=$n?>"type="hidden" value="" name="img_y[<?=$n?>]">
		<input id="r_<?=$n?>"type="hidden" value="" name="img_r[<?=$n?>]">
	<?}?>
	</div>
</div>
</form>
<input id="upd0" class="img_upd" type="file" accept="image/*" style="display:none;">
<input id="upd1" class="img_upd" type="file" accept="image/*" style="display:none;">
<input id="upd2" class="img_upd" type="file" accept="image/*" style="display:none;">
<input id="upd3" class="img_upd" type="file" accept="image/*" style="display:none;">
</div> 
<footer class="foot"></footer> 

