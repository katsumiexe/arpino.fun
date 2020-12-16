<?php
$now=date("Ymd",time()+32400);

$sql=" SELECT * FROM wp01_0sch_table";
$res0= $wpdb->get_results($sql,ARRAY_A);
foreach($res0 as $a1){
	$sch_table[$a1["in_out"]][$a1["name"]]=$a1["sort"];
}

$sql="SELECT * FROM wp01_0cast";
$sql.=" WHERE del=0";
$res= $wpdb->get_results($sql,ARRAY_A);

foreach($res as $a1){
	$dat[$a1["id"]]	=$a1;
	if (file_exists(get_template_directory()."/img/page/{$a1["id"]}/1.jpg")) {
		$dat[$a1["id"]]["face"]=get_template_directory_uri()."/img/page/".$a1["id"]."/1.jpg";			
	}else{
		$dat[$a1["id"]]["face"]=get_template_directory_uri()."/img/page/noimage.jpg";			
	}
		$dat[$a1["id"]]["sch"]="休み";
		$sort[$a1["id"]]=999999;
}

$sql="SELECT * FROM wp01_0schedule WHERE sche_date='{$now}' ORDER BY schedule_id ASC";
$res2 = $wpdb->get_results($sql,ARRAY_A);

foreach($res2 as $a2){
	if($a2["stime"] && $a2["etime"]){
		$dat[$a1["id"]]["sch"]	="{$a2["stime"]} - {$a2["etime"]}";
		$sort[$a1["id"]]=$sch_table["in"][$a2["stime"]];

	}else{
		$sch[$a2["cast_id"]]	="休み";
		$sort[$a1["id"]]=999999;
	}
}

$sql	 ="SELECT meta_id, meta_value, post_type FROM wp01_postmeta AS M";
$sql	.=" LEFT JOIN wp01_posts AS P on M.post_id=P.ID";
$sql	.=" WHERE meta_key='_top_slide'";
$sql	.=" AND meta_value>0";
$sql	.=" ORDER BY meta_value ASC";
$res2 = $wpdb->get_results($sql,ARRAY_A);
foreach($res2 as $a2){
	$slide[]=$a2;
}
get_header();
?>

<style>
.slide_img{
	width		:calc( 1200px * <?=count($slide)?>);
}

.slide_point{
	width		:calc( 70px + 30px * <?=count($slide)?>);
}

@media screen and (max-width: 959px){
	.slide_img{
		width		:calc( 98vw * <?=count($slide)?>);
	}

	.slide_point{
		width		:calc( 25vw + 5vw * <?=count($slide)?>);
	}
}
</style>
<script>
var Cnt=<?=(count($slide)-1)?>;
</script>
<script src="<?php echo get_template_directory_uri(); ?>/js/index.js?t=<?=time()?>"></script>
<div class="main_top">
<?if(count($slide) ==1){?>
	<div class="slide">
		<div class="slide_img">
			<?if($slide[0]["post_type"]=="nonlink"){?>
				<img src="<?=get_template_directory_uri()?>/img/page/top/top<?=$slide[0]["meta_id"]?>.jpg" class="top_img">;
			<?}else{?>	
				<a href="<?=home_url('/event')?>/?code=<?=$slide[0]["meta_id"]?>"><img src="<?=get_template_directory_uri()?>/img/page/top/top<?=$slide[0]["meta_id"]?>.jpg" class="top_img"></a>;
			<?}?>	
		</div>
	</div>
<?}elseif(count($slide) >1){?>
	<div class="slide">
		<div class="slide_img">
			<?for($n=0;$n<count($slide);$n++){?>
				<?if($slide[$n]["post_type"]=="nonlink"){?>
					<img src="<?=get_template_directory_uri()?>/img/page/top/top<?=$slide[$n]["meta_id"]?>.jpg" class="top_img">;
				<?}else{?>	
					<a href="<?=home_url('/event')?>/?code=<?=$slide[$n]["meta_id"]?>"><img src="<?=get_template_directory_uri()?>/img/page/top/top<?=$slide[$n]["meta_id"]?>.jpg" class="top_img"></a>;
				<?}?>	
			<?}?>	
		</div>

		<div class="slide_point">
			<?for($n=0;$n<count($slide);$n++){?>
				<div id="dot<?=$n?>" class="slide_dot<?if($n == 0){?> dot_on<?}?>"></div>
			<?}?>
		</div>
	</div>
<?}?>

	<div class="main_b">
		<div class="main_b_title">新着情報</div>
		<div class="main_b_top">
			<?for($n=0;$n<count($news);$n++){?>
				<div class="main_b_notice">
					<span class="main_b_notice_date"><?=$news[$n]["date"]?>"></span>
					<span class="main_b_notice_title"><?=$news[$n]["post_title"]?>"></span>
			<?if($news[$n]["post_type"]=="nlink"){?>
					<span class="main_b_notice_arrow">▼</span>
			<?}?>
				</div>
			<?}?>
		</div>

		<div class="main_b_title">本日の出勤キャスト</div>
		<div class="main_b_in">
			<? foreach($sort as $b1=> $b2){?>
				<a href="<?=home_url('/person')?>/?cast=<?=$b1?>" id="i<?=$b1?>" class="main_b_1">
					<img src="<?=$dat[$b1]["face"]?>?t=<?=time()?>" class="main_b_1_1">
					<span class="main_b_1_2">
						<span class="main_b_1_2_h"></span>
						<span class="main_b_1_2_f f_tr"></span>
						<span class="main_b_1_2_f f_tl"></span>
						<span class="main_b_1_2_f f_br"></span>
						<span class="main_b_1_2_f f_bl"></span>
						<span class="main_b_1_2_name"><?=$dat[$b1]["genji"]?></span>
						<span class="main_b_1_2_sch">OPEN-LAST</span>
					</span>
				</a>
			<? } ?>
		</div>
	</div>

	<div class="main_c">
		<a class="twitter-timeline" data-width="310" data-height="500" data-theme="dark" href="https://twitter.com/serra_geddon?ref_src=twsrc%5Etfw">Tweets by serra_geddon</a> <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
	</div>
</div>
<?php get_footer(); ?>
