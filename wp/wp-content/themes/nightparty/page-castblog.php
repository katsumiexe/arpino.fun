<?php
/*
Template Name: castblog
*/

$tag_icon[0]="";
$tag_icon["tag1"]="";
$tag_icon["tag2"]="";
$tag_icon["tag3"]="";
$tag_icon["tag4"]="";
$tag_icon["tag5"]="";
$tag_icon["tag6"]="";
$tag_icon["tag7"]="";
$tag_icon["tag8"]="";

$pg=$_REQUEST["pg"];
if($pg+0<1) $pg=1;

$pg_st=($pg-1)*16;
$pg_ed=($pg-1)*16+16;

$blog_day	=$_REQUEST["blog_day"];
$cast_list	=$_REQUEST["cast_list"];
$tag_list	=$_REQUEST["tag_list"];
$month		=$_REQUEST["month"];

$n=0;
$now=date("Y-m-d H:i:s",time()+32400);
if(!$month) $month=substr($now,0,4).substr($now,5,2);


//■カレンダーカウント
$sql ="";
$sql ="SELECT post_date FROM wp01_posts";
$sql.=" WHERE post_type='post'";
$sql.=" AND post_status='publish'";
$sql.=" AND post_date LIKE '".substr($month,0,4)."-".substr($month,4,2)."%'";
$sql.=" AND post_date<='{$now}'";
$res = $wpdb->get_results($sql,ARRAY_A);

foreach($res as $a1){
	$tmp=substr($a1["post_date"],8,2)+0;
	$calendar_ck[$tmp]=1;
}


//■キャスト件数カウント
$sql ="";
$sql ="SELECT T.slug, MAX(P.post_date) AS last, C.genji, COUNT(T.term_id) AS cnt FROM wp01_posts AS P";
$sql.=" LEFT JOIN wp01_term_relationships AS R on P.ID=R.object_id";
$sql.=" LEFT JOIN wp01_term_taxonomy AS X on R.term_taxonomy_id=X.term_id";
$sql.=" LEFT JOIN wp01_terms AS T on X.term_id=T.term_id";
$sql.=" INNER JOIN wp01_0cast AS C ON T.slug=C.id";

$sql.=" WHERE post_type='post'";
$sql.=" AND post_status='publish'";
$sql.=" AND post_date<='{$now}'";
$sql.=" AND X.taxonomy='category'";
$sql.=" GROUP BY slug";
$sql.=" ORDER BY post_date ASC";

$res = $wpdb->get_results($sql,ARRAY_A);
foreach($res as $a1){
	$cast_name[$a1["slug"]]	=$a1["genji"];
	$cast_count[$a1["slug"]]=$a1["cnt"];
	$last_date[$a1["slug"]]	=str_replace("-",".",substr($a1["last"],0,10));


	if (file_exists(get_template_directory()."/img/page/{$a1["slug"]}/1.jpg")) {
		$cast_face[$a1["slug"]]=get_template_directory_uri()."/img/page/".$a1["slug"]."/1.jpg";			
	}else{
		$cast_face[$a1["slug"]]=get_template_directory_uri()."/img/page/noimage.jpg";			
	}
}

ksort($cast_count);

//■カテゴリ件数カウント
$sql ="";
$sql ="SELECT T.slug, T.name, COUNT(T.term_id) AS cnt FROM wp01_posts AS P";
$sql.=" LEFT JOIN wp01_term_relationships AS R on P.ID=R.object_id";
$sql.=" LEFT JOIN wp01_term_taxonomy AS X on R.term_taxonomy_id=X.term_id";
$sql.=" LEFT JOIN wp01_terms AS T on X.term_id=T.term_id";
$sql.=" WHERE post_type='post'";
$sql.=" AND post_status='publish'";
$sql.=" AND post_date<='{$now}'";
$sql.=" AND X.taxonomy='post_tag'";
$sql.=" GROUP BY slug";

$res = $wpdb->get_results($sql,ARRAY_A);
foreach($res as $a1){
	$cate_name[$a1["slug"]]=$a1["name"];
	$cate_count[$a1["slug"]]=$a1["cnt"];
	$cate_all+=$a1["cnt"];
}

$pg_max=ceil($cate_all/16);

if($pg_max==1){

}elseif($pg_max<=5){
	$p_list.="<div class=\"page_box\">";
		for($pp=1;$pp<$pg_max+1;$pp++){
			$p_list.="<a href=\"".get_template_directory_uri()."/castblog/?pg={$pp}\" class=\"page_n ";
			if($pp==$pg) $p_list.="pg_n";
			$p_list.="\">{$pp}</a>";
		}
	$p_list.="</div>";
}else{
	if($pg<3){
		$pg_s=1;
		$pg_e=5;

	}elseif($pg_max-$pg<2){
		$pg_e=$pg_max;
		$pg_s=$pg_max-5;
	
	}else{
		$pg_s=$pg-2;
		$pg_e=$pg+2;
	}

	$p_list.="<div class=\"page_box\">";
		$p_list.="<a href=\"castblog.php/?\" class=\"page_n pg_f\">«</a>";
		for($pp=$pg_s;$pp<$pg_e+1;$pp++){
			$p_list.="<a href=\"".get_template_directory_uri()."/castblog/?pg={$pp}\" class=\"page_n ";
		if($pp==$pg) $p_list.="pg_n";
			$p_list.="\">{$pp}</a>";
		}
		$p_list.="<a href=\"\" class=\"page_n pg_b\">»</a>";
	$p_list.="</div>";

}

