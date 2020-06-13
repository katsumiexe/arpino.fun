<div class="wrap">
<h2>スタッフ一覧</h2>
<table class="wp-list-table widefat fixed striped posts">
<tr>
<th class='manage-column column-author'>ID</th>
<th id='author' class='manage-column column-author'>名前</th>
<th id='author' class='manage-column column-author'>役職</th>
<th id='author' class='manage-column column-author'>ランク</th>
<th id='author' class='manage-column column-author'>グループ</th>
</tr>
<?for($n=0;$n<count($member);$n++){?>
<tr>
<td class='manage-column column-author'><?=$member[$n]["staff_id"]?></td>
<td class='manage-column column-author'><?=$member[$n]["name"]?></td>
<td class='manage-column column-author'><?=$member[$n]["position"]?></td>
<td class='manage-column column-author'><?=$member[$n]["group"]?></td>
</tr>
<? } ?>
</table>
</div>
