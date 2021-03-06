<?php
/*
Template Name: person
*/
$week[0]="(日)";
$week[1]="(月)";
$week[2]="(火)";
$week[3]="(水)";
$week[4]="(木)";
$week[5]="(金)";
$week[6]="(土)";
$updir = wp_upload_dir();

$t_day=date("Ymd",time()+32400);
$n_day=date("Ymd",time()+32400+86400*7);

$tm=time();
$link=get_template_directory_uri();

$tmp=explode("/",$_SERVER["REQUEST_URI"]);
//$val=$tmp[count($tmp)-2];
$val=$_REQUEST["cast"];

$sql="SELECT * FROM wp01_0cast WHERE id='".$val."'";
$res = $wpdb->get_results($sql,ARRAY_A);
foreach($res as $a1){

	if (file_exists(get_template_directory()."/img/page/{$a1["id"]}/0.jpg")) {
		$face_a="<img src=\"{$link}/img/page/{$a1["id"]}/0.jpg?t={$tm}\" class=\"person_img_main\">";
		$face_b="<img id=\"i1\" src=\"{$link}/img/page/{$a1["id"]}/0.jpg?t={$tm}\" class=\"person_img_sub\">";

		if (file_exists(get_template_directory()."/img/page/{$a1["id"]}/1.jpg")) {
			$face_b.="<img id=\"i2\" src=\"{$link}/img/page/{$a1["id"]}/1.jpg?t={$tm}\" class=\"person_img_sub\">";
		}
		if (file_exists(get_template_directory()."/img/page/{$a1["id"]}/2.jpg")) {
			$face_b.="<img id=\"i3\" src=\"{$link}/img/page/{$a1["id"]}/2.jpg?t={$tm}\" class=\"person_img_sub\">";
		}
		if (file_exists(get_template_directory()."/img/page/{$a1["id"]}/3.jpg")) {
			$face_b.="<img id=\"i4\" src=\"{$link}/img/page/{$a1["id"]}/3.jpg?t={$tm}\" class=\"person_img_sub\">";
		}
	}else{
		$a1["face"]="{$link}/img/cast/noimage.jpg";			
		$face_a="<img src=\"{$link}/img/page/noimage.jpg\" class=\"person_img_main\">";
	}
}

$sql="SELECT * FROM wp01_0schedule WHERE sche_date>='".$t_day."' AND sche_date<'".$n_day."' AND cast_id='".$val."'";
$res2 = $wpdb->get_results($sql,ARRAY_A);
foreach($res2 as $a2){
	$sch[$a2["sche_date"]]=$a2;
}

for($n=0;$n<7;$n++){
	$t_sch=date("Ymd",time()+(86400*$n)+32400);

	$tmp_s=$sch[$t_sch]["stime"];
	$tmp_e=$sch[$t_sch]["etime"];

	$list_day=substr($t_sch,4,2)."/".substr($t_sch,6,2);
	$list_week=date("w",strtotime($t_sch));

	if($tmp_s && $tmp_e){
		$list.="<tr><td class=\"sche_l_".$list_week."\">".$list_day." ".$week[$list_week]."</td><td class=\"sche_r_".$list_week."\"><span class=\"sche_block1\">".$tmp_s."</span>－<span class=\"sche_block1\">".$tmp_e."</span></td>";
	}else{
		$list.="<tr><td class=\"sche_l_".$list_week."\">".$list_day." ".$week[$list_week]."</td><td class=\"sche_r_".$list_week."\"><span class=\"sche_block1\">休み</span></td>";
	}
}

$sql="SELECT id, charm,style FROM wp01_0charm_table WHERE del=0 ORDER BY sort ASC";
$res3 = $wpdb->get_results($sql,ARRAY_A);
foreach($res3 as $a3){
	if($a3["style"] == 1){
	$charm_list.="<tr><td class=\"prof_0\" colspan=\"2\"></td></tr><tr><td class=\"prof_l2\" colspan=\"2\">{$a3["charm"]}</td></tr><tr><td class=\"prof_r2\" colspan=\"2\">{$charm[$a3["id"]]}</td></tr>";
	}else{
	$charm_list.="<tr><td class=\"prof_l\">{$a3["charm"]}</td><td class=\"prof_r\">{$charm[$a3["id"]]}</td></tr>";
	}
}

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
$sql.=" AND T.slug='{$val}'";

$sql.=" ORDER BY P.post_date DESC";
$sql.=" LIMIT 6";
$res = $wpdb->get_results($sql,ARRAY_A);

foreach($res as $a2){
	$a2["date"]	=date("Y.m.d H:i",strtotime($a2["post_date"]));

	$sql ="SELECT guid FROM wp01_postmeta";
	$sql.=" LEFT JOIN `wp01_posts` ON meta_value=ID";
	$sql.=" WHERE meta_key='_thumbnail_id'";
	$sql.=" AND post_id='{$a2["ID"]}'";
	$sql.=" ORDER BY meta_id DESC";
	$sql.=" LIMIT 1";
	$thumb = $wpdb->get_var($sql);

	if($thumb){
		$a2["img"]=str_replace(".png","_s.png",$thumb)."?t=".time();
	}else{
		$a2["img"]=get_template_directory_uri()."/img/customer_no_img.jpg?t=".time();
	}
	$blog[]=$a2;
}

