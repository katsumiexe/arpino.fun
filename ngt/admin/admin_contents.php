<?

/*
st
0 表示
1 表示前
2 非表示
3 削除
*/

/*-----news_status*/
$st[0]="表示中";
$st[1]="表示前";
$st[2]="注目";
$st[3]="非表示";
$st[4]="削除";

$sel_id			=$_POST["sel_id"];
$post_id		=$_POST["post_id"];
if(!$post_id) $post_id="event";

$news_id		=$_POST["news_id"];
$news_upd		=$_POST["news_upd"];
$news_contents	=$_POST["news_contents"];
$news_tag		=$_POST["news_tag"];
$news_date		=$_POST["news_date"]." 00:00:00";
$news_status	=$_POST["news_status"];

if($news_id){
	$sql	 ="UPDATE wp01_0contents SET";
	$sql	.=" `title`='{$news_contents}',";
	$sql	.=" `display_date`='{$news_date}',";
	$sql	.=" `tag`='{$news_tag}',";
	$sql	.=" status='{$news_status}'";
	$sql	.=" WHERE `id`='{$news_id}'";
	mysqli_query($mysqli,$sql);
echo $sql;
}

if($post_id == "news"){
	$sql	 ="SELECT * FROM wp01_0contents";
	$sql	.=" WHERE page='{$post_id}'";
	$sql	.=" AND status<4";
	$sql	.=" ORDER BY display_date DESC";
	if($result = mysqli_query($mysqli,$sql)){
		while($res = mysqli_fetch_assoc($result)){
			$res["news_date"]	=substr($res["display_date"],0,10);
			$res["event_date"]	=substr($res["display_date"],0,10);
			if($res["status"] ==0 && $res["news_date"] > date("Y-m-d")){
				$res["status"]=1;
			}
			$dat[$res["id"]]=$res;
		}
	}

	$sql	 ="SELECT * FROM wp01_0tag";
	$sql	.=" WHERE tag_group='news'";
	$sql	.=" AND del=0";
	$sql	.=" ORDER BY sort ASC";

	if($result = mysqli_query($mysqli,$sql)){
		while($row = mysqli_fetch_assoc($result)){
			$tag[$row["id"]]=$row;
		}
	}

}else{
	$sql	 ="SELECT * FROM wp01_0contents";
	$sql	.=" WHERE page='{$post_id}'";
	$sql	.=" AND status=0";
	$sql	.=" ORDER BY sort ASC";

	if($result = mysqli_query($mysqli,$sql)){
		while($res = mysqli_fetch_assoc($result)){
			$dat[$res["sort"]]=$res;
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
	cursor			:pointer;
}

.sel_ck{
	background		:linear-gradient(#ff0000,#d00000);
}

.main_box{
	display			:inline-block;
	flex-basis		:800px;
	background		:#e0e000;
	min-height		:calc(100vh - 80px);
}

.sub_box{
	display			:inline-block;
	flex-basis		:400px;
	background		:#008040;
	min-height		:calc(100vh - 80px);
}

.news_tag{
	display			:inline-block;
	font-size		:16px;
	height			:30px;
	line-height		:30px;
	text-align		:right;
	padding-right	:5px; 
	width			:50px;
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
	background:#fafafa;
}

.c1{
	background:#f0ffc0;
}
.c2{
	background:#ffd0d8;
}

.c3{
	background:#e0e0e0;
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
	width			:65px;
	background		:#aaaaaa;
	color			:#ffffff;
	margin			:0 2px;
}

.st_view{
	display			:inline-block;
	width			:80px;
	height			:28px;
	line-height		:28px;
	text-align		:center;
	font-weight		:600;
	font-size		:15px;
}

.v0{
	background		:#d0e0ff;
	color			:#0000c0;
	border			:2px solid #0000c0;
}
.v2{
	background		:#ffe0f0;
	color			:#d00000;
	border			:2px solid #d00000;
}


.v1{
	background		:#ffffe0;
	color			:#a08000;
	border			:2px solid #a08000;
}

.v3{
	background		:#fafafa;
	color			:#909090;
	border			:2px solid #909090;
}

.page_area{
	width		:710px;
	height		:500px;
	resize		:none;
	font-szie	:15px;
	padding		:5px;
	border:1px solid #303030;
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
		$('#upd'+Tmp2).val(Tmp);


		if(Tmp == 'chg'){
			if (!confirm('変更します。よろしいですか')) {
				return false;
			}else{
				console.log(Tmp2);
				$('#f'+Tmp2).submit();
			}

		}else if(Tmp == 'del'){
			if (!confirm('削除します。よろしいですか')) {
				return false;
			}else{
				$('#f'+Tmp2).submit();
				return false;
			}
		}
	});
});
</script>
<header class="head">
<div id="event"   class="sel_contents <?if($post_id == "event"){?> sel_ck<?}?>">イベント</div>
<div id="news"    class="sel_contents <?if($post_id == "news"){?> sel_ck<?}?>">NEWS</div>
<div id="info"    class="sel_contents <?if($post_id == "info"){?> sel_ck<?}?>">お知らせ</div>
<div id="system"  class="sel_contents <?if($post_id == "system"){?> sel_ck<?}?>">SYSTEM</div>
<div id="access"  class="sel_contents <?if($post_id == "access"){?> sel_ck<?}?>">ACCESS</div>
<div id="recruit" class="sel_contents <?if($post_id == "recruit"){?> sel_ck<?}?>">RECRUIT</div>
<div id="policy"  class="sel_contents <?if($post_id == "policy"){?> sel_ck<?}?>">ポリシー</div>

