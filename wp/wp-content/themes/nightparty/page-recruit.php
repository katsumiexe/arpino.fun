<?php
/*
Template Name: Recruit
*/

$sql="SELECT post_content,post_title FROM wp01_posts WHERE post_name LIKE 'RECRUIT-%' AND post_status='publish' ORDER BY post_name ASC";
$res = $wpdb->get_results($sql,ARRAY_A);

foreach($res as $a1){
	$recruit[]=$a1;
}

//var_dump($recruit);
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
		<span class="sys_box_ttl">Recruit</span><br>
		<?for($n=0;$n<count($recruit);$n++){?>
			<?if($recruit[$n]["post_content"]){?>
			<div class="rec">
				<div class="rec_l"><?=$recruit[$n]["post_title"]?></div>
				<div class="rec_r"><?=$recruit[$n]["post_content"]?></div>
			</div>
			<?}?>
		<?}?>
		<?if(!$recruit){?>
			<span class="sys_box_log">情報はまだありません</span><br>
		<?}?>
	</div>
<div class="corner box_1"></div>
<div class="corner box_2"></div>
<div class="corner box_3"></div>
<div class="corner box_4"></div>
</div>
<?php get_footer(); ?>