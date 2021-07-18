<?php
include_once('./library/sql.php');

$sql  ="SELECT id, tag_name, tag_icon,sort FROM wp01_0tag ";
$sql .=" WHERE tag_group='ribbon'";
$sql.=" AND del='0'";

if($result = mysqli_query($mysqli,$sql)){
	while($row = mysqli_fetch_assoc($result)){

		$ribbon_sort[$row["sort"]]=$row["id"];
		$ribbon[$row["id"]]["name"]=$row["tag_name"];

		$tmp=hexdec(str_replace("#","",$row["tag_icon"]));
		$tmp+=2631720;
		$tmp=dechex($tmp);
	
		$ribbon[$row["id"]]["c1"]="#".$tmp;
		$ribbon[$row["id"]]["c2"]=$row["tag_icon"];
	}
}

$sql=" SELECT wp01_0cast.id,sche_date, wp01_0sch_table.sort, wp01_0schedule.cast_id, ribbon_use, cast_ribbon, stime, etime, ctime, genji,wp01_0cast.id FROM wp01_0schedule";
$sql.=" LEFT JOIN wp01_0sch_table ON stime=name";
$sql.=" LEFT JOIN wp01_0cast ON wp01_0schedule.cast_id=wp01_0cast.id";
$sql.=" WHERE sche_date='{$day_8}'";
$sql.=" AND del='0'";
$sql.=" AND cast_status=0";
$sql.=" ORDER BY wp01_0cast.cast_sort ASC, wp01_0schedule.id ASC";

if($result = mysqli_query($mysqli,$sql)){
	while($row = mysqli_fetch_assoc($result)){
		if($row["stime"] && $row["etime"]){
			$row["sch_view"]=$row["stime"]." － ".$row["etime"];

			if($admin_config["ribbon"] ==1){
				if($day_8 < $row["ctime"] && $admin_config["coming_soon"]==1){
					$row["ribbon_name"]	=$ribbon[$ribbon_sort[1]]["name"];
					$row["ribbon_c1"]	=$ribbon[$ribbon_sort[1]]["c1"];
					$row["ribbon_c2"]	=$ribbon[$ribbon_sort[1]]["c2"];

				}elseif($day_8 == $row["ctime"] && $admin_config["today_commer"]==1){
					$row["ribbon_name"]	=$ribbon[$ribbon_sort[2]]["name"];
					$row["ribbon_c1"]	=$ribbon[$ribbon_sort[2]]["c1"];
					$row["ribbon_c2"]	=$ribbon[$ribbon_sort[2]]["c2"];

				}elseif((strtotime($day_8) - strtotime($row["ctime"]))/86400<$admin_config["new_commer_cnt"]){
					$row["ribbon_name"]	=$ribbon[15]["name"];
					$row["ribbon_c1"]	=$ribbon[$ribbon_sort[3]]["c1"];
					$row["ribbon_c2"]	=$ribbon[$ribbon_sort[3]]["c2"];

				}elseif($row["cast_ribbon"]>0){
					$row["ribbon_name"]	=$ribbon[$row["cast_ribbon"]]["name"];
					$row["ribbon_c1"]	=$ribbon[$row["cast_ribbon"]]["c1"];
					$row["ribbon_c2"]	=$ribbon[$row["cast_ribbon"]]["c2"];

				}
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
			$a1["link"]="./event.php";
			$a1["code"]=$a1["id"];

		}elseif($a1["category"] == "person"){
			$a1["link"]="./person.php";
			$a1["code"]=$a1["contents_key"];

		}elseif($a1["category"]){
			$a1["link"]=$a1["contents_key"];
		}

		if (file_exists("./img/page/event/event_{$a1["id"]}.webp")) {
			$a1["img"]="./img/page/event/event_{$a1["id"]}.webp";

		}elseif (file_exists("./img/page/event/event_{$a1["id"]}.jpg")) {
			$a1["img"]="./img/page/event/event_{$a1["id"]}.jpg";

		}elseif (file_exists("./img/page/event/event_{$a1["id"]}.png")) {
			$a1["img"]="./img/page/event/event_{$a1["id"]}.png";
		}
		$event[]=$a1;
		$count_event++;
	}
}

$sql	 ="SELECT tag_name, tag_icon, date, display_date,event_date, category, contents_key, title, contents, contents_url FROM wp01_0contents";
$sql	.=" LEFT JOIN wp01_0tag ON tag=wp01_0tag.id";
$sql	.=" WHERE status<3";
$sql	.=" AND display_date<'{$now}'";
$sql	.=" AND page='news'";
$sql	.=" ORDER BY status DESC, event_date DESC";
$sql	.=" LIMIT 5";

if($res1 = mysqli_query($mysqli,$sql)){
	while($a1 = mysqli_fetch_assoc($res1)){

		$a1["date"]=substr(str_replace("-",".",$a1["event_date"]),0,10);

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
$sql	.=" WHERE status<4";
$sql	.=" AND display_date<'{$now}'";
$sql	.=" AND page='info'";
$sql	.=" ORDER BY sort ASC";
$sql	.=" LIMIT 6";

if($res2 = mysqli_query($mysqli,$sql)){
	while($a1 = mysqli_fetch_assoc($res2)){

		if($a1["category"] == "person" && $a1["contents_key"]){
			$a1["link"]="person.php?post_id=".$a1["contents_key"];

		}elseif($a1["category"] == "event" && $a1["contents_key"]){
			$a1["link"]="event.php?post_id=".$a1["contents_key"];

		}elseif($a1["contents_key"]){
			$a1["link"]=$a1["contents_key"];

		}

		$info[]=$a1;
		$info_count++;
	}
}
include_once('./header.php');
?>
<style>
#slide_img0{
	left			:0;
	z-index			:1;
}

#slide_img<?=$count_event-1?>{
	left			:0;
	z-index			:0;
}
#slide_img1{
	z-index			:2;
}
</style>

