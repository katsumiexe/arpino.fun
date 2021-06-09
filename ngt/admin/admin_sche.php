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

$sql =" SELECT * FROM wp01_0sch_table";
$sql .=" ORDER BY sort ASC";

if($result = mysqli_query($mysqli,$sql)){
	while($row = mysqli_fetch_assoc($result)){
		$sch_table[$row["in_out"]][$row["sort"]]=$row["name"];
	}
}

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
			$stime[$row["cast_id"]][$row["sche_date"]]=$row["stime"];
			$etime[$row["cast_id"]][$row["sche_date"]]=$row["etime"];
	
		}else{
			$stime[$row["cast_id"]][$row["sche_date"]]="休み";
			$etime[$row["cast_id"]][$row["sche_date"]]="";
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
	text-align	:center;
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
.box_inout{
	display			:block;
	height			:30px;
	width			:100%;
	margin			:10px 3px;
}

.tag_inout{
	display			:inline-block;
	height			:30px;
	line-height		:30px;
	width			:20px;
	font-size		:15px;
	font-weight		:700;
	text-align		:center;
	vertical-align	:top;
}

.sel_inout{
	width:80px;
}

.td_castname{
	text-align:center;
	font-size:0;
}

.td_castname_in{
	width		:150px;
	text-align	:left;
	font-size	:14px;
	margin		:3px auto;
}

.sche_submit,.sche_reset{
	width		:65px;
	font-size	:13px;
	margin		:5px;
	height		:30px;
}


-->
</style>
<script>
$(function(){ 
	$('.sche_reset').on('click',function(){	
		Tmp =$(this).attr("id").substr(3);
		for(var i=0;i<7;i++){
			$('#s_'+Tmp + "_" + i).val($('#hs_'+Tmp + "_" + i).val());
			$('#e_'+Tmp + "_" + i).val($('#he_'+Tmp + "_" + i).val());
		}
		$(this).parents().siblings('td').css('background','#fafafa');
	});

	$('.sche_submit').on('click',function(){	
		Tmp =$(this).attr("id").substr(3);

		for(var i=0;i<7;i++){
			if($('#s_'+Tmp + "_" + i).val() != $('#hs_'+Tmp + "_" + i).val()){

				$('#hs_'+Tmp + "_" + i).val($('#s_'+Tmp + "_" + i).val());
				$('#he_'+Tmp + "_" + i).val($('#e_'+Tmp + "_" + i).val());

				Chg_s[i]=$('#s_'+Tmp + "_" + i).val();		
				Chg_e[i]=$('#e_'+Tmp + "_" + i).val();		
			}
		}

		$.post({
			url:"./post/sch_chg.php",
			data:{
				'chg_s[]'	:Chg_s,
				'chg_e[]'	:Chg_e,
				'cast_id'	:Tmp,
			},

		}).done(function(data, textStatus, jqXHR){
			$(this).parents().siblings('td').css('background','#fafafa');

		}).fail(function(jqXHR, textStatus, errorThrown){
			console.log(textStatus);
			console.log(errorThrown);
		});
	});


	$('.sel_inout').on('change',function(){	
		Tmp =$(this).attr("id").substr(2);
		if($('#s_'+Tmp).val() == $('#hs_'+Tmp).val() && $('#e_'+Tmp).val() == $('#he_'+Tmp).val() ){
			$(this).parents('.td_inout').css('background','#fafafa');

		}else{
			$(this).parents('.td_inout').css('background','#f0f0c0');
		}
	});
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
		<td class="w60"><img src="<?=$a2["face"]?>?t=<?=time()?>" style="width:60px; height:80px;"></td>

		<td class="td_castname w160">
			<div class="td_castname_in">
			<?=$a2["genji"]?><br>
			[<?=$a2["genji_kana"]?>]
			</div>
			<button id="ch_<?=$a2["id"]?>" type="button" class="sche_submit">更新</button><button id="rs_<?=$a1?>" type="button" class="sche_reset">RESET</button>
		</td>

		<?for($n=0;$n<7;$n++){?>
			<?
				$tmp_day=date("Ymd",strtotime($st_day)+($n*86400));
				if(!$stime[$a2["id"]][$tmp_day]) $stime[$a2["id"]][$tmp_day]="休み";
			?>
			<td class="td_inout w120">
				<div class="box_inout">
					<span class="tag_inout">入</span>
					<select id ="s_<?=$a1?>_<?=$n?>" class="sel_inout">
					<option value="休み" <?if($stime[$a2["id"]][$tmp_day]== "休み"){?> selected="selected"<?}?>>休み</option>
						<?foreach($sch_table["in"] as $b2){?>
							<option value="<?=$b2?>" <?if($b2 == $stime[$a2["id"]][$tmp_day]){?> selected="selected"<?}?>><?=$b2?></option>
						<?}?>
					</select>
					<input type="hidden" id="hs_<?=$a1?>_<?=$n?>" value="<?=$stime[$a2["id"]][$tmp_day]?>">
				</div>

				<div class="box_inout">
					<span class="tag_inout">退</span>
					<select id ="e_<?=$a1?>_<?=$n?>" class="sel_inout">
						<option value="" <?if($stime[$a2["id"]][$tmp_day]== "休み"){?> selected="selected"<?}?>>　</option>
						<?foreach($sch_table["out"] as $b2){?>
							<option value="<?=$b2?>" <?if($b2 == $etime[$a2["id"]][$tmp_day]){?> selected="selected"<?}?>><?=$b2?></option>
						<?}?>
					</select>
					<input type="hidden" id="he_<?=$a1?>_<?=$n?>" value="<?=$etime[$a2["id"]][$tmp_day]?>">
				</div>
			</td>
		<?}?>
	</tr>
<?}?>
</table>
</div>
</div>
<footer class="foot"></footer> 
