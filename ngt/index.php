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
			$sort[$a1["id"]]=9999;
		}
	}
}

$sql	 ="SELECT * FROM wp01_top_slide";
$sql	.=" WHERE status=0";
$sql	.=" ORDER BY sort ASC";
$sql	.=" LIMIT 5";

if($res = mysqli_query($mysqli,$sql)){
	while($a2 = mysqli_fetch_assoc($res)){
		$slide[]=$a2:
	}
}

$sql	 ="SELECT * FROM wp01_top_news";
$sql	.=" WHERE status=0";
$sql	.=" ORDER BY `date` ASC";
$sql	.=" LIMIT 5";

if($res = mysqli_query($mysqli,$sql)){
	while($a3 = mysqli_fetch_assoc($res)){
		$news[]=$a3:
	}
}

$sql	 ="SELECT * FROM wp01_top_info";
$sql	.=" WHERE status=0";
$sql	.=" ORDER BY `sort` ASC";
$sql	.=" LIMIT 4";

if($res = mysqli_query($mysqli,$sql)){
	while($a4 = mysqli_fetch_assoc($res)){
		$info[]=$a4:
	}
}
include_once('./header.php');
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
<script src="./js/index.js?t=<?=time()?>"></script>

<div class="main_top">
<?if(count($slide) ==1){?>
	<div class="slide">
		<div class="slide_img">
			<?if($slide[0]["link"]){?>
				<a href="<?=$slide[0]["link"]?>"><img src="./img/page/top/top<?=$slide[0]["meta_id"]?>.webp" class="top_img"></a>;
			<?}else{?>	
				<img src="./img/page/top/top<?=$slide[0]["meta_id"]?>.webp" class="top_img">;
			<?}?>	
		</div>
	</div>

<?}elseif(count($slide) >1){?>
	<div class="slide">
		<div class="slide_img">
			<?for($n=0;$n<count($slide);$n++){?>
				<?if($slide[$n]["link"]){?>
					<a href="<?=$slide[$n]["link"]?>"><img src="./img/page/top/top<?=$slide[$n]["meta_id"]?>.webp" class="top_img"></a>;
				<?}else{?>	
					<img src="./img/page/top/top<?=$slide[$n]["meta_id"]?>.webp" class="top_img">;
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
		<div class="main_b_title">新着情報<a href="./new_list.php" class="new_all">一覧≫</a></div>
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

		<div class="info_box sp_only">
			<?for($n=0;$n<count($info);$n++){?>
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
	</div>

	<div class="main_c">
		<div class="pc_only">
			<?for($n=0;$n<count($info);$n++){?>
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
