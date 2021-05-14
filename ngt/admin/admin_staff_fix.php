<?
$staff_id=$_REQUEST["staff_id"];

$sql	 ="SELECT * FROM wp01_0staff AS S";
$sql	.=" LEFT JOIN wp01_0cast AS C ON S.staff_id=C.id";
$sql	.=" WHERE staff_id={$staff_id}";
$sql	.=" LIMIT 1";

if($res = mysqli_query($mysqli,$sql) ){
	$staff_data = mysqli_fetch_assoc($res);

	if($staff_data["birthday"]){
		$staff_data["b_yy"]=substr($staff_data["birthday"],0,4);
		$staff_data["b_mm"]=substr($staff_data["birthday"],4,2);
		$staff_data["b_dd"]=substr($staff_data["birthday"],6,2);
	}
	if($staff_data["ctime"]){
		$staff_data["c_yy"]=substr($staff_data["ctime"],0,4);
		$staff_data["c_mm"]=substr($staff_data["ctime"],4,2);
		$staff_data["c_dd"]=substr($staff_data["ctime"],6,2);
	}
}

if($staff_data["id"]){
	$sql	 ="SELECT * FROM wp01_0check_main";
	$sql	.=" WHERE del=0";
	$sql	.=" ORDER BY sort ASC";

	if($result = mysqli_query($mysqli,$sql)){
		while($row = mysqli_fetch_assoc($result)){
			$ck_main[$row["id"]]=$row;
		}
	}

	$sql	 ="SELECT L.id, host_id,list_sort,list_title,cast_id ,sel FROM wp01_0check_list AS L";
	$sql	.=" LEFT JOIN wp01_0check_sel AS S ON L.id=S.list_id";
	$sql	.=" AND(cast_id='{$staff_id}' OR cast_id IS NULL)";
	$sql	.=" AND del=0";
	$sql	.=" ORDER BY host_id ASC, list_sort ASC";

	if($result = mysqli_query($mysqli,$sql)){
		while($row = mysqli_fetch_assoc($result)){
			$ck_sub[$row["host_id"]][$row["id"]]=$row;
		}
	}


	$sql	 ="SELECT * FROM wp01_0charm_table";
	$sql	.=" WHERE del=0";
	$sql	.=" ORDER BY sort ASC";

	if($result = mysqli_query($mysqli,$sql)){
		while($row = mysqli_fetch_assoc($result)){
			$charm_main[$row["id"]]=$row;
		}
	}

	$sql	 ="SELECT * FROM wp01_0charm_sel";
	$sql	.=" WHERE cast_id='{$staff_id}'";
	if($result = mysqli_query($mysqli,$sql)){
		while($row = mysqli_fetch_assoc($result)){
			$charm_list[$row["list_id"]]=$row;
		}
	}

	for($n=0;$n<4;$n++){
		if(file_exists("../img/profile/{$staff_id}/{$n}.jpg")){
			$face[$n]="../img/profile/{$staff_id}/{$n}.jpg?t=".time();		
		}
	}

$sql	 ="SELECT * FROM wp01_0tag";
$sql	.=" WHERE del=0";
$sql	.=" and tag_group='cast_group'";
$sql	.=" ORDER BY sort ASC";
if($result = mysqli_query($mysqli,$sql)){
	while($row = mysqli_fetch_assoc($result)){
		$cast_group[$row["id"]]=$row["tag_name"];
	}
}

}
?>
<style>
<!--

td{
	vertical-align:top;
}


#sel_staff,#sel_cast{
	display:none;
}

#staff_l{
	border-radius:10px 0 0 10px;
}

#cast_l{
	border-radius:0 10px 10px 0;
}


