<?php
/*
Template Name: news
*/
$tag_list=$_REQUEST["tag_list"];

if($tag_list){
	$app=" AND term_id='{$tag_list}'";
}

$sql	 ="SELECT meta_id, meta_value, post_type, post_title, post_content, post_date_gmt, T.name, slug FROM wp01_postmeta AS M";
$sql	.=" LEFT JOIN wp01_posts AS P on M.post_id=P.ID";
$sql	.=" LEFT JOIN wp01_terms AS T on M.meta_value=T.term_id";

$sql	.=" WHERE meta_key='_top_news'";
$sql	.=" AND meta_value>0";
$sql	.=" AND term_group=1";

$sql	.=$app;
	
$sql	.=" ORDER BY post_date_gmt DESC";
$sql	.=" LIMIT 20";
$res2 = $wpdb->get_results($sql,ARRAY_A);
foreach($res2 as $a2){
	$a2["news_date"]=substr($a2["post_date_gmt"],0,4).".".substr($a2["post_date_gmt"],5,2).".".substr($a2["post_date_gmt"],8,2);
	$a2["post_title"]=str_replace("\n","<br>",$a2["post_title"]);
	$news[]=$a2;
}


$sql	 ="SELECT term_id, name, slug FROM wp01_terms";
$sql	 .=" WHERE term_group=1";
$res2 = $wpdb->get_results($sql,ARRAY_A);
foreach($res2 as $a2){
	$tag_list[]=$a2;
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
		<span class="footmark_icon"></span>
		<span class="footmark_text">NEWS一覧</span>
	</div>
</div>

<div class="main_top">

	<div class="main_b">
		<div class="main_b_title">新着情報</div>

		<div class="main_b_top">
			<?for($n=0;$n<count($tag_list);$n++){?>
			<a href="<?=home_url('/news_all')?>/?tag_list=<?=$tag_list[$n]["term_id"]?" class="main_b_notice_link">
				<span class="main_b_notice_tag notice" style="background:<?=$tag_list[$n]["slug"]?>"><?=$tag_list[$n]["name"]?></span>
			</a>
			<? } ?>	
		</div>

		<div class="main_b_top">
			<?for($n=0;$n<count($news);$n++){?>
				<?if($news[$n]["post_content"]){?>
					<table  class="main_b_notice" colspan="3">
					<tr>
					<td  class="main_b_td_1">
						<span class="main_b_notice_date"><?=$news[$n]["news_date"]?></span>
						<span class="main_b_notice_tag notice" style="background:<?=$news[$n]["slug"]?>"><?=$news[$n]["name"]?></span>
					</td>
					<td  class="main_b_td_2">
						<a href="<?=home_url('/news')?>/?code=<?=$news[$n]["meta_id"]?>" class="main_b_notice_link">
							<span class="main_b_notice_title"><?=$news[$n]["post_title"]?></span>
						</a>
					</td>
					<td  class="main_b_td_3">
						<span class="main_b_notice_arrow"><a href="<?=home_url('/news')?>/?code=<?=$news[$n]["meta_id"]?>" class="main_b_notice_alink">	</a></span>
					</td>
					</tr>
					</table>
				<?}else{?>
					<table class="main_b_notice" colspan="2">
					<tr>
					<td  class="main_b_td_1">
						<span class="main_b_notice_date"><?=$news[$n]["news_date"]?></span>
						<span class="main_b_notice_tag notice" style="background:<?=$news[$n]["slug"]?>"><?=$news[$n]["name"]?></span>
					</td>
					<td  class="main_b_td_2">
						<span class="main_b_notice_title"><?=$news[$n]["post_title"]?></span>
					</td>
					</tr>
					</table>
				<?}?>
			<?}?>
		</div>
	</div>
	<div class="main_c">
		<?for($n=0;$n<count($info);$n++){?>
			<?if($info[$n]["post_content"]){?>
				<a href="<?=home_url('/info')?>/?code=<?=$slide[$n]["meta_id"]?>" class="side_img_out"><img src="<?=get_template_directory_uri()?>/img/page/top/top_side{$n}.png" class="side_img"></a>;
			<?}else{?>
				<div class="side_img_out"><img src="<?=get_template_directory_uri()?>/img/page/top/top_side{$n}.png" class="side_img"></div>;
			<?}?>	
		<?}?>	
		<a class="twitter-timeline" data-width="300" data-height="500" data-theme="dark" href="https://twitter.com/serra_geddon?ref_src=twsrc%5Etfw">Tweets by serra_geddon</a> <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
	</div>
</div>
<br>
<?php get_footer(); ?>