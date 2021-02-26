<table>

<tr>
<td>開始時間</td>
<td>
<select name="set_week" class="set_box">
<option value="0">24時</option>
<option value="1" <?if($set_week="1"){?> selected="selected"<?}?>>01時</option>
<option value="2" <?if($set_week="2"){?> selected="selected"<?}?>>02時</option>
<option value="3" <?if($set_week="3"){?> selected="selected"<?}?>>03時</option>
<option value="4" <?if($set_week="4"){?> selected="selected"<?}?>>04時</option>
<option value="5" <?if($set_week="5"){?> selected="selected"<?}?>>05時</option>
<option value="6" <?if($set_week="6"){?> selected="selected"<?}?>>06時</option>
<option value="7" <?if($set_week="1"){?> selected="selected"<?}?>>07時</option>
<option value="8" <?if($set_week="2"){?> selected="selected"<?}?>>08時</option>
<option value="9" <?if($set_week="3"){?> selected="selected"<?}?>>09時</option>
<option value="10" <?if($set_week="4"){?> selected="selected"<?}?>>10時</option>
<option value="11" <?if($set_week="5"){?> selected="selected"<?}?>>11時</option>
<option value="12" <?if($set_week="6"){?> selected="selected"<?}?>>12時</option>
<option value="13" <?if($set_week="1"){?> selected="selected"<?}?>>13時</option>
<option value="14" <?if($set_week="2"){?> selected="selected"<?}?>>14時</option>
<option value="15" <?if($set_week="3"){?> selected="selected"<?}?>>15時</option>
<option value="16" <?if($set_week="4"){?> selected="selected"<?}?>>16時</option>
<option value="17" <?if($set_week="5"){?> selected="selected"<?}?>>17時</option>
<option value="18" <?if($set_week="6"){?> selected="selected"<?}?>>18時</option>
<option value="19" <?if($set_week="1"){?> selected="selected"<?}?>>19時</option>
<option value="20" <?if($set_week="2"){?> selected="selected"<?}?>>20時</option>
<option value="21" <?if($set_week="3"){?> selected="selected"<?}?>>21時</option>
<option value="22" <?if($set_week="4"){?> selected="selected"<?}?>>22時</option>
<option value="23" <?if($set_week="5"){?> selected="selected"<?}?>>23時</option>
</select>
</td>
</tr>
</table>

<table>
<tr>
<td>IN/OUT</td>
<td>表示</td>
<td>時間</td>
</tr>
<td>
<select name="set_sch_inout[0]" class="set_box">
<option value="0">IN</option>
<option value="1" <?if($set_week="1"){?> selected="selected"<?}?>>OUT</option>
</select>
</td>
<td>
<input type="text" name="set_sch_in_name[0]" class="set_box">
</td>
<td>
<input type="text" name="set_sch_in_time[0]" class="set_box">
</td>
</tr>
</table>



<tr>
<td>開始曜日</td>
<td>
<select name="set_week" class="set_box">
<option value="0">日曜日</option>
<option value="1" <?if($set_week="1"){?> selected="selected"<?}?>>月曜日</option>
<option value="2" <?if($set_week="2"){?> selected="selected"<?}?>>火曜日</option>
<option value="3" <?if($set_week="3"){?> selected="selected"<?}?>>水曜日</option>
<option value="4" <?if($set_week="4"){?> selected="selected"<?}?>>木曜日</option>
<option value="5" <?if($set_week="5"){?> selected="selected"<?}?>>金曜日</option>
<option value="6" <?if($set_week="6"){?> selected="selected"<?}?>>土曜日</option>
</select>
</td>
</tr>


