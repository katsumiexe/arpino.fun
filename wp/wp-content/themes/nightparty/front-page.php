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
get_header();
?>
<script src="<?php echo get_template_directory_uri(); ?>/js/index.js?t=<?=time()?>"></script>
<div class="main_top">
	<div class="slide">
		<div class="slide_img">
		<img src="<?=get_template_directory_uri()?>/img/page/top/top1.jpg" class="top_img">;
		<img src="<?=get_template_directory_uri()?>/img/page/top/top2.jpg" class="top_img">;
		<img src="<?=get_template_directory_uri()?>/img/page/top/top3.jpg" class="top_img">;
		<img src="<?=get_template_directory_uri()?>/img/page/top/top4.jpg" class="top_img">;
		<img src="<?=get_template_directory_uri()?>/img/page/top/top5.jpg" class="top_img">;
		</div>
		<div class="slide_point">
			<div id="dot0" class="slide_dot dot_on"></div>
			<div id="dot1" class="slide_dot"></div>
			<div id="dot2" class="slide_dot"></div>
			<div id="dot3" class="slide_dot"></div>
			<div id="dot4" class="slide_dot"></div>
		</div>
	</div>

		<div class="main_b_top">
			<div class="main_b_notice"></div>
			<div class="main_b_notice"></div>
			<div class="main_b_notice"></div>
			<div class="main_b_notice"></div>
			<div class="main_b_notice"></div>
		</div>

	<div class="main_b">
		<h2 class="main_b_title">本日の出勤キャスト</h2>
		<div class="main_b_in">
			<? foreach($sort as $b1=> $b2){?>
				<a href="<?=home_url('/person')?>/?cast=<?=$b1?>" id="i<?=$b1?>" class="main_b_1">
					<img src="<?=$dat[$b1]["face"]?>?t=<?=time()?>" class="main_b_1_1">
					<span class="main_b_1_2">
						<span class="main_b_1_2_name"><?=$dat[$b1]["genji"]?></span>
						<span class="main_b_1_2_sch"></span>
					</span>
					<span class="main_b_1_3"></span>
				</a>
			<? } ?>
		</div>
	</div>
	<div class="main_c">
		<a class="twitter-timeline" data-width="310" data-height="500" data-theme="dark" href="https://twitter.com/serra_geddon?ref_src=twsrc%5Etfw">Tweets by serra_geddon</a> <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
	</div>
</div>
<?php get_footer(); ?>
