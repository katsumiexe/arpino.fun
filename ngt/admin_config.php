<?
$sql ="SELECT * FROM wp01_0check_main";
$sql.=" ORDER BY sort ASC";

if($result = mysqli_query($mysqli,$sql)){
	while($row = mysqli_fetch_assoc($result)){
		$c_main_dat[$row["id"]]=$row;
	}
}

$sql ="SELECT * FROM wp01_0check_list";
$sql.=" ORDER BY host_id ASC, list_sort ASC";

if($result = mysqli_query($mysqli,$sql)){
	while($row = mysqli_fetch_assoc($result)){
		$c_list_dat[$row["host_id"]][$row["id"]]=$row;
		$count_list++;
	}
}

$sql ="SELECT * FROM wp01_0charm_table";
$sql.=" ORDER BY sort ASC";

if($result = mysqli_query($mysqli,$sql)){
	while($row = mysqli_fetch_assoc($result)){
		$charm_dat[$row["id"]]=$row;
	}
}

$sql ="SELECT * FROM wp01_0sch_table";
$sql.=" ORDER BY sort ASC";
if($result = mysqli_query($mysqli,$sql)){
	while($row = mysqli_fetch_assoc($result)){
		$table_sort[$row["sort"]]=1;
		$table_id[$row["in_out"]][$row["sort"]]	=$row["id"];
		$table_dat[$row["id"]]=$row;
	}
}

