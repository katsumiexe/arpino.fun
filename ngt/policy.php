<?php
include_once('./library/sql.php');

$sql	 ="SELECT * FROM wp01_0contents";
$sql	.=" WHERE page='policy'";
$sql	.=" AND status=0";
$sql	.=" LIMIT 1";
$res = mysqli_query($mysqli,$sql);
$dat = mysqli_fetch_assoc($res);
include_once('./header.php');

?>
<div class="footmark">
	<a href="./index.php" class="footmark_box box_a">
		<span class="footmark_icon"></span>
		<span class="footmark_text">TOP</span>
	</a>
	<span class="footmark_icon"></span>
	<div class="footmark_box">
		<span class="footmark_icon"></span>
		<span class="footmark_text">プライバシーポリシー</span>
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
<span class="sys_box_ttl"><?=$dat["title"]?></span><br>
<span class="sys_box_log"><?=$dat["contents"]?></span><br>
</div>
<div class="corner box_1"></div>
<div class="corner box_2"></div>
<div class="corner box_3"></div>
<div class="corner box_4"></div>
</div>
<br>
<?include_once('./footer.php'); ?>
