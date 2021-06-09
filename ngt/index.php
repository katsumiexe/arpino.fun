<?php
include_once('./library/sql.php');

$sql=" SELECT wp01_0cast.id,sche_date, wp01_0sch_table.sort, wp01_0schedule.cast_id, stime, etime, ctime, genji,wp01_0cast.id FROM wp01_0schedule";
$sql.=" LEFT JOIN wp01_0sch_table ON stime=name";
$sql.=" LEFT JOIN wp01_0cast ON wp01_0schedule.cast_id=wp01_0cast.id";
$sql.=" WHERE sche_date='{$day_8}'";
$sql.=" AND del='0'";
$sql.=" ORDER BY wp01_0cast.cast_sort ASC, wp01_0schedule.id ASC";

if($result = mysqli_query($mysqli,$sql)){
	while($row = mysqli_fetch_assoc($result)){
		if($row["stime"] && $row["etime"]){
			$row["sch_view"]=$row["stime"]." － ".$row["etime"];

			if($day_8 < $row["ctime"] && $admin_config["coming_soon"]==1){
				$row["new"]=1;

			}elseif($day_8 == $row["ctime"] && $admin_config["today_commer"]==1){
				$row["new"]=2;

			}elseif((strtotime($day_8) - strtotime($row["ctime"]))/86400<$admin_config["new_commer_cnt"]){
				$row["new"]=3;
			}

			if (file_exists("./img/profile/{$row["id"]}/0.webp")) {
				$row["face"]="./img/profile/{$row["id"]}/0.webp";			

			}elseif (file_exists("./img/profile/{$row["id"]}/0.jpg")) {
				$row["face"]="./img/profile/{$row["id"]}/0.jpg";			

			}else{
				$row["face"]="./img/cast_no_image.jpg";			
			}
			$dat[$row["id"]]=$row;
		}else{
			$dat[$row["id"]]="";
		}
	}
}

if(is_array($dat)){
	foreach($dat as $a1 => $a2){
		if($a2){
			$sch_dat[]=$a2;
			$dat_count++;
		}
	}
}



$sql	 ="SELECT * FROM wp01_0contents";
$sql	.=" WHERE status=0";
$sql	.=" AND display_date<'{$now}'";
$sql	.=" AND page='event'";
$sql	.=" ORDER BY sort ASC";
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

		if (file_exists("./img/page/event/{$a1["id"]}.webp")) {
			$a1["img"]="./img/page/event/{$a1["id"]}.webp";

		}elseif (file_exists("./img/page/event/{$a1["id"]}.jpg")) {
			$a1["img"]="./img/page/event/{$a1["id"]}.jpg";

		}elseif (file_exists("./img/page/event/{$a1["id"]}.png")) {
			$a1["img"]="./img/page/event/{$a1["id"]}.png";
		}
		$event[]=$a1;
		$count_event++;
	}
}


$sql	 ="SELECT tag_name, tag_icon, date, display_date, category, contents_key, title, contents, contents_url FROM wp01_0contents";
$sql	.=" LEFT JOIN wp01_0tag ON tag=wp01_0tag.id";
$sql	.=" WHERE status<3";
$sql	.=" AND display_date<'{$now}'";
$sql	.=" AND page='news'";
$sql	.=" ORDER BY status DESC, display_date DESC";
$sql	.=" LIMIT 5";

echo $sql;

if($res1 = mysqli_query($mysqli,$sql)){
	while($a1 = mysqli_fetch_assoc($res1)){
		$a1["date"]=substr(str_replace("-",".",$a1["display_date"]),0,10);
		if($a1["category"] == "person"){
			$a1["news_link"]="./person.php?post_id={$a1["contents_key"]}";

		}elseif($a1["category"] == "outer"){
			$a1["news_link"]=$a1["contents_key"];

		}elseif($a1["category"] == "event"){
			$a1["news_link"]="./event.php?post_id={$a1["contents_key"]}";
		}
		
		$news[]=$a1;
		$count_news++;
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

		if($a1["contents_url"]){
			$a1["link"]=$a1["contents_url"];

		}elseif($a1["category"] == "person" && $a1["contents_key"]>0){
			$a1["link"]="person.php?post_id=".$a1["contents_key"];

		}elseif($a1["category"] == "event" && $a1["contents_key"]>0){
			$a1["link"]="event.php?post_id=".$a1["contents_key"];
		}

		$info[]=$a1;
		$info_count++;
	}
}

include_once('./header.php');
?>

<style>
.slide_img{
	width		:calc( 1200px * <?=$count_slide?>);
}

.slide_point{
	width		:calc( 70px + 30px * <?=$count_slide?>);
}

