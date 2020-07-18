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
	$dat[$n]=$a1;
	if($a1->face1 > 0):
		$dat[$n]->face=get_template_directory_uri()."/img/page/".$a1->id."/".$a1->face1.".jpg";			
	else:
		$dat[$n]->face=get_template_directory_uri()."/img/page/noimage.jpg";			
	endif;
	$n++;
endforeach;
wp_reset_postdata();

$now=time()+32400+$chg_time*86400;

$week[0]="(日)";
$week[1]="(月)";
$week[2]="(火)";
$week[3]="(水)";
$week[4]="(木)";
$week[5]="(金)";
$week[6]="(土)";

$cl[0]="tag_sun";
$cl[6]="tag_sat";

for($e=0;$e<7;$e++){
	$cast_tag[$e]=date("m月d日",$now+86400*$e).$week[date("w",$now+86400*$e)];
}

?>
<div class="cast_tag">
<div class="cast_tag_box">ALL</div>
<? for($e=0;$e<7;$e++){?><div class="cast_tag_box <?PHP echo $cl[$e]?>"><?PHP echo $cast_tag[$e]?></div><?}?>
</div>
<div class="main_b_all">
	<? for($s=0;$s<$n;$s++){?>
		<a href="<?PHP ECHO get_template_directory_uri(); ?>/person/<?PHP echo $dat[$s]->id?>" id="<?PHP echo $dat[$s]->id?>" class="main_b_1">
		<img src="<?PHP ECHO $dat[$s]->face?>" class="main_b_1_1">
		<span class="main_b_1_2"><?PHP echo $dat[$s]->genji?></span>
		<div class="main_b_1_3"></div>
		</a>
	<? } ?>
</div>
<?php get_footer(); ?>
