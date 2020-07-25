<?php 
/*
Template Name: cast
*/
get_header();

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
	$cast_id[$e]=date("Ymd",$now+86400*$e);
}

?>
<div class="cast_tag">
<!--div id="d0" class="cast_tag_box cast_tag_box_sel">ALL</div-->
<? for($e=0;$e<7;$e++){?><div id="d<?PHP echo $cast_id[$e]?>" class="cast_tag_box <?PHP echo $cl[$e]?><?if($e == 0){?> cast_tag_box_sel<?}?>"><?PHP echo $cast_tag[$e]?></div><?}?>
</div>
<div class="main_d">
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
<?php get_footer(); ?>
