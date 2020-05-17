<?php 
/*
Template Name: cast
*/
get_header();
$res = $wpdb->get_results('
 SELECT * FROM wp01_0cast
');
$n=0;
foreach($res as $a1):
	$dat[$n]		=$a1;
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
	<div class="main_b_all">
		<? for($s=0;$s<$n;$s++){?>
			<a href="<?php echo get_template_directory_uri(); ?>/person/" id="<?PHP echo $dat[$s]->id?>" class="main_b_1">
			<img src="<?PHP echo $dat[$s]->face?>" class="main_b_1_1">
			<span class="main_b_1_2"><?PHP echo $dat[$s]->genji?></span>
			<div class="main_b_1_3"></div>
			</a>
		<? } ?>
	</div>
</div>
<form action="/person/" method="post"> </form>
<form id="form_p" action="<?php echo home_url('/person/'); ?>" method="post"> 
<input type="hidden" id="val_p" name="val">
</form>
<?php get_footer(); ?>
