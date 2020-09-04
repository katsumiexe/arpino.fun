<?php
/*
Template Name: castblog
*/

$tag_icon[0]="";
$tag_icon[1]="";
$tag_icon[2]="";
$tag_icon[3]="";
$tag_icon[4]="";
$tag_icon[5]="";
$tag_icon[6]="";
$tag_icon[7]="";


$cast_list	=$_REQUEST["cast_list"];
$tag_list	=$_REQUEST["tag_list"];

$n=0;
$now=date("Y-m-d H:i:s",time()+32400);

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

if($cast_list){
$sql.=" AND T.slug='{$cast_list}'";
}elseif($tag_list){
$sql.=" AND T.slug='tag{$tag_list}'";
}
$sql.=" ORDER BY P.post_date DESC";
$sql.=" LIMIT 20";

$res = $wpdb->get_results($sql,ARRAY_A);
$updir = wp_upload_dir();

foreach($res as $a2){
	$blog[$n]=$a2;
	$blog[$n]["date"]	=date("Y.m.d H:i",strtotime($a2["post_date"]));

	$sql ="SELECT guid FROM wp01_postmeta";
	$sql.=" LEFT JOIN `wp01_posts` ON meta_value=ID";
	$sql.=" WHERE post_id='{$a2["ID"]}'";
	$sql.=" AND meta_key='_thumbnail_id'";
	$thumb = $wpdb->get_var($sql);

	if($thumb){
		$blog[$n]["img"]=$thumb."?t=".time();
	}else{
		$blog[$n]["img"]=get_template_directory_uri()."/img/customer_no_img.jpg?t=".time();
	}
	$n++;
}

//■カテゴリ--------------------
$n=0;
$sql ="SELECT count,name,slug FROM wp01_term_taxonomy";
$sql.=" LEFT JOIN `wp01_terms` USING(term_id)";
$sql.=" WHERE taxonomy='post_tag'";
$sql.=" ORDER BY count DESC";
$res = $wpdb->get_results($sql,ARRAY_A);

foreach($res as $res2){
	$all_tag[$n]=$res2;
	$n++;
}

//■allcast--------------------
$n=0;
$sql ="SELECT count,name,slug, MAX(post_date) AS last FROM wp01_term_taxonomy";
$sql.=" LEFT JOIN `wp01_terms` USING(term_id)";
$sql.=" LEFT JOIN `wp01_term_relationships` ON wp01_term_relationships.term_taxonomy_id=term_id";
$sql.=" LEFT JOIN `wp01_posts` ON object_id=ID";
$sql.=" WHERE taxonomy='category'";
$sql.=" GROUP BY slug";
$sql.=" ORDER BY last DESC";
$res3 = $wpdb->get_results($sql,ARRAY_A);

foreach($res3 as $res4){
	$all_cast[$n]=$res4;

	if (file_exists(get_template_directory()."/img/page/{$res4["slug"]}/1.jpg")) {
		$all_cast[$n]["face"]=get_template_directory_uri()."/img/page/".$res4["slug"]."/1.jpg";			
	}else{
		$all_cast[$n]["face"]=get_template_directory_uri()."/img/page/noimage.jpg";			
	}
	$all_cast[$n]["last"]=date("Y.m.d H:i",strtotime($all_cast[$n]["last"]));


	$n++;
}

$c_month=$_POST[$c_month];
if(!$c_month) $c_month=substr($now,0,7);

$month_w=date("w",strtotime($c_month."-01"))-1;
$month_e=date("t",strtotime($c_month."-01"));
$month_max=ceil(($month_w+$month_e)/7)*7;
for($n=0;$n<$month_max ;$n++){
	if($n % 7 == 0){
		$c_inc.="</tr><tr>";
	}
	$tmp_days=$n-$month_w;
	if($n>$month_w && $n<=$month_w+$month_e){
//		$c_inc.="<td id=\"".$n-$month_w."\" class=\"blog_calendar_d\">".$n-$month_w."</td>";
		$c_inc.="<td class=\"blog_calendar_d\">{$tmp_days}</td>";
	}else{
		$c_inc.="<td class=\"blog_calendar_d\"></td>";
	}
}

