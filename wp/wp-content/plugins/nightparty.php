<?php
/*
Plugin Name:nightparty
Plugin URI:https://onlyme.fun
Description:prigin
Version: 0
Author: KatsumiArai
Author URI:
*/

	add_action('admin_menu', 'custom_menu_page');
	function custom_menu_page()
	{
	add_menu_page(
		'キャスト登録', 
		'キャスト登録', 
		'manage_options', 
		'custom_menu_page', 
		'add_custom_menu_page', 
		'dashicons-businesswoman', 


		4
	);
	}
	function add_custom_menu_page()
	{
?>
<div class="wrap">
<h2>キャスト登録</h2>
<table class="wp-list-table widefat fixed striped posts">
<thead>
<tr>
<th class='manage-column column-author'>ID</th>
<th id='author' class='manage-column column-author'>名前</th>
</tr>
<tr>
<td class='manage-column column-author'>100</td>
<td class='manage-column column-author'>みりあ</td>
</tr>
</table>

</div>
<?php
}