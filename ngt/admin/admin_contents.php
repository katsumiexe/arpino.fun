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

if($post_id == "page") $post_id="system";

$news_id		=$_POST["news_id"];
$page_log		=$_POST["page_log"];
$post_id_set	=$_POST["post_id_set"];


if($news_id){
	$news_upd		=$_POST["news_upd"];
	$news_title		=$_POST["news_title"];
	$news_tag		=$_POST["news_tag"];
	$display_date	=$_POST["display_date"]." 00:00:00";
	$news_date		=$_POST["news_date"];
	$news_status	=$_POST["news_status"];
	$news_contents	=$_POST["news_contents"];

	$sql	 ="UPDATE wp01_0contents SET";
	$sql	.=" `title`='{$news_title}',";
	$sql	.=" `event_date`='{$event_date}',";
	$sql	.=" `display_date`='{$display_date}',";
	$sql	.=" `tag`='{$news_tag}',";
	$sql	.=" `contents`='{$news_contents}',";
	$sql	.=" status='{$news_status}'";
	$sql	.=" WHERE `id`='{$news_id}'";
	mysqli_query($mysqli,$sql);

echo $sql;

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
			$res["news_date"]	=substr($res["news_date"],0,10);
			$res["display_date"]	=substr($res["display_date"],0,10);
			if($res["status"] ==0 && $res["display_date"] > date("Y-m-d")){
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
	$sql	.=" AND status<4";
	$sql	.=" ORDER BY sort ASC";

	if($result = mysqli_query($mysqli,$sql)){
		while($res = mysqli_fetch_assoc($result)){
			$res["display_date"]	=substr($res["display_date"],0,10);

			if (file_exists("../img/page/event/{$res["id"]}.jpg")) {
				$res["img"]="../img/page/event/{$res["id"]}.jpg";			

			}else{
				$res["img"]="../img/cast_no_image.jpg";			
			}

			$dat[$res["id"]]=$res;
		}
	}

}elseif($post_id == "info"){
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
	$sql	.=" ORDER BY date DESC";

	if($result = mysqli_query($mysqli,$sql)){
		while($res = mysqli_fetch_assoc($result)){

			if($res["category"] == "top"){
				$recruit_title		=$res["title"];
				$recruit_contents	=$res["contents"];

			}elseif($res["category"] == "image"){
				$recruit_img	=$res["contents_key"];

			}else{
				$dat[$res["sort"]]=$res;
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
	width			:60px;
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

.news_tag_btn, .event_tag_btn{
	width			:65px;
	background		:#aaaaaa;
	color			:#ffffff;
	margin			:0 2px;
	height			:30px;
	vertical-align	:top;
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
		width		:80px;
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
//		width		:320px;
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
		width			:710px;
		height			:120px;
		background		:#f0f0ff;
	}
	.event_td_6{
		position	:relative;
		border-right:1px solid #303030;
		width		:325px;
	
	}

.event_img{
	position		:absolute;
	top				:5px;
	left			:5px;
//	right			:0;
//	bottom			:0;
	width			:275px;
	height			:110px;
	margin			:auto;
	overflow		:hidden;
	border			:1px solid #000000;

}

.img_chg,.img_large{
	position		:absolute;
	top				:5px;
	right			:5px;
	width			:30px;
	height			:30px;
	line-height		:30px;
	background		:rgba(255,255,255,0.5);
	border			:1px solid #303030;
	text-align		:center;
	color			:#303030;
	font-weight		:800;
	font-size		:16px;
	font-family		:at_icon;
}
	
.img_large{
	top				:40px ;
	font-size		:20px;
}

.event_set_btn{
	width			:60px;
	height			:30px;
	margin			:0 5px;
}

.box_sort{
	width			:30px;
	text-align		:right;
	padding			:5px;
}

.page_top{
	margin			:5px auto;
	width			:780px;
}

.recuruit_table td{
	padding			:5px;
	text-align		:center;
}

.recuruit_table{
	border			:1px solid #303030;
	margin			:0 auoto;
	border-collapse	:separate;
	border-spacing	:0 5px;;
	background		:#fafafa;
}

.recuruit_table td{
	padding		:3px;
	text-align	:"center";
}

.recruit_contents{
	resize		:none;
	width		:700px;
	height		:100px;
}

.recruit_title{
	width:500px;
	background	:#e6e6fa;
	border		:1px solid #e6e6fa;
}

.recruit_tr{
	background	:#fafafa;
}

.recruit_td1{
	border:1px solid #303030;
	width		:30px;
}

.recruit_td2{
	border:1px solid #303030;
	width		:30px;
	text-align	:center;
}

.recruit_td3{
	border		:1px solid #303030;
	width		:700px;
	text-align	:left;
	background	:#d0d0ff ;
}

.recruit_td4{
	border		:1px solid #303030;
	width		:700px;
	text-align	:left;
}

.news_box{
	height:30px;
	margin:0 2px;
	border:1px solid #303030;
	padding:1px;
	vertical-align:top;
}

.rec_link{
	resize			:none;
	width			:715px;
	height			:130px;
	padding			:5px;
	font-size		:16px;
	line-height		:22px;
	margin			:5px 0;
}

.link_tag{
	display			:inline-block;
	width			:60px;
	height			:130px;
	font-size		:16px;
	line-height		:30px;
	text-align		:center;
	background		:#d0d0ff;	
	vertical-align	:top;
	margin			:5px 0;
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
<div id="page"	  class="sel_contents  <?if($post_id == "system" || $post_id == "access" || $post_id == "recruit" || $post_id == "policy"){?> sel_ck<?}?>">PAGE</div>

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
							<td style="font-size:0;">
								<span class="news_tag">日付</span><input type="date" name="event_date" class="w140 news_box" value="<?=$a2["event_date"]?>" autocomplete="off"> 
								<span class="news_tag">公開日</span><input type="date" name="display_date" class="w140 news_box" value="<?=$a2["display_date"]?>" autocomplete="off"> 
								<span class="news_tag">状態</span>
								<select class="w120 news_box" name="news_status">
									<option value="0" <?if($a2["status"] == 0){?> selected="selected"<?}?>>表示</option>
									<option value="2" <?if($a2["status"] == 2){?> selected="selected"<?}?>>注目</option>
									<option value="3" <?if($a2["status"] == 3){?> selected="selected"<?}?>>非表示</option>
									<option value="4" <?if($a2["status"] == 4){?> selected="selected"<?}?>>削除</option>
								</select>
								<button id="chg<?=$a1?>" type="button" class="news_tag_btn">変更</button>
							</td>
						</tr>

						<tr>
							<td style="font-size:0;">
								<span class="news_tag">タグ</span>
								<select name="news_tag" class="w140 news_box">
									<?foreach($tag as $b1 => $b2){?><option value="<?=$b2["id"]?>" <?if($b2["id"] == $a2["tag"]){?> selected="selected"<?}?>><?=$b2["tag_name"]?></option>
									<? } ?>	
								</select>

								<span class="news_tag">リンク</span><select name="news_link" class="w140 news_box">
									<option value="">なし</option>
									<option value="page" <?if($a2["page"] == "person"){?> selected="selected"<?}?>>ページ</option>
									<option value="person" <?if($a2["category"] == "person"){?> selected="selected"<?}?>>CAST</option>
									<option value="event" <?if($a2["category"] == "event"){?> selected="selected"<?}?>>イベント</option>
									<option value="outer" <?if($a2["category"] == "outer"){?> selected="selected"<?}?>>外部リンク</option>
								</select>
								<input type="text" name="link_detail" class="news_box" style="border:1px solid #303030;width:185px;" value="<?=$a2["contents_key"]?>"> 
							</td>
						</tr>

						<tr>
							<td>
								<textarea name="news_title" class="news_title"><?=$a2["title"]?></textarea>
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
	<?}elseif($post_id == "event"){?>
		<div class="main_box">
			<?foreach($dat as $a1 => $a2){?>

			<form id="f<?=$a1?>" action="./index.php" method="post">
			<input type="hidden" name="post_id" value="event">
			<input type="hidden" name="menu_post" value="contents">
			<input type="hidden" name="news_id" value="<?=$a1?>">

			<table class="event_table">
				<tr>
					<td class="event_td_0" colspan="2"><span class="event_td_0_in"><?=$a2["id"]?></span></td>
						<td class="event_td_3">
						<span class="news_tag">公開日</span>
						<input type="date" name="display_date" class="w140" value="<?=$a2["display_date"]?>" autocomplete="off">
						<span class="news_tag">状態</span>
						<select class="w120 news_box" name="news_status">
							<option value="0" <?if($a2["status"] == 0){?> selected="selected"<?}?>>表示</option>
							<option value="3" <?if($a2["status"] == 3){?> selected="selected"<?}?>>非表示</option>
							<option value="4" <?if($a2["status"] == 4){?> selected="selected"<?}?>>削除</option>
						</select>
					</td>
					<td class="event_td_6" rowspan="3">
						<span class="event_img"><img src="<?=$a2["img"]?>" style="width:100%;"></span>
						<span class="img_large"></span><span class="img_chg"></span>
					</td>

				</tr><tr>
					<td rowspan="3"  class="event_td_1">●</td>
					<td rowspan="3"  class="event_td_2">
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
					<td  class="event_td_5">
						<span class="news_tag">TITLE</span>
						<input type="text" name="news_title" style="width:250px;" value="<?=$a2["title"]?>">
						<button id="chg<?=$a1?>" type="button" class="news_tag_btn">変更</button>
					</td>

				</tr><tr>
					<td  class="event_td_4" colspan="2"><textarea name="news_contents" class="event_td_4_in"><?=$a2["contents"]?></textarea></td>
				</tr>
			</table>
			</form>
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


<!--■■■■■■■■■■■■■■■■■■■■■■■■■■■-->
	<?}else{?>
		<?if($post_id == "recruit"){?>
			<div class="main_box">
				<table class="recuruit_table">
					<tr>
						<td colspan="2" rowspan="2" ></td>
						<td class="recruit_td3">
							<input type="text" name="recruit_title_top" class="recruit_title" value="<?=$recruit_title?>">
						</td>
						</tr><tr>
						<td class="recruit_td4">
							<textarea name="recruit_contents_top" class="recruit_contents"><?=$recruit_contents?></textarea>
						</td>
					</tr>

					<tbody id="sort">
						<?foreach($dat as $a1 => $a2){?>
							<tr id="tr_<?=$a1?>" class="tr">
								<td class="recruit_td1" rowspan="2" style="width:40px;">■</td>
								<td class="recruit_td2" rowspan="2"><?=$a2["sort"]?></td>

								<td class="recruit_td3">
									<input type="text" name="recruit_title[<?=$a2["sort"]?>]" class="recruit_title" value="<?=$a2["title"]?>">
								</td>
								</tr><tr>
								<td class="recruit_td4">
									<textarea name="recruit_contents[<?=$a2["sort"]?>]" class="recruit_contents"><?=$a2["contents"]?></textarea>
								</td>
							</tr>
						<? } ?>
					</tbody>
				</table>
			</div>

		<?}else{?>
			<div class="main_box">
				<form id="page_set" method="post">
					<div class="page_top">
						<span class="news_tag">TITLE</span>
						<input type="text" name="page_title" style="width:640px;" value="<?=$dat[0]["title"]?>"><button id="page_set_btn" type="button" class="event_set_btn">変更</button>
					</div>			
					<textarea class="page_area" name="page_log"><?=$dat[0]["contents"]?></textarea>
<?if($post_id =="access"){?>
					<span class="link_tag">リンク</span>
					<textarea name="page_key" class="rec_link"><?=$dat[0]["contents_key"]?></textarea>				
<?}?>
					<input type="hidden" name="post_id_set" value="<?=$post_id?>">
					<input type="hidden" name="menu_post" value="contents">
				</form>
			</div>
		<?}?>
	<div class="sub_box">
		<div id="system"  class="sel_contents <?if($post_id == "system"){?> sel_ck<?}?>">SYSTEM</div>
		<div id="access"  class="sel_contents <?if($post_id == "access"){?> sel_ck<?}?>">ACCESS</div>
		<div id="recruit" class="sel_contents <?if($post_id == "recruit"){?> sel_ck<?}?>">RECRUIT</div>
		<div id="policy"  class="sel_contents <?if($post_id == "policy"){?> sel_ck<?}?>">ポリシー</div>
	</div>

<!--■■■■■■■■■■■■■■■■■■■■■■■■■■■-->
	<? } ?>
</div>
<footer class="foot"></footer>
