<?php
include_once('./library/sql.php');
$post_id=$_REQUEST["post_id"];
$sql	 ="SELECT * FROM wp01_0contents";
$sql	.=" WHERE status<4";
$sql	.=" AND id='{$post_id}'";
$sql	.=" LIMIT 1";

if($res0 = mysqli_query($mysqli,$sql)){
	$event = mysqli_fetch_assoc($res0);
	$event["contents"]=str_replace("\n","<br>",$event["contents"]);

	if (file_exists("./img/page/event/event_{$event["id"]}.webp")) {
		$event["top"]="<img src=\"./img/page/event/event_{$event["id"]}.webp\" class=\"event_img\">";			

	}elseif (file_exists("./img/page/event/event_{$event["id"]}.jpg")) {
		$event["top"]="<img src=\"./img/page/event/event_{$event["id"]}.jpg\" class=\"event_img\">";			

	}elseif (file_exists("./img/page/event/event_{$event["id"]}.png")) {
		$event["top"]="<img src=\"./img/page/event/event_{$event["id"]}.png\" class=\"event_img\">";			
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
	<div class="footmark_box">
		<span class="footmark_icon"></span>
		<span class="footmark_text">EVENT</span>
	</div>
</div>

<?if(!$event){?>
<div class="main_e">
<div class="main_e_in">
<span class="main_e_f c_tr"></span>
<span class="main_e_f c_tl"></span>
<span class="main_e_f c_br"></span>
<span class="main_e_f c_bl"></span>
<div class="corner_in box_in_1"></div>
<div class="corner_in box_in_2"></div>
<div class="corner_in box_in_3"></div>
<div class="corner_in box_in_4"></div>
<span class="sys_box_log">こちらのイベントは終了しています</span><br>
</div>
<div class="corner box_1"></div>
<div class="corner box_2"></div>
<div class="corner box_3"></div>
<div class="corner box_4"></div>
</div>
<?}else{?>

<?=$event["top"]?>
<div class="main_e">
<div class="main_e_in">
<span class="main_e_f c_tr"></span>
<span class="main_e_f c_tl"></span>
<span class="main_e_f c_br"></span>
<span class="main_e_f c_bl"></span>
<div class="corner_in box_in_1"></div>
<div class="corner_in box_in_2"></div>
<div class="corner_in box_in_3"></div>
<div class="corner_in box_in_4"></div>
<span class="sys_box_ttl"><?=$event["title"]?></span><br>
<span class="sys_box_log"><?=$event["contents"]?></span><br>
</div>
<div class="corner box_1"></div>
<div class="corner box_2"></div>
<div class="corner box_3"></div>
<div class="corner box_4"></div>
</div>
<?}?>
<br>
<?include_once('./footer.php'); ?>
