<style>
<!--
input[type=text]{
	height:30px;
}

.w200{
	width:200px;
}

.w100{
	width:100px;
}

.w80{
	width:80px;
}

.w50{
	width:60px;
}

.w40{
	width:40px;
}

.box{
	display			:inline-flex;
	width			:200px;
	text-align		:center;
	padding			:5px;
	margin			:5px;
	background		:#906000;
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
	display				:inline-block;
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
<h2>オプション登録</h2>
<button type='submit' class='button button-primary button-large' name="chg" value="追加">追加</button>

<?foreach($options as $a1 => $a2){?>
<form action="" method='post' id="config_option<?=$a1?>">
	<button type='submit' class='button button-primary button-large' name="set" value="保存">保存</button>
	<button type='submit' class='button button-primary button-large' name="del" value="削除">削除</button>
	<table>
		<tr>
			<td>
				<input type="text" name="option_group" class="w200" autocomplete="off" value="">
				<select name="option_v<?=$a2["meta_value"]?>" id="option_v<?=$a2["meta_value"]?>">
					<option value="100">未選択表示</option>
					<option <?if($a2["term_group"] == 101){?> selected='selected'<?}?> value="101">未選択非表示</option>
				</select>
			</td>

			<td>
				<?foreach($a2 as $b1){?>
				<div class="box">
					<input type="text" name="option_name[<?=$a1?>][<?=$b1["term_id"]?>]" value="<?=$b1["name"]?>" class="w100" autocomplete="off">
					<input type="text" name="option_slug[<?=$a1?>][<?=$b1["term_id"]?>]" value="<?=$b1["slug"]?>" class="w80" autocomplete="off">
				</div>
				<? } ?>
			</td>
		</tr>
	</table>
</form>
<?}?>
</div> 