get_header();
?>
<div class="footmark">
	<a href="<?=home_url()?>" class="footmark_box box_a">
		<span class="footmark_icon"></span>
		<span class="footmark_text">TOP</span>
	</a>
<?if($cast_list){?>
	<span class="footmark_icon"></span>
	<a href="<?=home_url()?>/castblog/" class="footmark_box box_a">
		<span class="footmark_icon"></span>
		<span class="footmark_text">BLOG</span>
	</a>
	<span class="footmark_icon"></span>
	<div class="footmark_box">
		<span class="footmark_icon"></span>
		<span class="footmark_text"><?=$a2["name"]?></span>
	</div>

<?}elseif($tag_list){?>
	<span class="footmark_icon"></span>
	<a href="<?=home_url()?>/castblog/" class="footmark_box box_a">
		<span class="footmark_icon"></span>
		<span class="footmark_text"><?=$a2["name"]?></span>
	</a>


	<span class="footmark_icon"></span>
	<div class="footmark_box">
		<span class="footmark_icon"></span>
		<span class="footmark_text">BLOG</span>
	</div>

<?}else{?>
	<span class="footmark_icon"></span>
	<div class="footmark_box">
		<span class="footmark_icon"></span>
		<span class="footmark_text">BLOG</span>
	</div>
<?}?>
</div>

<div class="main_top">
	<div class="main_b">
		<h2 class="main_b_title">本日の出勤キャスト</h2>
		<?for($n=0;$n<count($blog);$n++){?>
			<a href="<?=get_template_directory_uri(); ?>/article/?cast_list=<?=$blog[$n]["ID"]?>" id="i<?=$b1?>" class="blog_list">
				<img src="<?=$blog[$n]["img"]?>" class="blog_list_img">

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
				<img src="https://arpino.fun/wp/wp-content/themes/nightparty/img/page/<?=$blog[$n]["slug"]?>/1.jpg?t=<?=time()?>" class="blog_list_castimg">
				</span>
				</span>
			</a>
		<? } ?>
	</div>
	<div class="main_c">

	<table class="blog_calendar">
		<tr>
			<td class="blog_calendar_m" colspan="7"><?=$c_month?></td>
		</tr>
		<tr>
			<td class="blog_calendar_w">日</td>
			<td class="blog_calendar_w">月</td>
			<td class="blog_calendar_w">火</td>
			<td class="blog_calendar_w">水</td>
			<td class="blog_calendar_w">木</td>
			<td class="blog_calendar_w">金</td>
			<td class="blog_calendar_w">土</td>
			<?=$c_inc?>
		</tr>
	</table>

	<div class="blog_h1">
		<div class="blog_h2">
		カテゴリー
		</div>
	</div>
	<div class="blog_h3">
		<?for($s=0;$s<count($all_tag);$s++){?>
			<a href="./?tag_list=<?=$all_tag[$s]["slug"]?>" class="all_tag">
			<span class="all_tag_icon"><?=$tag_icon[$s]?></span>
			<span class="all_tag_name"><?=$all_tag[$s]["name"]?></span>
			<span class="all_tag_count"><?=$all_tag[$s]["count"]?></span>
			</a>
		<? } ?>
	</div>
	<div class="blog_h1">
		<div class="blog_h2">
		最新コメント
		</div>
	</div>

	<?for($s=0;$s<count($all_cast);$s++){?>
		<a href="./?cast_list=<?=$all_cast[$s]["slug"]?>" class="all_cast">
			
			<span class="all_cast_img"><img src="<?=$all_cast[$s]["face"]?>?t=<?=time()?>" class="all_cast_img_in"></span>
			<span class="all_cast_name"><?=$all_cast[$s]["name"]?></span>
			<span class="all_cast_icon"></span>
			<span class="all_cast_last"><?=$all_cast[$s]["last"]?></span>
			<span class="all_cast_count"><?=$all_cast[$s]["count"]?></span>

		</a>
	<?}?>
	</div>
</div>
<?php get_footer(); ?>
