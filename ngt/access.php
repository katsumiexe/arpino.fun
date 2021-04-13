<?php
include_once('./library/sql.php');

$sql="SELECT * FROM wp01_0contents WHERE page='system' AND status='0' ORDER BY id DESC LIMIT 1";
if($res = mysqli_query($mysqli,$sql)){
$dat = mysqli_fetch_assoc($res);
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
		<span class="footmark_icon"></span>
		<span class="footmark_text">ACCESS</span>
	</div>
</div>

<?if($dat){?>
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
	<span class="sys_box_ttl">ACCESS</span><br>
	<div class="access_table">
		<div class="access_map">
			<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3240.203467095303!2d139.69973731446893!3d35.69661033673738!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMzXCsDQxJzQ3LjgiTiAxMznCsDQyJzA2LjkiRQ!5e0!3m2!1sja!2sjp!4v1618311196518!5m2!1sja!2sjp" width="600" height="400" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0" class="access_map_in"></iframe>
		</div>
		<div class="access_sig">
			<h1 class="access_h1">Night☆Party</h1>
			<div class="access_tag">住所</div>
			<div class="access_box">
				〒160-0021<br>
				東京都新宿区歌舞伎町1-1-1 新宿ビルB1F<br>
			</div>

			<div class="access_tag">アクセス</div>
			<div class="access_box">
				JR線 新宿駅東口より徒歩3分<br> 
				西武新宿線西武新宿駅より徒歩3分<br>
			</div>
			<div class="access_tag">電話番号</div>
			<div class="access_box">
				<span>03</span>-<span>6457</span>-<span>6156</span>
			</div>
			<div class="access_tag">営業時間</div>
			<div class="access_box">
				20:00～LAST<br>
			</div>


		</div>
	</div>
</div>
<div class="corner box_1"></div>
<div class="corner box_2"></div>
<div class="corner box_3"></div>
<div class="corner box_4"></div>
</div>
</div>
<?}else{?>
<div class="main_e">
<span class="sys_box_log">情報はまだありません</span><br>
</div>
<?}?>
<br>
<?include_once('./footer.php'); ?>


