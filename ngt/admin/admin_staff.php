<?
$sql	 ="SELECT id,staff_id,genji,genji_kana, cast_sort, ctime, cast_id,cast_status,name,kana FROM wp01_0staff AS S";
$sql	.=" LEFT JOIN wp01_0cast AS C ON S.staff_id=C.id";
$sql	.=" WHERE S.del=0";
$sql	.=" ORDER BY cast_sort ASC";

if($result = mysqli_query($mysqli,$sql)){
	while($res = mysqli_fetch_assoc($result)){
		if (file_exists("../img/profile/{$res["id"]}/0.webp")) {
			$res["face"]="../img/profile/{$res["id"]}/0.webp";			

		}elseif (file_exists("../img/profile/{$res["id"]}/0.jpg")) {
			$res["face"]="../img/profile/{$res["id"]}/0.jpg";			

		}else{
			$res["face"]="../img/cast_no_image.jpg";			
		}
		$dat[]=$res;
	}
	if(is_array($dat)){
		$count_dat=count($dat);
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
	background	:#fafafa;
	border:1px solid #303030;

}

#sel_staff,#sel_cast{
	display:none;
}

#staff_l{
	border-radius:10px 0 0 10px;
}

#cast_l{
	border-radius:0 10px 10px 0;
}

.c_s_box{
	display				:inline-block;
	height				:30px;
	line-height			:30px;
	width				:180px;
	font-size			:0;
	color				:#fafafa;
	text-align			:left;
	margin 0 50px;
}

.c_s_btn{
	display				: inline-block;
	height				:30px;
	line-height			:30px;
	width				:80px;
	font-size			:16px;
	text-align			:center;
	background			:#cccccc;
	color				:#fafafa;
}

.on_1{
	background:#0000c0;
}

.on_2{
	background:#c00000;
}

.ck_off:checked + label{
	background		:linear-gradient(#c0c0f0,#8080ff);
}


.sel_status{
	display			:inline-block;
	background		:#d0d0d0;
	width			:80px;
	height			:30px;
	line-height		:30px;
	margin			:5px;
	border-radius	:5px;
	color			:#fafafa;
	font-size		:18px;
	font-weight		:600;
	text-align		:center;
}

input[type=checkbox]:checked + label{
	background		:linear-gradient(#c0c0f0,#8080ff);
}


.table_title{
	background		:linear-gradient(#e0e0e0,#d0d0d0);
	padding			:5px;
	font-size		:14px;
}


.icon{
	font-family:at_icon;
}

.box_sort{
	width		:40px;
	text-align	:right;
	padding		:5px;
}
-->
</style>
<script>
$(function(){ 
	$('#staff_l').on('click',function () {
		$(this).addClass('on_1');
		$('#cast_l').removeClass('on_2');
		$('.cast_table').fadeOut(100);
	});

	$('#cast_l').on('click',function () {
		$(this).addClass('on_2');
		$('#staff_l').removeClass('on_1');
		$('.cast_table').fadeIn(100);
	});

	$('#sort').sortable({
		axis: 'y',
        handle: '.td_sort',
		stop : function(){
			ChgList=$(this).sortable("toArray");
			console.log(ChgList);
			var Cnt = 1;
			$(this).children('.tr').each(function(){
				$(this).children('.w40').children('.box_sort').val(Cnt);
				Cnt++;
			});

			$.ajax({
				url:'./post/admin_staff_sort.php',
				type: 'post',
				data:{
					'list[]':ChgList,
				},
				dataType: 'json',

			}).done(function(data, textStatus, jqXHR){
		
			});
		}
	});
});

</script>
<header class="head">
<h2 class="head_ttl">スタッフ一覧</h2>
<input id="sel_staff" value="1" type="radio" name="c_s"><label id="staff_l" for="staff" class="c_s_btn">STAFF</label>
<input id="sel_cast" value="2" type="radio" name="c_s" checked="checked"><label id="cast_l" for="cast" class="c_s_btn on_2">CAST</label>

<input id="sel_staff" value="1" type="radio" name="c_s"><label id="label_staff" for="sel_staff" class="c_s_btn">STAFF</label>
<input id="sel_cast" value="2" type="radio" name="c_s" checked="checked"><label id="label_cast" for="sel_cast" class="c_s_btn on_2">CAST</label>

<input id="sel_sort" value="1" type="radio" name="sort"><label id="label_sort" for="sel_sort" class="c_s_btn">昇順</label>
<input id="sel_ksort" value="2" type="radio" name="sort" checked="checked"><label id="label_ksort" for="sel_ksort" class="c_s_btn on_2">降順</label>
<input id="sel_status_0" value="1" type="checkbox" name="sel_status_0"><label id="label_status_0" for="sel_status_0" class="sel_status">通常</label>
<input id="sel_status_1" value="1" type="checkbox" name="sel_status_1"><label id="label_status_1" for="sel_status_1" class="sel_status">準備</label>
<input id="sel_status_2" value="1" type="checkbox" name="sel_status_2"><label id="label_status_2" for="sel_status_2" class="sel_status">休職</label>
<input id="sel_status_3" value="1" type="checkbox" name="sel_status_3"><label id="label_status_3" for="sel_status_3" class="sel_status">退職</label>
<input id="sel_status_4" value="1" type="checkbox" name="sel_status_4"><label id="label_status_4" for="sel_status_4" class="sel_status">停止</label>
</header>
<div class="wrap">
<div class="main_box">
<table>
<thead>
<tr>
<td class="td_top">替</td>
<td class="td_top">順</td>
<td class="td_top"></td>
<td class="td_top">源氏名[フリガナ]</td>
<td class="td_top">ID</td>
<td class="td_top">登録日</td>
<td class="td_top">状態</td>
<td class="td_top">変更</td>
</tr>
</thead>
<tbody id="sort">
<?for($n=0;$n<$count_dat;$n++){?>
<tr id="tr_<?=$dat[$n]["staff_id"]?>" class="tr">
<td class="td_sort">■</td>
<td class="w40"><input type="text" value="<?=$dat[$n]["cast_sort"]?>" class="box_sort" disabled></td>
<td class="w60"><img src="<?=$dat[$n]["face"]?>?t=<?=time()?>" style="width:60px; height:80px;"></td>
<td class="w200"><?=$dat[$n]["genji"]?><br>[<?=$dat[$n]["genji_kana"]?>]</td>
<td class="w100"><?=$dat[$n]["cast_id"]?></td>
<td class="w100"><?=$dat[$n]["ctime"]?></td>
<td class="w100"><?=$cast_status_select[$dat[$n]["cast_status"]]?></td>

<td class="w60" style="position:relative;">
	<form method="post">
		<button type="submit" class="staff_submit">変更</button>
		<input type="hidden" value="staff_fix" name="menu_post">
		<input type="hidden" name="staff_id" value="<?=$dat[$n]["staff_id"]?>">
	</form>
</td>
</tr>
<?}?>
</tbody>
</table>
<footer class="foot"></footer> 

