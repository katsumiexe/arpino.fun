<?php
/*
Template Name: castblog
*/

$n=0;
$now=date("Y-m-d H:i:s",time()+23400);

$sql ="SELECT";

$sql.=" ID, post_date,post_content,post_title,post_status,comment_count,slug,name";
$sql.=" FROM wp01_posts AS P";
$sql.=" LEFT JOIN wp01_term_relationships AS R ON P.ID=R.object_id";
$sql.=" LEFT JOIN wp01_term_taxonomy AS X ON R.term_taxonomy_id=X.term_id";
$sql.=" LEFT JOIN wp01_terms AS T ON R.term_taxonomy_id=T.term_id";
$sql.=" WHERE P.post_name='post'";
$sql.=" AND P.post_status='publish'";
$sql.=" AND P.post_date<='{$now}'";

if($cast_id){
$sql.=" AND T.slug='{$cast_id}'";
}elseif($gp){
$sql.=" AND T.slug='tag{$gp}'";
}
$sql.=" ORDER BY P.post_date DESC";
$sql.=" LIMIT 15";

print($sql);
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
print($a2["ID"]."<br>");
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
				<span class="blog_list_castname"><?=$blog[$n]["name"]?></span>

				<span class="blog_list_frame_a">
				<span class="blog_list_frame_b">
				<img src="https://arpino.fun/wp/wp-content/themes/nightparty/img/page/<?=$blog[$n]["slug"]?>/1.jpg?t=<?=time()?>" class="blog_list_castimg">
				</span>
				</span>
				</span>
			</a>
		<? } ?>
	</div>
	<div class="main_c">


	</div>
</div>
<?php get_footer(); ?>
