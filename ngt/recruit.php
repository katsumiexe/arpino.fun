<?php
include_once('./library/sql.php');
$sql="SELECT * FROM wp01_0contents WHERE page='recruit' ORDER BY sort ASC";

if($result = mysqli_query($mysqli,$sql)){
	while($raw= mysqli_fetch_assoc($result)){
		if($raw["category"] == "list"){
			$raw["contents"]=str_replace("\n","<br>",$raw["contents"]);
			$dat_list[$raw["sort"]]=$raw;

		}else{
			$dat_config[$raw["category"]]=$raw;
		}
	}
}

$ck_tg["1"]="<span class=\"nec\">※必須項目</span>";
$ck_jq["1"]="nec_ck";

if($dat_config["form"]){
	$sql="SELECT * FROM wp01_0contact_table";
	$sql.=" WHERE id='{$dat_config["form"]["contents_key"]}'";

	if($result = mysqli_query($mysqli,$sql)){
		$c_form= mysqli_fetch_assoc($result);
	}

	$form_dat="<div class=\"contact_form\">";
	for($n=1;$n<11;$n++){
		$tmp_nm="log_{$n}_name";

		if($c_form[$tmp_nm]){

			$tmp_pt=substr($c_form["log_".$n."_type"],0,1);
			$tmp_ck=substr($c_form["log_".$n."_type"],-1,1);

			$form_dat.="<div class=\"contact_tag\">{$c_form[$tmp_nm]}{$ck_tg[$tmp_ck]}</div>";

			if($tmp_pt== 1){//text
				$form_dat.="<input id=\"contact{$n}\" type=\"text\" name=\"contact{$n}\" class=\"contact {$ck_jq[$tmp_ck]}\" autocomplete=\"off\">";

			}elseif($tmp_pt== 2){//mail
				$form_dat.="<input id=\"contact{$n}\" type=\"text\" name=\"contact{$n}\" class=\"contact v_mail {$ck_jq[$tmp_ck]}\" autocomplete=\"off\">";

			}elseif($tmp_pt== 3){//number
				$form_dat.="<input id=\"contact{$n}\" type=\"number\" inputmode=\"numeric\" name=\"contact{$n}\" class=\"contact {$ck_jq[$tmp_ck]}\" autocomplete=\"off\">";

			}elseif($tmp_pt== 4){//comm
				$form_dat.="<textarea id=\"contact{$n}\" name=\"contact{$n}\" class=\"contact_area {$ck_jq[$tmp_ck]}\" autocomplete=\"off\">";
			}
		}
	}
	$form_dat.="<button id=\"send_btn\" type=\"button\">送信</button>";
	$form_dat.="</div>";
}

include_once('./header.php');
?>


$('#send_btn').on('click',function(){
	if()
});


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
	<?if (file_exists("./img/page/contents/{$dat_config["top"]["contents_key"]}.webp")) {?>
		<img src="./img/page/contents/<?=$dat_config["top"]["contents_key"]?>.webp" class="rec_img">

	<?}elseif (file_exists("./img/page/contents/{$dat_config["top"]["contents_key"]}.jpg")) {?>
		<img src="./img/page/contents/<?=$dat_config["top"]["contents_key"]?>.jpg" class="rec_img">

	<?}elseif (file_exists("./img/page/contents/{$dat_config["top"]["contents_key"]}.png")) {?>
		<img src="./img/page/contents/<?=$dat_config["top"]["contents_key"]?>.png" class="rec_img">
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

		<span class="sys_box_ttl"><?=$dat_config["top"]["title"]?></span><br>
		<span class="sys_box_log"><?=$dat_config["top"]["contents"]?></span><br>

		<?foreach($dat_list as $a2){?>
			<div class="rec">
				<div class="rec_l"><?=$a2["title"]?></div>
				<div class="rec_r"><?=$a2["contents"]?></div>
			</div>
		<?}?>


	<div class="contact_box">
		<?if($dat_config["tel"]){?>
			<div class="recruit_contact r_tel"><span class="contact_icon"></span><span class="contact_comm">電話</span></div>
		<?}?>

		<?if($dat_config["line"]){?>
			<div class="recruit_contact r_tel"><span class="contact_icon"></span><span class="contact_comm">LINE</span></div>
		<?}?>
	</div>
	<?=$form_dat?>


	</div>
	<div class="corner box_1"></div>
	<div class="corner box_2"></div>
	<div class="corner box_3"></div>
	<div class="corner box_4"></div>
</div>

<?if(!$dat_config){?>
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
