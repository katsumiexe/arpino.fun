<?php
include_once('./library/sql.php');
$code=$_REQUEST["code"];
$sql	 ="SELECT * FROM wp01_0contents";
$sql	.=" WHERE status=0";
$sql	.=" AND id='{$code}'";
$sql	.=" LIMIT 1";


if($res0 = mysqli_query($mysqli,$sql)){
$event = mysqli_fetch_assoc($res0);

$event["contents"]=str_replace("\n","<br>",$event["contents"]);
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
<img src="./img/page/event/event_<?=$code?>.jpg" class="top_img">;
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
