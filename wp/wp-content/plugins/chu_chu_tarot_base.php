<style>
<!--
input[type=text]{
	height:30px;
}

.w300{
	width:300px;
}

.w150{
	width:150px;
}

.w40{
	width:40px;
}
.title{
	background:#f0f0ff;
}
table{
	border-collapse: collapse;
}
td,th{
	border:1px solid #909090;
	padding:3px;
	background:#f0f0f0;
}

input{
	border:1px solid #f0f0f0;
}
-->
</style><div class="wrap">
<h2>タロットカード一覧</h2>
<table class="wp-list-table striped posts">
<tr>
<th class='manage-column title' colspan="2">ID</th>
<th class='manage-column title' colspan="3">名前</th>
<th class='manage-column title' colspan="2">暗示</th>
</tr>
<tr>
<th class='manage-column title w40'>R</th>
<th class='manage-column title w40'>M</th>

<th class='manage-column title w150'>日本語</th>
<th class='manage-column title w150'>英語</th>
<th class='manage-column title w150'>仏語</th>

<th class='manage-column title w300'>正位置</th>
<th class='manage-column title w300'>逆位置</th>
</tr>
<?for($n=0;$n<count($card);$n++){?>
<tr>
<td class='manage-column w40'><input type="text" id="b_yy" name="b_yy" class="w40" value="<?=$card[$n]["no_r"]?>"></td>
<td class='manage-column w40'><input type="text" id="b_yy" name="b_yy" class="w40" value="<?=$card[$n]["no_m"]?>"></td>
<td class='manage-column'><input type="text" id="b_yy" name="b_yy" class="w150" value="<?=$card[$n]["name_j"]?>"></td>
<td class='manage-column'><input type="text" id="b_yy" name="b_yy" class="w150" value="<?=$card[$n]["name_e"]?>"></td>
<td class='manage-column'><input type="text" id="b_yy" name="b_yy" class="w150" value="<?=$card[$n]["name_f"]?>"></td>
<td class='manage-column'><input type="text" id="b_yy" name="b_yy" class="w300" value="<?=$card[$n]["mean_1"]?>"></td>
<td class='manage-column'><input type="text" id="b_yy" name="b_yy" class="w300" value="<?=$card[$n]["mean_0"]?>"></td>
</tr>
<? } ?>	
</table>
</div>



