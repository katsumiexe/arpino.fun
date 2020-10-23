
<div id="wpbody" role="main">
<div id="wpbody-content">
	<div id="screen-meta" class="metabox-prefs">
			<div id="contextual-help-wrap" class="hidden" tabindex="-1" aria-label="コンテクストヘルプタブ">
				<div id="contextual-help-back"></div>
				<div id="contextual-help-columns">
					<div class="contextual-help-tabs">
						<ul>
							<li id="tab-link-overview" class="active">
								<a href="#tab-panel-overview" aria-controls="tab-panel-overview">概要</a>
							</li>
							
							<li id="tab-link-managing-pages">
								<a href="#tab-panel-managing-pages" aria-controls="tab-panel-managing-pages">固定ページの管理</a>
							</li>
						</ul>
					</div>

					<div class="contextual-help-sidebar">
						<p><strong>詳細情報:</strong></p><p><a href="https://ja.wordpress.org/support/article/pages-screen/">固定ページ管理の解説</a></p><p><a href="https://ja.wordpress.org/support/">サポート</a></p></div>
					<div class="contextual-help-tabs-wrap">
						<div id="tab-panel-overview" class="help-tab-content active">
							<p>固定ページにはタイトル、本文、関連メタデータがありブログ投稿に似ていますが、時系列のブログの一部ではなく、常設の投稿のようになっているという点で異なっています。固定ページにはカテゴリーやタグはありませんが、階層を持たせることはできます。固定ページを別の親ページの下に入れ子にし、ページをグループ化できます。</p>
						</div>
						<div id="tab-panel-managing-pages" class="help-tab-content">
							<p>固定ページの管理はブログ投稿の管理に似ており、管理画面は同様にカスタマイズできます。</p><p>また、同様の操作も実行できます。フィルターを使って一覧表示を絞り込んだり、行にマウスオーバーしたときに表示される操作リンクを使って固定ページへ変更を加えたり、一括操作メニューを使って複数のページのメタデータを編集したりなどです。</p>							</div>
						</div>
					</div>
				</div>
		<div id="screen-options-wrap" class="hidden" tabindex="-1" aria-label="表示オプションタブ">
<form id='adv-settings' method='post'>
		<fieldset class="metabox-prefs">
		<legend>カラム</legend>
		<label><input class="hide-column-tog" name="author-hide" type="checkbox" id="author-hide" value="author" checked='checked' />投稿者</label>
<label><input class="hide-column-tog" name="comments-hide" type="checkbox" id="comments-hide" value="comments" checked='checked' />コメント</label>
<label><input class="hide-column-tog" name="date-hide" type="checkbox" id="date-hide" value="date" checked='checked' />日付</label>
		</fieldset>
				<fieldset class="screen-options">
		<legend>ページ送り</legend>
							<label for="edit_page_per_page">ページごとに表示する項目数:</label>
				<input type="number" step="1" min="1" max="999" class="screen-per-page" name="wp_screen_options[value]"
					id="edit_page_per_page" maxlength="3"
					value="20" />
							<input type="hidden" name="wp_screen_options[option]" value="edit_page_per_page" />
		</fieldset>
				<fieldset class="metabox-prefs view-mode">
			<legend>表示モード</legend>
			<label for="list-view-mode">
				<input id="list-view-mode" type="radio" name="mode" value="list"  checked='checked' />
				コンパクト表示			</label>
			<label for="excerpt-view-mode">
				<input id="excerpt-view-mode" type="radio" name="mode" value="excerpt"  />
				拡張表示			</label>
		</fieldset>
		<p class="submit"><input type="submit" name="screen-options-apply" id="screen-options-apply" class="button button-primary" value="適用"  /></p>
