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
$page_log		=$_POST["page_log"];
$post_id_set	=$_POST["post_id_set"];

if($news_id){
	$news_id		=$_POST["news_id"];
	$news_upd		=$_POST["news_upd"];
	$news_contents	=$_POST["news_contents"];
	$news_tag		=$_POST["news_tag"];
	$news_date		=$_POST["news_date"]." 00:00:00";
	$news_status	=$_POST["news_status"];

	$sql	 ="UPDATE wp01_0contents SET";
	$sql	.=" `title`='{$news_contents}',";
	$sql	.=" `display_date`='{$news_date}',";
	$sql	.=" `tag`='{$news_tag}',";
	$sql	.=" status='{$news_status}'";
	$sql	.=" WHERE `id`='{$news_id}'";
	mysqli_query($mysqli,$sql);

}elseif($post_id_set){
	$post_id	=$_POST["post_id_set"];
	$page_log	=$_POST["page_log"];
	$page_title	=$_POST["page_title"];
	$page_key	=$_POST["page_key"];

	$sql	 ="INSERT INTO  wp01_0contents (`date`,`page`,`title`,`contents`,`contents_key`)";
	$sql	.=" VALUES('{$now}','{$post_id}','{$page_title}','{$page_log}','{$page_key}')";
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

}if($post_id == "event"){
	$sql	 ="SELECT * FROM wp01_0contents";
	$sql	.=" WHERE page='{$post_id}'";
	$sql	.=" AND status=0";
	$sql	.=" ORDER BY sort ASC";

	if($result = mysqli_query($mysqli,$sql)){
		while($res = mysqli_fetch_assoc($result)){

			if (file_exists("../img/page/event/{$res["id"]}.jpg")) {
				$res["img"]="../img/page/event/{$res["id"]}.jpg";			

			}else{
				$res["img"]="../img/cast_no_image.jpg";			
			}

			$dat[$res["sort"]]=$res;
		}
	}

}elseif($post_id == "recruit"){
	$sql	 ="SELECT * FROM wp01_0contents";
	$sql	.=" WHERE page='{$post_id}'";
	$sql	.=" AND status=0";
	$sql	.=" ORDER BY sort ASC";

	if($result = mysqli_query($mysqli,$sql)){
		while($res = mysqli_fetch_assoc($result)){

			if (file_exists("../img/page/event/contents/recruit.jpg")) {
				$res["img"]="../img/page/event/contents/recruit.jpg";

			}elseif (file_exists("../img/page/event/contents/recruit.png")) {
				$res["img"]="../img/page/event/contents/recruit.png";

			}else{
				$res["img"]="../img/cast_no_image.jpg";			
			}

			$dat[$res["sort"]]=$res;
		}
	}

}else{
	$sql	 ="SELECT * FROM wp01_0contents";
	$sql	.=" WHERE page='{$post_id}'";
	$sql	.=" AND status=0";
	$sql	.=" ORDER BY id DESC";

	if($result = mysqli_query($mysqli,$sql)){
		while($res = mysqli_fetch_assoc($result)){
			if($res["category"] == "top){"
				$recuruit_title	=$res["title"];
				$recuruit_log	=$res["log"];

			}else{
			$dat[]=$res;
			
			}
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
	min-height		:calc(100vh - 80px);
	background		:#e6e6fa;
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
	width		:780px;
	height		:58px;
	line-height	:24px;
	font-size	:16px;
	resize		:none;
	padding		:5px;
	background	:#fafafa;
}

.news_table{
	margin		:5px auto;
	background	:#fafafa;
	border		:1px solid #303030;
}

.news_table td{
	padding:5px;

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
	margin			:0 auto;
	width			:780px;
	height			:500px;
	resize			:none;
	font-size		:15px;
	padding			:5px;
	border			:1px solid #303030;
}

td{
	padding			:0;
}

	.event_table{
		width			:810px;
		margin			:5px;
		border			:1px solid #303030;
		background		:#fafafa;
		font-size		:0;
		vertical-align	:top;
	}

	.event_td_0{

		background		:#d0d0ff;
		color			:#fafafa;
		text-align		:right;
		padding-right	:5px;
		font-size		:16px;
		border-right	:1px solid #303030;
	}

	.event_td_1{
		background	:#a06000;
		color		:#fafafa;
		width		:40px;
		text-align	:center;
		font-size	:16px;
	}

	.event_td_2{
		width		:40px;
		text-align	:center;
		border-right:1px solid #303030;
	}


	.event_td_3,.event_td_5{
		position	:relative;
		width		:360px;
		height		:40px;
		border-right:1px solid #303030;
	}

	.event_td_4{
	}

	.event_td_4_in{
		resize			:none;
		font-size		:14px;
		line-height:1.5;
		padding			:5px;
		border			:1px solid #303030;
		margin			:5px;
		width			:350px;
		height			:220px;
		background		:#f0f0ff;
	}
	.event_td_6{
		position	:relative;
		height		:150px;
		border-right:1px solid #303030;
	}

.event_img{
	position		:absolute;
	top				:0;
	right			:0;
	left			:0;
	bottom			:0;
	width			:350px;
	height			:140px;
	margin			:auto;
	overflow		:hidden;
	border			:1px solid #000000;
}

.img_chg,.img_large{
	position		:absolute;
	top				:6px;
	right			:8px;
	width			:24px;
	height			:24px;
	line-height		:24px;
	background		:rgba(255,255,255,0.5);
	border			:1px solid #303030;
	text-align		:center;
	color			:#303030;
	font-weight		:800;
	font-size		:16px;
	font-family		:at_icon;
}

.img_large{
	right			:35px ;
	font-size		:20px;
}

.event_set_btn{
	width		:60px;
	height		:30px;
	margin		:0 5px;
}

.box_sort{
	width		:30px;
	text-align	:right;
	padding		:5px;
}

.page_top{
	margin		:5px auto;
	width		:780px;
}

.recuruit_table td{
	padding		:5px;
	text-ali	gn	:center;
}

.recuruit_table{
	border			:1px solid #303030;
	margin			:0 auoto;
	border-collapse	:separate;
	border-spacing	:0 5px;;
}


.recuruit_table td{
	padding		:3px;
	text-align	:"center";
	
}

.recruit_tr{
	background	:#fafafa;
}

.recruit_td1{
	width		:30px;
}

.recruit_td2{
	width		:30px;
	text-align	:center;
}

.recruit_td3{
	width		:700px;
	text-align	:center;
}

-->
</style>
<script>

$(function(){ 
	$('.sel_contents').on('click',function(){
		Tmp=$(this).attr('id');
		$('#sel_ck').val(Tmp);
		$('#form').submit();
	});

	$('#page_set_btn').on('click',function(){
		if (!confirm('変更します。よろしいですか')) {
			return false;
		}else{
			$('#page_set').submit();
		}
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
							<td style="width:200px">
								<span class="news_tag">日付</span><input type="date" name="news_date" class="w140" value="<?=$a2["news_date"]?>" autocomplete="off"> 
							</td>

							<td style="width:200px">
								<span class="news_tag">公開日</span><input type="date" name="news_date" class="w140" value="<?=$a2["news_date"]?>" autocomplete="off"> 
							</td>

							<td style="width:200px">
								<span class="news_tag">タグ</span><select name="news_tag" class="w140">
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
			<form id="page_set" method="post">
				<div class="page_top"><span class="news_tag">Title</span><input type="text" name="page_title" class="w400" value="<?=$dat[0]["title"]?>"><button id="page_set_btn" type="button" class="event_set_btn">変更</button></div>			
				<textarea class="page_area" name="page_log"><?=$dat[0]["contents"]?></textarea>
				<div class="page_top"><span class="news_tag">リンク</span><input type="text" name="page_key" class="w400" value="<?=$dat[0]["contents_key"]?>"></div>				

				<input type="hidden" name="post_id_set" value="<?=$post_id?>">
				<input type="hidden" name="menu_post" value="contents">
			</form>
		</div>
		<div class="sub_box"></div>

<!--■■■■■■■■■■■■■■■■■■■■■■■■■■■-->
	<?}elseif($post_id == "recruit"){?>
		<div class="main_box">
			<table>
				<tr>
					<td style="width:80px;">TOPバナー<br>変更</td>
					<td style="width:620px;"></td>
				</tr>
				<tr>
					<td style="width:80px;">メイン告知</td>
					<td style="width:620px;"><textarea class="w000"><?=$dat[0]["contents"]?></textarea></td>
				</tr>
			</table>


			<table class="recuruit_table">
				<tr>
					<td colspan="2"></td>
					<td style="width:620px;">
						<input type="text" name="event_title" value="<?=$recuest_title?>">
						<textarea class="w000"><?=$recuest_contents?></textarea>
					</td>
				</tr>

				<tbody id="sort">
				<?foreach($dat as $a1 => $a2){?>
					<tr id="tr_<?=$a1?>" class="tr">
						<td class="recruit_td1" style="width:40px;">■</td>
						<td class="recruit_td2" ><?=$a2["sort"]?></td>

						<td class="recruit_td3">
							<input type="text" name="event_title" value="<?=$a2["title"]?>">
							<textarea name="event_contents" class="w000"><?=$a2["contents"]?>"</textarea>
						</td>
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
			<table class="event_table">
				<tr>
					<td class="event_td_0" colspan="2"><span class="event_td_0_in"><?=$a2["id"]?></span></td>

					<td class="event_td_3">
						<span class="news_tag">公開日</span>
						<input type="date" name="event_view_date" class="w150" value="<?=$a2["display_date"]?>" autocomplete="off">
						<button id="chg<?=$a1?>" type="button" class="event_set_btn">変更</button>
						<button id="chg<?=$a1?>" type="button" class="event_set_btn">変更</button>
					</td>

					<td  class="event_td_4" rowspan="3"><textarea class="event_td_4_in"></textarea></td>
				</tr><tr>

					<td rowspan="2"  class="event_td_1">●</td>
					<td rowspan="2"  class="event_td_2">
						<input type="text" value="<?=$a2["sort"]?>" class="box_sort" disabled>
					</td>
					<td  class="event_td_5">
						<span class="news_tag">リンク</span><select name="news_link" class="w120">
							<option value="">なし</option>
							<option value="page"   <?if($a2["category"] == "page"){?> selected="selected"<?}?>>ページ</option>
							<option value="person" <?if($a2["category"] == "person"){?> selected="selected"<?}?>>CAST</option>
							<option value="event"  <?if($a2["category"] == "event"){?> selected="selected"<?}?>>イベント</option>
							<option value="outer"  <?if($a2["category"] == "outer"){?> selected="selected"<?}?>>外部リンク</option>
						</select>
						<input type="text" name="link_detail" style="width:175px;margin-left:5px;" value="<?=$a2["contents_key"]?>"> 
					</td>
				</tr><tr>
					<td class="event_td_6">
					<span class="event_img"><img src="<?=$a2["img"]?>" style="width:100%;"></span>
					<span class="img_large"></span><span class="img_chg"></span>
					</td>
				</tr>
			</table>
			<? } ?>
		</div>

		<div class="sub_box">
			<?foreach($dat as $a1 => $a2){?>
				<table>
					<tr>
						<Td><?=$a2["display_date"]?></td>
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
