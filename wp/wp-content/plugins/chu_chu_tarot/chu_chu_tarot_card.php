<style>
td{
	text-align:center;
	font-size:14px;
	border:1px solid #303030;
	vertical-align:top;
}
.ttl{
	display:block;
	width:100%;
	text-align:center;
	margin:auto;
	height:25px;
	line-height:25px;
	font-size:16px;
	background:#c02010;
	color:#fafafa;
}

.w80{
	width:80px;
}

.w40{
	width:40px;
}

</style>
<div class="wrap">
<h2>カード画像</h2>
<table class="wp-list-table striped posts">
<tr>
<th class='manage-column title'>ID</th>
<th class='manage-column title'>名前</th>
</tr>
<?for($n=0;$n<count($card);$n++){?>
<tr>
<td class='manage-column w80'>
<span class="ttl"><?=$card[$n]["no_r"]?></span>
<?=$card[$n]["name_j"]?><br><button type="button">変更</button></td>
<td class='manage-column w80'><img src="../../../../wp/wp-content/plugins/chu_chu_tarot/img/cardimg_<?=$card[$n]["no_r"]?>.jpg?t=<?=time()?>" class="w80"></td>
</tr>
<? } ?>	
</table>
</div>



