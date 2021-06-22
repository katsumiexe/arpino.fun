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

/*
<input id="ck_b" type="checkbox" name="cl_b" class="sche_ck_box" value="1"><label for="ck_b" class="ck_label">通常</label>
<input id="ck_c" type="checkbox" name="cl_c" class="sche_ck_box" value="1"><label for="ck_c" class="ck_label">準備</label>
<input id="ck_d" type="checkbox" name="cl_d" class="sche_ck_box" value="1"><label for="ck_d" class="ck_label">休職</label>
<input id="ck_e" type="checkbox" name="cl_e" class="sche_ck_box" value="1"><label for="ck_e" class="ck_label">退職</label>
<input id="ck_f" type="checkbox" name="cl_f" class="sche_ck_box" value="1"><label for="ck_f" class="ck_label">停止</label>
*/

$ck_date=$_POST["ck_date"];
if(!$ck_date) $ck_date=$day_8;

$tmp_d=strtotime($ck_date);

if($_POST["page"]=="n"){
	$tmp_d+=604800;

}elseif($_POST["page"]=="p"){
	$tmp_d-=604800;
}
$tmp_week=date("w",$tmp_d);

$st_day		=date("Ymd",$tmp_d-($tmp_week-$start_week)*86400);
$ed_day		=date("Ymd",$tmp_d-($tmp_week-$start_week)*86400+518400);
$ck_date	=date("Y-m-d",$tmp_d-($tmp_week-$start_week)*86400);

$cl_b=$_POST["cl_b"];
$cl_c=$_POST["cl_c"];
$cl_d=$_POST["cl_d"];
$cl_e=$_POST["cl_e"];
$cl_f=$_POST["cl_f"];

if(!$cl_b && !$cl_c && !$cl_d && !$cl_e && !$cl_f){
	$cl_b=1;
	$cl_c=1;
}

if($cl_b == 1){
	$app.=" OR ( cast_status =0 AND ctime<='{$ed_day}')";
}

if($cl_c == 1){
	$app.=" OR ( cast_status =0 AND ctime>'{$ed_day}')";
}

if($cl_d == 1){
	$app.=" OR cast_status =2";
}

if($cl_e == 1){
	$app.=" OR cast_status =3";
}

if($cl_f == 1){
	$app.=" OR cast_status =4";
}

$sql =" SELECT * FROM wp01_0sch_table";
$sql .=" ORDER BY sort ASC";

if($result = mysqli_query($mysqli,$sql)){
	while($row = mysqli_fetch_assoc($result)){
		$sch_table[$row["in_out"]][$row["sort"]]=$row["name"];
	}
}

