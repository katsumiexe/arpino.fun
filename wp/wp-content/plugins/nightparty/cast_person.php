<style>
.right{
	text-align:right;
}
.column-ttl{
	background:#e0e0ff;
	font-weight:600;
	padding-left:15px;
}

.img_wrap{
	position	:relative;
	width		:80px;
	height		:80px;
	overflow	:hidden;
}

.img_wrap_in{
	position	:absolute;
	top			:0;
	left		:0;
	width		:80px;
}

.w80{
	width:80px;
}
.w60{
	width:60px;
}
.w40{
	width:40px;
}
.w150{
	width:150px;
}

.txt_box{
	width			:100%;
	height			:30px;
	padding-left	:5px;
	padding-right	:5px;
}
.span_box{
	display			:inline-block;
	width			:90%;
	height			:28px;
	line-height		:28px;
	padding-left	:5px;
	padding-right	:5px;
	border			:1px solid #909090;
	border-radius	:3px;
	background		:#f0f0f0;
}

.btm{
	vertical-align:bottom !important;
}

.button{
	margin:2px !important;
}
</style>

<div class="wrap">
<h1 class="wp-heading-inline">CAST詳細</h1>
<a href="https://arpino.fun/wp/wp-admin/post-new.php?post_type=page" class="page-title-action">新規追加</a>
<hr class="wp-header-end">

<h2 class='screen-reader-text'>絞り込み</h2>
<ul class='subsubsub'>
	<li class='all'>
		<a href="admin.php?page=cast_list" class="current" aria-current="page">
			すべて
			<span class="count">(<?=$count_all?>)</span>
		</a>
		|
	</li>

	<li class='all'>
		<a href="admin.php?page=cast_list&sort_del=0" class="current" aria-current="page">
			表示
			<span class="count">(<?=$count_del[0]+0?>)</span>
		</a>
		|
	</li>


	<li class='all'>
		<a href="admin.php?page=cast_list&sort_del=1" class="current" aria-current="page">
			非表示
			<span class="count">(<?=$count_del[1]+0?>)</span>
		</a>
		|
	</li>

	<li class='all'>
		<a href="admin.php?page=cast_list&sort_del=2" class="current" aria-current="page">
			準備中
			<span class="count">(<?=$count_del[2]+0?>)</span>
		</a>
		|
	</li>
	<li class='all'>
		<a href="admin.php?page=cast_list&sort_del=3" class="current" aria-current="page">
			退職
			<span class="count">(<?=$count_del[3]+0?>)</span>
		</a>
		|
	</li>

	<li class='all'>
		<a href="admin.php?page=cast_list&sort_del=4" class="current" aria-current="page">
			利用停止
			<span class="count">(<?=$count_del[4]+0?>)</span>
		</a>
	</li>
</ul>

<form id="posts-filter" method="get">
<p class="search-box">
	<label class="screen-reader-text" for="post-search-input">固定ページを検索:</label>
	<input type="search" id="post-search-input" name="s" value="" />
	<input type="submit" id="search-submit" class="button" value="固定ページを検索"  />
</p>
<input type="hidden" name="post_status" class="post_status_page" value="all" />
<input type="hidden" name="post_type" class="post_type_page" value="page" />
<input type="hidden" id="_wpnonce" name="_wpnonce" value="72402eb421" />
<input type="hidden" name="_wp_http_referer" value="/wp/wp-admin/edit.php?post_type=page" />

<div class="tablenav top">
	<input type="submit" id="doaction" class="button action" value="一括削除">
	</div>

	<div class="alignleft actions">
		<label for="filter-by-date" class="screen-reader-text">ランク</label>
		<select name="m" id="filter-by-date">
		<option selected='selected' value="0">すべて</option>
		</select>
		<input type="submit" name="filter_action" id="post-query-submit" class="button" value="ランク"  />
	</div>
	

	<div class='tablenav-pages one-page'>
		<span class="displaying-num">18個の項目</span>
		<span class='pagination-links'><span class="tablenav-pages-navspan button disabled" aria-hidden="true">&laquo;</span>
		<span class="tablenav-pages-navspan button disabled" aria-hidden="true">&lsaquo;</span>
		<span class="paging-input"><label for="current-page-selector" class="screen-reader-text">現在のページ</label><input class='current-page' id='current-page-selector' type='text' name='paged' value='1' size='1' aria-describedby='table-paging' /><span class='tablenav-paging-text'> / <span class='total-pages'>1</span></span></span>
		<span class="tablenav-pages-navspan button disabled" aria-hidden="true">&rsaquo;</span>
		<span class="tablenav-pages-navspan button disabled" aria-hidden="true">&raquo;</span></span></div>
		<br class="clear" />
	</div>

<h2 class='screen-reader-text'>固定ページリスト</h2>
<table class="wp-list-table widefat striped posts">
<tr>
<th class='manage-column column-author column-ttl w40'> </th>
<th class='manage-column column-author column-ttl w80'></th>
<th class='manage-column column-author column-ttl'>名前</th>
<th class='manage-column column-author column-ttl w60'>SORT</th>
<th class='manage-column column-author column-ttl w60'>ランク</th>
<th class='manage-column column-author column-ttl w150'>ID</th>
<th class='manage-column column-author column-ttl w150'>PASS</th>
<th class='manage-column column-author column-ttl w80'>ステータス</th>
</tr>
<?for($n=0;$n<count($member);$n++){?>
<tr>

<td class='manage-column column-author btm'>
<input type="submit" name="publish" id="detail<?=$member[$n]["id"]?>" class="button button-primary button-large" value="詳細"><br>
<input type="submit" name="publish" id="chg<?=$member[$n]["id"]?>" class="button button-large" value="修正">


</td>
<td class='manage-column column-author btm'><div class="img_wrap"><img src="<?=$member[$n]["img"]?>" class="img_wrap_in"></div></td>
<td class='manage-column column-author btm'><input id="genji<?=$member[$n]["id"]?>" type="text" value="<?=$member[$n]["genji"]?>" class="txt_box"></td>
<td class='manage-column column-author btm'><input id="sort<?=$member[$n]["id"]?>" type="text" value="<?=$member[$n]["sort"]?>" class="txt_box right"></td>
<td class='manage-column column-author btm'><input id="rank<?=$member[$n]["id"]?>" type="text" value="<?=$member[$n]["rank"]?>" class="txt_box right"></td>
<td class='manage-column column-author btm'><input id="cast_id<?=$member[$n]["id"]?>" type="text" value="<?=$member[$n]["cast_id"]?>" class="txt_box"></td>
<td class='manage-column column-author btm'><input id="cast_pass<?=$member[$n]["id"]?>" type="text" value="<?=$member[$n]["cast_pass"]?>" class="txt_box"></td>
<td class='manage-column column-author btm'>
	<select name="m" id="filter-by-date">

	<option selected='selected' value="0">表示</option>
	<option value="1"<?if($member[$n]["del"] == 1){?> selected="selected"<?}?>>非表示</option>
	<option value="2"<?if($member[$n]["del"] == 2){?> selected="selected"<?}?>>準備中</option>
	<option value="3"<?if($member[$n]["del"] == 3){?> selected="selected"<?}?>>退職</option>
	<option value="3"<?if($member[$n]["del"] == 4){?> selected="selected"<?}?>>利用停止</option>
	<option value="4">削除</option>
	</select>
</td>
</tr>



<? } ?>
</table>
</div>