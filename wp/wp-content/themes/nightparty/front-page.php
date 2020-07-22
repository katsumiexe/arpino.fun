<?php
get_header();
$now=date("Ymd",time()+32400);

$sql=" SELECT * FROM wp01_0sch_table";
$res0= $wpdb->get_results($sql,ARRAY_A);
foreach($res0 as $a1){
	$sch_table[$a1["in_out"]][$a1["name"]]=$a1["sort"];
}

$sql="SELECT * FROM wp01_0cast";
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
?>
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
<? foreach($sort as $b1=> $b2){?>
	<a href="<?PHP ECHO get_template_directory_uri(); ?>/person/<?PHP echo $b1?>" id="<?PHP echo $b1?>" class="main_b_1">
		<img src="<?PHP ECHO $dat[$b1]["face"]?>" class="main_b_1_1">
		<span class="main_b_1_2">
			<span class="main_b_1_2_name"><?PHP echo $dat[$b1]["genji"]?></span>
			<span class="main_b_1_2_sch"></span>
		</span>
		<span class="main_b_1_3"></span>
	</a>
<? } ?>
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
<?php get_footer(); ?>
