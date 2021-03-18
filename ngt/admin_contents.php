<?

$sel_id	=$_POST["sel_id"];
$post_id=$_POST["post_id"];

if(!$post_id) $post_id="event";

$sql	 ="SELECT * FROM wp01_0contents";
$sql	.=" WHERE page={$post_id}";
$sql	.=" ORDER BY id DESC";
if($result = mysqli_query($mysqli,$sql)){
	while($res = mysqli_fetch_assoc($result)){
		$dat[$res["id"]]=$res;
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
			$tag_count=count($dat);
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

input[type=radio]:checked + label{
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
	$('#e_yy, #t_yy').datetimepicker();
});
</script>
<header class="head">
<input id="sel_contents_0" value="event" type="radio" name="sel_contents" <?if($post_id=="event"){?>checked="checked"<?}?>><label id="label_contents_0" for="sel_contents_0" class="sel_contents">イベント</label>
<input id="sel_contents_1" value="news" type="radio" name="sel_contents" <?if($post_id=="news"){?>checked="checked"<?}?>><label id="label_contents_1" for="sel_contents_1" class="sel_contents">NEWS</label>
<input id="sel_contents_2" value="info" type="radio" name="sel_contents" <?if($post_id=="info"){?>checked="checked"<?}?>><label id="label_contents_2" for="sel_contents_2" class="sel_contents">お知らせ</label>
<input id="sel_contents_3" value="system" type="radio" name="sel_contents" <?if($post_id=="system"){?>checked="checked"<?}?>><label id="label_contents_3" for="sel_contents_3" class="sel_contents">SYSTEM</label>
<input id="sel_contents_4" value="access" type="radio" name="sel_contents" <?if($post_id=="access"){?>checked="checked"<?}?>><label id="label_contents_4" for="sel_contents_4" class="sel_contents">ACCESS</label>
<input id="sel_contents_5" value="recruit" type="radio" name="sel_contents" <?if($post_id=="recruit"){?>checked="checked"<?}?>><label id="label_contents_5" for="sel_contents_5" class="sel_contents">RECRUIT</label>
</header>

<div class="wrap">
	<div class="main_box">
	<span class="tag">表示時間</span>
	<input type="text" id="t_yy" name="b_yy" class="w60" value="" autocomplete="off"> 

	<span class="tag">イベント時間</span>
	<input type="text" id="e_yy" name="b_yy" class="w60" value="" autocomplete="off"> 

	<span class="tag">タイトル</span>
	<input type="text" name="title" value="<?=$dat["sel_id"]["title"]?>"> 

	<span class="tag">タグ</span>
	<select name="tag">
		<?for($n=0;$n<$tag_count;$n++){?>
		<option value="<?=$tag[$n]["id"]?>"><?=$tag[$n]["tag_name"]?></option>
		<? } ?>	
	</select>
	<textarea class="textarea"><?=$dat["sel_id"]["contents"]?></textarea>
	</div>

	<div class="sub_box">
		<?foreach($dat as $a1 => $a2){?>
		<? } ?>
	</div>
</div>
<footer class="foot"></footer>
