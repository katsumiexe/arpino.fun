<?php 
/*
Template Name: cast
*/

//---------------------------------------
//require_once ("../../../wp-load.php");
global $wpdb;

$sql=" SELECT meta_value, meta_key FROM wp01_usermeta";
$sql.=" WHERE meta_key IN('start_time','start_week')";
$admin	= $wpdb->get_results($sql,ARRAY_A);
$jst=time()+32400;
$now=$jst-($admin["start_time"]*3600);
$sch_8=date("Ymd",$now);
$link=get_template_directory_uri();
//-------------------------------------------

/*
$sql	 =" SELECT * FROM wp01_0sch_table";
$res0= $wpdb->get_results($sql,ARRAY_A);
foreach($res0 as $a1){
	$sch_table[$a1["in_out"]][$a1["name"]]=$a1["sort"];
}

$sql	="SELECT * FROM wp01_0cast";
$sql	.=" WHERE del=0";
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

$sql="SELECT * FROM wp01_0schedule WHERE sche_date='{$now_ymd}' ORDER BY schedule_id ASC";
$res2 = $wpdb->get_results($sql,ARRAY_A);
foreach($res2 as $a2){
	if($a2["stime"] && $a2["etime"]){
		$dat[$a2["cast_id"]]["sch"]	="{$a2["stime"]} － {$a2["etime"]}";
		$sort[$a2["cast_id"]]=$sch_table["in"][$a2["stime"]];
	}else{
		$sch[$a2["cast_id"]]	="休み";
		$sort[$a2["cast_id"]]	=999999;
	}
}
*/

$sql=" SELECT in_out, `name`, `sort` FROM wp01_0sch_table";
$res0= $wpdb->get_results($sql,ARRAY_A);
foreach($res0 as $a1){
	$sch_table[$a1["in_out"]][$a1["name"]]=$a1["sort"];
}

$sql=" SELECT genji,ctime,id FROM wp01_0cast";
$sql.=" WHERE del=0";
$res = $wpdb->get_results($sql,ARRAY_A);

foreach($res as $a1){
	$dat[$a1["id"]]=$a1;

	$sql =" SELECT * FROM wp01_0schedule";
	$sql.=" WHERE sche_date='{$sch_8}'";
	$sql.=" AND cast_id='{$a1["id"]}'";
	$sql.=" ORDER BY schedule_id DESC";
	$sql.=" LIMIT 1";
	$res2 = $wpdb->get_results($sql,ARRAY_A);

	foreach($res2 as $a2){
		if($a2["stime"] && $a2["etime"]){
			$dat[$a1["id"]]["sch"]="{$a2["stime"]} － {$a2["etime"]}";
			$sort[$a1["id"]]=$sch_table["in"][$a2["stime"]];
		}else{
			$dat[$a1["id"]]["sch"]="休み";
			$sort[$a1["id"]]=999999;
		}
	}

	if(!$res2){
		$dat[$a1["id"]]["sch"]="休み";
		$sort[$a1["id"]]=999999;
	}


	if (file_exists(get_template_directory()."/img/page/{$a1["id"]}/0.jpg")) {
		$dat[$a1["id"]]["face"]="{$link}/img/page/{$a1["id"]}/0.jpg";		

	}else{
		$dat[$a1["id"]]["face"]="{$link}/img/page/noimage.jpg";			
	}

	if($sch_8 < $a1["ctime"]){
		$dat[$a1["id"]]["new"]=1;

	}elseif($sch_8 == $a1["ctime"]){
		$dat[$a1["id"]]["new"]=2;

	}elseif(strtotime($sch_8) - strtotime($a1["ctime"])<=2592000){
		$dat[$a1["id"]]["new"]=3;
	}


}
asort($sort);

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
	$cast_tag[$e]="<span class=\"tag_pc\">".date("m月d日",$now+86400*$e).$week[date("w",$now+86400*$e)]."</span><span class=\"tag_sp\">".date("m/d",$now+86400*$e)."<br>".$week[date("w",$now+86400*$e)]."</span>";
	$cast_id[$e]=date("Ymd",$now+86400*$e);
}

get_header();
?>
<div class="footmark">
	<a href="<?=home_url()?>" class="footmark_box box_a">
		<span class="footmark_icon"></span>
		<span class="footmark_text">TOP</span>
	</a>
	<span class="footmark_icon"></span>
	<div class="footmark_box">
		<span class="footmark_icon"></span>
		<span class="footmark_text">CAST</span>
	</div>
</div>
<div class="cast_tag">
<!--div id="d0" class="cast_tag_box cast_tag_box_sel">ALL</div-->
<? for($e=0;$e<7;$e++){?><div id="d<?=$cast_id[$e]?>" class="cast_tag_box <?=$cl[$e]?><?if($e == 0){?> cast_tag_box_sel<?}?>"><?=$cast_tag[$e]?></div><?}?>
</div>
<div class="main_d">
<? foreach($sort as $b1=> $b2){?>
	<a href="<?=home_url('/person')?>/?cast=<?=$b1?>" id="i<?=$b1?>" class="main_d_1">
		<img src="<?=$dat[$b1]["face"]?>" class="main_d_1_1">
		<span class="main_d_1_2">
			<span class="main_b_1_2_h"></span>
			<span class="main_b_1_2_f f_tr"></span>
			<span class="main_b_1_2_f f_tl"></span>
			<span class="main_b_1_2_f f_br"></span>
			<span class="main_b_1_2_f f_bl"></span>

			<span class="main_d_1_2_name"><?=$dat[$b1]["genji"]?></span>
			<span class="main_d_1_2_sch"><?=$dat[$b1]["sch"]?></span>
		</span>

		<?if($dat[$b1]["new"] == 1){?>
			<span class="main_b_1_ribbon ribbon1">近日入店</span>
		<?}elseif($dat[$b1]["new"] == 2){?>
			<span class="main_b_1_ribbon ribbon2">本日入店</span>
		<?}elseif($dat[$b1]["new"] == 3){?>
			<span class="main_b_1_ribbon ribbon3">新人</span>
		<?}?>
	</a>
<? } ?>
</div>
<?php get_footer(); ?>
