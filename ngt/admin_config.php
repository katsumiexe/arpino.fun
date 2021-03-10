<?
$sql ="SELECT * FROM wp01_0sch_table";
$sql.=" ORDER BY sort ASC";
if($result = mysqli_query($mysqli,$sql)){
	while($row = mysqli_fetch_assoc($result)){
		$table_sort[$row["sort"]]=1;
		$table_id[$row["in_out"]][$row["sort"]]	=$row["id"];
		$table_dat[$row["id"]]=$row;
	}
}


$sql ="SELECT * FROM wp01_0charm_table";
$sql.=" ORDER BY sort ASC";

if($result = mysqli_query($mysqli,$sql)){
	while($row = mysqli_fetch_assoc($result)){
		$charm_dat[$row["sort"]]=$row;
	}
}
?>

<script>
$(function(){ 
	$('.prof_sort').on('change',function(){

		Tmp=$(this).parents('.plof_list').attr('id').replace('prof_b','');
		Tmp2=$(this).val();

		$('#prof_b'+Tmp2).children('.prof_sort').val(Tmp);
		$('#prof_b'+Tmp2).css('order',Tmp);
		$('#prof_b'+Tmp).css('order',Tmp2);

		console.log(Tmp);
		console.log(Tmp2);

	});
});
</script>
<table>
<tr>
<td>開始時間</td>
<td>
<select name="set_time" class="set_box">
<option value="0">24時</option>
<option value="1" <?if($start_time="1"){?> selected="selected"<?}?>>01時</option>
<option value="2" <?if($start_time="2"){?> selected="selected"<?}?>>02時</option>
<option value="3" <?if($start_time="3"){?> selected="selected"<?}?>>03時</option>
<option value="4" <?if($start_time="4"){?> selected="selected"<?}?>>04時</option>
<option value="5" <?if($start_time="5"){?> selected="selected"<?}?>>05時</option>
<option value="6" <?if($start_time="6"){?> selected="selected"<?}?>>06時</option>
<option value="7" <?if($start_time="1"){?> selected="selected"<?}?>>07時</option>
<option value="8" <?if($start_time="2"){?> selected="selected"<?}?>>08時</option>
<option value="9" <?if($start_time="3"){?> selected="selected"<?}?>>09時</option>
<option value="10" <?if($start_time="4"){?> selected="selected"<?}?>>10時</option>
<option value="11" <?if($start_time="5"){?> selected="selected"<?}?>>11時</option>
<option value="12" <?if($start_time="6"){?> selected="selected"<?}?>>12時</option>
<option value="13" <?if($start_time="1"){?> selected="selected"<?}?>>13時</option>
<option value="14" <?if($start_time="2"){?> selected="selected"<?}?>>14時</option>
<option value="15" <?if($start_time="3"){?> selected="selected"<?}?>>15時</option>
<option value="16" <?if($start_time="4"){?> selected="selected"<?}?>>16時</option>
<option value="17" <?if($start_time="5"){?> selected="selected"<?}?>>17時</option>
<option value="18" <?if($start_time="6"){?> selected="selected"<?}?>>18時</option>
<option value="19" <?if($start_time="1"){?> selected="selected"<?}?>>19時</option>
<option value="20" <?if($start_time="2"){?> selected="selected"<?}?>>20時</option>
<option value="21" <?if($start_time="3"){?> selected="selected"<?}?>>21時</option>
<option value="22" <?if($start_time="4"){?> selected="selected"<?}?>>22時</option>
<option value="23" <?if($start_time="5"){?> selected="selected"<?}?>>23時</option>
</select>
</td>
</tr>

<tr>
<td>開始曜日</td>
<td>
<select name="set_week" class="set_box">
<option value="0">日曜日</option>
<option value="1" <?if($start_week="1"){?> selected="selected"<?}?>>月曜日</option>
<option value="2" <?if($start_week="2"){?> selected="selected"<?}?>>火曜日</option>
<option value="3" <?if($start_week="3"){?> selected="selected"<?}?>>水曜日</option>
<option value="4" <?if($start_week="4"){?> selected="selected"<?}?>>木曜日</option>
<option value="5" <?if($start_week="5"){?> selected="selected"<?}?>>金曜日</option>
<option value="6" <?if($start_week="6"){?> selected="selected"<?}?>>土曜日</option>
</select>
</td>
</tr>
</table>

<table>
<tr>
<td colspan="2">IN</td><td colspan="2">OUT</td>
</tr><tr>
<td>表示</td>
<td>時間</td>
<td>表示</td>
<td>時間</td>
</tr>

<?foreach($table_sort as $a1 => $a2){?>
<tr>
<td><input type="text" name="in_name[<?=$a1?>]" class="set_box" value="<?=$table_dat[$table_id["in"][$a1]]["name"]?>"></td>
<td><input type="text" name="in_time[<?=$a1?>]" class="set_box" value="<?=$table_dat[$table_id["in"][$a1]]["time"]?>"></td>
<td><input type="text" name="out_name[<?=$a1?>]" class="set_box" value="<?=$table_dat[$table_id["out"][$a1]]["name"]?>"></td>
<td><input type="text" name="out_time[<?=$a1?>]" class="set_box" value="<?=$table_dat[$table_id["out"][$a1]]["time"]?>"></td>
</tr>
<?}?>
</table>
プロフィール
<div class="prof_box">
<?foreach($charm_dat as $a1 => $a2){?>
	<div id="prof_b<?=$a2["sort"]?>" class="prof_list" style="order:<?=$a2["sort"]?>;">
		<input type="textbox" value="<?=$a2["sort"]?>" name="prof_sort[<?=$a1?>]" class="prof_sort">
		<input type="text" name="prof_name[<?=$a1?>]" value="<?=$a2["charm"]?>" class="prof_name">
		<select name="prof_name[<?=$a1?>]" class="prof_option">
			<option value="0">コメント</option>
			<option value="1" <?if($a2["style"]== 1){?>selected="selected"<?}?>>文章</option>
		</select>
	</div>
<? } ?>
</div>
オプション
<table>
<tr>
	<td>順</td>
	<td>表題：<input id="sel_ttl_1" type="text" name="" value="" class="sel_ttl"></td>
	<td>未選択
	<select class="sel_option">
		<option value="1">表示</option>
		<option value="2">非表示</option>
	</select>
	</td>
	<td>項目数：<span class="sel_count"></span></td>
</tr>
<tr>
	<td colspan="3" class="sel_flex">
		<div class="sel_block">
		<span class="sel_del">×</span>
			<input id="sel_1" type="text" name="" value="" class="sel_text">
		</div>
	</td>
</tr>
</table>