$sql ="SELECT sort,charm,style,log FROM wp01_0charm_table";
$sql.=" LEFT JOIN `wp01_0charm_sel` ON wp01_0charm_table.id=list_id";
$sql.=" WHERE wp01_0charm_table.del='0'";
$sql.=" AND (wp01_0charm_sel.cast_id='{$val}' OR wp01_0charm_sel.cast_id='')";
$sql.=" ORDER BY sort ASC";
$res = $wpdb->get_results($sql,ARRAY_A);
foreach($res as $a0){
	$a0["log"]=str_replace("\n","<br>",$a0["log"]);
	$cast_table[]=$a0;
}

$sql ="SELECT id,title,style FROM wp01_0check_main";
$sql.=" WHERE del='0'";
$sql.=" ORDER BY sort ASC";

$res = $wpdb->get_results($sql,ARRAY_A);
foreach($res as $a0){
	$check_main[]=$a0;
}

$sql ="SELECT * FROM wp01_0check_list";
$sql.=" LEFT JOIN `wp01_0check_sel` ON wp01_0check_list.id=wp01_0check_sel.list_id";
$sql.=" AND del='0'";
$sql.=" AND (cast_id IS NULL OR cast_id='{$val}')";
$sql.=" ORDER BY host_id ASC, list_sort ASC";
$res = $wpdb->get_results($sql,ARRAY_A);

foreach($res as $a0){
	$check_list[$a0["host_id"]][$a0["list_sort"]]=$a0;
}
get_header();
?>
<div class="footmark">
	<a href="<?=home_url()?>" class="footmark_box box_a">
		<span class="footmark_icon"></span>
		<span class="footmark_text">TOP</span>
	</a>
	<span class="footmark_icon"></span>
	<a href="<?=home_url()?>/cast/" class="footmark_box box_a">
		<span class="footmark_icon"></span>
		<span class="footmark_text">CAST</span>
	</a>
	<span class="footmark_icon"></span>
	<span class="footmark_icon"></span>
	<span class="footmark_text"><?=$a1["genji"]?></span>
</div>
<div class="person_main">
	<div class="person_left">
		<div class="person_img_box">
			<?=$face_a?>
			<span class="person_img_top"></span>
		</div>
		<div class="person_img_list">
			<?=$face_b?>
		</div>
	</div>

	<div class="person_middle">
		<div class="prof_title">Profile</div>
		<table class="prof">
			<tr>
				<td class="prof_l">名前</td>
				<td class="prof_r"><?=$a1["genji"]?></td>
			</tr>

	<?for($n=0;$n<count($cast_table);$n++){?>
		<?if($cast_table[$n]["style"] == 1){?>
			<tr><td class="prof_0" colspan="2"></td></tr>
			<tr><td class="prof_l2" colspan="2"><?=$cast_table[$n]["charm"]?></td></tr>
			<tr><td class="prof_r2" colspan="2"><?=$cast_table[$n]["log"]?></td></tr>
		<?}else{?>
			<tr>
			<td class="prof_l"><?=$cast_table[$n]["charm"]?></td>
			<td class="prof_r"><?=$cast_table[$n]["log"]?></td>
			</tr>
		<?}?>
	<?}?>
		</table>
		<div class="sche_title">Schedule</div>
		<table class="sche">
			<?=$list?>
		</table>

		<?for($n=0;$n<count($check_main);$n++){?>
		<div class="prof_title"><?=$check_main[$n]["title"]?></div>
			<div class="check_box">
				<?foreach($check_list[$check_main[$n]["id"]] as $a1 => $a2){?>
				<?if($check_main[$n]["style"]==1 || $check_list[$check_main[$n]["id"]][$a2["list_sort"]]["sel"]== 1){?>
					<div class="check_set<?=$check_list[$check_main[$n]["id"]][$a2["list_sort"]]["sel"]?>"><?=$check_list[$check_main[$n]["id"]][$a2["list_sort"]]["list_title"]?></div>
				<? } ?>
				<? } ?>
			</div>
		<?}?>
	</div>

	<div class="person_right">
		<div class="blog_title">Blog</div>
			<?for($s=0;$s<count($blog);$s++){?>
				<a href="<?=get_template_directory_uri(); ?>/article/?cast_list=<?=$blog[$s]["ID"]?>" id="i<?=$b1?>" class="person_blog">
					<img src="<?=$blog[$s]["img"]?>" class="person_blog_img">
					<span class="person_blog_date"><?=$blog[$s]["date"]?></span>
					<span class="person_blog_title"><?=$blog[$s]["post_title"]?></span>
					<span class="person_blog_tag"><span class="hist_watch_c">0</span></span>
					<span class="person_blog_comm"><span class="person_blog_i"></span><span class="person_blog_c"><?=$blog[$s]["count"]+0?></span></span>
				</a>
			<?}?>
			<?if(!$blog){?>
				<div class="person_blog">
					<span class="person_blog_no">まだありません</span>
				</div>
			<?}?>
		</div>
	</div>
</div>
<?php get_footer(); ?>