$sql =" SELECT id, ctime, genji,genji_kana FROM wp01_0cast";
$sql.=" WHERE (cast_status=99";
$sql.=$app;
$sql.=")";
$sql.=" AND del=0";
$sql.=" ORDER BY cast_sort ASC";
echo $sql;
if($result = mysqli_query($mysqli,$sql)){
	while($row = mysqli_fetch_assoc($result)){
		if (file_exists("../img/profile/{$row["id"]}/0.jpg")) {
			$row["face"]="../img/profile/{$row["id"]}/0.jpg";			

		}else{
			$row["face"]="../img/cast_no_image.jpg";			
		}
		$row["sch"]="休み";
		$cast_dat[$row["id"]]=$row;
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

.back_now{
	background	:#808000;
	color		:#fafafa;
}

.line_now{
	box-shadow	:3px 0 0 0 #808000 inset,-3px 0 0 0 #808000 inset;
}

.disabled{
	background	:#e0e0e0 !important;
	
}

.sche_ck{
	display:inline-flex;
	justify-content: space-between;
	width:280px;
}

.sche_ck_box:checked + label{
	background	:#0000d0;
}	

.sche_ck label{
	display		:inline-block;
	height		:30px;
	width		:50px;
	flex-basis	:50px;
	line-height	:30px;
	text-align	:center;
	background	:#cccccc;
	color		:#fafafa;
	font-size	:16px;
}

-->
</style>
<script>
$(function(){ 

	var Chg_s=[];
	var Chg_e=[];
	var Sch_d=[];

	$('.sche_reset').on('click',function(){	
		Tmp =$(this).attr("id").substr(3);
		for(var i=0;i<7;i++){
			$('#s_'+Tmp + "_" + i).val($('#hs_'+Tmp + "_" + i).val());
			$('#e_'+Tmp + "_" + i).val($('#he_'+Tmp + "_" + i).val());
		}
		$(this).parents().siblings('td').css('background','#fafafa');
	});

	$('.sche_submit').on('click',function(){	
		$(this).parents().siblings('td').css('background','#fafafa');

		Tmp =$(this).attr("id").substr(3);
		for(var i=0;i<7;i++){
			if(
				$('#s_'+Tmp + "_" + i).val() != $('#hs_'+Tmp + "_" + i).val() ||
				$('#e_'+Tmp + "_" + i).val() != $('#he_'+Tmp + "_" + i).val()
			){

				if($('#s_'+Tmp + "_" + i).val() == "休み"){
					$('#e_'+Tmp + "_" + i).val('');
				}

				$('#hs_'+Tmp + "_" + i).val($('#s_'+Tmp + "_" + i).val());
				$('#he_'+Tmp + "_" + i).val($('#e_'+Tmp + "_" + i).val());

				Chg_s[i]=$('#s_'+Tmp + "_" + i).val();		
				Chg_e[i]=$('#e_'+Tmp + "_" + i).val();		
				Sch_d[i]=$('#d_'+Tmp + "_" + i).val();		
			}
		}

		$.post({
			url:"./post/sch_chg.php",
			data:{
				'sch_d[]'	:Sch_d,
				'chg_s[]'	:Chg_s,
				'chg_e[]'	:Chg_e,
				'cast_id'	:Tmp,
			},

		}).done(function(data, textStatus, jqXHR){
			console.log(data);

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

	$('#sel_date,.sche_ck_box').on('change',function(){	
		$('#page').val('');
		$('#wform').submit();
	});

	$('#p_week').on('click',function(){	
		$('#page').val('p');
		$('#wform').submit();
	});

	$('#n_week').on('click',function(){	
		$('#page').val('n');
		$('#wform').submit();
	});
});
</script>
<header class="head">
<form id="wform" method="post">
<button id="p_week" type="button" class="sche_submit">翌週</button>
<input id="sel_date" type="date" name="ck_date" value="<?=$ck_date?>" class="w140">
<button id="n_week" type="button" class="sche_submit">翌週</button>
<input id="page" type="hidden" value="" name="page">
<input type="hidden" value="sche" name="menu_post">

<div class="sche_ck">
<input id="ck_b" type="checkbox" name="cl_b" class="sche_ck_box" value="1"<?if($cl_b==1){?> checked="checked"<?}?>><label for="ck_b" class="ck_label">通常</label>
<input id="ck_c" type="checkbox" name="cl_c" class="sche_ck_box" value="1"<?if($cl_c==1){?> checked="checked"<?}?>><label for="ck_c" class="ck_label">準備</label>
<input id="ck_d" type="checkbox" name="cl_d" class="sche_ck_box" value="1"<?if($cl_d==1){?> checked="checked"<?}?>><label for="ck_d" class="ck_label">休職</label>
<input id="ck_e" type="checkbox" name="cl_e" class="sche_ck_box" value="1"<?if($cl_e==1){?> checked="checked"<?}?>><label for="ck_e" class="ck_label">退職</label>
<input id="ck_f" type="checkbox" name="cl_f" class="sche_ck_box" value="1"<?if($cl_f==1){?> checked="checked"<?}?>><label for="ck_f" class="ck_label">停止</label>
</div>
</form>
</header>
<div class="wrap">
<div class="main_box">
<table>
	<tr>
		<td class="td_top" colspan="2">キャスト名</td>
		<?for($n=0;$n<7;$n++){?>
		<td class="td_top<?if($day_8 == date("Ymd",strtotime($st_day)+($n*86400))){ ?> back_now<? } ?>">
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

			<td class="td_inout w120<?if($day_8 == $tmp_day){ ?> line_now<? } ?> <?if($cast_dat[$a2["id"]]["ctime"] > $tmp_day){?> disabled<?}?>">
				<div class="box_inout">
					<span class="tag_inout">入</span>
					<select id ="s_<?=$a2["id"]?>_<?=$n?>" class="sel_inout" <?if($cast_dat[$a2["id"]]["ctime"] > $tmp_day){?> disabled<?}?>>
					<option value="休み" <?if($stime[$a2["id"]][$tmp_day]== "休み"){?> selected="selected"<?}?>>休み</option>
						<?foreach($sch_table["in"] as $b2){?>
							<option value="<?=$b2?>" <?if($b2 == $stime[$a2["id"]][$tmp_day]){?> selected="selected"<?}?>><?=$b2?></option>
						<?}?>
					</select>
					<input type="hidden" id="hs_<?=$a2["id"]?>_<?=$n?>" value="<?=$stime[$a2["id"]][$tmp_day]?>">
				</div>
				<div class="box_inout">
					<span class="tag_inout">退</span>
					<select id ="e_<?=$a2["id"]?>_<?=$n?>" class="sel_inout" <?if($cast_dat[$a2["id"]]["ctime"] > $tmp_day){?> disabled<?}?>>
						<option value="" <?if($stime[$a2["id"]][$tmp_day]== "休み"){?> selected="selected"<?}?>>　</option>
						<?foreach($sch_table["out"] as $b2){?>
							<option value="<?=$b2?>" <?if($b2 == $etime[$a2["id"]][$tmp_day]){?> selected="selected"<?}?>><?=$b2?></option>
						<?}?>
					</select>
					<input type="hidden" id="he_<?=$a2["id"]?>_<?=$n?>" value="<?=$etime[$a2["id"]][$tmp_day]?>">
				</div>
				<input type="hidden" id="d_<?=$a2["id"]?>_<?=$n?>" value="<?=$tmp_day?>">

			</td>
		<?}?>
	</tr>
<?}?>
</table>
</div>
</div>
<footer class="foot"></footer> 
