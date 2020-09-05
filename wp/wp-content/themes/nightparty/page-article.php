<?php
/*
Template Name: article
*/

$n=0;
$now=date("Y-m-d H:i:s",time()+23400);

$cast_list	=$_REQUEST["cast_list"];
$tag_list	=$_REQUEST["tag_list"];

if($cast_list){
	$article=$cast_list;
	$category=1;

}elseif($tag_list){
	$article=$tag_list;
	$category=2;

}else{
	$article="err";
}

$sql ="SELECT";
$sql.=" ID, post_date,post_content,post_title,post_status,comment_count,slug,name";
$sql.=" FROM wp01_posts AS P";
$sql.=" LEFT JOIN wp01_term_relationships AS R ON P.ID=R.object_id";
$sql.=" LEFT JOIN wp01_term_taxonomy AS X ON R.term_taxonomy_id=X.term_id";
$sql.=" LEFT JOIN wp01_terms AS T ON R.term_taxonomy_id=T.term_id";
$sql.=" WHERE P.ID='{$article}'";
$sql.=" AND X.taxonomy='category'";
$sql.=" LIMIT 1";
$res0 = $wpdb->get_row($sql,ARRAY_A);
$res0["post_content"]=str_replace("\n","<br>",$res0["post_content"]);
$res0["date"]	=date("Y.m.d H:i",strtotime($res0["post_date"]));

$sql ="SELECT guid FROM wp01_postmeta";
$sql.=" LEFT JOIN `wp01_posts` ON meta_value=ID";
$sql.=" WHERE post_id='{$res0["ID"]}'";
$sql.=" AND meta_key='_thumbnail_id'";
$thumb = $wpdb->get_var($sql);

if($thumb){
	$blog_img=$thumb."?t=".time();
}

$sql ="SELECT name,slug FROM wp01_term_relationships";
$sql.=" LEFT JOIN wp01_terms ON wp01_term_relationships.term_taxonomy_id=wp01_terms.term_id";
$sql.=" WHERE object_id='{$res0["ID"]}'";
$sql.=" AND slug LIKE 'tag%'";
$tag = $wpdb->get_var($sql);

/*
$sql ="SELECT";
$sql.=" ID, post_date,post_content,post_title,post_status,comment_count,slug,name";
$sql.=" FROM wp01_posts AS P";
$sql.=" LEFT JOIN wp01_term_relationships AS R ON P.ID=R.object_id";
$sql.=" LEFT JOIN wp01_term_taxonomy AS X ON R.term_taxonomy_id=X.term_id";
$sql.=" LEFT JOIN wp01_terms AS T ON R.term_taxonomy_id=T.term_id";
$sql.=" WHERE P.post_type='post'";
$sql.=" AND P.post_status='publish'";
$sql.=" AND P.post_date<='{$now}'";
$sql.=" AND X.taxonomy='category'";
$sql.=" AND T.slug='{$res0["slug"]}'";

$sql.=" ORDER BY P.post_date DESC";
$sql.=" LIMIT 15";

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
*/

get_header();
?>
<div class="footmark">
	<a href="<?=home_url()?>" class="footmark_box box_a">
		<span class="footmark_icon"></span>
		<span class="footmark_text">TOP</span>
	</a>
	<span class="footmark_icon"></span>
	<a href="<?=home_url()?>/castblog/" class="footmark_box box_a">
		<span class="footmark_icon"></span>
		<span class="footmark_text">BLOG</span>
	</a>
	<span class="footmark_icon"></span>
	<a href="<?=home_url()?>/castblog/?cast_list=<?=$res0["slug"]?>" class="footmark_box box_a">
		<span class="footmark_icon"></span>
		<span class="footmark_text"><?=$res0["name"]?></span>
	</a>
	<span class="footmark_icon"></span>
	<div class="footmark_box">
		<span class="footmark_icon"></span>
		<span class="footmark_text">『<?=$res0["post_title"]?>』</span>
	</div>
</div>

<div class="main_top">
	<div class="main_b">
		<h1 class="blog_ttl">
			<?=$res0["post_title"]?>
		</h1>
		<div class="blog_ttl_btm">
			<span class="blog_ttl_tag"><span class="icon"></span><?=$tag?></span>
			<span class="blog_ttl_date"><span class="icon"></span><?=$res0["date"]?></span>
		</div>
		<div class="blog_ttl_border">　</div>

		<?if($blog_img){?>
		<div class="blog_top_img">
		<img src="<?=$blog_img?>" class="blog_img">
		</div>
		<?}?>
		<div class="blog_log">
			<?=$res0["post_content"]?>
		</div>
	</div>

	<div class="main_c">
		<div class="blog_h1">
			<div class="blog_h2">
				<?=$res0["name"]?>
			</div>
		</div>

		<table class="blog_calender">
			<tr>
				<td class="blog_calender_m" colspan="7"><?=$c_month?></td>
			</tr>
			<tr>
				<td class="blog_calender_w">日</td>
				<td class="blog_calender_w">月</td>
				<td class="blog_calender_w">火</td>
				<td class="blog_calender_w">水</td>
				<td class="blog_calender_w">木</td>
				<td class="blog_calender_w">金</td>
				<td class="blog_calender_w">土</td>
				<?=$c_inc?>
			</tr>
		</table>

		<div class="blog_h1">
			<div class="blog_h2">
			新着
			</div>
		</div>

		<div class="blog_h1">
			<div class="blog_h2">
			カテゴリー
			</div>
		</div>
	</div>
</div>
<?php get_footer(); ?>
