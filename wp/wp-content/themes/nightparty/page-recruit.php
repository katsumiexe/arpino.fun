<?php
/*
Template Name: Recruit
*/

$sql="SELECT post_content,post_title FROM wp01_posts WHERE post_name LIKE 'RECRUIT-%' AND post_status='publish' ORDER BY post_name ASC";
$res = $wpdb->get_results($sql,ARRAY_A);

foreach($res as $a1){
	$recruit[]=$a1;
}

var_dump($recruit);
//ksort($sys);
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
		<span class="footmark_text">RECRUIT</span>
	</div>
</div>
<div class="main_b">
<?for($n=0;$n<count($recruit);$n++){?>
	<?if($recruit[$n]["post_content"]){?>
	<div class="rec_l"><?=$recruit[$n]["post_title"]?></div><div class="rec_r"><?=$recruit[$n]["post_content"]?></div>
	<?}?>
<?}?>
</div>
<?if(!$reqruit){?>
<div class="main_e">
<span class="sys_box_log">情報はまだありません</span><br>
</div>
<?}?>
<?php get_footer(); ?>