?>
<script>
ids='<?=$count_list+1?>';
$(function(){ 
	$('.prof_sort').on('change',function(){
		Tmp=$(this).parent('.plof_list').attr('id').replace('prof_b','');
		Tmp2=$(this).val();
		$('#prof_b'+Tmp2).children('.prof_sort').val(Tmp);
		$('#prof_b'+Tmp2).css('order',Tmp);
		$('#prof_b'+Tmp).css('order',Tmp2);
	});

	$('#prof').sortable({
		axis: 'y',
        handle: '.config_prof_handle',

		stop : function(){
			var Cnt = 1;
			$(this).children('.tr').each(function(){
				$(this).children('.config_prof_sort').children('.prof_sort').val(Cnt);
				Cnt++;
			});
		},
	});


	$('.sel_flex').sortable({
		containment: 'parent',
		handle: '.sel_move',
		stop : function(){
			Tmp=$(this).attr('id');

			var Cnt = 1;
			$('.'+Tmp).each(function(){
				$(this).children('.sel_hidden').val(Cnt);
				Cnt++;
			});
		}
	});

	$('.main_box').on('change','.sel_ck',function() {
		if($(this).prop('checked')){
			$(this).parents('.sel_block').addClass('sel_ck_off');	
			$(this).siblings().addClass('sel_ck_off');	

		}else{
			$(this).parents('.sel_block').removeClass('sel_ck_off');	
			$(this).siblings().removeClass('sel_ck_off');	
		}
	});

	$('.sel_count').on('click',function(){
		ids++;
		Tmp=$(this).attr('id').replace("ad_","");
		Cnt = $("#no_" + Tmp + " > div").length;
		Cnt++;	
		Lst="<div class=\"sel_block no_"+Tmp+"\"><span class=\"sel_move\"></span><input id=\"sel_"+ ids +"\" type=\"text\" name=\"sel[" + ids + "]\" class=\"sel_text\"><input id=\"sel_del" + ids + "\" type=\"checkbox\" name=\"del[" + ids + "]\" class=\"sel_ck\" value=\"0\"><label for=\"sel_del" + ids + "\" class=\"sel_del\">×</label><input type=\"hidden\" name=\"sort[<?=$b1?>]\" value=\"" + Cnt + "\" class=\"sel_hidden\"></div>";
		$('#no_'+Tmp).append(Lst);
	});
});
</script>
<style>
.sel_ck_off{
	background		:linear-gradient(#e0e0e0,#d0d0d0);
	color			:#a0a0a0;
}

</style>
<header class="head">
</header>
<div class="wrap">
<div class="main_box">

<div class="config_title">カレンダースタート</div>

<table class="config_sche">	
	<tr>
		<td class="config_sche_top" style="width:120px;">開始時間</td>
		<td class="config_sche_list">
			<select name="set_time" class="set_box">
			<option value="0">24時</option>
			<option value="1" <?if($start_time="1"){?> selected="selected"<?}?>>01時</option>
			<option value="2" <?if($start_time="2"){?> selected="selected"<?}?>>02時</option>
			<option value="3" <?if($start_time="3"){?> selected="selected"<?}?>>03時</option>
			<option value="4" <?if($start_time="4"){?> selected="selected"<?}?>>04時</option>
			<option value="5" <?if($start_time="5"){?> selected="selected"<?}?>>05時</option>
			<option value="6" <?if($start_time="6"){?> selected="selected"<?}?>>06時</option>
			<option value="7" <?if($start_time="1"){?> selected="selected"<?}?>>07時</option>
			<option value="8" <?if($start_time="2"){?> selected="selected"<?}?>>08時</option>
			<option value="9" <?if($start_time="3"){?> selected="selected"<?}?>>09時</option>
			<option value="10" <?if($start_time="4"){?> selected="selected"<?}?>>10時</option>
			<option value="11" <?if($start_time="5"){?> selected="selected"<?}?>>11時</option>
			<option value="12" <?if($start_time="6"){?> selected="selected"<?}?>>12時</option>
			<option value="13" <?if($start_time="1"){?> selected="selected"<?}?>>13時</option>
			<option value="14" <?if($start_time="2"){?> selected="selected"<?}?>>14時</option>
			<option value="15" <?if($start_time="3"){?> selected="selected"<?}?>>15時</option>
			<option value="16" <?if($start_time="4"){?> selected="selected"<?}?>>16時</option>
			<option value="17" <?if($start_time="5"){?> selected="selected"<?}?>>17時</option>
			<option value="18" <?if($start_time="6"){?> selected="selected"<?}?>>18時</option>
			<option value="19" <?if($start_time="1"){?> selected="selected"<?}?>>19時</option>
			<option value="20" <?if($start_time="2"){?> selected="selected"<?}?>>20時</option>
			<option value="21" <?if($start_time="3"){?> selected="selected"<?}?>>21時</option>
			<option value="22" <?if($start_time="4"){?> selected="selected"<?}?>>22時</option>
			<option value="23" <?if($start_time="5"){?> selected="selected"<?}?>>23時</option>
			</select>
		</td>
		<td class="config_sche_top" style="width:120px;">開始曜日</td>
		<td class="config_sche_list">
			<select name="set_week" class="set_box">
			<option value="0">日曜日</option>
			<option value="1" <?if($start_week="1"){?> selected="selected"<?}?>>月曜日</option>
			<option value="2" <?if($start_week="2"){?> selected="selected"<?}?>>火曜日</option>
			<option value="3" <?if($start_week="3"){?> selected="selected"<?}?>>水曜日</option>
			<option value="4" <?if($start_week="4"){?> selected="selected"<?}?>>木曜日</option>
			<option value="5" <?if($start_week="5"){?> selected="selected"<?}?>>金曜日</option>
			<option value="6" <?if($start_week="6"){?> selected="selected"<?}?>>土曜日</option>
			</select>
		</td>
	</tr>
</table>


<div class="config_title">スケジュール</div>
<table class="config_sche">	
	<tr>
		<td colspan="2" class="config_sche_top">IN</td>
		<td colspan="2" class="config_sche_top">OUT</td>
	</tr>
	<tr>
		<td class="config_sche_top">表示</td>
		<td class="config_sche_top">時間</td>
		<td class="config_sche_top">表示</td>
		<td class="config_sche_top">時間</td>
	</tr>
<?foreach($table_sort as $a1 => $a2){?>
<tr>
<td class="config_sche_list"><input type="text" name="in_name[<?=$a1?>]" class="set_box" value="<?=$table_dat[$table_id["in"][$a1]]["name"]?>"></td>
<td class="config_sche_list"><input type="text" name="in_time[<?=$a1?>]" class="set_box" value="<?=$table_dat[$table_id["in"][$a1]]["time"]?>"></td>
<td class="config_sche_list"><input type="text" name="out_name[<?=$a1?>]" class="set_box" value="<?=$table_dat[$table_id["out"][$a1]]["name"]?>"></td>
<td class="config_sche_list"><input type="text" name="out_time[<?=$a1?>]" class="set_box" value="<?=$table_dat[$table_id["out"][$a1]]["time"]?>"></td>
</tr>
<?}?>
</table>

<div class="config_title">プロフィール</div>
	
<table class="config_sche">
<thead>
	<tr>
		<td class="config_sche_top">替</td>
		<td class="config_sche_top">順番</td>
		<td class="config_sche_top">名前</td>
		<td class="config_sche_top">スタイル</td>
		<td class="config_sche_top">削除</td>
	</tr>
</thead>
<tbody id="prof">
<?foreach($charm_dat as $a1 => $a2){?>
	<tr id="tr_<?=$a1?>" class="tr">
		<td class="config_prof_handle"></td>

		<td class="config_prof_sort"><input type="textbox" value="<?=$a2["sort"]?>" class="prof_sort" disabled></td>
		<td class="config_prof_name"><input type="text" name="prof_name[<?=$a1?>]" value="<?=$a2["charm"]?>" class="prof_name"></td>
		<td class="config_prof_style">
			<select name="prof_style[<?=$a1?>]" class="prof_option">
				<option value="0">コメント</option>
				<option value="1" <?if($a2["style"]== 1){?>selected="selected"<?}?>>文章</option>
			</select>
		</td>
		<td class="config_prof_sort">
		</td>
	</tr>
<? } ?>
</tbody>
	<tr>
		<td style="border-bottom:none;border-left:none;"></td>
		<td class="config_prof_sort"><input type="textbox" value="<?=$a2["sort"]+1?>" class="prof_sort" disabled></td>
		<td class="config_prof_name"><input type="text" name="prof_name_new" value="" class="prof_name"></td>
		<td class="config_prof_style">
			<select name="prof_style_new" class="prof_option">
				<option value="0">コメント</option>
				<option value="1">文章</option>
			</select>
		</td>
		<td class="config_prof_sort">
		</td>
	</tr>
</table>

<div class="config_title">オプション</div>
<?foreach($c_main_dat as $a1 => $a2){?>
	<table class="option_table">
		<tr>
			<td class="option_top">
			<input id="sel_ttl_<?=$a1?>" type="text" name="" value="<?=$a2["title"]?>" class="option_ttl">
			<span class="option_tag">未選択</span>
			<select class="option_select">
				<option value="0">表示</option>
				<option value="1">非表示</option>
			</select>
			<span id="ad_<?=$a1?>" class="option_add">＋項目追加</span>
			<span id="dl_<?=$a1?>" class="option_del">×オプション削除</span>
			</td>
		</tr>
		<tr>
			<td id="no_<?=$a1?>" class="option_flex">
				<?foreach($c_list_dat[$a1] as $b1 => $b2){?>
				<?$u++?>
				<div id="item_<?=$a1?>_<?=$b1?>" class="sel_block no_<?=$a1?>">
					<span class="sel_move"></span>
					<input id="sel_<?=$b1?>" type="text" name="sel[<?=$b1?>]" value="<?=$b2["list_title"]?>" class="sel_text">
					<input id="sel_del<?=$b1?>" type="checkbox" name="del[<?=$b1?>]" class="sel_ck" value="0">
					<label for="sel_del<?=$b1?>" class="sel_del">×</label>
					<input type="hidden" name="sort[<?=$b1?>]" value="<?=$u?>" class="sel_hidden">
				</div>
				<? } ?>
				<?$u=0?>
			</td>
		</tr>
	</table>
<? } ?>
</div>
</div>
<footer class="foot"></footer> 
