<?php
/*
Template Name: event
*/
$code=$_REQUEST["code"];
$sql	 ="SELECT meta_id, post_date_gmt, post_content, post_title FROM wp01_postmeta AS M";
$sql	.=" LEFT JOIN wp01_posts AS P on M.post_id=P.ID";
$sql	.=" WHERE meta_id='{$code}'";
$sql	.=" AND post_status='publish'";
$sql	.=" ORDER BY meta_value ASC";
$dat = $wpdb->get_row($sql,ARRAY_A);

$dat["post_content"]=str_replace("\n","<br>",$dat["post_content"]);
get_header();
?>
<div class="footmark">
	<a href="<?=home_url()?>" class="footmark_box box_a">
		<span class="footmark_icon"></span>
		<span class="footmark_text">TOP</span>
	</a>
	<span class="footmark_icon"></span>
	<div class="footmark_box">
		<span class="footmark_icon"></span>
		<span class="footmark_text">NEWS</span>
	</div>
</div>
<div class="main_e">
<div class="main_e_in">
<span class="main_e_f c_tr"></span>
<span class="main_e_f c_tl"></span>
<span class="main_e_f c_br"></span>
<span class="main_e_f c_bl"></span>
<div class="corner_in box_in_1"></div>
<div class="corner_in box_in_2"></div>
<div class="corner_in box_in_3"></div>
<div class="corner_in box_in_4"></div>
<?if(!$dat){?>
<span class="sys_box_log">こちらのイベントは終了しています</span><br>
<?}else{?>
<span class="sys_box_ttl"><?=$dat["post_title"]?></span><br>
<span class="sys_box_log"><?=$dat["post_content"]?></span><br>
<?}?>
</div>
<div class="corner box_1"></div>
<div class="corner box_2"></div>
<div class="corner box_3"></div>
<div class="corner box_4"></div>
</div>
<br>
<?php get_footer(); ?>