@media screen and (max-width: 959px){
.slide_img{
	width		:calc( 98vw * <?=$count_slide?>);
}
.slide_point{
	width		:calc( 25vw + 5vw * <?=$count_slide?>);
}
}
</style>
<script>
var Cnt=<?=$count_event?>-1;
</script>
<script src="./js/index.js?t=<?=time()?>"></script>
<div class="main_top">
<?if($count_event>0){?>
	<div class="slide">
		<div class="slide_img">

			<?for($n=0;$n<$count_event;$n++){?>
				<?if($event[$n]["link"]){?>
					<a href="<?=$event[$n]["link"]?>"><img src="<?=$event[$n]["img"]?>" class="top_img"></a>;
				<?}else{?>	
					<img src="<?=$event[$n]["img"]?>" class="top_img">;
				<?}?>	
			<?}?>	
		</div>

		<?if($count_event >1){?>
			<div class="slide_point">
				<?for($n=0;$n<$count_event;$n++){?>
					<div id="dot<?=$n?>" class="slide_dot<?if($n == 0){?> dot_on<?}?>"></div>
				<?}?>
			</div>
		<?}?>
	</div>
<?}?>

	<div class="main_b">
		<?if($count_news){?>
		<div class="main_b_title">新着情報<a href="./news_list.php" class="new_all">一覧≫</a></div>
		<div class="main_b_top">

			<?for($n=0;$n<$count_news;$n++){?>

				<?if($news[$n]["category"]){?>
					<table  class="main_b_notice" colspan="3">
					<tr>
					<td  class="main_b_td_1">
						<span class="main_b_notice_date"><?=$news[$n]["date"]?></span>
						<span class="main_b_notice_tag" style="background:<?=$news[$n]["tag_icon"]?>"><?=$news[$n]["tag_name"]?></span>
					</td>

					<td  class="main_b_td_2">
						<a href="<?=$news[$n]["news_link"]?>" class="main_b_notice_link">
							<span class="main_b_notice_title"><?=$news[$n]["title"]?></span>
						</a>
					</td>
					<td class="main_b_td_3">
						<span class="main_b_notice_arrow"><a href="<?=$news[$n]["news_link"]?>" class="main_b_notice_alink">	</a></span>
					</td>
					</tr>
					</table>

				<?}else{?>
					<table class="main_b_notice" colspan="2">
						<tr>
							<td  class="main_b_td_1">
								<span class="main_b_notice_date"><?=$news[$n]["date"]?></span>
								<span class="main_b_notice_tag" style="background:<?=$news[$n]["tag_icon"]?>"><?=$news[$n]["tag_name"]?></span>
							</td>
							<td  class="main_b_td_2">
								<span class="main_b_notice_title"><?=$news[$n]["title"]?></span>
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
						<img src="./img/page/info/<?=$info[$n]["id"]?>.png" class="info_img">
					</a>
				<?}else{?>	
					<span class="info_img_out">
						<img src="./img/page/info/<?=$info[$n]["id"]?>.png" class="info_img">
					</span>	
				<?}?>
			<?}?>
		</div>

		<div class="main_b_title">本日の出勤キャスト</div>
		<div class="main_b_in">
			<?if($dat_count>0){?>
				<? foreach($sch_dat as $b2){?>
					<span class="main_b_1">
						<img src="<?=$b2["face"]?>?t=<?=time()?>" class="main_b_1_1">
						<span class="main_b_1_2">
							<span class="main_b_1_2_h"></span>
							<span class="main_b_1_2_f f_tr"></span>
							<span class="main_b_1_2_f f_tl"></span>
							<span class="main_b_1_2_f f_br"></span>
							<span class="main_b_1_2_f f_bl"></span>
							<span class="main_b_1_2_name"><?=$b2["genji"]?></span>
							<span class="main_b_1_2_sch"><?=$b2["sch_view"]?></span>
						</span>
						<?if($b2["new"] == 1){?>
						<span class="main_b_1_ribbon ribbon1">近日入店</span>
						<?}elseif($b2["new"] == 2){?>
						<span class="main_b_1_ribbon ribbon2">本日入店</span>
						<?}elseif($b2["new"] == 3){?>
						<span class="main_b_1_ribbon ribbon3">新人</span>
						<?}?>
					<a href="./person.php?post_id=<?=$b2["cast_id"]?>" id="i<?=$b1?>" class="main_b_1_0"></a>
					</span>
				<? } ?>
			<? }else{ ?>
				<span class="no_blog">予定はありません</span>
			<? } ?>
		</div>
	</div>

	<div class="main_c">
		<div class="pc_only">
			<?for($n=0;$n<$info_count;$n++){?>
				<?if($info[$n]["link"]){?>
					<a href="<?=$info[$n]["link"]?>" class="info_img_out">
						<img src="./img/page/info/<?=$info[$n]["id"]?>.png?d=<?=time()?>" class="info_img">
					</a>
				<?}else{?>	
					<span class="info_img_out">
						<img src="./img/page/info/<?=$info[$n]["id"]?>.png?d=<?=time()?>" class="info_img">
					</span>	
				<?}?>
			<?}?>
		</div>
		<?if($admin_config["twitter_view"]==1 && $admin_config["twitter"]){?>
		<a class="twitter-timeline" data-width="300" data-height="500" data-theme="dark" href="https://twitter.com/<?=$admin_config["twitter"]?>?ref_src=twsrc%5Etfw">Tweets by serra_geddon</a> <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
		<?}?>	
	</div>
</div>
<?include_once('./footer.php'); ?>
