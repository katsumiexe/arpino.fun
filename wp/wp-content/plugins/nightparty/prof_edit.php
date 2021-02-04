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

td,th{
	padding:0 !important;; 
}

.w40{
	width:40px;
}
.w60{
	width:60px;
}
.w80{
	width:80px;
}
.w150{
	width:150px;
}

.w200{
	width:200px;
}

.w300{
	width:300px;
}

.txt_box{
	width			:100%;
	height			:30px;
	padding-left	:5px;
	padding-right	:5px;
}
.txt_box_p{
	width			:120px;
	height			:30px;
	padding-left	:5px;
	padding-right	:5px;
}

.watch{
	display			:inline-block;
	width			:35px;
	height			:30px;
	line-height		:30px;
	text-align		:center;
	font-size		:20px;
	border-radius	:5px;
	background		:#0000d0;
	vertical-align	:bottom;
	color			:#fafafa;
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
$(function(){ 
	$('.watch').on('click',function () {
		Chg=$(this).attr('id').replace('w','');
		$('#cast_pass'+Chg).attr('type','text');
	});

	$('.detal_btn').on('click',function () {
		Tmp=$(this).attr('id').replace('detail','');
		get_cast_detail(Tmp);
	});

	$('.chg_btn').on('click',function () {
		Chg=$(this).attr('id').replace('chg','');

		if($('#del'+Chg).val() ==6){

			if (!confirm('削除します。よろしいですか')) {
				return false;
			}else{
				$.post({
					url:"../../../../wp/wp-content/plugins/nightparty/post/chg_cast_list.php",
					data:{
					'del'		:$('#del'+Chg).val(),
					},
				}).done(function(data, textStatus, jqXHR){

				});
			}


		}else{
			$.post({
				url:"../../../../wp/wp-content/plugins/nightparty/post/Chg_cast_list.php",
				data:{
				'genji'		:$('#genji'+Chg).val(),
				'sort'		:$('#sort'+Chg).val(),
				'rank'		:$('#rank'+Chg).val(),
				'cast_id'	:$('#cast_id'+Chg).val(),
				'cast_pass'	:$('#cast_pass'+Chg).val(),
				'del'		:$('#del'+Chg).val(),
				},
			}).done(function(data, textStatus, jqXHR){

			});
		}
	});
});
</script>

<div class="wrap">
<h1 class="wp-heading-inline">CAST一覧</h1>
<a href="staff_regist.php" class="page-title-action">新規追加</a>
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
			退職
			<span class="count">(<?=$count_del[1]+0?>)</span>
		</a>
		|
	</li>
	<li class='all'>
		<a href="admin.php?page=cast_list&sort_del=2" class="current" aria-current="page">
			休職
			<span class="count">(<?=$count_del[2]+0?>)</span>
		</a>
		|
	</li>
	<li class='all'>
		<a href="admin.php?page=cast_list&sort_del=3" class="current" aria-current="page">
			準備中
			<span class="count">(<?=$count_del[3]+0?>)</span>
		</a>
		|
	</li>
	<li class='all'>
		<a href="admin.php?page=cast_list&sort_del=4" class="current" aria-current="page">
			非表示
			<span class="count">(<?=$count_del[4]+0?>)</span>
		</a>
		|
	</li>
	<li class='all'>
		<a href="admin.php?page=cast_list&sort_del=5" class="current" aria-current="page">
			利用停止
			<span class="count">(<?=$count_del[5]+0?>)</span>
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
<table class="wp-list-table striped posts">
<tr>
<th class='manage-column column-author column-ttl w40'></th>
<th class='manage-column column-author column-ttl w80'></th>
<th class='manage-column column-author column-ttl w300'>名前</th>
<th class='manage-column column-author column-ttl w40'>SORT</th>
<th class='manage-column column-author column-ttl w40'>ランク</th>
<th class='manage-column column-author column-ttl w150'>ID</th>
<th class='manage-column column-author column-ttl w150'>PASS</th>
<th class='manage-column column-author column-ttl w80'>ステータス</th>
</tr>
<?for($n=0;$n<count($member);$n++){?>
<tr>


https://arpino.fun/wp/wp-admin/admin.php?page=cast_list

<td class='manage-column column-author btm'>
<a href="<?=plugin_dir_url( __FILE__ )?>/cast_detail.php?cast_id=<?=$member[$n]["id"]?>" class="detal_btn button button-primary button-large">しょうさい</a>

<input type="submit" name="detail" id="detail<?=$member[$n]["id"]?>" class="detal_btn button button-primary button-large" value="詳細"><br>
<button type="button" name="chg" id="chg<?=$member[$n]["id"]?>" class="chg_btn button button-large">修正</button>
</td>
<td class='manage-column column-author btm'><div class="img_wrap"><img src="<?=$member[$n]["img"]?>" class="img_wrap_in"></div></td>
<td class='manage-column column-author btm'><input id="genji<?=$member[$n]["id"]?>" type="text" value="<?=$member[$n]["genji"]?>" class="txt_box"></td>
<td class='manage-column column-author btm'><input id="sort<?=$member[$n]["id"]?>" type="text" value="<?=$member[$n]["sort"]?>" class="txt_box right"></td>
<td class='manage-column column-author btm'><input id="rank<?=$member[$n]["id"]?>" type="text" value="<?=$member[$n]["rank"]?>" class="txt_box right"></td>
<td class='manage-column column-author btm'><input id="cast_id<?=$member[$n]["id"]?>" type="text" value="<?=$member[$n]["cast_id"]?>" class="txt_box"></td>
<td class='manage-column column-author btm'><input id="cast_pass<?=$member[$n]["id"]?>" type="password" value="<?=$member[$n]["cast_pass"]?>" class="txt_box_p"><span id="w<?=$member[$n]["id"]?>" class="watch">●</span></td>
<td class='manage-column column-author btm'>
	<select name="m" id="del<?=$member[$n]["id"]?>">

	<option selected='selected' value="0">表示</option>
	<option value="1"<?if($member[$n]["del"] == 1){?> selected="selected"<?}?>>退職</option>
	<option value="2"<?if($member[$n]["del"] == 2){?> selected="selected"<?}?>>休職</option>
	<option value="3"<?if($member[$n]["del"] == 3){?> selected="selected"<?}?>>準備中</option>
	<option value="4"<?if($member[$n]["del"] == 4){?> selected="selected"<?}?>>非表示</option>
	<option value="5"<?if($member[$n]["del"] == 5){?> selected="selected"<?}?>>利用停止</option>
	<option value="6">削除</option>
	</select>
</td>
</tr>



<? } ?>
</table>
</div>