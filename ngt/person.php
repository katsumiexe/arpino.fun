<?php
include_once('./library/sql.php');
$week[0]="(日)";
$week[1]="(月)";
$week[2]="(火)";
$week[3]="(水)";
$week[4]="(木)";
$week[5]="(金)";
$week[6]="(土)";

/*
0　通常
1　休職
2　退職
3　停止
*/

$t_day=date("Ymd",$day_time);
$n_day=date("Ymd",$day_time+(86400*7));

$cast=$_REQUEST["cast"];
$sql="SELECT * FROM wp01_0cast WHERE id='{$cast}' AND status<2 LIMIT 1";
if($res = mysqli_query($mysqli,$sql)){
	while($a1 = mysqli_fetch_assoc($res)){
		if (file_exists("./img/page/{$a1["id"]}/0.jpg")) {
			$face_a="<img src=\"./img/page/{$a1["id"]}/0.jpg?t={$tm}\" class=\"person_img_main\">";
			$face_b="<img id=\"i1\" src=\"./img/page/{$a1["id"]}/0.jpg?t={$tm}\" class=\"person_img_sub\">";

			if (file_exists("./img/page/{$a1["id"]}/1.jpg")) {
				$face_b.="<img id=\"i2\" src=\"./img/page/{$a1["id"]}/1.jpg?t={$tm}\" class=\"person_img_sub\">";
			}
			if (file_exists("./img/page/{$a1["id"]}/2.jpg")) {
				$face_b.="<img id=\"i3\" src=\"./img/page/{$a1["id"]}/2.jpg?t={$tm}\" class=\"person_img_sub\">";
			}
			if (file_exists("./img/page/{$a1["id"]}/3.jpg")) {
				$face_b.="<img id=\"i4\" src=\"./img/page/{$a1["id"]}/3.jpg?t={$tm}\" class=\"person_img_sub\">";
			}
		}else{
			$a1["face"]="./img/cast/noimage.jpg";			
			$face_a="<img src=\"./img/page/noimage.jpg\" class=\"person_img_main\">";
		}
	}
}

$sql	 ="SELECT * FROM wp01_0schedule";
$sql	.=" WHERE sche_date>='{$t_day}'";
$sql	.=" AND sche_date<'{$n_day}'";
$sql	.=" AND cast_id='{$cast}'";
$sql	.=" ORDER BY id ASC";

if($res = mysqli_query($mysqli,$sql)){
	while($a1 = mysqli_fetch_assoc($res)){
		$sch[$a1["sche_date"]]=$a1;
	}
}

for($n=0;$n<7;$n++){
	$t_sch=date("Ymd",$day_time+(86400*$n));
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
if($res = mysqli_query($mysqli,$sql)){
	while($a1 = mysqli_fetch_assoc($res)){
		if($a1["style"] == 1){
			$charm_list.="<tr><td class=\"prof_0\" colspan=\"2\"></td></tr><tr><td class=\"prof_l2\" colspan=\"2\">{$a1["charm"]}</td></tr><tr><td class=\"prof_r2\" colspan=\"2\">{$charm[$a1["id"]]}</td></tr>";
		}else{
			$charm_list.="<tr><td class=\"prof_l\">{$a1["charm"]}</td><td class=\"prof_r\">{$charm[$a1["id"]]}</td></tr>";
		}
	}
}

$sql ="SELECT * FROM wp01_posts AS P";
$sql.=" LEFT JOIN wp01_0blog_tag AS T= ON P.tag=T.id";
$sql.=" WHERE P.cast='{$cast}'";
$sql.=" AND P.write_date<='{$now}'";
$sql.=" AND P.status='0'";
$sql.=" ORDER BY P.write_date DESC";
$sql.=" LIMIT 6";

if($res = mysqli_query($mysqli,$sql)){
	while($a1 = mysqli_fetch_assoc($res)){
		$blog[]=$a1;
	}
}

$sql ="SELECT sort,charm,style,log FROM wp01_0charm_table";
$sql.=" LEFT JOIN `wp01_0charm_sel` ON wp01_0charm_table.id=list_id";
$sql.=" WHERE wp01_0charm_table.del='0'";
$sql.=" AND (wp01_0charm_sel.cast_id='{$cast}' OR wp01_0charm_sel.cast_id='')";
$sql.=" ORDER BY sort ASC";

if($res = mysqli_query($mysqli,$sql)){
	while($a1 = mysqli_fetch_assoc($res)){
		$a["log"]=str_replace("\n","<br>",$a0["log"]);
		$cast_table[]=$a;
	}
}


$sql ="SELECT id,title,style FROM wp01_0check_main";
$sql.=" WHERE del='0'";
$sql.=" ORDER BY sort ASC";

if($res = mysqli_query($mysqli,$sql)){
	while($a1 = mysqli_fetch_assoc($res)){
		$check_main[]=$a1;
	}
}


$sql ="SELECT * FROM wp01_0check_list";
$sql.=" LEFT JOIN `wp01_0check_sel` ON wp01_0check_list.id=wp01_0check_sel.list_id";
$sql.=" AND del='0'";
$sql.=" AND (cast_id IS NULL OR cast_id='{$cast}')";
$sql.=" ORDER BY host_id ASC, list_sort ASC";

foreach($res as $a1){
	$check_list[$a1["host_id"]][$a1["list_sort"]]=$a1;
}
include_once('./header.php');
?>

<div class="footmark">
	<a href="./index.php" class="footmark_box box_a">
		<span class="footmark_icon"></span>
		<span class="footmark_text">TOP</span>
	</a>
	<span class="footmark_icon"></span>
	<a href="./cast.php" class="footmark_box box_a">
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
				<a href="./article/?cast_list=<?=$blog[$s]["id"]?>" id="i<?=$b1?>" class="person_blog">
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
<?include_once('./footer.php'); ?>