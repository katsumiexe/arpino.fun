<?php
include_once('./library/sql.php');
ini_set( 'display_errors', 1 );
ini_set('error_reporting', E_ALL);


$code=$_REQUEST["code"];

if($code){
	$app=" AND tag='{$code}'";
}

$now_year=$_POST["now_year"];

if(!$now_year) $now_year=date("Y");

$start_year=date("Y");


$sql	 ="SELECT display_date FROM wp01_0contents";
$sql	.=" WHERE status=0";
$sql	.=" AND page='news'";
$sql	.=" ORDER BY date ASC";
$sql	.=" LIMIT 1";

if($result = mysqli_query($mysqli,$sql)){
	$row = mysqli_fetch_assoc($result);
	$start_year=substr($row["display_date"],0,4);
}

$sql	 ="SELECT tag_name, tag_icon, date,category, contents_key, title, contents, contents_url FROM wp01_0contents";
$sql	.=" LEFT JOIN wp01_0tag ON tag=wp01_0tag.id";
$sql	.=" WHERE status=0";
$sql	.=" AND display_date<'{$now}'";
$sql	.=" AND page='news'";
$sql	.=" ORDER BY display_date DESC";

if($res1 = mysqli_query($mysqli,$sql)){
	while($a1 = mysqli_fetch_assoc($res1)){
		$a1["date"]=substr(str_replace("-",".",$a1["date"]),0,10);
		$news[]=$a1;
		$count_news++;
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


<?if($now_year > $start_year){?>
<form id="year_sel">
<select>
<?for($n=$start_year;$n<$now_year+1;$n++){?>
<option value="<?=$n?>" <?if($now_year == $n){?>selected="selcted"<?}?>><?=$n?></option>
<?}?>
<select>
<input id="sel" type="hidden" value="0">
</form>
<?}?>
<div class="main_top_flex">
	<div class="news_main_a">
		<div class="main_b_top">
			<?for($n=0;$n<$count_news;$n++){?>
				<?if($news[$n]["contents_url"]){?>
					<table class="main_b_notice tag<?=$news[$n]["tag"]?>">">
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
					<table  class="main_b_notice tag<?=$news[$n]["tag"]?>">">
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
					<table class="main_b_notice">
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
			<div class="person_blog no_news">
				<span class="person_blog_no">お知らせはまだありません</span>
			</div>
		</div>

	</div>
	<div class="news_main_b">
		<?if($tag){?>
			<div class="news_tag">
					<div id="tag0" class="news_tag_list cast_tag_box_sel">全て</div>
				<?for($n=0;$n<$count_tag;$n++){?>
					<div id="tag<?=$tag[$n]["id"]?>" class="news_tag_list"><?=$tag[$n]["tag_name"]?></div>
				<?}?>
			</div>
		<?}?>
	</div>
</div>
<br>
<?include_once('./footer.php'); ?>
