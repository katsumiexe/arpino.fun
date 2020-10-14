<div class="wrap">
<h2>キャスト一覧</h2>
<table class="wp-list-table widefat fixed striped posts">
<tr>
<th class='manage-column column-author'>ID</th>
<th id='author' class='manage-column column-author'>名前</th>
<th id='' class='manage-column column-author'>twitter</th>
<th id='' class='manage-column column-author'>mail_id</th>
<th id='' class='manage-column column-author'>instagram</th>
</tr>
<?for($n=0;$n<count($member);$n++){?>
<tr>
<td class='manage-column column-author'><?=$member[$n]["cast_id"]?></td>
<td class='manage-column column-author'><?=$member[$n]["genji"]?></td>
<td class='manage-column column-author'><?=$member[$n]["twitter"]?></td>
<td class='manage-column column-author'><?=$member[$n]["castmail"]?></td>
<td class='manage-column column-author'><?=$member[$n]["instagram"]?></td>
</tr>
<? } ?>
</table>

</div>