<form id="form" method="post">
	<input id="sel_ck" type="hidden" name="post_id">
	<input type="hidden" name="menu_post" value="contents">
</form>
</header>
<div class="wrap">

	<?if($post_id == "news"){?>
		<div class="main_box">
			<?foreach($dat as $a1 => $a2){?>
				<form id="f<?=$a1?>" action="./index.php" method="post">
					<input type="hidden" name="post_id" value="news">
					<input type="hidden" name="menu_post" value="contents">
					<input type="hidden" name="news_id" value="<?=$a1?>">
					<input id="upd<?=$a1?>" type="hidden" value="" name="news_upd">

					<table class="news_table c<?=$a2["status"]?>">
						<tr>
							<td style="width:220px;">
								<span class="news_tag">日付</span><input type="date" name="news_date" class="w150" value="<?=$a2["news_date"]?>" autocomplete="off"> 
							</td>

							<td style="width:220px;">
								<span class="news_tag">公開日</span><input type="date" name="news_date" class="w150" value="<?=$a2["news_date"]?>" autocomplete="off"> 
							</td>

							<td style="width:220px;">
								<span class="news_tag">タグ</span><select name="news_tag" class="w150">
									<?foreach($tag as $b1 => $b2){?>
										<option value="<?=$b2["id"]?>" <?if($b2["id"] == $a2["tag"]){?> selected="selected"<?}?>><?=$b2["tag_name"]?></option>
									<? } ?>	
								</select>
							</td>

							<td>
								<select class="w120" name="news_status">
									<option value="0" <?if($a2["status"] == 0){?> selected="selected"<?}?>>表示</option>
									<option value="2" <?if($a2["status"] == 2){?> selected="selected"<?}?>>注目</option>
									<option value="3" <?if($a2["status"] == 3){?> selected="selected"<?}?>>非表示</option>
								</select>
							</td>
						</tr>
						<tr>
							<td>
								<span class="news_tag">リンク</span><select name="news_link" class="w150">
									<option value="">なし</option>
									<option value="page" <?if($a2["page"] == "person"){?> selected="selected"<?}?>>ページ</option>
									<option value="person" <?if($a2["category"] == "person"){?> selected="selected"<?}?>>CAST</option>
									<option value="event" <?if($a2["category"] == "event"){?> selected="selected"<?}?>>イベント</option>
									<option value="outer" <?if($a2["category"] == "outer"){?> selected="selected"<?}?>>外部リンク</option>
								</select>
							</td>
							<td colspan="2">
								<span class="news_tag">詳細</span><input type="text" name="link_detail" class="w280" value="<?=$a2["contents_key"]?>"> 
							</td>
							<td style="text-align:right;">
								<button id="chg<?=$a1?>" type="button" class="news_tag_btn">変更</button>
							</td>
						</tr>
						<tr>
							<td colspan="4">
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

<!--■■■■■■■■■■■■■■■■■■■■■■■■■■■-->
	<?}elseif($post_id == "info"){?>
		<div class="main_box">
			<table>
				<tr>
					<td style="width:60px;"><?=$a2["title"]?></td>
					<td style="width:60px;"><?=$a2["contents"]?></td>
				</tr>
			</table>
		</div>
		<div class="sub_box"></div>

<!--■■■■■■■■■■■■■■■■■■■■■■■■■■■-->
	<?}elseif($post_id == "system" || $post_id == "access" || $post_id == "policy"){?>
		<div class="main_box">
			<textarea class="page_area"><?=$dat[0]["contents"]?></textarea>
		</div>
		<div class="sub_box"></div>

<!--■■■■■■■■■■■■■■■■■■■■■■■■■■■-->
	<?}elseif($post_id == "recruit"){?>
		<div class="main_box">
			<table>
				<tr>
					<td style="width:80px;">TOPバナー<br>変更</td>
					<td style="width:620px;"><input type="text" name="event_title" value="<?=$a2["title"]?>"></td>
				</tr>
				<tr>
					<td style="width:80px;">メイン告知</td>
					<td style="width:620px;"><textarea class="w000"><?=$dat[0]["top"]?></textarea></td>
				</tr>
			</table>

			<table>
				<tbody id="sort">
				<?foreach($dat as $a1 => $a2){?>
					<tr id="tr_<?=$a1?>" class="tr">
						<td class="td_sort" style="width:60px;">■</td>
						<td style="width:60px;"><?=$a2["sort"]?></td>
						<td style="width:200px;"><input type="text" name="event_title" value="<?=$a2["title"]?>"></td>
						<td><textarea name="event_contents" class="w000"><?=$a2["contents"]?>"</textarea></td>
					</tr>
				<? } ?>
				</tbody>
			</table>
		</div>
		<div class="sub_box"></div>

<!--■■■■■■■■■■■■■■■■■■■■■■■■■■■-->
	<?}elseif($post_id == "event"){?>
		<div class="main_box">
			<?foreach($dat as $a1 => $a2){?>
			<table style="margin:5px; border:1px solid #303030;">
				<tr>
					<td rowspan="2" style="width:30px; background:#ff0000"><?=$a2["id"]?></td>
					<td rowspan="2" style="width:40px; background:#008000">
						<input type="text" name="event_sort" value="<?=$a2["sort"]?>" style="width:30px"> 
					</td>
					<td style="background:#90d0c0;width:300px;" colspan="3">
						<span class="tag">公開日</span>
						<input type="date" name="event_view_date" class="w150" value="<?=$a2["display_date"]?>" autocomplete="off">
					</td>
				</tr><tr>
					<td>
						<span class="news_tag">リンク</span><select name="news_link" class="w150">
							<option value="">なし</option>
							<option value="page" <?if($a2["page"] == "person"){?> selected="selected"<?}?>>ページ</option>
							<option value="person" <?if($a2["category"] == "person"){?> selected="selected"<?}?>>CAST</option>
							<option value="event" <?if($a2["category"] == "event"){?> selected="selected"<?}?>>イベント</option>
							<option value="outer" <?if($a2["category"] == "outer"){?> selected="selected"<?}?>>外部リンク</option>
						</select>
					</td>
					<td>
						<span class="news_tag">詳細</span><input type="text" name="link_detail" class="w280" value="<?=$a2["contents_key"]?>"> 
					</td>
					<td style="text-align:right;">
						<button id="chg<?=$a1?>" type="button" class="news_tag_btn">変更</button>
					</td>

				</tr>
			</table>
			<? } ?>
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