$sql ="SELECT";
$sql.=" P.ID, post_date,post_content,post_title,post_status,comment_count,";
$sql.=" T.slug AS castslug, C.genji AS castname,";
$sql.=" T2.slug AS tagslug, T2.name AS tagname";

$sql.=" FROM wp01_posts AS P";
$sql.=" LEFT JOIN wp01_term_relationships AS R ON P.ID=R.object_id";
$sql.=" LEFT JOIN wp01_term_taxonomy AS X ON R.term_taxonomy_id=X.term_id";
$sql.=" LEFT JOIN wp01_terms AS T ON R.term_taxonomy_id=T.term_id";

$sql.=" LEFT JOIN wp01_term_relationships AS R2 ON P.ID=R2.object_id";
$sql.=" LEFT JOIN wp01_term_taxonomy AS X2 ON R2.term_taxonomy_id=X2.term_id";
$sql.=" LEFT JOIN wp01_terms AS T2 ON R2.term_taxonomy_id=T2.term_id";
$sql.=" INNER JOIN wp01_0cast AS C ON T.slug=C.id";

$sql.=" WHERE P.post_type='post'";
$sql.=" AND P.post_status='publish'";
//$sql.=" AND P.post_date LIKE '".substr($month,0,4)."-".substr($month,4,2)."%'";
$sql.=" AND P.post_date<='{$now}'";
$sql.=" AND X.taxonomy='category'";
$sql.=" AND X2.taxonomy='post_tag'";

if($cast_list){
	$sql.=" AND T.slug='{$cast_list}'";
	$c_para="&cast_list={$cast_list}";
}

if($tag_list){
	$sql.=" AND T2.slug='{$tag_list}'";
	$t_para="&tag_list={$tag_list}";
}

$sql.=" ORDER BY P.post_date DESC";
$sql.=" LIMIT {$pg_st},16";
$res = $wpdb->get_results($sql,ARRAY_A);
$updir = wp_upload_dir();


