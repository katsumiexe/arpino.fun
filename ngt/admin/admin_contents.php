<?

$sel_id			=$_POST["sel_id"];
$post_id		=$_POST["post_id"];

if(!$post_id) $post_id="event";

$sql	 ="SELECT * FROM wp01_0contents";
$sql	.=" WHERE page={$post_id}";
$sql	.=" ORDER BY id DESC";

if($result = mysqli_query($mysqli,$sql)){
	while($res = mysqli_fetch_assoc($result)){
		$dat[$res["id"]]=$res;

		if($res["id"] == "$sel_id"){
			$dat_sel=$res;
		}
	}

	if(is_array($dat)){
		$dat_count=count($dat);
	}
}

if($post_id == "news"){
	$sql	 ="SELECT * FROM wp01_0tag";
	$sql	.=" WHERE tag_group='{$post_id}'";
	$sql	.=" ORDER BY sort ASC";

	if($result = mysqli_query($mysqli,$sql)){
		while($res = mysqli_fetch_assoc($result)){
			$tag[]=$res;
		}

		if(is_array($tag)){
			$tag_count=count($tag);
		}
	}

	$sql	 ="SELECT * FROM wp01_0tag";
	$sql	.=" WHERE tag_group='news'";
	$sql	.=" AND del=0";
	$sql	.=" ORDER BY sort ASC";

	if($result = mysqli_query($mysqli,$sql)){
		while($row = mysqli_fetch_assoc($result)){
			$tag[]=$row;
			$count_tag++;
		}
	}
}

?>
<style>
<!--

.sel_contents{
	display			:inline-block;
	background		:#bbbbbb;
	width			:150px;
	height			:30px;
	line-height		:30px;
	margin			:5px;
	border-radius	:5px;
	color			:#fafafa;
	font-size		:18px;
	font-weight		:600;
	text-align		:center;
}

.sel_ck{
	background		:linear-gradient(#ff0000,#d00000);
}

.main_box{
	display:inline-block;
	flex-basis:800px;
	background:#e0e000;
	min-height:calc(100vh - 80px);
}

.sub_box{
	display:inline-block;
	flex-basis:400px;
	background:#008040;
	min-height:calc(100vh - 80px);
}

-->
</style>
<script>
$(function(){ 
//	$('#e_yy, #t_yy').datetimepicker();

	$('.sel_contents').on('click',function(){
		Tmp=$(this).attr('id');
		$('#sel_ck').val(Tmp);
		$('#form').submit();
	});

});
</script>
<header class="head">
<div id="event" class="sel_contents <?if($post_id == "event"){?> sel_ck<?}?>">イベント</div>
<div id="news" class="sel_contents <?if($post_id == "news"){?> sel_ck<?}?>">NEWS</div>
<div id="info" class="sel_contents <?if($post_id == "info"){?> sel_ck<?}?>">お知らせ</div>
<div id="system" class="sel_contents <?if($post_id == "system"){?> sel_ck<?}?>">SYSTEM</div>
<div id="access" class="sel_contents <?if($post_id == "access"){?> sel_ck<?}?>">ACCESS</div>
<div id="recruit" class="sel_contents <?if($post_id == "recruit"){?> sel_ck<?}?>">RECRUIT</div>

<form id="form" method="post">
	<input id="sel_ck" type="hidden" name="post_id">
	<input type="hidden" name="menu_post" value="contents">
</form>
</header>

<div class="wrap">
	<?if($post_id == "news"){?>
		<div class="main_box">
			<table>
				<tr>
					<td>
						<span class="tag">表示時間</span>
						<input type="text" id="t_yy" name="b_yy" class="w60" value="" autocomplete="off"> 
					</td>

					<td>
						<select name="tag">
							<?for($n=0;$n<$tag_count;$n++){?>
								<option value="<?=$tag[$n]["id"]?>"><?=$tag[$n]["tag_name"]?></option>
							<? } ?>	
						</select>
					</td>
				</tr>
				<tr>
					<td>
						<span class="tag">タイトル</span>
						<input type="text" name="event_title" value="<?=$dat_sel["title"]?>"> 
					</td>
					<td>
						<span class="tag">URL</span>
						<input type="text" name="event_url" value="<?=$dat_sel["contents_url"]?>"> 
					</td>
				</tr>
				<tr>
					<td>
						<textarea class="textarea"><?=$dat_sel["contents"]?></textarea>
					</td>
				</tr>
			</table>
		</div>
			<div class="sub_box">
				<?forech($tag as $a1 => $a2){?>

					<div class="yser_box">
					<input id="rd<?=$a1?>"  type="radio" style="display:inline-block;">
					<lebel for="rd<?=$a1?>">
					</div>
				<?}?>



 
	<?}elseif($post_id == "event"){?>
		<div class="main_box">
			<table>
				<tr>
					<td>
						<span class="tag">表示時間</span>
						<input type="text" id="t_yy" name="b_yy" class="w60" value="" autocomplete="off"> 
					</td>

					<td>
						<span class="tag">イベント時間</span>
						<input type="text" id="e_yy" name="b_yy" class="w60" value="" autocomplete="off"> 
					</td>

					<td>
						<span class="tag">タグ</span>
						<select name="tag">
							<?for($n=0;$n<$tag_count;$n++){?>
								<option value="<?=$tag[$n]["id"]?>"><?=$tag[$n]["tag_name"]?></option>
							<? } ?>	
						</select>
					</td>
				</tr>
				<tr>
					<td>
						<span class="tag">タイトル</span>
						<input type="text" name="event_title" value="<?=$dat_sel["title"]?>"> 
					</td>

					<td>
						<span class="tag">URL</span>
						<input type="text" name="event_url" value="<?=$dat_sel["contents_url"]?>"> 
					</td>

					<td>
						<span class="tag">Key</span>
						<input type="text" name="event_key" value="<?=$dat_sel["contents_key"]?>"> 
					</td>
				</tr>
				<tr>
					<td>
						<textarea class="textarea"><?=$dat_sel["contents"]?></textarea>
					</td>
				</tr>
			</table>
		</div>

		<div class="sub_box">
			<?foreach($dat as $a1 => $a2){?>
				<table>
					<tr>
						<Td><?=$a2["display_daye"]?></td>
						<Td></td>
					</tr>
					<tr>
						<td colspan="2"><?=$a2["title"]?></td>
					</tr>
					<tr>
						<td colspan="2"><?=$a2["contents"]?></td>
					</tr>
				</table>
			<? } ?>
		</div>
	<? } ?>


</div>
<footer class="foot"></footer>
