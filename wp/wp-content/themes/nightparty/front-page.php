<?php
//---------------------------------------
//require_once ("../../../wp-load.php");
global $wpdb;

$sql=" SELECT meta_value, meta_key FROM wp01_usermeta";
$sql.=" WHERE meta_key IN('start_time','start_week')";
$admin	= $wpdb->get_results($sql,ARRAY_A);
$jst=time()+32400;
$sch_8=date("Ymd",$jst-($admin["start_time"]*3600));
//$link=get_template_directory_uri();
//-------------------------------------------

$sql=" SELECT sche_date, wp01_0sch_table.sort, wp01_0schedule.cast_id, stime, etime, ctime, genji,wp01_0cast.id FROM wp01_0schedule";
$sql.=" LEFT JOIN wp01_0sch_table ON stime=name";
$sql.=" LEFT JOIN wp01_0cast ON wp01_0schedule.cast_id=wp01_0cast.id";
$sql.=" WHERE sche_date='{$sch_8}'";
$sql.=" AND del='0'";
$sql.=" ORDER BY schedule_id ASC";

$res0= $wpdb->get_results($sql,ARRAY_A);
foreach($res0 as $a1){

	if($a1["stime"] && $a1["etime"]){
		$a1["sc"]="{$a1["stime"]} － {$a1["etime"]}";
		$sort[$a1["id"]]=$a1["sort"];

		if($sch_8 < $a1["ctime"]){
			$a1["new"]=1;

		}elseif($sch_8 == $a1["ctime"]){
			$a1["new"]=2;

		}elseif(strtotime($sch_8) - strtotime($a1["ctime"])<=2592000){
			$a1["new"]=3;
		}
	}else{
		$sort[$a1["id"]]=9999;
	}

	$dat[$a1["cast_id"]]=$a1;
	if (file_exists(get_template_directory()."/img/page/{$a1["id"]}/0.jpg")) {
		$dat[$a1["id"]]["face"]=get_template_directory_uri()."/img/page/".$a1["id"]."/0.jpg";			
	}else{
		$dat[$a1["id"]]["face"]=get_template_directory_uri()."/img/page/noimage.jpg";			
	}
}

$sql	 ="SELECT meta_id, meta_value, post_type, post_content, post_mime_type, guid FROM wp01_postmeta AS M";
$sql	.=" LEFT JOIN wp01_posts AS P on M.post_id=P.ID";
$sql	.=" WHERE meta_key='_top_slide'";
$sql	.=" AND meta_value>0";
$sql	.=" ORDER BY meta_value ASC";
$res2 = $wpdb->get_results($sql,ARRAY_A);
foreach($res2 as $a2){

	if($a2["guid"]){
		$a2["link"]=home_url($a2["guid"]);

	}elseif($a2["post_content"]){
		$a2["link"]=home_url('/event')."/?code=".$a2["meta_id"];
	}

	if($a2["post_mime_type"]){
		$a2["link"].="/?cast={$a2["post_mime_type"]}";
	}
	$slide[]=$a2;

}

$sql	 ="SELECT meta_id, meta_value, post_type, post_content, post_mime_type, guid FROM wp01_postmeta AS M";
$sql	.=" LEFT JOIN wp01_posts AS P on M.post_id=P.ID";
$sql	.=" WHERE meta_key='_top_info'";
$sql	.=" AND meta_value>0";
$sql	.=" ORDER BY meta_value ASC";
echo $sql;
$res2 = $wpdb->get_results($sql,ARRAY_A);
foreach($res2 as $a2){

	if($a2["guid"]){
		$a2["link"]=home_url($a2["guid"]);

	}elseif($a2["post_content"]){
		$a2["link"]=home_url('/info')."/?code=".$a2["meta_id"];
	}

	if($a2["post_mime_type"]){
		$a2["link"].="/?cast={$a2["post_mime_type"]}";
	}
	$info[]=$a2;
}


$sql	 ="SELECT meta_id, meta_value, post_type, post_title, post_content, post_date_gmt, T.name, slug, post_mime_type, guid FROM wp01_postmeta AS M";
$sql	.=" LEFT JOIN wp01_posts AS P on M.post_id=P.ID";
$sql	.=" LEFT JOIN wp01_terms AS T on M.meta_value=T.term_id";
$sql	.=" WHERE meta_key='_top_news'";
$sql	.=" AND meta_value>0";
$sql	.=" ORDER BY post_date_gmt DESC";
$sql	.=" LIMIT 5";
$res2 = $wpdb->get_results($sql,ARRAY_A);
foreach($res2 as $a2){
	$a2["news_date"]=substr($a2["post_date_gmt"],0,4).".".substr($a2["post_date_gmt"],5,2).".".substr($a2["post_date_gmt"],8,2);
	$a2["post_title"]=str_replace("\n","<br>",$a2["post_title"]);

	if($a2["guid"]){
		$a2["link"]=home_url($a2["guid"]);

	}elseif($a2["post_content"]){
		$a2["link"]=home_url('/news')."/?code=".$a2["meta_id"];
	}

	if($a2["post_mime_type"]){
		$a2["link"].="/?cast={$a2["post_mime_type"]}";
	}

	$news[]=$a2;
}