foreach($res as $a2){
	$blog[$n]=$a2;
	$blog[$n]["date"]	=date("Y.m.d H:i",strtotime($a2["post_date"]));
	$cal[date("d",strtotime($a2["post_date"]))+0]	=1;

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

if(!$a2 && $cast_list){
	$sql	 ="SELECT `name` FROM wp01_terms";
	$sql	.=" WHERE slug='{$cast_list}'";
	$res = $wpdb->get_results($sql,ARRAY_A);
	$a2["castname"]=$res[0]["name"];
}

if(!$a2 && $tag_list){
	$sql	 ="SELECT `name` FROM wp01_terms";
	$sql	.=" WHERE slug='{$tag_list}'";
	$res = $wpdb->get_results($sql,ARRAY_A);
	$a2["tagname"]=$res[0]["name"];
}

/*/■カテゴリ--------------------
$n=1;
$sql ="SELECT name,slug FROM wp01_term_taxonomy";
$sql.=" LEFT JOIN `wp01_terms` USING(term_id)";
$sql.=" WHERE taxonomy='post_tag'";
$sql.=" ORDER BY count DESC";
$res = $wpdb->get_results($sql,ARRAY_A);

foreach($res as $res2){
	$all_tag[$n]=$res2;

	$n++;
}
*/


//■allcast--------------------
/*
$n=0;
$sql ="SELECT count,name,slug, MAX(post_date) AS last FROM wp01_term_taxonomy";
$sql.=" LEFT JOIN `wp01_terms` USING(term_id)";
$sql.=" LEFT JOIN `wp01_term_relationships` ON wp01_term_relationships.term_taxonomy_id=term_id";
$sql.=" LEFT JOIN `wp01_posts` ON object_id=ID";
$sql.=" WHERE wp01_term_taxonomy.taxonomy='category'";
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
*/


$v_month=date("Y年m月",strtotime($month."01"));
$p_month=date("Ym",strtotime($month."01")-86400);
$n_month=date("Ym",strtotime($month."01")+3456000);
$month_w=date("w",strtotime($month."01"))-1;
$month_e=date("t",strtotime($month."01"));
$month_max=ceil(($month_w+$month_e)/7)*7;

for($n=0;$n<$month_max ;$n++){
	if($n % 7 == 0){
		$c_inc.="</tr><tr>";
	}
	$tmp_days=$n-$month_w;
	if($n>$month_w && $n<=$month_w+$month_e){

		$ky=$month."00"+$tmp_days;
		$c_inc.="<td class=\"blog_calendar_d\"><a href=\"".home_url('/castblog')."/?blog_day={$ky}&month={$month}{$c_para}{$t_para}\" class=\"cal{$calendar_ck[$tmp_days]}\">{$tmp_days}</a></td>";
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
		<span class="footmark_text">blog</span>
	</a>
	<span class="footmark_icon"></span>
	<div class="footmark_box">
		<span class="footmark_icon"></span>
		<span class="footmark_text"><?=$a2["castname"]?></span>
	</div>

<?}elseif($tag_list){?>
	<span class="footmark_icon"></span>
	<a href="<?=home_url()?>/castblog/" class="footmark_box box_a">
		<span class="footmark_icon"></span>
		<span class="footmark_text">blog</span>
	</a>
	<span class="footmark_icon"></span>
	<div class="footmark_box">
		<span class="footmark_icon"><?=$tag_icon[str_replace("tag","",$tag_list)]?></span>
		<span class="footmark_text"><?=$a2["tagname"]?></span>
	</div>

<?}else{?>
	<span class="footmark_icon"></span>
	<div class="footmark_box">
		<span class="footmark_icon"></span>
		<span class="footmark_text">blog</span>
	</div>
<?}?>
</div>

<div class="main_top_flex">
	<div class="main_article_out">
		<h2 class="main_blog_title"> Cast Blog</h2>
		<div class="main_article">
			<?for($n=0;$n<count($blog);$n++){?>
				<a href="<?=home_url('/article')?>/?cast_list=<?=$blog[$n]["ID"]?>" id="i<?=$b1?>" class="blog_list">

					<img src="<?=$blog[$n]["img"]?>" class="blog_list_img">
					<span class="blog_list_comm">
						<span class="blog_list_i"></span>
						<span class="blog_list_c"><?=$blog[$n]["count"]+0?></span>
					</span>
					<span class="blog_list_title"><?=$blog[$n]["post_title"]?></span>
					<span class="blog_list_cast">
					<span class="blog_list_tag"><span class="blog_list_icon"></span><span class="blog_list_tcomm"><?=$blog[$n]["tagname"]?></span></span>
					<span class="blog_list_date"><?=$blog[$n]["date"]?></span>
					<span class="blog_list_castname"><?=$blog[$n]["castname"]?></span>
					<span class="blog_list_frame_a">
					<img src="https://arpino.fun/wp/wp-content/themes/nightparty/img/page/<?=$blog[$n]["castslug"]?>/1.jpg?t=<?=time()?>" class="blog_list_castimg">
					</span>
					</span>
				</a>
			<? } ?>
		</div>
		<?=$p_list?>
	</div>

	<div class="sub_blog">
		<table id="c" class="blog_calendar">
			<tr>
				<td id="c_prev"class="blog_calendar_n"><a href="<?=home_url('/castblog')?>/?month=<?=$p_month?><?=$c_para?><?=$t_para?>" class="carendar_pn"></a></td>
				<td class="blog_calendar_m" colspan="5"><?=$v_month?></td>
				<td id="c_next" class="blog_calendar_n"><a href="<?=home_url('/castblog')?>/?month=<?=$n_month?><?=$c_para?><?=$t_para?>" class="carendar_pn"></a></td>
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

		<div class="sub_blog_pack">
			<div class="sub_blog_in">
				<div class="blog_h1">カテゴリー</div>
				<a href="<?=home_url('/castblog')?>/" class="all_tag">
					<span class="all_tag_icon"><?=$tag_icon[0]?></span>
					<span class="all_tag_name">全て</span>
					<span class="all_tag_count"><?=$cate_all?></span>
				</a>
				<?foreach($cate_count as $a1=> $a2){?>
				<a href="<?=home_url('/castblog')?>/?tag_list=<?=$a1?>" class="all_tag">
					<span class="all_tag_icon"><?=$tag_icon[$a1]?></span>
					<span class="all_tag_name"><?=$cate_name[$a1]?></span>
					<span class="all_tag_count"><?=$a2?></span>
				</a>
				<? } ?>
			</div>


			<div class="sub_blog_in">
				<div class="blog_h1">CAST一覧</div>
				<?foreach($cast_count as $a1=> $a2){?>
					<a href="<?=home_url('/castblog')?>/?cast_list=<?=$a1?>" class="all_cast">
						<span class="all_cast_img"><img src="<?=$cast_face[$a1]?>?t=<?=time()?>" class="all_cast_img_in"></span>
						<span class="all_cast_name"><?=$cast_name[$a1]?></span>
						<span class="all_cast_last">更新：<?=$last_date[$a1]?></span>
						<span class="all_cast_count"><?=$a2?></span>
					</a>
				<?}?>
			</div>
		</div>
	</div>
</div>
</div>
<?php get_footer(); ?>
