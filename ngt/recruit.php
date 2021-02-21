<?php
include_once('./library/sql.php');
$sql="SELECT * FROM wp01_0contents WHERE page='recruit' ORDER BY sort ASC";

if($res = mysqli_query($mysqli,$sql)){
	while($a1= mysqli_fetch_assoc($res)){
		$recruit[$a1["category"]][$a1["sort"]]=$a1;
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
		<span class="footmark_text">RECRUIT</span>
	</div>
</div>
<?foreach($recruit["image"] as $a2){?>
	<?if (file_exists("./img/page/contents/{$a2["contents"]}.webp")) {?>
		<img src="./img/page/contents/<?=$a2["contents"]?>.webp" class="rec_img">

	<?}elseif (file_exists("./img/page/contents/{$a2["contents"]}.jpg")) {?>
		<img src="./img/page/contents/<?=$a2["contents"]?>.jpg" class="rec_img">

	<?}elseif (file_exists("./img/page/contents/{$a2["contents"]}.png")) {?>
		<img src="./img/page/contents/<?=$a2["contents"]?>.png" class="rec_img">
	<?}?>
<?}?>

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
		<?foreach($recruit["top"] as $a2){?>
			<span class="sys_box_ttl"><?=$a2["title"]?></span><br>
			<span class="sys_box_log"><?=$a2["contents"]?></span><br>
		<?}?>
	</div>
<div class="corner box_1"></div>
<div class="corner box_2"></div>
<div class="corner box_3"></div>
<div class="corner box_4"></div>
</div>

<?foreach($recruit["list"] as $a2){?>
	<div class="rec">
		<div class="rec_l"><?=$a2["title"]?></div>
		<div class="rec_r"><?=$a2["contents"]?></div>
	</div>
<?}?>

<?if(!$recruit){?>
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
		<span class="sys_box">情報はありません</span><br>
	</div>
<div class="corner box_1"></div>
<div class="corner box_2"></div>
<div class="corner box_3"></div>
<div class="corner box_4"></div>
</div>
<?}?>

<?include_once('./footer.php'); ?>
