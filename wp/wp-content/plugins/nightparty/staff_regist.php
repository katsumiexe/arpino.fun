<style>
<!--
input[type=text]{
	height:30px;
}

.w200{
	width:200px;
}

.w50{
	width:60px;
}

.w40{
	width:40px;
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


-->
</style>
<div class="wrap">
<h2>スタッフ登録</h2>
<form action="" method='post' id="my-submenu-form">
<button type='submit' class='button button-primary button-large' name="set" value="保存">保存</button>
<button type='submit' class='button button-primary button-large' name="del" value="削除">削除</button>
<input type="hidden" value="1" name="staff_set">
<div class="c_s_box">
　<input id="staff" value="1" type="radio" name="c_s"><label id="staff_l" for"staff" class="c_s_btn on_1">STAFF</label>
　<input id="cast" value="2" type="radio" name="c_s"><label for"staff" id="cast_l" class="c_s_btn">CAST</label>
</div>


<table>
<tr><td>
	<div>名前			</div><input type="text" name="staff_name" class="w200" autocomplete="off">
	<div>フリガナ		</div><input type="text" name="staff_kana" class="w200" autocomplete="off">
	<div>生年月日		</div><input type="text" id="b_yy" name="b_yy" class="w60" value="1990" size="4" maxlength="4" autocomplete="off">年 <input type="text" class="w40" id="b_mm" name="b_mm" value="01" size="2" maxlength="2" autocomplete="off">月 <input type="text" class="w40" id="b_dd" name="b_dd" value="01" size="2" maxlength="2" autocomplete="off">日
	<div>性別			</div>
	<input id="sex1" type="radio" name="staff_sex" value="1"><label for="sex1">男性</label>
	<input id="sex2" type="radio" name="staff_sex" value="2"><label for="sex2">女性</label> 
	<input id="sex3" type="radio" name="staff_sex" value="3"><label for="sex3">他</label> 
	
	<div>役職			</div><input type="text" name="staff_position" class="w200" autocomplete="off">
	<div>グループ		</div><input type="text" name="staff_group" class="w200" autocomplete="off">
	<div>ランク			</div><input type="text" name="staff_rank" class="w200" autocomplete="off">

	<div>電話番号		</div><input type="text" name="staff_tel" class="w200" autocomplete="off">
	<div>住所			</div><input type="text" name="staff_address" class="w200" autocomplete="off">
	<div>メールアドレス	</div><input type="text" name="staff_mail" class="w200" autocomplete="off">
	<div>LINE			</div><input type="text" name="staff_mail" class="w200" autocomplete="off">


</td><td>
	<div>ログインID		</div><input type="text" name="cast_id" class="w200" autocomplete="off">
	<div>ログインPASS	</div><input type="text" name="cast_pass" class="w200" autocomplete="off">
	<div>CAST名			</div><input type="text" name="genji" class="w200" autocomplete="off">
	<div>フリガナ		</div><input type="text" name="genji_kana" class="w200" autocomplete="off">
	<div>表示順			</div><input type="text" name="castmail_pass" class="w200" autocomplete="off">
</td><td>

	<?foreach($cast_table as $a1 => $a2){?>
	<div><?=$a2["charm"]?></div>
	<?if($a2["style"] == 1){?>
		<textarea name="cast_table_<?=$a2["id"]?>" class="w200" autocomplete="off"></textarea>
	<? }else{ ?>
		<input type="text" name="cast_table_<?=$a2["id"]?>" class="w200" autocomplete="off">
	<? } ?>
	<? } ?>
</td><td>
	<div class"up_box">
	画像の推奨は縦800px×横600pxです。<br>
	縦：横は4:3です。比率が違う場合は自動的にリサイズされます。<br>
	</div>

	<div class="img_up_box">
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

