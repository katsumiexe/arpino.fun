<?php

$n=0;
$now=date("Y-m-d H:i:s",time()+32400);

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

//■image---------------------------------
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

if($category == 1){
	if (file_exists(get_template_directory()."/img/page/{$res0["slug"]}/0.jpg")) {
		$cast_face=get_template_directory_uri()."/img/page/{$res0["slug"]}/0.jpg";			
	}else{
		$cast_face=get_template_directory_uri()."/img/page/noimage.jpg";			
	}
}

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
$sql.=" LIMIT 4";

$res = $wpdb->get_results($sql,ARRAY_A);

foreach($res as $a2){
	$blog[$n]=$a2;
	$blog[$n]["date"]	=date("m月d日 H:i",strtotime($a2["post_date"]));

	$sql ="SELECT guid FROM wp01_postmeta";
	$sql.=" LEFT JOIN `wp01_posts` ON meta_value=ID";
	$sql.=" WHERE post_id='{$a2["ID"]}'";
	$sql.=" AND meta_key='_thumbnail_id'";
	$thumb = $wpdb->get_var($sql);
	if($thumb){
		$blog[$n]["img"]	=str_replace(".png","_s.png",$thumb)."?t=".time();

	}else{
		$blog[$n]["img"]=get_template_directory_uri()."/img/customer_no_img.jpg";
	}
	$n++;
}
include_once('./header.php');
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

	<span class="footmark_icon pc_only"></span>
	<div class="footmark_box pc_only">
		<span class="footmark_icon"></span>
		<span class="footmark_text">『<?=$res0["post_title"]?>』</span>
	</div>
</div>

<div class="main_top_flex">

	<div class="main_article">
		<h1 class="blog_ttl">
			<?=$res0["post_title"]?>
		</h1>

		<div class="blog_ttl_btm">
			<span class="blog_ttl_tag"><span class="blog_list_icon"></span><span class="blog_list_tcomm"><?=$tag?></span></span>
			<span class="blog_ttl_date"><span class="icon"></span><?=$res0["date"]?></span>
		</div>
		<div class="blog_ttl_border">　</div>
		<?if($blog_img){?>
		<div class="blog_top_img"><img src="<?=$blog_img?>" class="blog_img"></div>
		<?}?>
		<div class="blog_log">
			<?=$res0["post_content"]?>
		</div>
	</div>

	<div class="sub_blog">
		<div class="sub_blog_pack">
			<div class="sub_blog_in">
			<div class="blog_h1"><?=$res0["name"]?></div>
				<img src="<?=$cast_face?>" class="blog_cast_img">
				<a href="<?=home_url('/person')?>/?cast=<?=$res0["slug"]?>" class="blog_cast_link">プロフィール</a>
			</div>

			<div class="sub_blog_in">
			<div class="blog_h1">新着</div>
			<?for($s=0;$s<count($blog);$s++){?>
				<a href="<?=get_template_directory_uri(); ?>/article/?cast_list=<?=$blog[$s]["ID"]?>" id="i<?=$b1?>" class="person_blog">
					<img src="<?=$blog[$s]["img"]?>" class="person_blog_img">
					<span class="person_blog_date"><?=$blog[$s]["date"]?></span>
					<span class="person_blog_title"><?=$blog[$s]["post_title"]?></span>
				</a>
			<?}?>
			</div>
		</div>
	</div>
</div>
<?php get_footer(); ?>
