<?php
/*
Template Name: System
*/

$sql="SELECT * FROM wp01_posts WHERE post_name LIKE 'SYSTEM-%' ORDER BY post_name DESC";
$res = $wpdb->get_results($sql,ARRAY_A);
foreach($res as $a1){
	$sort=str_replace("SYSTEM-","",$a1["post_name"]);
	$sys[$sort]=$a1;
}
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
		<span class="footmark_text">SYSTEM</span>
	</div>
</div>

<?foreach($sys as $a1){?>
<?if($a1["post_content"]){?>
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
<span class="sys_box_ttl"><?=$a1["post_title"]?></span><br>
<span class="sys_box_log"><?=$a1["post_content"]?></span><br>
</div>
<div class="corner box_1"></div>
<div class="corner box_2"></div>
<div class="corner box_3"></div>
<div class="corner box_4"></div>
</div>
<?}?>
<?}?>


<?if(!$sys){?>
<div class="main_e">
<span class="sys_box_log">情報はまだありません</span><br>
</div>
<?}?>
<br>
<?php get_footer(); ?>