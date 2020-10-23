<div class="wrap">
<h2>キャスト一覧</h2>
<table class="wp-list-table widefat striped posts">
<tr>
<th class='manage-column column-author'>No</th>
<th class='manage-column column-author'>sort</th>
<th class='manage-column column-author'></th>
<th class='manage-column column-author'>名前</th>
<th class='manage-column column-author'>ランク</th>
<th class='manage-column column-author'>ID</th>
<th class='manage-column column-author'>PASS</th>


</tr>
<?for($n=0;$n<count($member);$n++){?>
<tr>
<td class='manage-column column-author'><?=$member[$n]["id"]?></td>
<td class='manage-column column-author'><?=$member[$n]["sort"]?></td>
<td class='manage-column column-author'></td>
<td class='manage-column column-author'><?=$member[$n]["genji"]?></td>
<td class='manage-column column-author'><?=$member[$n]["rank"]?></td>
<td class='manage-column column-author'><?=$member[$n]["cast_id"]?></td>
<td class='manage-column column-author'><?=$member[$n]["cast_pass"]?></td>
</tr>
<? } ?>
</table>
</div>