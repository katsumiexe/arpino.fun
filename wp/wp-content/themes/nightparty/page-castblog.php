<?php
/*
Template Name: castblog
*/



$n=0;
$now=date("Y-m-d H:i:s",time()+23400);

$sql ="SELECT * FROM wp01_posts";
$sql.=" WHERE post_name='post'";
$sql.=" AND post_password='{$a1["id"]}'";
$sql.=" AND post_status='publish'";
$sql.=" AND post_date<='{$now}'";
$sql.=" ORDER BY post_date DESC";
$sql.=" LIMIT 10";


$res = $wpdb->get_results($sql,ARRAY_A);
foreach($res as $a2){
	$blog[$n]=$a2;
	$img_tmp=$a2["ID"]+2;
	$updir = wp_upload_dir();

	$sql ="SELECT * FROM wp01_postmeta";
	$sql.=" WHERE post_id='{$a2["ID"]}'";
	$sql.=" AND meta_key='_thumbnail_id'";

	$blog[$n]["date"]	=date("m月d日 H:i",strtotime($a2["post_date"]));

	$thumb = $wpdb->get_var($sql);
	if($thumb){
		$blog[$n]["img"]="{$updir['baseurl']}/np{$a1["id"]}/img_{$img_tmp}.png?t=".time();
		$blog[$n]["img_on"]="{$updir['baseurl']}/np{$a1["id"]}/img_{$img_tmp}.png?t=".time();

	}else{
		$blog[$n]["img"]=get_template_directory_uri()."/img/customer_no_img.jpg?t=".time();
	}
	$n++;
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
		<span class="footmark_icon"></span>
		<span class="footmark_text">BLOG</span>
	</div>
</div>
<div class="main_top">
	<div class="main_b">
		<h2 class="main_b_title">本日の出勤キャスト</h2>
		<?for($n=0;$n<count($blog);$n++){?>
			<a href="<?=get_template_directory_uri(); ?>/article/?cast=<?=$b1?>" id="i<?=$b1?>" class="blog_list">
				<img src="<?=$blog[$n]["img"]?>?t=<?=time()?>" class="blog_list_img">
				<span class="blog_list_comm">
					<span class="blog_list_i"></span>
					<span class="blog_list_c"><?=$blog[$n]["count"]+0?></span>
				</span>

				<span class="blog_list_title"><?=$blog[$n]["post_title"]?></span>
				<span class="blog_list_tag"></span>


				<span class="blog_list_cast">
				<span class="blog_list_date"><?=$blog[$n]["date"]?></span>
				<span class="blog_list_castname">いなださん</span>

				<span class="blog_list_frame">
				<img src="https://arpino.fun/wp/wp-content/themes/nightparty/img/page/101/1.jpg?t=1598275364" class="blog_list_castimg">
				</span>
				</span>
			</a>
		<? } ?>
	</div>
	<div class="main_c">
		<a class="twitter-timeline" data-width="310" data-height="500" data-theme="dark" href="https://twitter.com/serra_geddon?ref_src=twsrc%5Etfw">Tweets by serra_geddon</a> <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
	</div>

</div>
<?php get_footer(); ?>
