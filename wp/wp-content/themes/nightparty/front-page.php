<?php
get_header();
$dat[0]->face=get_template_directory_uri()."/img/cast/noimage.jpg";			
$dat[1]->face=get_template_directory_uri()."/img/cast/noimage.jpg";			
$dat[2]->face=get_template_directory_uri()."/img/cast/noimage.jpg";			
$dat[3]->face=get_template_directory_uri()."/img/cast/noimage.jpg";			
$dat[4]->face=get_template_directory_uri()."/img/cast/noimage.jpg";			
$dat[5]->face=get_template_directory_uri()."/img/cast/noimage.jpg";			
$dat[6]->face=get_template_directory_uri()."/img/cast/noimage.jpg";			
$dat[7]->face=get_template_directory_uri()."/img/cast/noimage.jpg";			
$dat[8]->face=get_template_directory_uri()."/img/cast/noimage.jpg";			
$dat[9]->face=get_template_directory_uri()."/img/cast/noimage.jpg";			
$res = $wpdb->get_results('
 SELECT * FROM wp01_0cast
');
$n=0;
foreach($res as $a1):
	$dat[$n]	=$a1;
	if($a1->face1 > 0):
		$dat[$n]->face=get_template_directory_uri()."/img/cast/".$a1->id."/".$a1->face1.".jpg";			
	else:
		$dat[$n]->face=get_template_directory_uri()."/img/cast/noimage.jpg";			
	endif;
	$n++;
endforeach;
wp_reset_postdata();
?>
<div class="main">
	<div class="slide">
	<div class="slide_img"></div>

	<div class="slide_point">
	<div class="slide_dot"></div>
	<div class="slide_dot"></div>
	<div class="slide_dot"></div>
	<div class="slide_dot"></div>
	<div class="slide_dot"></div>
	<div class="slide_dot"></div>
	</div>

	</div>
	<div class="main_b">
	<h1 class="main_b_title">本日の出勤キャスト</h1>

<?for($s=0;$s<10;$s++){?>
	<a href="<?php echo get_template_directory_uri(); ?>/person/" id="<?PHP echo $dat[$s]->id?>" class="main_b_1">
	<img src="<?PHP echo $dat[$s]->face?>" class="main_b_1_1">
	<div class="main_b_1_2"><?PHP echo $dat[$s]->genji?></div>
	<div class="main_b_1_3"></div>
	</a>
<?}?>


	</div>
	<div class="main_c">
	<div class="main_c_1">
<?php echo $cast[1]["genji"]?><bR>
	にゃんにゃか<br>
	にゃんにゃか<br>
	にゃんにゃか<br>
	にゃんにゃか<br>
	にゃんにゃか<br>
	</div>

	<div class="main_c_1">
	にゃんにゃか<br>
	にゃんにゃか<br>
	にゃんにゃか<br>
	にゃんにゃか<br>
	</div>
	<div class="main_c_1">
	
	</div>

	</div>
</div>
<?php get_footer(); ?>