<input type="hidden" id="screenoptionnonce" name="screenoptionnonce" value="8f472b9430" />
</form>
</div>		</div>
				<div id="screen-meta-links">
					<div id="screen-options-link-wrap" class="hide-if-no-js screen-meta-toggle">
			<button type="button" id="show-settings-link" class="button show-settings" aria-controls="screen-options-wrap" aria-expanded="false">表示オプション</button>
			</div>
						<div id="contextual-help-link-wrap" class="hide-if-no-js screen-meta-toggle">
			<button type="button" id="contextual-help-link" class="button show-settings" aria-controls="contextual-help-wrap" aria-expanded="false">ヘルプ</button>
			</div>
				</div>
		<div class="wrap">
<h1 class="wp-heading-inline">固定ページ</h1>
 <a href="https://arpino.fun/wp/wp-admin/post-new.php?post_type=page" class="page-title-action">新規追加</a>
<hr class="wp-header-end">

<h2 class='screen-reader-text'>固定ページリストの絞り込み</h2>
<ul class='subsubsub'>
	<li class='all'><a href="edit.php?post_type=page" class="current" aria-current="page">すべて <span class="count">(18)</span></a> |</li>
	<li class='publish'><a href="edit.php?post_status=publish&#038;post_type=page">公開済み <span class="count">(18)</span></a></li>
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
	<div class="alignleft actions bulkactions">
		<label for="bulk-action-selector-top" class="screen-reader-text">一括操作を選択</label>
		<select name="action" id="bulk-action-selector-top">
			<option value="-1">一括操作</option>
			<option value="edit" class="hide-if-no-js">編集</option>
			<option value="trash">ゴミ箱へ移動</option>
		</select>
		<input type="submit" id="doaction" class="button action" value="適用"  />
	</div>


	<div class="alignleft actions">
		<label for="filter-by-date" class="screen-reader-text">日付で絞り込み</label>
		<select name="m" id="filter-by-date">
		<option selected='selected' value="0">すべての日付</option>
			<option  value='202010'>2020年10月</option>
			<option  value='202008'>2020年8月</option>
			<option  value='202007'>2020年7月</option>
			<option  value='202005'>2020年5月</option>
		</select>
		<input type="submit" name="filter_action" id="post-query-submit" class="button" value="絞り込み"  />
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

	<table class="wp-list-table widefat fixed striped table-view-list pages">
	<thead>
		<tr>
			<td  id='cb' class='manage-column column-cb check-column'>
				<label class="screen-reader-text" for="cb-select-all-1">すべて選択</label>
				<input id="cb-select-all-1" type="checkbox" />
			</td>
			<th scope="col" id='title' class='manage-column column-title column-primary sortable desc'>
				<a href="https://arpino.fun/wp/wp-admin/edit.php?post_type=page&#038;orderby=title&#038;order=asc"><span>タイトル</span><span class="sorting-indicator"></span></a>
			</th>
			<th scope="col" id='author' class='manage-column column-author'>
				投稿者
			</th>
			<th scope="col" id='comments' class='manage-column column-comments num sortable desc'>
				<a href="https://arpino.fun/wp/wp-admin/edit.php?post_type=page&#038;orderby=comment_count&#038;order=asc"><span><span class="vers comment-grey-bubble" title="コメント"><span class="screen-reader-text">コメント</span></span></span><span class="sorting-indicator"></span></a></th><th scope="col" id='date' class='manage-column column-date sortable asc'><a href="https://arpino.fun/wp/wp-admin/edit.php?post_type=page&#038;orderby=date&#038;order=desc"><span>日付</span><span class="sorting-indicator"></span></a>
			</th>
		</tr>
	</thead>

	<tbody id="the-list">
		<tr id="post-65" class="iedit author-self level-0 post-65 type-page status-publish hentry">
			<th scope="row" class="check-column">
				<label class="screen-reader-text" for="cb-select-65">accessを選択</label>
				<input id="cb-select-65" type="checkbox" name="post[]" value="65" />

				<div class="locked-indicator">
					<span class="locked-indicator-icon" aria-hidden="true"></span>
					<span class="screen-reader-text">
					&#8220;access&#8221; はロックされています				</span>
				</div>
			</th>
			<td class="title column-title has-row-actions column-primary page-title" data-colname="タイトル">
				<div class="locked-info"><span class="locked-avatar"></span> <span class="locked-text"></span></div>
				<strong><a class="row-title" href="https://arpino.fun/wp/wp-admin/post.php?post=65&amp;action=edit" aria-label="「access」 (編集)">access</a></strong>

				<div class="hidden" id="inline_65">
					<div class="post_title">access</div>
					<div class="post_name">access</div>
					<div class="post_author">1</div>
					<div class="comment_status">closed</div>
					<div class="ping_status">closed</div>
					<div class="_status">publish</div>
					<div class="jj">16</div>
					<div class="mm">05</div>
					<div class="aa">2020</div>
					<div class="hh">15</div>
					<div class="mn">09</div>
					<div class="ss">54</div>
					<div class="post_password"></div>
					<div class="post_parent">0</div>
					<div class="page_template">default</div>
					<div class="menu_order">0</div>
				</div>
				
				<div class="row-actions">
					<span class='edit'><a href="https://arpino.fun/wp/wp-admin/post.php?post=65&amp;action=edit" aria-label="&#8220;access&#8221; を編集">編集</a> | </span>
					<span class='inline hide-if-no-js'><button type="button" class="button-link editinline" aria-label="「access」をインラインでクイック編集" aria-expanded="false">クイック編集</button> | </span>
					<span class='trash'><a href="https://arpino.fun/wp/wp-admin/post.php?post=65&amp;action=trash&amp;_wpnonce=23df0bbd80" class="submitdelete" aria-label="「access」をゴミ箱に移動">ゴミ箱へ移動</a> | </span>
					<span class='view'><a href="https://arpino.fun/wp/access/" rel="bookmark" aria-label="&#8220;access&#8221; を表示">表示</a></span>
				</div>
				<button type="button" class="toggle-row"><span class="screen-reader-text">詳細を追加表示</span></button></td><td class='author column-author' data-colname="投稿者"><a href="edit.php?post_type=page&#038;author=1">katsumi</a>
			</td>
			<td class='comments column-comments' data-colname="コメント">
				<div class="post-com-count-wrapper">
					<span aria-hidden="true">&#8212;</span>
					<span class="screen-reader-text">コメントはありません</span>
					<span class="post-com-count post-com-count-pending post-com-count-no-pending">
						<span class="comment-count comment-count-no-pending" aria-hidden="true">0</span>
						<span class="screen-reader-text">コメントはありません</span>
					</span>
				</div>
			</td>
			<td class='date column-date' data-colname="日付">
				公開済み<br />2020年5月16日 3:09 PM
			</td>
		</tr>
	</tbody>

	<tfoot>
	<tr>
		<td   class='manage-column column-cb check-column'><label class="screen-reader-text" for="cb-select-all-2">すべて選択</label><input id="cb-select-all-2" type="checkbox" /></td><th scope="col"  class='manage-column column-title column-primary sortable desc'><a href="https://arpino.fun/wp/wp-admin/edit.php?post_type=page&#038;orderby=title&#038;order=asc"><span>タイトル</span><span class="sorting-indicator"></span></a></th><th scope="col"  class='manage-column column-author'>投稿者</th><th scope="col"  class='manage-column column-comments num sortable desc'><a href="https://arpino.fun/wp/wp-admin/edit.php?post_type=page&#038;orderby=comment_count&#038;order=asc"><span><span class="vers comment-grey-bubble" title="コメント"><span class="screen-reader-text">コメント</span></span></span><span class="sorting-indicator"></span></a></th><th scope="col"  class='manage-column column-date sortable asc'><a href="https://arpino.fun/wp/wp-admin/edit.php?post_type=page&#038;orderby=date&#038;order=desc"><span>日付</span><span class="sorting-indicator"></span></a></th>	</tr>
	</tfoot>
</table>
<div class="clear"></div></div><!-- wpbody-content -->
<div class="clear"></div></div><!-- wpbody -->
