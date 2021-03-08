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

?>
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
