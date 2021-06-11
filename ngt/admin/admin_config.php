<?

$sql ="SELECT * FROM wp01_0check_main";
$sql.=" ORDER BY sort ASC";
if($result = mysqli_query($mysqli,$sql)){
	while($row = mysqli_fetch_assoc($result)){
		$c_main_dat[$row["id"]]=$row;
	}
}

$sql ="SELECT * FROM wp01_0config";
if($result = mysqli_query($mysqli,$sql)){
	while($row = mysqli_fetch_assoc($result)){
		$config[$row["config_key"]]=$row["config_value"];
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
$sql.=" WHERE del=0";
$sql.=" ORDER BY sort ASC";
if($result = mysqli_query($mysqli,$sql)){
	while($row = mysqli_fetch_assoc($result)){
		$charm_dat[$row["id"]]=$row;
	}
	if(is_array($charm_dat)){
		$max_charm=max(array_keys($charm_dat));
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

$sql ="SELECT * FROM wp01_0tag";
$sql.=" ORDER BY sort ASC";

if($result = mysqli_query($mysqli,$sql)){
	while($row = mysqli_fetch_assoc($result)){
		$tag_dat[$row["tag_group"]][$row["id"]]=$row;
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


	$('.option_flex').sortable({
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
			$(this).parents('.sel_flex').addClass('sel_ck_off');	
			$(this).siblings().addClass('sel_ck_off');	

		}else{
			$(this).parents('.sel_flex').removeClass('sel_ck_off');	
			$(this).siblings().removeClass('sel_ck_off');	
		}
	});

	$('.option_add').on('click',function(){
		Tmp=$(this).attr('id').replace("ad_","");
		Cnt = $("#no_" + Tmp + " > div").length;
		Cnt++;	
		Lst="<div class=\"sel_flex no_"+Tmp+"\"><span class=\"sel_move\"></span><input id=\"sel_"+ ids +"\" type=\"text\" name=\"sel[" + ids + "]\" class=\"sel_text\"><input id=\"sel_del" + ids + "\" type=\"checkbox\" name=\"del[" + ids + "]\" class=\"sel_ck\" value=\"0\"><label for=\"sel_del" + ids + "\" class=\"sel_del\">×</label><input type=\"hidden\" name=\"sort[<?=$b1?>]\" value=\"" + Cnt + "\" class=\"sel_hidden\"></div>";
		$('#no_'+Tmp).append(Lst);
	});

	$('#prof_set').on('click',function() {
		if($('#prof_name_new').val()==''){
			alert('プロフィール名がありません');
			return false;
		}else{
			$('#new_set').submit()
		}
	});

	$('#prof').on('click','.view_btn',function() {
		if($(this).hasClass('bg1')){
			$(this).parent().parent('.tr').find('.bg1').addClass('bg0').removeClass('bg1');	

		}else if($(this).hasClass('bg0')){
			$(this).parent().parent('.tr').find('.bg0').addClass('bg1').removeClass('bg0');	
		}
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
			<option value="1" <?if($start_time=="1"){?> selected="selected"<?}?>>01時</option>
			<option value="2" <?if($start_time=="2"){?> selected="selected"<?}?>>02時</option>
			<option value="3" <?if($start_time=="3"){?> selected="selected"<?}?>>03時</option>
			<option value="4" <?if($start_time=="4"){?> selected="selected"<?}?>>04時</option>
			<option value="5" <?if($start_time=v"5"){?> selected="selected"<?}?>>05時</option>
			<option value="6" <?if($start_time=="6"){?> selected="selected"<?}?>>06時</option>
			<option value="7" <?if($start_time=="7"){?> selected="selected"<?}?>>07時</option>
			<option value="8" <?if($start_time=="8"){?> selected="selected"<?}?>>08時</option>
			<option value="9" <?if($start_time=="9"){?> selected="selected"<?}?>>09時</option>
			<option value="10" <?if($start_time=="10"){?> selected="selected"<?}?>>10時</option>
			<option value="11" <?if($start_time=="11"){?> selected="selected"<?}?>>11時</option>
			<option value="12" <?if($start_time=="12"){?> selected="selected"<?}?>>12時</option>
			<option value="13" <?if($start_time=="13"){?> selected="selected"<?}?>>13時</option>
			<option value="14" <?if($start_time=="14"){?> selected="selected"<?}?>>14時</option>
			<option value="15" <?if($start_time=="15"){?> selected="selected"<?}?>>15時</option>
			<option value="16" <?if($start_time=="16"){?> selected="selected"<?}?>>16時</option>
			<option value="17" <?if($start_time=="17"){?> selected="selected"<?}?>>17時</option>
			<option value="18" <?if($start_time=="18"){?> selected="selected"<?}?>>18時</option>
			<option value="19" <?if($start_time=="19"){?> selected="selected"<?}?>>19時</option>
			<option value="20" <?if($start_time=="20"){?> selected="selected"<?}?>>20時</option>
			<option value="21" <?if($start_time=="21"){?> selected="selected"<?}?>>21時</option>
			<option value="22" <?if($start_time=="22"){?> selected="selected"<?}?>>22時</option>
			<option value="23" <?if($start_time=="23"){?> selected="selected"<?}?>>23時</option>
			</select>
		</td>
		<td class="config_sche_top" style="width:120px;">開始曜日</td>
		<td class="config_sche_list">
			<select name="set_week" class="set_box">
			<option value="0">日曜日</option>
			<option value="1" <?if($start_week=="1"){?> selected="selected"<?}?>>月曜日</option>
			<option value="2" <?if($start_week=="2"){?> selected="selected"<?}?>>火曜日</option>
			<option value="3" <?if($start_week=="3"){?> selected="selected"<?}?>>水曜日</option>
			<option value="4" <?if($start_week=="4"){?> selected="selected"<?}?>>木曜日</option>
			<option value="5" <?if($start_week=="5"){?> selected="selected"<?}?>>金曜日</option>
			<option value="6" <?if($start_week=="6"){?> selected="selected"<?}?>>土曜日</option>
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

<div class="config_title">リボン</div>
<table class="config_sche">	
	<tr>
		<td class="config_sche_top"></td>
		<td class="config_sche_top">入店前</td>
		<td class=""><?=$config["comming_soon"]?></td>
	</tr>
	<tr>
		<td class="config_sche_top"></td>
		<td class="config_sche_top">入店日</td>
		<td class=""><?=$config["today_commer"]?></td>
	</tr>
	<tr>
		<td class="config_sche_top"></td>
		<td class="config_sche_top">新人期間</td>
		<td class=""><input type="text" name="new_commer_cnt" class="set_box" value="<?=$config["new_commer_cnt"]?>"></td>
	</tr>

<?foreach($table_sort as $a1 => $a2){?>
<?}?>
</table>



<div class="config_title">ニュース</div>
<table class="config_sche">	
<thead>
	<tr>
		<td class="config_sche_top">替</td>
		<td class="config_sche_top">順番</td>
		<td class="config_sche_top">名前</td>
		<td class="config_sche_top">スタイル</td>
		<td class="config_sche_top"></td>
	</tr>
</thead>
<tbody id="news">
<?foreach($tag_dat["news"] as $a1 => $a2){?>

	<tr id="tr_n_<?=$a1?>" class="tr">
		<input type="hidden" value="<?=$a2["view"]?>" name="prof_view">

		<td class="config_prof_handle bg<?=$a2["view"]?>"></td>
		<td class="config_prof_sort bg<?=$a2["view"]?>"><input type="textbox" value="<?=$a2["sort"]?>" class="prof_sort" disabled></td>

		<td class="config_prof_name bg<?=$a2["view"]?>"><input type="text" name="news_name[<?=$a1?>]" value="<?=$a2["tag_name"]?>" class="prof_name bg<?=$a2["view"]?>"></td>
		<td class="config_prof_style bg<?=$a2["view"]?>"><input type="text" name="news_icon[<?=$a1?>]" value="<?=$a2["tag_icon"]?>" class="prof_name bg<?=$a2["view"]?>"></td>
		<td class="config_prof_style bg<?=$a2["view"]?>">
			<button type="button" class="prof_btn view_btn bg<?=$a2["view"]?>">非表示</button>
			<button type="button" class="prof_btn del_btn  bg<?=$a2["view"]?>">削除</button>
		</td>
	</tr>
<? } ?>
</tbody>
</table>

<table class="config_sche">
	<tr>
	<form id="new_set" action="" method="post">
	<input type="hidden" name="menu_post" value="config">
	<input type="hidden" value="<?=$max_charm+1?>" name="prof_sort_new">
		<td style="width:71px; background:#ffe0f0;text-align:center;font-weight:600;color:#900000;" colspan="2">追加</td>
		<td class="config_prof_name" style=" background:#ffe0f0"><input id="prof_name_new" type="text" name="prof_name_new" value="" class="prof_name"></td>
		<td class="config_prof_style" style=" background:#ffe0f0"><input type="text" name="news_icon_new" value="<?=$a2["tag_icon"]?>" class="prof_name bg<?=$a2["view"]?>"></td>
	</form>
		<td class="config_prof_style" style=" background:#ffe0f0">
			<button id="prof_set" type="submit" class="prof_btn">追加</button>
		</td>
	</tr>
</table>


<div class="config_title">インセンティブ</div>
<table class="config_sche">	
<?foreach($table_sort as $a1 => $a2){?>
	<tr>
		<td class="config_sche_top"></td>
		<td class="config_sche_top">新人期間</td>
		<td class=""></td>
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
		<td class="config_sche_top"></td>
	</tr>
</thead>
<tbody id="prof">
<?foreach($charm_dat as $a1 => $a2){?>
	<tr id="tr_<?=$a1?>" class="tr">
		<input type="hidden" value="<?=$a2["view"]?>" name="prof_view">
		<td class="config_prof_handle bg<?=$a2["view"]?>"></td>
		<td class="config_prof_sort bg<?=$a2["view"]?>"><input type="textbox" value="<?=$a2["sort"]?>" class="prof_sort" disabled></td>
		<td class="config_prof_name bg<?=$a2["view"]?>"><input type="text" name="prof_name[<?=$a1?>]" value="<?=$a2["charm"]?>" class="prof_name bg<?=$a2["view"]?>"></td>
		<td class="config_prof_style bg<?=$a2["view"]?>">
			<select name="prof_style[<?=$a1?>]" class="prof_option bg<?=$a2["view"]?>">
				<option value="0">コメント</option>
				<option value="1" <?if($a2["style"]== 1){?>selected="selected"<?}?>>文章</option>
			</select>
		</td>
		<td class="config_prof_style bg<?=$a2["view"]?>">
			<button type="button" class="prof_btn view_btn bg<?=$a2["view"]?>">非表示</button>
			<button type="button" class="prof_btn del_btn  bg<?=$a2["view"]?>">削除</button>
		</td>
	</tr>
<? } ?>
</tbody>
</table>

<table class="config_sche">
	<tr>
	<form id="new_set" action="" method="post">
	<input type="hidden" name="menu_post" value="config">
	<input type="hidden" value="<?=$max_charm+1?>" name="prof_sort_new">
		<td style="width:71px; background:#ffe0f0;text-align:center;font-weight:600;color:#900000;" colspan="2">追加</td>
		<td class="config_prof_name" style=" background:#ffe0f0"><input id="prof_name_new" type="text" name="prof_name_new" value="" class="prof_name"></td>
		<td class="config_prof_style" style=" background:#ffe0f0">
			<select name="prof_style_new" class="prof_option">
				<option value="0">コメント</option>
				<option value="1">文章</option>
			</select>
		</td>
	</form>
		<td class="config_prof_style" style=" background:#ffe0f0">
			<button id="prof_set" type="submit" class="prof_btn">追加</button>
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
				<option value="1"<?if($a2["style"] == 1){?> selected="selected"<?}?>>非表示</option>
			</select>
			<span id="ad_<?=$a1?>" class="option_add">＋項目追加</span>
			<span id="dl_<?=$a1?>" class="option_del">×オプション削除</span>
			</td>
		</tr>
		<tr>
			<td id="no_<?=$a1?>" class="option_flex">
				<?foreach($c_list_dat[$a1] as $b1 => $b2){?>
				<?$u++?>
				<div id="item_<?=$a1?>_<?=$b1?>" class="sel_flex no_<?=$a1?>">
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
