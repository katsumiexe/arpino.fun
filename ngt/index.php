<?php
include_once('./library/sql.php');

$sql=" SELECT sche_date, wp01_0sch_table.sort, wp01_0schedule.cast_id, stime, etime, ctime, genji,wp01_0cast.id FROM wp01_0schedule";
$sql.=" LEFT JOIN wp01_0sch_table ON stime=name";
$sql.=" LEFT JOIN wp01_0cast ON wp01_0schedule.cast_id=wp01_0cast.id";
$sql.=" WHERE sche_date='{$day_8}'";
$sql.=" AND del='0'";
$sql.=" ORDER BY schedule_id ASC";

if($res = mysqli_query($mysqli,$sql)){
	while($a1 = mysqli_fetch_assoc($res)){

		if($a1["stime"] && $a1["etime"]){
			$cast_sch[$a1["id"]]="{$a1["stime"]} － {$a1["etime"]}";

			$sort[$a1["id"]]=$a1["sort"];

			if($day_8 < $a1["ctime"]){
				$a1["new"]=1;

			}elseif($day_8 == $a1["ctime"]){
				$a1["new"]=2;

			}elseif(strtotime($day_8) - strtotime($a1["ctime"])<=2592000){
				$a1["new"]=3;
			}

			if (file_exists("./img/cast/{$a1["id"]}/0_s.webp")) {
				$dat[$a1["id"]]["face"]="./img/cast/{$a1["id"]}/0_s.webp";			

			}elseif (file_exists("./img/cast/{$a1["id"]}/0_s.jpg")) {
				$dat[$a1["id"]]["face"]="./img/cast/{$a1["id"]}/0_s.jpg";			

			}else{
				$dat[$a1["id"]]["face"]="./img/cast/noimage.jpg";			
			}
		}else{
			$sort[$a1["id"]]="";
		}
	}
}

$sql	 ="SELECT * FROM wp01_0contents";
$sql	.=" WHERE status=0";
$sql	.=" AND display_date<'{$now}'";
$sql	.=" AND page='event'";
$sql	.=" ORDER BY sort DESC";
$sql	.=" LIMIT 6";

if($res0 = mysqli_query($mysqli,$sql)){
	while($a1 = mysqli_fetch_assoc($res0)){
		if($a1["category"] == "event"){
			$a1["link"]="./event.php?code={$a1["id"]}";

		}elseif($a1["contents_key"]>0){
			$a1["link"]="./{$a1["category"]}.php?code={$a1["contents_key"]}";

		}elseif($a1["category"]){
			$a1["link"]=$a1["category"];
		}
		$event[]=$a1;
	}
	if (is_array($event)) {
		$event_count=count($event);
	}
}


$sql	 ="SELECT * FROM wp01_0contents";
$sql	.=" WHERE status=0";
$sql	.=" AND display_date<'{$now}'";
$sql	.=" AND page='news'";
$sql	.=" ORDER BY sort ASC";
$sql	.=" LIMIT 5";

if($res1 = mysqli_query($mysqli,$sql)){
	while($a1 = mysqli_fetch_assoc($res1)){
		$news[]=$a1;
	}
	if (is_array($news)) {
		$news_count=count($news);
	}
}

$sql	 ="SELECT * FROM wp01_0contents";
$sql	.=" WHERE status=0";
$sql	.=" AND display_date<'{$now}'";
$sql	.=" AND page='info'";
$sql	.=" ORDER BY sort ASC";
$sql	.=" LIMIT 2";

if($res2 = mysqli_query($mysqli,$sql)){
	while($a1 = mysqli_fetch_assoc($res2)){
		$info[]=$a1;
	}
	if (is_array($info)) {
		$info_count=count($info);
	}
}

include_once('./header.php');
?>
<style>
.slide_img{
	width		:calc( 1200px * <?=$slide_count?>);
}

.slide_point{
	width		:calc( 70px + 30px * <?=$slide_count?>);
}

@media screen and (max-width: 959px){
.slide_img{
	width		:calc( 98vw * <?=$slide_count?>);
}
.slide_point{
	width		:calc( 25vw + 5vw * <?=$slide_count?>);
}
}
</style>
<script>
var Cnt=<?=$event_count?>-1;
</script>
<script src="./js/index.js?t=<?=time()?>"></script>
<div class="main_top">
<?if($event_count>0){?>
	<div class="slide">
		<div class="slide_img">
		
			<?for($n=0;$n<$event_count;$n++){?>
				<?if($event[$n]["link"]){?>
					<a href="<?=$event[$n]["link"]?>"><img src="./img/page/event/event_<?=$event[$n]["id"]?>.jpg" class="top_img"></a>;
				<?}else{?>	
					<img src="./img/page/event/noimage.jpg" class="top_img">;
				<?}?>	
			<?}?>	
		</div>

<?if($event_count >1){?>
		<div class="slide_point">
			<?for($n=0;$n<$slide_count;$n++){?>
				<div id="dot<?=$n?>" class="slide_dot<?if($n == 0){?> dot_on<?}?>"></div>
			<?}?>
		</div>
<?}?>
	</div>
<?}?>


	<div class="main_b">
		<?if($news_count){?>
		<div class="main_b_title">新着情報<a href="./new_list.php" class="new_all">一覧≫</a></div>
		<div class="main_b_top">
			<?for($n=0;$n<$news_count;$n++){?>
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
		<?}?>

		<div class="info_box sp_only">
			<?for($n=0;$n<$info_count;$n++){?>
				<?if($info[$n]["link"]){?>
					<a href="<?=$info[$n]["link"]?>" class="info_img_out">
						<img src=".img/page/top/info<?=$info[$n]["meta_id"]?>.png" class="info_img">
					</a>
				<?}else{?>	
					<span class="info_img_out">
						<img src="./img/page/top/info<?=$info[$n]["meta_id"]?>.png" class="info_img">
					</span>	
				<?}?>
			<?}?>
		</div>

<?if($sort){?>
		<div class="main_b_title">本日の出勤キャスト</div>
		<div class="main_b_in">
			<? foreach($sort as $b1=> $b2){?>
				<? if($b2 !='9999'){?>
					<span class="main_b_1">
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
					<a href="./person.php?cast=<?=$b1?>" id="i<?=$b1?>" class="main_b_1_0"></a>
					</span>
				<? } ?>
			<? } ?>
		</div>
<? } ?>

	</div>

	<div class="main_c">
		<div class="pc_only">
			<?for($n=0;$n<$info_count;$n++){?>
				<?if($info[$n]["link"]){?>
						<a href="<?=$info[$n]["link"]?>" class="info_img_out">
							<img src="./img/page/top/info<?=$info[$n]["meta_id"]?>.png" class="info_img">
						</a>
				<?}else{?>	
						<img src="./img/page/top/info<?=$info[$n]["meta_id"]?>.png" class="info_img">
				<?}?>
			<?}?>
		</div>
		<a class="twitter-timeline" data-width="300" data-height="500" data-theme="dark" href="https://twitter.com/serra_geddon?ref_src=twsrc%5Etfw">Tweets by serra_geddon</a> <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
	</div>
</div>
<?include_once('./footer.php'); ?>