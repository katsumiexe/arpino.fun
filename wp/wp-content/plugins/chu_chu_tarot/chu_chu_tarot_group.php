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
<table class="wp-list-table posts">
<tr>
<th class='manage-column title w40'>ID</th>
<th class='manage-column title w300'>鑑定内容</th>

<th class='manage-column title w40'>正逆</th>
<th class='manage-column title w40'>オラクル</th>

<th class='manage-column title w200'>暗示：1</th>
<th class='manage-column title w200'>暗示：2</th>
<th class='manage-column title w200'>暗示：3</th>
</tr>

<?for($n=0;$n<count($card);$n++){?>
<tr>
<td class='manage-column w40'><input type="text" name="id[<?=$n?>]" class="w40" value="<?=$group[$n]["id"]?>"></td>
<td class='manage-column'><textarea name="name" class="w300" value="<?=$group[$n]["group_name"]?>"></textarea>

<td class='manage-column w40'><input type="text" name="position" class="w40" value="<?=$group[$n]["position"]?>"></td>
<td class='manage-column w40'><input type="text" name="oracle" class="w40" value="<?=$group[$n]["oracle"]?>"></td>

<td class='manage-column'><input type="text" name="b_yy" class="w200" value="<?=$oracle[$s]["orale_name"]?>"></td>
</tr>
<? } ?>	
</table>
</table>
</div>

