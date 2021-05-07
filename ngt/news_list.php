<?php
include_once('./library/sql.php');
$code=$_REQUEST["code"];

if($code){
	$app=" AND tag='{$code}'";
}

$sql	 ="SELECT * FROM wp01_0contents";
$sql	.=" WHERE page='news'";
$sql	.=" AND status=0";
$sql	.=" ORDER BY display_date DESC";
$sql	.=" LIMIT 20";

if($result = mysqli_query($mysqli,$sql)){
	while($row = mysqli_fetch_assoc($result)){
		$dat[]=$row;
		$count_dat++;
	}
}

$sql	 ="SELECT * FROM wp01_0tag";
$sql	.=" WHERE tag_group='news'";
$sql	.=" AND del=0";
$sql	.=" ORDER BY sort ASC";

if($result = mysqli_query($mysqli,$sql)){
	while($row = mysqli_fetch_assoc($result)){
		$tag[]=$row;
		$count_tag++;
	}
}
include_once('./header.php');

?>
<div class="footmark">
	<a href="./index.php" class="footmark_box box_a">
		<span class="footmark_icon"></span>
		<span class="footmark_text">TOP</span>
	</a>
	<span class="footmark_icon"></span>
	<div class="footmark_box">
		<span class="footmark_icon"></span>
		<span class="footmark_text">NEWS</span>
	</div>
</div>





<div class="main_top_flex">
<div class="news_main_a">
<?if($count_dat>0){?>
	<div class="main_b_top">
		<?for($n=0;$n<$news_count;$n++){?>
			<?if($news[$n]["contents_url"]){?>
				<table  class="main_b_notice" colspan="3">
				<tr>
				<td  class="main_b_td_1">
					<span class="main_b_notice_date"><?=$news[$n]["date"]?></span>
					<span class="main_b_notice_tag" style="background:<?=$news[$n]["tag_icon"]?>"><?=$news[$n]["tag_name"]?></span>
				</td>
				<td  class="main_b_td_2">
					<a href="<?=$news[$n]["contents_url"]?>" class="main_b_notice_link">
						<span class="main_b_notice_title"><?=$news[$n]["title"]?></span>
					</a>
				</td>
				<td  class="main_b_td_3">
					<span class="main_b_notice_arrow"><a href="<?=$news[$n]["contents_url"]?>" class="main_b_notice_alink">	</a></span>
				</td>
				</tr>
				</table>

			<?}elseif($news[$n]["category"]){?>
				<table  class="main_b_notice" colspan="3">
				<tr>
				<td  class="main_b_td_1">
					<span class="main_b_notice_date"><?=$news[$n]["date"]?></span>
					<span class="main_b_notice_tag" style="background:<?=$news[$n]["tag_icon"]?>"><?=$news[$n]["tag_name"]?></span>
				</td>
				<td  class="main_b_td_2">
					<a href="<?=$news[$n]["category"]?>.php?post_id=<?=$news[$n]["contents_key"]?>" class="main_b_notice_link">
						<span class="main_b_notice_title"><?=$news[$n]["title"]?></span>
					</a>
				</td>
				<td class="main_b_td_3">
					<span class="main_b_notice_arrow"><a href="<?=$news[$n]["category"]?>.php?post_id=<?=$news[$n]["contents_key"]?>" class="main_b_notice_alink">	</a></span>
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
<?}else{?>
	<div class="person_blog">
		<span class="person_blog_no">お知らせはまだありません</span>
	</div>
<?}?>
</div>
<div class="news_main_b">
<?if($tag){?>
<ul>
<?for($n=0;$n<$tag_count;$n++){?>
<li id="tag<?=$tag[$n]["id"]?>"><?=$tag[$n]["tag_name"]?></li>
<?}?>
</ul>
<?}?>
</div>
</div>
<?php get_footer(); ?>