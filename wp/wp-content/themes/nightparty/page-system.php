<?php
/*
Template Name: System
*/
get_header();

$sql="SELECT * FROM wp01_posts WHERE post_name LIKE 'SYSTEM-%' ORDER BY post_name DESC";
$res = $wpdb->get_results($sql,ARRAY_A);
foreach($res as $a1){
	$sort=str_replace("SYSTEM-","",$a1["post_name"]);
	$sys[$sort]=$a1;
}
//ksort($sys);
?>
<div class="footmark">
	<a href="<?=home_url()?>" class="footmark_box box_a">
		<span class="footmark_icon"></span>
		<span class="footmark_text">TOP</span>
	</a>
	<span class="footmark_icon"></span>
	<div class="footmark_box">
		<span class="footmark_icon"></span>
		<span class="footmark_text">SYSTEM</span>
	</div>
</div>
<?foreach($sys as $a1){?>
<?if($a1["post_content"]){?>
<div class="main_d">
<span class="sys_box_ttl"><?=$a1["post_title"]?></span><br>
<span class="sys_box_log"><?=$a1["post_content"]?></span><br>
</div>
<?}?>
<?}?>
<?if(!$sys){?>
<div class="sys_box">
<span class="sys_box_log">情報はまだありません</span><br>
</div>
<?}?>
</div>
<?php get_footer(); ?>