/*
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
	width			:128px;
	margin			:3px;
	padding			:4px;
	border-radius	:5px;
	background		:#c0c0c0;
	color			:#fafafa;
	font-size		:14px;
	text-align		:left;
}


.sex_box{
	position		:relative;
	display			:inline-block;
	height			:30px;
	width			:70px;
}

.sex_box_ck{
	position		:absolute;
	top				:0;
	left			:3px;
	bottom			:0;
	margin			:auto !important; 
}

.sex_box_txt{
	position		:absolute;
	display			:inline-block;
	top				:0px;
	left			:25px;
	bottom			:0;
	margin			:auto;
	height			:30px;
	line-height		:30px;

}
.td_tag{
	font-weight:600;
	color:#101010;
	font-size:14px;

}
*/
-->
</style>
<link rel="stylesheet" href="./css/admin_image.css?t=<?=time()?>">
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

	$('.img_up_al').on('click',function(){
		$(this).parents('.img_box_table').animate({'left':'0'},200);
		$(this).parents('.img_box_table').next('.chg_check').val('0');
	});

	$('.img_up_al2,.img_box_in2').on('click',function(){
		$(this).parents('.img_box_table').animate({'left':'-192px'},200);
		$(this).parents('.img_box_table').next('.chg_check').val('1');
	});

	$('.btn_fix').on('click',function(){
		$('#fix_flg').val('2');
		$('#form_fix').submit();
	});

	$('.btn_del').on('click',function(){
		if(!confirm('削除します。よろしいですか')){
		    return false;
		}else{
			$('#fix_flg').val('4');
			$('#form_fix').submit();
		}
	});
});
</script>

<form id="form" action="" method="post" autocomplete="off">
<input type="hidden" value="<?=$staff_id?>" name="staff_id">
<input id="fix_flg" type="hidden" value="2" name="staff_set">
<header class="head">
<h2 class="head_ttl">スタッフ登録</h2>
<button id="set" type="button" class="submit_btn">保存</button>
<button id="del" type="button" class="submit_btn">削除</button>

<div class="c_s_box">
　<input id="sel_staff" value="1" type="radio" name="c_s"><label id="staff_l" for="staff" class="c_s_btn">STAFF</label>
　<input id="sel_cast" value="2" type="radio" name="c_s" checked="checked"><label id="cast_l" for="cast" class="c_s_btn on_2">CAST</label>
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
	<div>名前			</div><input type="text" name="staff_name" value="<?=$staff_data["name"]?>" class="w000" autocomplete="off">
</td><td>
	<div>フリガナ		</div><input type="text" name="staff_kana" value="<?=$staff_data["kana"]?>" class="w000" autocomplete="off">
</td><td>
	<div>生年月日		</div><input type="text" id="b_yy" name="b_yy" class="w60" value="1990" size="4" maxlength="4" autocomplete="off">年 <input type="text" class="w40" id="b_mm" name="b_mm" value="01" size="2" maxlength="2" autocomplete="off">月 <input type="text" class="w40" id="b_dd" name="b_	dd" value="01" size="2" maxlength="2" autocomplete="off">日
</td>
</tr><tr>
<td colspan="2">
	<div>住所			</div><span></span><input type="text" name="staff_address " value="<?=$staff_data["address"]?>" class="w000">
</td><td >
	<div>性別			</div>

<label for="sex1" class="ck_free">
	<span class="check2">
		<input id="sex1" type="radio" name="staff_sex" value="1" class="ck0" <?if($staff_data["sex"]+0<2){?>checked="checked"<?}?>>
		<span class="check1"></span>
	</span>
	女性
</label>

<label for="sex2" class="ck_free">
	<span class="check2">
		<input id="sex2" type="radio" name="staff_sex" value="2" class="ck0" <?if($staff_data["sex"]+0==2){?>checked="checked"<?}?>>
		<span class="check1"></span>
	</span>
	男性
</label>

<label for="sex3" class="ck_free">
	<span class="check2">
		<input id="sex3" type="radio" name="staff_sex" value="3" class="ck0" <?if($staff_data["sex"]+0 == 3){?>checked="checked"<?}?>>
		<span class="check1"></span>
	</span>
	他
</label>
</td>
</tr><tr>
<td>
	<div>電話番号		</div><input type="text" name="staff_tel" value="<?=$staff_data["tel"]?>" class="w000" autocomplete="off">
</td><td>
	<div>メールアドレス	</div><input type="text" name="staff_mail" value="<?=$staff_data["mail"]?>" class="w000" autocomplete="off">
</td><td>
	<div>LINE			</div><input type="text" name="staff_line" value="<?=$staff_data["line"]?>" class="w000" autocomplete="off">
</td>
</tr><tr>
<td>
	<div>役職			</div><input type="text" name="staff_position" value="<?=$staff_data["position"]?>" class="w000" autocomplete="off">
</td><td>
	<div>ランク			</div><input type="text" name="staff_rank" value="<?=$staff_data["rank"]?>" class="w000" autocomplete="off">
