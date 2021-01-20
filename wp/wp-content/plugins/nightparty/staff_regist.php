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

td{
	vertical-align:top;
}

.img_up_box{
	display		:flex;
	justify-content: space-around;
	flex-wrap	:wrap;
	background	:#0000f0;
	width		:400px;
	height		:600px;
}

.img_up_box_in{
	display:block;
	background	:#900000;
	width		:190px;
	height		:290px;
	position	:relative;
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
	left		:20px;
	background	:#900090;
	width		:150px;
	height		:40px;
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
	margin			:5px;
	padding			:5px;
	border-radius	:5px;
	background		:#dddddd;
	color			:#fafafa;
	font-size		:14px;
	text-align		:left;
}
.table_title{
	background		:linear-gradient(#e0e0e0,#c0c0c0);
	padding:5px;
	font-size:14px;
}

-->
</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
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


<div class="wrap">
<h2>スタッフ登録</h2>
<form action="" method='post' id="my-submenu-form">
<button type='submit' class='button button-primary button-large' name="set" value="保存">保存</button>
<button type='submit' class='button button-primary button-large' name="del" value="削除">削除</button>
<input type="hidden" value="1" name="staff_set">
<div class="c_s_box">
　<input id="staff" value="1" type="radio" name="c_s"><label id="staff_l" for="staff" class="c_s_btn">STAFF</label>
　<input id="cast" value="2" type="radio" name="c_s"><label id="cast_l" for="cast" class="c_s_btn on_2">CAST</label>
</div>


<table>
<tr><td>
<table style="width:720px;">
<tr>
<td colspan="3">
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
</td><td>
	<div>性別			</div>
	<input id="sex1" type="radio" name="staff_sex" value="1"><label for="sex1">男性</label>
	<input id="sex2" type="radio" name="staff_sex" value="2"><label for="sex2">女性</label> 
	<input id="sex3" type="radio" name="staff_sex" value="3"><label for="sex3">他</label> 
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


<table style="width:720px;" class="cast_table">
<tr>
<td class="table_title" colspan="3">
CAST情報
</td>
</tr><tr>
<td>
	<div>CAST名			</div><input type="text" name="genji" class="w000" autocomplete="off">
</td><td>
	<div>フリガナ		</div><input type="text" name="genji_kana" class="w000" autocomplete="off">
</td><td>
	<div>表示順			</div><input type="text" name="castmail_pass" class="w000" autocomplete="off">
</td>
</tr><tr>
<td>
	<div>ログインID		</div><input type="text" name="cast_id" class="w000" autocomplete="off">
</td><td>
	<div>ログインPASS	</div><input type="text" name="cast_pass" class="w000" autocomplete="off">
</td><td>
</td>
</tr>
</table>
<table style="width:720px;" class="cast_table">
<tr>
	<?foreach($cast_table as $a1 => $a2){?>
<td>
	<div><?=$a2["charm"]?></div>
	<?if($a2["style"] == 1){?>
		<textarea name="cast_table_<?=$a2["id"]?>" class="w000 tbox" autocomplete="off"></textarea>
	<? }else{ ?>
		<input type="text" name="cast_table_<?=$a2["id"]?>" class="w000" autocomplete="off">
	<? } ?>
</td>
<?if(($cnt+0) % 2 ==1){?>
</tr><tr>
<?}?>
<?$cnt++;?>
	<? } ?>
</tr>
</table>

<?for($n=0;$n<count($ck_main);$n++){?>
<table style="width:720px;" class="cast_table">
	<tr>
	<td class="table_title">
<span class="table_title cast_table"><?=$ck_main[$n]["title"]?></span>
</td></tr>
	<tr>
	<td>
		<?foreach($ck_list[$ck_main[$n]["id"]] as $a1 => $a2){?>
		<input type="checkbox" id="sel_<?=$ck_main[$n]["id"]?>_<?=$a1?>" name="sel_<?=$ck_main[$n]["id"]?>_<?=$a1?>" class="ck_off" autocomplete="off" style="display:none;">
		<label for="sel_<?=$ck_main[$n]["id"]?>_<?=$a1?>" class="ck_box"><?=$a2["list_title"]?></label>
		<?}?>
	</td>
	</tr>
</table>
<? } ?>

</td><td class="cast_table">
	<div class"up_box">
	画像の推奨は縦800px×横600pxです。<br>
	縦：横は4:3です。比率が違う場合は自動的にリサイズされます。<br>
	</div>

	<div class="img_up_box"">
	<?for($n=0;$n<4;$n++){?>
		<div class="img_up_box_in">
			<div class="img_up_img">
			</div>
			<div class="img_up_comm">

			</div>
		</div>
	<?}?>
	</div>
</td>
</tr>
</table>
</form>
</div> 
