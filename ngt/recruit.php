<?php
include_once('./library/sql.php');
$page=$_REQUEST["page"]
$sql="SELECT * FROM wp01_0contents WHERE page='{$page}' ORDER BY id ASC LIMIT 1";

if($res = mysqli_query($mysqli,$sql)){
	$recruit= mysqli_fetch_assoc($res);
}
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
		<span class="sys_box_ttl">Recruit</span><br>
		<?if($recruit){?>
			<div class="rec">
				<div class="rec_l"><?=$recruit["title"]?></div>
				<div class="rec_r"><?=$recruit["contents"]?></div>
			</div>
		<?}else{?>
			<span class="sys_box_log">情報はまだありません</span><br>
		<?}?>
	</div>
<div class="corner box_1"></div>
<div class="corner box_2"></div>
<div class="corner box_3"></div>
<div class="corner box_4"></div>
</div>
<?include_once('./footer.php'); ?>