/*
$stime[1]="OPEN";
$stime[2]="OPEN";
$stime[3]="OPEN";
$stime[4]="OPEN";
$stime[5]="19:30";
$stime[6]="OPEN";

$etime[1]="LAST";
$etime[2]="LAST";
$etime[3]="23:30";
$etime[4]="LAST";
$etime[5]="LAST";
$etime[6]="LAST";

$date=date("Y-m-d H:i:s");
$app="INSERT INTO wp01_0schedule (`date`,sche_date,cast_id,stime,etime) VALUES";
for($s=0;$s<20;$s++){
	$ymd=date("Ymd",time()+86400*$s);
	for($cast=100;$cast<115;$cast++){
		$rnd=rand(0,5);
		if($rnd>0){
			$list.="('{$date}','{$ymd}','{$cast}','{$stime[$rnd]}','{$etime[$rnd]}'),";
		}
	}
}

$list=substr($list,0,-1);
$app.=$list;
$wpdb->query($app);
*/


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
			<?if($slide[0]["link"]){?>
				<a href="<?=$slide[0]["link"]?>"><img src="<?=get_template_directory_uri()?>/img/page/top/top<?=$slide[0]["meta_id"]?>.jpg" class="top_img"></a>;
			<?}else{?>	
				<img src="<?=get_template_directory_uri()?>/img/page/top/top<?=$slide[0]["meta_id"]?>.jpg" class="top_img">;
			<?}?>	
		</div>
	</div>

<?}elseif(count($slide) >1){?>
	<div class="slide">
		<div class="slide_img">
			<?for($n=0;$n<count($slide);$n++){?>
				<?if($slide[$n]["link"]){?>
					<a href="<?=$slide[0]["link"]?>"><img src="<?=get_template_directory_uri()?>/img/page/top/top<?=$slide[$n]["meta_id"]?>.jpg" class="top_img"></a>;
				<?}else{?>	
					<img src="<?=get_template_directory_uri()?>/img/page/top/top<?=$slide[$n]["meta_id"]?>.jpg" class="top_img">;
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
		<div class="main_b_title">新着情報<a href="<?=home_url('/new_list')?>" class="new_all">一覧≫</a></div>
		<div class="main_b_top">
			<?for($n=0;$n<count($news);$n++){?>
				<?if($news[$n]["link"]){?>
					<table  class="main_b_notice" colspan="3">
					<tr>
					<td  class="main_b_td_1">
						<span class="main_b_notice_date"><?=$news[$n]["news_date"]?></span>
						<span class="main_b_notice_tag" style="background:<?=$news[$n]["slug"]?>"><?=$news[$n]["name"]?></span>
					</td>
					<td  class="main_b_td_2">
						<a href="<?=$news[$n]["link"]?>" class="main_b_notice_link">
							<span class="main_b_notice_title"><?=$news[$n]["post_title"]?></span>
						</a>
					</td>
					<td  class="main_b_td_3">
						<span class="main_b_notice_arrow"><a href="<?=$news[$n]["link"]?>" class="main_b_notice_alink">	</a></span>
					</td>
					</tr>
					</table>
				<?}else{?>
					<table class="main_b_notice" colspan="2">
					<tr>
					<td  class="main_b_td_1">
						<span class="main_b_notice_date"><?=$news[$n]["news_date"]?></span>
						<span class="main_b_notice_tag" style="background:<?=$news[$n]["slug"]?>"><?=$news[$n]["name"]?></span>
					</td>
					<td  class="main_b_td_2">
						<span class="main_b_notice_title"><?=$news[$n]["post_title"]?></span>
					</td>
					</tr>
					</table>
				<?}?>
			<?}?>
		</div>
		<div class="main_b_top2">
			<?for($n=0;$n<count($info);$n++){?>
				<?if($info[$n]["link"]){?>
					<a href="<?=$info[$n]["link"]?>" class="side_img_out">
						<img src="<?=get_template_directory_uri()?>/img/page/top/info<?=$info[$n]["meta_id"]?>.png" class="side_img">
					</a>
				<?}else{?>	
						<img src="<?=get_template_directory_uri()?>/img/page/top/info<?=$info[$n]["meta_id"]?>.png" class="top2_img">
				<?}?>
			<?}?>
		</div>
		<div class="main_b_title">本日の出勤キャスト</div>
		<div class="main_b_in">
			<? foreach($sort as $b1=> $b2){?>
				<? if($b2 !='9999'){?>
					<a href="<?=home_url('/person')?>/?cast=<?=$b1?>" id="i<?=$b1?>" class="main_b_1">
						<img src="<?=$dat[$b1]["face"]?>?t=<?=time()?>" class="main_b_1_1">
						<span class="main_b_1_2">
							<span class="main_b_1_2_h"></span>
							<span class="main_b_1_2_f f_tr"></span>
							<span class="main_b_1_2_f f_tl"></span>
							<span class="main_b_1_2_f f_br"></span>
							<span class="main_b_1_2_f f_bl"></span>
							<span class="main_b_1_2_name"><?=$dat[$b1]["genji"]?></span>
							<span class="main_b_1_2_sch"><?=$dat[$b1]["sc"]?></span>
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
			<? } ?>
		</div>
	</div>

	<div class="main_c">
		<?for($n=0;$n<count($info);$n++){?>
			<?if($info[$n]["link"]){?>
					<a href="<?=$info[$n]["link"]?>" class="side_img_out">
						<img src="<?=get_template_directory_uri()?>/img/page/top/info<?=$info[$n]["meta_id"]?>.png" class="side_img">
					</a>
			<?}else{?>	
					<img src="<?=get_template_directory_uri()?>/img/page/top/info<?=$info[$n]["meta_id"]?>.png" class="side_img">
			<?}?>
		<?}?>

		<a class="twitter-timeline" data-width="300" data-height="500" data-theme="dark" href="https://twitter.com/serra_geddon?ref_src=twsrc%5Etfw">Tweets by serra_geddon</a> <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
	</div>
</div>
<?php get_footer(); ?>

