<?php
include_once('./library/sql.php');

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
if(!$month) $month=substr($day_8,0,6);

//■カレンダーカウント
$sql ="SELECT post_date FROM wp01_0posts";
$sql.=" WHERE status=0";
$sql.=" AND blog_date LIKE '".substr($month,0,4)."-".substr($month,4,2)."%'";
$sql.=" AND post_date<='{$now}'";

if($res = mysqli_query($mysqli,$sql)){
	while($a1 = mysqli_fetch_assoc($res)){
		$tmp=substr($a1["blog_date"],8,2)+0;
		$calendar_ck[$tmp]=1;
	}
}

//■キャスト件数カウント
$sql ="SELECT cast, genji, COUNT(id) AS cnt ,MAX(blog_date) AS b_date ,FROM wp01_0posts";
$sql.=" LEFT JOIN wp01_0cast ON wp01_0posts.cast=wp01_0cast.id";
$sql.=" WHERE status=0";
$sql.=" AND blog_date<='{$now}'";
$sql.=" GROUP BY cast'";

if($res = mysqli_query($mysqli,$sql)){
	while($a1 = mysqli_fetch_assoc($res)){
		$cast_dat[$a1["cast"]]["cnt"]	=$a1["cnt"];
		$cast_dat[$a1["cast"]]["name"]	=$a1["genji"];
		$cast_dat[$a1["cast"]]["date"]	=$a1["b_date"];

		if (file_exists("./img/profile/{$a1["cast"]}/0_s.jpg")) {
			$cast_dat[$a1["cast"]]["face"]	="./img/profile/{$a1["cast"]}/0_s.jpg";
		}else{
			$cast_dat[$a1["cast"]]["face"]	="/img/profile/noimage.jpg";
		}
	}
}

//■カテゴリ件数カウント
$sql ="SELECT tag, COUNT(id) AS cnt FROM wp01_0posts";
$sql.=" WHERE status=0";
$sql.=" AND blog_date<='{$now}'";
$sql.=" GROUP BY tag'";

if($res = mysqli_query($mysqli,$sql)){
	while($a1 = mysqli_fetch_assoc($res)){
		$tag_count[$a1["tag"]]	=$a1["cnt"];
	}
}


$pg_max=ceil($cate_all/16);
if($pg_max==1){
}elseif($pg_max<=5){
	$p_list.="<div class=\"page_box\">";
		for($pp=1;$pp<$pg_max+1;$pp++){
			$p_list.="<a href=\"/castblog/?pg={$pp}\" class=\"page_n ";
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
			$p_list.="<a href=\"/castblog/?pg={$pp}\" class=\"page_n ";
			if($pp==$pg) $p_list.="pg_n";
			$p_list.="\">{$pp}</a>";
		}
		$p_list.="<a href=\"\" class=\"page_n pg_b\">»</a>";
	$p_list.="</div>";
}

$sql ="SELECT * FROM wp01_0posts";
$sql.=" WHERE status=0";
$sql.=" AND blog_date<='{$now}'";

if($cast_list){
	$sql.=" AND cast='{$cast_list}'";
}

if($tag_list){
	$sql.=" AND tag='{$tag_list}'";
}

$sql.=" ORDER BY blog_date DESC";
$sql.=" LIMIT {$pg_st},16";

if($res = mysqli_query($mysqli,$sql)){
	while($a1 = mysqli_fetch_assoc($res)){
		$blog[]	=$a1;
	}
}

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
		$c_inc.="<td class=\"blog_calendar_d\"><a href=\"castblog.php?blog_day={$ky}&month={$month}{$c_para}{$t_para}\" class=\"cal{$calendar_ck[$tmp_days]}\">{$tmp_days}</a></td>";
	}else{
		$c_inc.="<td class=\"blog_calendar_d\"></td>";
	}
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

<?if($cast_list){?>
	<span class="footmark_icon"></span>
	<a href="./castblog.php?cast=<?=$cast_list?>" class="footmark_box box_a">
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
	<a href="./castblog.php?tag=<?=$tag_list?>" class="footmark_box box_a">
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
				<a href="./article.php?cast_list=<?=$blog[$n]["ID"]?>" id="i<?=$b1?>" class="blog_list">
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
					<img src="https://arpino.fun/wp/wp-content/themes/nightparty/img/page/<?=$blog[$n]["castslug"]?>/0.jpg?t=<?=time()?>" class="blog_list_castimg">
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
				<td id="c_prev"class="blog_calendar_n"><a href="./castblog.php?month=<?=$p_month?><?=$c_para?><?=$t_para?>" class="carendar_pn"></a></td>
				<td class="blog_calendar_m" colspan="5"><?=$v_month?></td>
				<td id="c_next" class="blog_calendar_n"><a href="./castblog.php?month=<?=$n_month?><?=$c_para?><?=$t_para?>" class="carendar_pn"></a></td>
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
				<a href="./castblog.php" class="all_tag">
					<span class="all_tag_icon"><?=$tag_icon[0]?></span>
					<span class="all_tag_name">全て</span>
					<span class="all_tag_count"><?=$cate_all?></span>
				</a>
				<?foreach($tag_count as $a1=> $a2){?>
				<a href="./castblog.php?tag_list=<?=$a1?>" class="all_tag">
					<span class="all_tag_icon"><?=$tag_icon[$a1]?></span>
					<span class="all_tag_name"><?=$cate_name[$a1]?></span>
					<span class="all_tag_count"><?=$a2?></span>
				</a>
				<? } ?>
			</div>

			<div class="sub_blog_in">
				<div class="blog_h1">CAST一覧</div>
				<?foreach($cast_dat as $a1=> $a2){?>
					<a href="./castblog.php?cast_list=<?=$a1?>" class="all_cast">
						<span class="all_cast_img"><img src="<?=$cast_dat[$a1]["face"]?>?t=<?=time()?>" class="all_cast_img_in"></span>
						<span class="all_cast_name"><?=$cast_dat[$a1]["name"]?></span>
						<span class="all_cast_last">更新：<?=$cast_dat[$a1]["date"]?></span>
						<span class="all_cast_count"><?=$cast_dat[$a1]["cnt"]?></span>
					</a>
				<?}?>
			</div>
		</div>
	</div>
</div>
</div>
<?include_once('./footer.php'); ?>
