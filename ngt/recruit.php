<?php
include_once('./library/sql.php');
$sql="SELECT * FROM wp01_0contents WHERE page='recruit' ORDER BY sort ASC";

if($res = mysqli_query($mysqli,$sql)){
	while($a1= mysqli_fetch_assoc($res)){
		$a1["contents"]=str_replace("\n","<br>",$a1["contents"]);
		$recruit[$a1["category"]][$a1["sort"]]=$a1;
	}
}
/*
if($recruit["contact"][0]){
	$sql="SELECT * FROM wp01_0contact_table;
	WHERE type='{$recruit["contents_key"][0]}' ORDER BY sort ASC";
	if($res = mysqli_query($mysqli,$sql)){
		while($tv= mysqli_fetch_assoc($res)){
		}
	}
}
*/

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
	<?if (file_exists("./img/page/contents/{$a2["id"]}.webp")) {?>
		<img src="./img/page/contents/<?=$a2["id"]?>.webp" class="rec_img">

	<?}elseif (file_exists("./img/page/contents/{$a2["id"]}.jpg")) {?>
		<img src="./img/page/contents/<?=$a2["id"]?>.jpg" class="rec_img">

	<?}elseif (file_exists("./img/page/contents/{$a2["id"]}.png")) {?>
		<img src="./img/page/contents/<?=$a2["id"]?>.png" class="rec_img">
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
		<?foreach($recruit["list"] as $a2){?>
			<div class="rec">
				<div class="rec_l"><?=$a2["title"]?></div>
				<div class="rec_r"><?=$a2["contents"]?></div>
			</div>
		<?}?>

<div class="contact_box">
<?if($recruit["tel"][0]){?>
<div class="recruit_contact r_tel"><span class="contact_icon"></span><span class="contact_comm">電話</span></div>
<?}?>

<?if($recruit["line"][0]){?>
<div class="recruit_contact r_tel"><span class="contact_icon"></span><span class="contact_comm">LINE</span></div>
<?}?>

<?if($recruit["mail"][0]){?>
<div class="recruit_contact r_tel"><span class="contact_icon"></span><span class="contact_comm">メール</span></div>
<?}?>
</div>


<?if($recruit["form"][0]){?>
<input type="text">


<?}?>


	</div>
	<div class="corner box_1"></div>
	<div class="corner box_2"></div>
	<div class="corner box_3"></div>
	<div class="corner box_4"></div>
</div>

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
