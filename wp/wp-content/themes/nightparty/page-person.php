<?php
$week[0]="(日)";
$week[1]="(月)";
$week[2]="(火)";
$week[3]="(水)";
$week[4]="(木)";
$week[5]="(金)";
$week[6]="(土)";

$t_day=date("Ymd",time()+32400);
$n_day=date("Ymd",time()+32400+86400*7);
$tm=time();
$link=get_template_directory_uri();

$tmp=explode("/",$_SERVER["REQUEST_URI"]);
$val=$tmp[count($tmp)-2];

$sql="SELECT * FROM wp01_0cast WHERE id='".$val."'";
$res = $wpdb->get_results($sql,ARRAY_A);
foreach($res as $a1){
	$charm[1]=$a1["charm01"];
	$charm[2]=$a1["charm02"];
	$charm[3]=$a1["charm03"];
	$charm[4]=$a1["charm04"];
	$charm[5]=$a1["charm05"];
	$charm[6]=$a1["charm06"];
	$charm[7]=$a1["charm07"];
	$charm[8]=$a1["charm08"];
	$charm[9]=$a1["charm09"];

	if (file_exists(get_template_directory()."/img/page/{$a1["id"]}/1.jpg")) {
		$face_a="<img src=\"{$link}/img/page/{$a1["id"]}/1.jpg?t={$tm}\" class=\"person_img_main\">";
		$face_b="<img id=\"i1\" src=\"{$link}/img/page/{$a1["id"]}/1.jpg?t={$tm}\" class=\"person_img_sub\">";

//		if($a1["face2"] > 0){

		if (file_exists(get_template_directory()."/img/page/{$a1["id"]}/2.jpg")) {
			$face_b.="<img id=\"i2\" src=\"{$link}/img/page/{$a1["id"]}/2.jpg?t={$tm}\" class=\"person_img_sub\">";
		}
		if (file_exists(get_template_directory()."/img/page/{$a1["id"]}/3.jpg")) {
			$face_b.="<img id=\"i3\" src=\"{$link}/img/page/{$a1["id"]}/3.jpg?t={$tm}\" class=\"person_img_sub\">";
		}
		if (file_exists(get_template_directory()."/img/page/{$a1["id"]}/4.jpg")) {
			$face_b.="<img id=\"i4\" src=\"{$link}/img/page/{$a1["id"]}/4.jpg?t={$tm}\" class=\"person_img_sub\">";
		}

	}else{
		$a1["face"]="{$link}/img/cast/noimage.jpg";			
		$face_a="<img src=\"{$link}/img/page/noimage.jpg\" class=\"person_img_main\">";
	}
}

$sql="SELECT * FROM wp01_0schedule WHERE sche_date>='".$t_day."' AND sche_date<'".$n_day."' AND cast_id='".$val."'";
$res2 = $wpdb->get_results($sql,ARRAY_A);
foreach($res2 as $a2):
	$sch[$a2["sche_date"]]=$a2;
endforeach;

for($n=0;$n<7;$n++){
	$t_sch=date("Ymd",time()+(86400*$n)+32400);

	$tmp_s=$sch[$t_sch]["stime"];
	$tmp_e=$sch[$t_sch]["etime"];

	$list_day=substr($t_sch,4,2)."/".substr($t_sch,6,2);
	$list_week=date("w",strtotime($t_sch));

	if($tmp_s && $tmp_e):
		$tmp_date=$tmp_s."～".$tmp_e;
	else:
		$tmp_date="";
	endif;

	if($tmp_s && $tmp_e):
		$list.="<tr><td class=\"sche_l_".$list_week."\">".$list_day." ".$week[$list_week]."</td><td class=\"sche_r_".$list_week."\">".$tmp_s."～".$tmp_e."</td>";
	else:
		$list.="<tr><td class=\"sche_l_".$list_week."\">".$list_day." ".$week[$list_week]."</td><td class=\"sche_r_".$list_week."\">休み</td>";
	endif;
}

$sql="SELECT * FROM wp01_0charm_table WHERE del=0 ORDER BY sort ASC";
$res3 = $wpdb->get_results($sql,ARRAY_A);
foreach($res3 as $a3){
	$charm_list.="<tr><td class=\"prof_l\">{$a3["charm"]}</td><td class=\"prof_r\">{$charm[$a3["id"]]}</td></tr>";
}

$n=0;
$sql="SELECT * FROM wp01_posts WHERE post_name='post' AND post_password='{$a1["id"]}' ORDER BY post_date DESC LIMIT 6;";
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
<div class="main_top">
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
		<div class="footmark_box">
			<span class="footmark_icon"></span>
			<span class="footmark_text"><?=$a1["genji"]?></span>
		</div>
	</div>
<div class="person_main">
	<div class="person_left">
			<?PHP ECHO $face_a?>
		<div class="person_img_list">
			<?PHP ECHO $face_b?>
		</div>
	</div>
<div class="person_middle">
<table class="prof">
<tr>
<td class="prof_l">名前</td>
<td class="prof_r"><?PHP ECHO $a1["genji"]?></td>
</tr>
<?=$charm_list?>
</table>
<table class="sche">
<?=$list?>
</table>
</div>
<div class="person_right">
<div class="person_blog_ttl">Blog</div>
<?for($n=0;$n<count($blog);$n++){?>
<div class="person_blog">
	<img src="<?=$blog[$n]["img"]?>" class="person_blog_img">
	<span class="person_blog_date"><?=$blog[$n]["date"]?></span>
	<span class="person_blog_title"><?=$blog[$n]["post_title"]?></span>
	<span class="person_blog_tag"><span class="hist_watch_c">0</span></span>
	<span class="person_blog_comm"><span class="person_blog_i"></span><span class="person_blog_c"><?=$blog[$n]["count"]+0?></span></span>
</div>
<?}?>
</div>
</div>
<?php get_footer(); ?>