<?
/*
$start_time	=$admin_config["start_time"];
$start_week	=$admin_config["start_week"];
*/

$week[0]="日";
$week[1]="月";
$week[2]="火";
$week[3]="水";
$week[4]="木";
$week[5]="金";
$week[6]="土";

$ck_date=$_POST["sk_date"];
if(!$ck_date) $ck_date=substr($day_8,0,4)."-".substr($day_8,4,2)."-".substr($day_8,6,2);

$tmp_d=strtotime($ck_date);
$tmp_week=date("w",$tmp_d);
$st_day=date("Ymd",$tmp_d-($tmp_week-$start_week)*86400);
$ed_day=date("Ymd",$tmp_d-($tmp_week-$start_week)*86400+518400);


$sql =" SELECT id, genji,genji_kana FROM wp01_0cast";
$sql.=" WHERE cast_status<2";
$sql.=" AND del=0";
$sql.=" ORDER BY id ASC";

if($result = mysqli_query($mysqli,$sql)){
	while($row = mysqli_fetch_assoc($result)){

		if (file_exists("../img/profile/{$row["id"]}/0.jpg")) {
			$row["face"]="../img/profile/{$row["id"]}/0.jpg";			

		}else{
			$row["face"]="../img/cast_no_image.jpg";			
		}
		$row["sch"]="休み";
		$cast_dat[]=$row;
	}
}

$sql ="SELECT cast_id, stime, etime, sche_date FROM wp01_0schedule";
$sql.=" WHERE sche_date>='{$st_day}'";
$sql.=" AND sche_date<='{$ed_day}'";
$sql.=" ORDER BY id ASC";

if($result = mysqli_query($mysqli,$sql)){
	while($row = mysqli_fetch_assoc($result)){

		if($row["stime"] && $row["etime"]){
			$sche_dat[$row["cast_id"]][$row["sche_date"]]="{$row["stime"]}<br>｜<br>{$row["etime"]}";

		}else{
			$sche_dat[$row["cast_id"]][$row["sche_date"]]="休み";
		}
	}
}

?>
<style>
<!--
input[type=text]{
	height:30px;
}

input[type="checkbox"],input[type="radio"]{
	display:none;
}

td{
	border:1px solid #303030;
}


.td_top{
	background	:#f0f0ff;
	text-align	:center;
	font-size	:14px;
}

.td_sort{
	width		:30px;
	text-align	:center;
	background	:#a06000;
	color		:#fafafa;
}

.td_40{
	width		:40px;
	background	:#fafafa;
	text-align:center;
}

.td_60{
	width		:60px;
	background	:#fafafa;
}

.td_100{
	width		:100px;
	background	:#fafafa;
	text-align	:center;
}

.td_200{
	width		:200px;
	background	:#fafafa;
}


.td_sort_up,.td_sort_down{
	display		:inline-block;
	position	:absolute;
	left		:0;
	right		:0;
	margin		:auto;
	width		:30px;
	height		:22px;
	line-height	:22px;
	background	:#d0d0d0;
	text-align	:center;
}

.td_sort_down{
	bottom:5px;
}

.td_sort_up{
	top:5px;
}

.td_sort_middle{
	display		:inline-block;
	position	:absolute;
	left		:0;
	right		:0;
	margin		:auto;
	top			:0;
	bottom		:0;
	height		:26px;
	background	:#fafafa;
	border		:1px solid #303030;
	text-align	:right;
	width		:24px;
	padding		:2px;
}


-->
</style>
<script>
$(function(){ 
});
</script>
<header class="head">
<input id="sel_date" type="date" name="sche_date" value="<?=$sel_date?>" class="sel_date">
<?=$st_day?> - <?=$ed_day?><br>
</header>
<div class="wrap">
	<div class="main_box">

<table>
<tr>
<td class="td_top" colspan="2">キャスト名</td>

<?for($n=0;$n<7;$n++){?>
<td class="td_top">
<?=date("m年d月",strtotime($st_day)+($n*86400))?>
[<?=$week[date("w",strtotime($st_day)+($n*86400))]?>]
</td>
<?}?>
</tr>

<?foreach($cast_dat as $a1=> $a2){?>
<tr>
<td class="td_60"><img src="<?=$a2["face"]?>?t=<?=time()?>" style="width:60px; height:80px;"></td>
<td class="td_200"><?=$a2["genji"]?><br>[<?=$a2["genji_kana"]?>]</td>
<?for($n=0;$n<7;$n++){?>
<?
	$tmp_day=date("Ymd",strtotime($st_day)+($n*86400));
	if(!$sche_dat[$a2["id"]][$tmp_day]) $sche_dat[$a2["id"]][$tmp_day]="休み";
?>
<td class="td_100"><?=$sche_dat[$a2["id"]][$tmp_day]?></td>
<?}?>
</tr>
<?}?>
</table>
	</div>
</div>
<footer class="foot"></footer> 