</td><td>
	<?if(is_array($cast_group)){?>
	<div>グループ		</div>
	<select name="staff_group" class="w000" autocomplete="off">
	<option value="">選択</option>
	<?foreach($cast_group as $a1 => $a2){?>
	<option value="<?=$a1?>"<?if($staff_data["group"]==$a1){?> selected="selected"<?}?>><?=$a2?></option>
	<?}?>
	</select>
	<?}?>
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
	<div>ログインPASS	</div><input type="text" name="cast_pass" class="w000" autocomplete="new_password">
</td><td>
	<div>給与		</div><input type="text" name="cast_salary" class="w000" autocomplete="off">
	</td>
</tr>
</table>

<table style="width:720px; table-layout: fixed;" class="cast_table">
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

<?if($ck_main){?>
<?foreach($ck_main as $a1 => $a2){?>
	<table style="width:720px;" class="cast_table">
		<tr>
			<td class="table_title"><?=$a2["title"]?></td>
		</tr>
		<tr>
		<td><?if($ck_sub[$a1]){?><?foreach($ck_sub[$a1] as $b1 => $b2){?><input type="checkbox" id="sel_<?=$b1?>" name="options[<?=$b1?>]" class="ck_off" autocomplete="off" style="display:none; value="1"<?if($b2["sel"] == 1){?> checked="checked"<?}?>><label for="sel_<?=$b1?>" class="ck_box"><?=$b2["list_title"]?></label><?}?><?}?></td>
		</tr>
	</table>
<? } ?>
<? } ?>
</div>

<div class="main_box cast_table">
	<div class="img_box_flex">
	<?for($n=0;$n<4;$n++){?>
		<div class="img_box_in">
			<table class="img_box_table" <?if($face[$n]){?> style="left:0px;"<?}?>>
				<tr>
					<td class="img_box_td_1">
						<img src="<?=$face[$n]?>" style="width:150px; margin:20px;">
					</td>
					<td class="img_box_td_1">
					<div class="img_box_td_1_in"><canvas id="cvs<?=$n?>" width="1200px" height="1600px;" class="cvs0"></canvas></div>

					<div class="img_box_out1"></div>
					<div class="img_box_out2"></div>
					<div class="img_box_out3"></div>
					<div class="img_box_out4"></div>
					<div class="img_box_out5"></div>
					<div class="img_box_out6"></div>
					<div class="img_box_out7"></div>
					<div class="img_box_out8"></div>
					</td>
				</tr>
				<tr>
					<td class="img_box_td_2">
						<span class="img_box_in2">写真変更</span>
						<span class="img_up_al2">
						<span class="img_up_al2_in"></span>
						</span>
					</td>
					<td class="img_box_td_2">
						<label for="upd<?=$n?>" class="img_up_file"></label>
						<span id="rote<?=$n?>" type="button" class="img_up_rote"></span>
						<span id="reset<?=$n?>" type="button" class="img_up_reset"></span>
						<span id="del<?=$n?>" type="button" class="img_up_del"></span>
						<div class="img_box_in3">
							<div id="mi<?=$n?>" class="zoom_mi">-</div>
							<div class="zoom_rg"><input id="zoom<?=$n?>" type="range" name="img_z[<?=$n?>]" min="100" max="200" step="1" value="100" class="range_bar"></div>
							<div id="pu<?=$n?>" class="zoom_pu">+</div><div id="zoom_box<?=$n?>" class="zoom_box">100</div>
						</div>
<?if($face[$n]){?>
						<span class="img_up_al">
						<span class="img_up_al_in"></span>
						</span>
<?}?>
					</td>
				</tr>
			</table>
			<input type="hidden" value="<?if($face[$n]){?>0<?}else{?>1<?}?>" class="chg_check" name="chg_check[<?=$n?>]">
			<input id="w_<?=$n?>"type="hidden" value="" name="img_w[<?=$n?>]">
			<input id="h_<?=$n?>"type="hidden" value="" name="img_h[<?=$n?>]">
			<input id="c_<?=$n?>"type="hidden" value="" name="img_c[<?=$n?>]">
			<input id="x_<?=$n?>"type="hidden" value="" name="img_x[<?=$n?>]">
			<input id="y_<?=$n?>"type="hidden" value="" name="img_y[<?=$n?>]">
			<input id="r_<?=$n?>"type="hidden" value="" name="img_r[<?=$n?>]">
		</div>
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