<script>
var Cnt=<?=$count_event?>;
var NewCnt=1;

</script>
<form id="form_1" method="get" action="">
<input id="s_code" type="hidden" name="post_id">
</form>
<script src="./js/index.js?t=<?=time()?>"></script>
<div class="main_top">
<?if($count_event>0){?>
	<div class="slide">
		<div class="slide_img">
			<?for($n=0;$n<$count_event;$n++){?>
				<img id="slide_img<?=$n?>" src="<?=$event[$n]["img"]?>" s_link="<?=$event[$n]["link"]?>" s_code="<?=$event[$n]["code"]?>" class="top_img" alt="<?=$event[$n]["title"]?>">;
			<?}?>	
			<div class="slide_img_cv"></div>
		</div>

		<?if($count_event >1){?>
			<span class="slide_point">
				<?for($n=0;$n<$count_event;$n++){?>
					<div id="dot<?=$n?>" class="slide_dot<?if($n == 0){?> dot_on<?}?>"></div>
				<?}?>
			</span>
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

						<?if($b2["ribbon_name"]){?>
							<span class="main_b_1_ribbon" style="background:linear-gradient(<?=$b2["ribbon_c1"]?>,<?=$b2["ribbon_c2"]?>);box-shadow	:0 -5px 0 <?=$b2["ribbon_c1"]?>,0 5px 0 <?=$b2["ribbon_c2"]?>;"><?=$b2["ribbon_name"]?></span>
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
		<div class="info_box">
			<?for($n=0;$n<$info_count;$n++){?>
				<?if($info[$n]["link"]){?>
					<a href="<?=$info[$n]["link"]?>" class="info_img_out">
						<img src="./img/page/info/info_<?=$info[$n]["id"]?>.png?d=<?=time()?>" class="info_img">
					</a>
				<?}else{?>	
						<img src="./img/page/info/info_<?=$info[$n]["id"]?>.png?d=<?=time()?>" class="info_img">
				<?}?>
			<?}?>
		</div>
		<?if($admin_config["twitter_view"]==1 && $admin_config["twitter"]){?>
			<div class="twitter_title" style="text-align:center">◆　twitter ◆</div>
			<div class="twitter_tl"><a class="twitter-timeline" data-width="300" data-height="500" data-theme="dark" data-chrome="noscrollbar,transparent,noheader,nofooter" style="width:100%" href="https://twitter.com/<?=$admin_config["twitter"]?>?ref_src=twsrc%5Etfw">Tweets by serra_geddon</a> <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
			</div>
			<div class="twitter_foot"><a href="https://twitter.com/<?=$admin_config["twitter"]?>" class="twitter_foot_in"><span class="icon"></span>　フォローする</a></div>
		<?}?>
	</div>
</div>
<?include_once('./footer.php'); ?>





