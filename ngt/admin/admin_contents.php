<?

/*
st
0 表示
1 表示前
2 非表示
3 削除
*/


$sel_id			=$_POST["sel_id"];
$post_id		=$_POST["post_id"];

if(!$post_id) $post_id="event";

$sql	 ="SELECT * FROM wp01_0contents";
$sql	.=" WHERE page='{$post_id}'";
$sql	.=" AND status<3'";
$sql	.=" ORDER BY id DESC";
echo $sql;
if($result = mysqli_query($mysqli,$sql)){
	while($res = mysqli_fetch_assoc($result)){

		$res["news_date"]=substr($res["display_date"],0,10);
		if($res["status"] ==0 && $res["news_date"] > date("Y-m-d")){
			$res["status"]=1;
		}
		$dat[$res["id"]]=$res;
		if($res["id"] == "$sel_id"){
			$dat_sel=$res;	
		}
	}
}
var_dump($dat[58]);

if($post_id == "news"){
	$sql	 ="SELECT * FROM wp01_0tag";
	$sql	.=" WHERE tag_group='news'";
	$sql	.=" AND del=0";
	$sql	.=" ORDER BY sort ASC";

	if($result = mysqli_query($mysqli,$sql)){
		while($row = mysqli_fetch_assoc($result)){
			$tag[$row["id"]]=$row;
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

.news_tag{
	display		:inline-block;
	font-size	:16px;
	height		:30px;
	line-height	:30px;
	text-align	:right;
	padding-right:5px; 
	width		:60px;
}


.news_contents{
	width		:800px;
	height		:58px;
	line-height	:24px;
	font-size	:16px;
	resize		:none;
	padding		:5px;
	background	:#fafafa;
}

.news_table{
	margin:5px auto;
	background:#eaeaea;
}

.news_tag_label{
	width		:160px;
	height		:30px;
	line-height	:30px;
	font-size	:14px;
	background	:#fafafa;
	border		:1px solid #303030;
	margin		:1px;
	display		:inline-block;
	padding		:0 10px;
}

.news_tag_btn{
	width:80px;
	background:#909090;
	color:#ffffff;
	margin:0 5px;
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

	$('.news_tag_btn').on('click',function(){
		Tmp	=$(this).attr('id').substr(0,3);
		Tmp2=$(this).attr('id').substr(3);

		if(Tmp == 'chg'){
			if (confirm('変更します。よろしいですか')) {
				$('#form'+Tmp2).submit();
			}

		}else if(Tmp == 'del'){
			if (confirm('削除します。よろしいですか')) {
				$('#form'+Tmp2).submit();
			}

		}else if(Tmp == 'cov'){
			if (confirm('非表示にします。よろしいですか')) {
				$('#form'+Tmp2).submit();
			}

		}else if(Tmp == 'dis'){
			if (confirm('表示にします。よろしいですか')) {
				$('#form'+Tmp2).submit();
			}
		}
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
<?foreach($dat as $a1 => $a2){?>
<form id="from<?=$a1?>" action="./index.php" method="post">
	<input type="hidden" value="contents" name="set_id">
	<input type="hidden" value="news" name="post_id">
	<input id="upd<?=$a1?>" type="hidden" value="" name="news_upd">
	<table class="news_table">
		<tr>
			<td>
				<span class="news_tag">公開日</span><input type="date" name="n_date" class="w150" value="<?=$a2["news_date"]?>" autocomplete="off"> 
			</td>
			<td>
				<span class="news_tag">タグ</span><select name="tag" class="w150">
					<?foreach($tag as $b1 => $b2){?>
						<option value="<?=$b2["id"]?>" <?if($b2["id"] == $a2["tag"]){?> selected="selected"<?}?>><?=$b2["tag_name"]?></option>
					<? } ?>	
				</select>
			</td>
			<td>
				<button id="chg<?=$a1?>" type="button" class="news_tag_btn">変更</button>
				<button id="cov<?=$a1?>" type="button" class="news_tag_btn">非表示</button>
				<button id="del<?=$a1?>" type="button" class="news_tag_btn">削除</button>
			</td>
		</tr>
		<tr>
			<td colspan="3">
				<div class="news_tag">タイトル</div>
				<textarea name="news_contents" class="news_contents"><?=$a2["title"]?></textarea>
			</td>
		</tr>
	</table>
</form>

<?}?>
		</div>

		<div class="sub_box">
			<?foreach($tag as $a1 => $a2){?>
				<input id="rd<?=$a2["id"]?>" type="radio"><label for="rd<?=$a1?>" class="news_tag_label"><?=$a2["tag_name"]?></label><br>
			<?}?>
		</div>

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
						<textarea class="news_textarea"><?=$dat_sel["contents"]?></textarea>
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
