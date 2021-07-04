<?

/*
st
0 表示
1 表示前
2 非表示
3 削除
*/

/*-----event_status*/
$st[0]="表示中";
$st[1]="表示前";
$st[2]="注目";
$st[3]="非表示";
$st[4]="削除";
$cat[0]="none";
$cat[1]="event";
$cat[2]="page";
$cat[3]="person";
$cat[4]="outer";

$sel_id			=$_POST["sel_id"];
$post_id		=$_POST["post_id"];

if(!$post_id) $post_id="event";

if($post_id == "page") $post_id="system";

$event_set_id	=$_POST["event_set_id"];
$page_log		=$_POST["page_log"];
$post_id_set	=$_POST["post_id_set"];

if($event_set_id){
	$event_title	=$_POST["event_title"];
	$event_tag		=$_POST["event_tag"];
	$display_date	=$_POST["display_date"]." 00:00:00";
	$event_date		=$_POST["event_date"];
	$event_status	=$_POST["event_status"];
	$event_contents	=$_POST["event_contents"];
	$category		=$_POST["category"];
	$event_key		=$_POST["event_key"];

	if($event_set_id == "new"){
		$sql	 ="INSERT INTO wp01_0contents(`date`,`display_date`,`event_date`,`sort`,`page`,`category`,`title`,`contents`,`contents_key`,`tag`)";
		$sql	.=" VALUES('{$now}','{$display_date}','{$event_date}','0','{$post_id}','{$category}','{$event_title}','{$event_contents}','{$event_key}','{$event_tag}')";
		mysqli_query($mysqli,$sql);
		$tmp_auto=mysqli_insert_id($mysqli);

	}else{
		$sql	 ="UPDATE wp01_0contents SET";
		$sql	.=" `title`='{$event_title}',";
		$sql	.=" `event_date`='{$event_date}',";
		$sql	.=" `display_date`='{$display_date}',";
		$sql	.=" `tag`='{$event_tag}',";
		$sql	.=" `contents`='{$event_contents}',";
		$sql	.=" `category`='{$category}',";
		$sql	.=" `contents_key`='{$event_key}',";
		$sql	.=" status='{$event_status}'";
		$sql	.=" WHERE `id`='{$event_set_id}'";
		mysqli_query($mysqli,$sql);
		$tmp_auto=$event_set_id;
	}

	if(isset($_FILES)&& isset($_FILES['upd_img']) && is_uploaded_file($_FILES['upd_img']['tmp_name'])){
		$img_reg=getimagesize($_FILES['upd_img']['tmp_name']);
		if($img_reg["mime"] =="image/jpeg"){
			$kk=".jpg";

		}elseif($img_reg["mime"] =="image/webp"){
			$kk=".webp";

		}elseif($img_reg["mime"] =="image/png"){
			$kk=".png";

		}elseif($img_reg["mime"] =="image/gif"){
			$kk=".gif";
		}

	    $img_url = "../img/page/{$post_id}/{$post_id}_{$tmp_auto}{$kk}";
		move_uploaded_file($_FILES['upd_img']['tmp_name'], $img_url);
	}


}elseif($post_id_set){
	$post_id	=$_POST["post_id_set"];
	$page_log	=$_POST["page_log"];
	$page_title	=$_POST["page_title"];
	$page_key	=$_POST["page_key"];

	$sql	 ="INSERT INTO  wp01_0contents (`date`,`page`,`title`,`contents`,`contents_key`)";
	$sql	.=" VALUES('{$now}','{$post_id}','{$page_title}','{$page_log}','{$page_key}')";
	mysqli_query($mysqli,$sql);
}


if($post_id == "news"){
	$sql	 ="SELECT * FROM wp01_0contents";
	$sql	.=" WHERE page='{$post_id}'";
	$sql	.=" AND status<4";
	$sql	.=" ORDER BY event_date DESC";
	if($result = mysqli_query($mysqli,$sql)){
		while($res = mysqli_fetch_assoc($result)){
			$res["event_date"]	=substr($res["event_date"],0,10);
			$res["display_date"]	=substr($res["display_date"],0,10);
			if($res["status"] ==0 && $res["display_date"] > date("Y-m-d")){
				$res["status"]=1;
			}
			if($res["status"] == 2){
				$dat0[$res["id"]]=$res;
			}else{
				$dat1[$res["id"]]=$res;
			}
		}
	}
//	$dat = array_merge($dat0, $dat1);

	$dat = (array)$dat0 + (array)$dat1;



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

			if (file_exists("../img/page/event/event_{$res["id"]}.jpg")) {
				$res["img"]="../img/page/event/event_{$res["id"]}.jpg";			

			}elseif (file_exists("../img/page/event/event_{$res["id"]}.png")) {
				$res["img"]="../img/page/event/event_{$res["id"]}.png";			

			}elseif (file_exists("../img/page/event/event_{$res["id"]}.gif")) {
				$res["img"]="../img/page/event/event_{$res["id"]}.gif";			

			}elseif (file_exists("../img/page/event/event_{$res["id"]}.webp")) {
				$res["img"]="../img/page/event/event_{$res["id"]}.webp";			

			}else{
				$res["img"]="../img/event_no_image.jpg";			
			}

			$dat[$res["id"]]=$res;
		}
	}

}elseif($post_id == "info"){
	$sql	 ="SELECT * FROM wp01_0contents";
	$sql	.=" WHERE page='{$post_id}'";
	$sql	.=" AND status<4";
	$sql	.=" ORDER BY sort ASC";

	if($result = mysqli_query($mysqli,$sql)){
		while($res = mysqli_fetch_assoc($result)){
			$res["display_date"]	=substr($res["display_date"],0,10);

			if (file_exists("../img/page/info/info_{$res["id"]}.webp")) {
				$res["img"]="../img/page/info/info_{$res["id"]}.webp";

			}elseif (file_exists("../img/page/info/info_{$res["id"]}.jpg")) {
				$res["img"]="../img/page/info/info_{$res["id"]}.jpg";

			}elseif (file_exists("../img/page/info/info_{$res["id"]}.png")) {
				$res["img"]="../img/page/info/info_{$res["id"]}.png";

			}else{
				$res["img"]="../img/info_no_image.png";			
			}

			$dat[$res["id"]]=$res;
		}
	}


}elseif($post_id == "recruit"){
	$sql	 ="SELECT * FROM wp01_0contents";
	$sql	.=" WHERE page='{$post_id}'";
	$sql	.=" AND status<4";
	$sql	.=" ORDER BY sort ASC";

	if($result = mysqli_query($mysqli,$sql)){
		while($res = mysqli_fetch_assoc($result)){

			if($res["category"] == "top"){
				$recruit_title		=$res["title"];
				$recruit_contents	=$res["contents"];

			}elseif($res["category"] == "image"){
				$recruit_img	=$res["contents_key"];

			}elseif($res["category"] == "list"){
				$dat[$res["id"]]=$res;

			}else{
				$contact[$res["category"]]=$res["contents_key"];
			}
		}
	}

}else{
	$sql	 ="SELECT * FROM wp01_0contents";
	$sql	.=" WHERE page='{$post_id}'";
	$sql	.=" AND status=0";
	$sql	.=" ORDER BY date DESC";
	$sql	.=" LIMIT 1";

	if($result = mysqli_query($mysqli,$sql)){
		while($res = mysqli_fetch_assoc($result)){

			if($res["category"] == "top"){
				$recruit_title		=$res["title"];
				$recruit_contents	=$res["contents"];
				$recruit_id			=$res["id"];

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

	$('.upd_file').on('change',function(e){
		Tmp=$(this).attr('id');
		Ck=Tmp.substr(-1);
		if(Ck=="i"){
			Ck_h=200;
			Ck_w=600;
		}else{
			Ck_h=480;
			Ck_w=1200;
		}
		
		var file = e.target.files[0];	
		var reader = new FileReader();

		if(file.type.indexOf("image") < 0){
			alert("NO IMAGE FILES");
			return false;
		}
		var img = new Image();

		reader.onload = function (e) {
			img.src = e.target.result;
			if(img.height != Ck_h || img.width != Ck_w){
				if (!confirm('画像が推奨サイズではありませんがよろしいですか\n※推奨サイズ　縦'+Ck_h+'px 横'+ Ck_w+'px')) {
					return false;
				}else{
					$("#top_"+Tmp).attr('src', e.target.result);
				}
			}else{
					$("#top_"+Tmp).attr('src', e.target.result);
			}

		}
		reader.readAsDataURL(e.target.files[0]);

	});

	$('.event_tag_btn,.event_set_btn').on('click',function(){
		Tmp	=$(this).attr('id').substr(0,3);
		Tmp2=$(this).attr('id').substr(3);
//		$('#upd'+Tmp2).val(Tmp);

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
				$('#st'+Tmp2).val('4');
				$('#f'+Tmp2).submit();
				return false;
			}

		}else if(Tmp == 'cov'){
			Tmp3=$('#st'+Tmp2).val();
			if(Tmp3 == 3){
				$('#st'+Tmp2).val('0');

			}else{
				$('#st'+Tmp2).val('3');
			}
			$('#f'+Tmp2).submit();
			return false;

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
					<input type="hidden" name="event_set_id" value="<?=$a1?>">

					<table class="news_table c<?=$a2["status"]?>">
						<tr>
							<td style="font-size:0;">
								<span class="event_tag">日付</span><input type="date" name="event_date" class="w140 news_box" value="<?=$a2["event_date"]?>" autocomplete="off"> 
								<span class="event_tag">公開日</span><input type="date" name="display_date" class="w140 news_box" value="<?=$a2["display_date"]?>" autocomplete="off"> 
								<span class="event_tag">状態</span>
								<select class="w120 news_box" name="event_status">
									<option value="0" <?if($a2["status"] == 0){?> selected="selected"<?}?>>表示</option>
									<option value="2" <?if($a2["status"] == 2){?> selected="selected"<?}?>>注目</option>
									<option value="3" <?if($a2["status"] == 3){?> selected="selected"<?}?>>非表示</option>
									<option value="4" <?if($a2["status"] == 4){?> selected="selected"<?}?>>削除</option>
								</select>
								<button id="chg<?=$a1?>" type="button" class="event_tag_btn">変更</button>
							</td>
						</tr>

						<tr>
							<td style="font-size:0;">
								<span class="event_tag">タグ</span>
								<select name="event_tag" class="w140 news_box">
									<?foreach($tag as $b1 => $b2){?><option value="<?=$b2["id"]?>" <?if($b2["id"] == $a2["tag"]){?> selected="selected"<?}?>><?=$b2["tag_name"]?></option>
									<? } ?>	
								</select>
								<span class="event_tag">リンク</span><select name="category" class="w140 news_box">
									<option value="">なし</option>
									<option value="self"   <?if($a2["category"] == "self"){?> selected="selected"<?}?>>ページ</option>
									<option value="person"  <?if($a2["category"] == "person"){?> selected="selected"<?}?>>CAST</option>
									<option value="page" <?if($a2["category"] == "page"){?> selected="selected"<?}?>>内部リンク</option>
									<option value="outer"  <?if($a2["category"] == "outer"){?> selected="selected"<?}?>>外部リンク</option>
								</select>
								<input type="text" name="event_key" class="news_box" style="border:1px solid #303030;width:185px;" value="<?=$a2["contents_key"]?>"> 
							</td>
						</tr>

						<tr>
							<td>
								<textarea name="event_title" class="news_title"><?=$a2["title"]?></textarea>
							</td>
						</tr>
					</table>
				</form>
			<?}?>
		</div>
		<div class="sub_box">
			<?foreach($tag as $a1 => $a2){?>
				<input id="rd<?=$a2["id"]?>" type="radio"><label for="rd<?=$a1?>" class="event_tag_label"><?=$a2["tag_name"]?></label><br>
			<?}?>
		</div>

<!--■■■■■■■■■■■■■■■■■■■■■■■■■■■-->
	<?}elseif($post_id == "info"){?>
		<div class="main_box">

		<table class="event_table" style="background:#ffe0f0;">
			<form id="fnew" action="./index.php" method="post" enctype="multipart/form-data">
			<input type="hidden" name="post_id" value="info">
			<input type="hidden" name="menu_post" value="contents">
			<input type="hidden" name="event_set_id" value="new">
			<tr>
				<td class="event_td_0" colspan="2"><span class="event_td_0_in">新規作成</span></td>

				<td class="event_td_3">
					<span class="event_tag">公開日</span>
					<input type="date" name="display_date" class="w140" value="<?=$day_date?>" autocomplete="off">
					<button  type="submit" class="event_reg_btn">登録</button>
				</td>

				<td class="event_td_7" rowspan="2">
					<label for="updnewi" class="info_img"><img id="top_updnewi" src="../img/info_no_image.png" style="width:210px; height:70px;"></label>
					<span class="img_large"></span>
			<input id="updnewi" name="upd_img" type="file" class="upd_file" style="display:none;">
				</td>
			</tr>

			<tr>
				<td colspan="2"></td>
				<td  class="event_td_5">
					<span class="event_tag">リンク</span><select name="category" class="w140">
						<option value="">なし</option>
						<option value="info"  <?if($a2["category"] == "info"){?> selected="selected"<?}?>>インフォ</option>
						<option value="event" <?if($a2["category"] == "event"){?> selected="selected"<?}?>>イベント</option>
						<option value="person"<?if($a2["category"] == "person"){?> selected="selected"<?}?>>CAST</option>
						<option value="blog"  <?if($a2["category"] == "blog"){?> selected="selected"<?}?>>ブログ</option>
						<option value="page"  <?if($a2["category"] == "page"){?> selected="selected"<?}?>>内部リンク</option>
						<option value="outer" <?if($a2["category"] == "outer"){?> selected="selected"<?}?>>外部リンク</option>
					</select>
					<input type="text" name="event_key" style="width:175px;margin-left:5px;" value=""> 
				</td>
			</form>
		</table>


		<div id="contents_sort" class="main_list list_sort">
			<?foreach($dat as $a1 => $a2){?>

			<table id="sort_item<?=$a1?>" class="event_table sort_item c<?=$a2["status"]?>">
				<form id="f<?=$a1?>" action="./index.php" method="post" enctype="multipart/form-data">
	
				<input type="hidden" name="post_id" value="info">
				<input type="hidden" name="menu_post" value="contents">
				<input type="hidden" name="event_set_id" value="<?=$a1?>">
				<tbody>
				<tr>
					<td class="event_td_1 handle" rowspan="2"></td>
					<td class="event_td_2" rowspan="2">
						<input type="text" value="<?=$a2["sort"]?>" class="box_sort" disabled>
					</td>


					<td class="event_td_3">
						<span class="event_tag">公開日</span>
						<input type="date" name="display_date" class="w140" value="<?=$a2["display_date"]?>" autocomplete="off">
						<button id="cov<?=$a1?>" type="button" class="event_set_btn"><?=$st[$a2["status"]]?></button>
						<button id="chg<?=$a1?>" type="button" class="event_set_btn">更新</button>
						<button id="del<?=$a1?>" type="button" class="event_set_btn">削除</button>
					</td>

					<td class="event_td_7" rowspan="2">
						<label for="upd_i<?=$a1?>" class="info_img"><img id="top_upd_i<?=$a1?>" src="<?=$a2["img"]?>" style="width:210px; height:70px;"></span>
						<span class="img_large"></span>
						<input id="upd_i<?=$a1?>" name="upd_img" type="file" class="upd_file" style="display:none;">
						<input id="st<?=$a1?>" type="hidden" name="event_status" value="<?=$a2["status"]?>">
					</td>
				</tr><tr>

					<td  class="event_td_5">
						<span class="event_tag">リンク</span><select name="category" class="w140">
							<option value="">なし</option>
							<option value="info"   <?if($a2["category"] == "info"){?> selected="selected"<?}?>>インフォ</option>
							<option value="event"   <?if($a2["category"] == "event"){?> selected="selected"<?}?>>イベント</option>
							<option value="person"  <?if($a2["category"] == "person"){?> selected="selected"<?}?>>CAST</option>
	　						<option value="blog"  <?if($a2["category"] == "blog"){?> selected="selected"<?}?>>ブログ</option>
							<option value="page"    <?if($a2["category"] == "page"){?> selected="selected"<?}?>>内部リンク</option>
							<option value="outer"   <?if($a2["category"] == "outer"){?> selected="selected"<?}?>>外部リンク</option>
						</select>
						<input type="text" name="event_key" style="width:175px;margin-left:5px;" value="<?=$a2["contents_key"]?>"> 
					</td>
				</tr>
				</tbody>
				</form>
			</table>
			<? } ?>
		</div>

		<div class="sub_box"></div>
<!--■■■■■■■■■■■■■■■■■■■■■■■■■■■-->
	<?}elseif($post_id == "event"){?>
		<div class="main_box">

		<table class="event_table" style="background:#ffe0f0;">
			<form id="fnew" action="./index.php" method="post" enctype="multipart/form-data">
			<input type="hidden" name="post_id" value="event">
			<input type="hidden" name="menu_post" value="contents">
			<input type="hidden" name="event_set_id" value="new">
			<input name="upd_img" type="file" class="upd_file" style="display:none;">
			<tr>
				<td class="event_td_0" rowspan="4"><span class="event_td_0_in">新規作成</span></td>
				<td class="event_td_3">
					<span class="event_tag">公開日</span>
					<input type="date" name="display_date" class="w140" value="<?=$day_date?>" autocomplete="off">
					<button  type="submit" class="event_reg_btn">登録</button>
				</td>

				<td class="event_td_6" rowspan="3">
					<label for="updnew" class="event_img"><img id="top_updnew" src="../img/event_no_image.png" style="width:275px; height:110px;"></span>
					<span class="img_large"></span>
				</td>

			</tr><tr>
				<td  class="event_td_5">
					<span class="event_tag">リンク</span><select name="category" class="w140">
						<option value="">なし</option>
						<option value="event"    <?if($a2["category"] == "event"){?> selected="selected"<?}?>>イベント</option>
						<option value="person"  <?if($a2["category"] == "person"){?> selected="selected"<?}?>>CAST</option>
						<option value="blog"  <?if($a2["category"] == "blog"){?> selected="selected"<?}?>>ブログ</option>
						<option value="page"    <?if($a2["category"] == "page"){?> selected="selected"<?}?>>内部リンク</option>
						<option value="outer"   <?if($a2["category"] == "outer"){?> selected="selected"<?}?>>外部リンク</option>
					</select>
					<input type="text" name="event_key" style="width:175px;margin-left:5px;" value=""> 
				</td>

			</tr><tr>
				<td  class="event_td_5">
					<span class="event_tag">TITLE</span>
					<input type="text" name="event_title" style="width:250px;" value="<?=$a2["title"]?>">
				</td>

			</tr><tr>
				<td  class="event_td_4" colspan="2"><textarea name="event_contents" class="event_td_4_in"><?=$a2["contents"]?></textarea></td>
			</tr>
			</form>
		</table>

		<div id="contents_sort" class="main_list list_sort">
			<?foreach($dat as $a1 => $a2){?>

			<table id="sort_item<?=$a1?>" class="event_table sort_item c<?=$a2["status"]?>">
				<form id="f<?=$a1?>" action="./index.php" method="post" enctype="multipart/form-data">
				<input type="hidden" name="post_id" value="event">
				<input type="hidden" name="menu_post" value="contents">
				<input type="hidden" name="event_set_id" value="<?=$a1?>">
				<input id="st<?=$a1?>" type="hidden" name="event_status" value="<?=$a2["status"]?>">
				<tbody>
				<tr>
					<td class="event_td_0" colspan="2"><span class="event_td_0_in"><?=$a2["id"]?></span></td>
						<td class="event_td_3">
						<span class="event_tag">公開日</span>
						<input type="date" name="display_date" class="w140" value="<?=$a2["display_date"]?>" autocomplete="off">
						<button id="cov<?=$a1?>" type="button" class="event_set_btn"><?=$st[$a2["status"]]?></button>
						<button id="chg<?=$a1?>" type="button" class="event_set_btn">更新</button>
						<button id="del<?=$a1?>" type="button" class="event_set_btn">削除</button>
					</td>

					<td class="event_td_6" rowspan="3">
						<label for="upd<?=$a1?>" class="event_img"><img id="top_upd<?=$a1?>" src="<?=$a2["img"]?>" style="width:275px; height:110px;"></span>
						<span class="img_large"></span>
						<input id="upd<?=$a1?>" name="upd_img" type="file" class="upd_file" style="display:none;">
					</td>
				</tr><tr>
					<td rowspan="3"  class="event_td_1 handle"></td>
					<td rowspan="3"  class="event_td_2">
						<input type="text" value="<?=$a2["sort"]?>" class="box_sort" disabled>
					</td>

					<td  class="event_td_5">
						<span class="event_tag">リンク</span><select name="category" class="w140">
							<option value="">なし</option>
							<option value="event"   <?if($a2["category"] == "event"){?> selected="selected"<?}?>>イベント</option>
							<option value="person"  <?if($a2["category"] == "person"){?> selected="selected"<?}?>>CAST</option>
							<option value="blog"  <?if($a2["category"] == "blog"){?> selected="selected"<?}?>>ブログ</option>
							<option value="page"    <?if($a2["category"] == "page"){?> selected="selected"<?}?>>内部リンク</option>
							<option value="outer"   <?if($a2["category"] == "outer"){?> selected="selected"<?}?>>外部リンク</option>
						</select>
						<input type="text" name="event_key" style="width:175px;margin-left:5px;" value="<?=$a2["contents_key"]?>"> 
					</td>

				</tr><tr>
					<td  class="event_td_5">
						<span class="event_tag">TITLE</span>
						<input type="text" name="event_title" style="width:250px;" value="<?=$a2["title"]?>">
					</td>

				</tr><tr>
					<td  class="event_td_4" colspan="2"><textarea name="event_contents" class="event_td_4_in"><?=$a2["contents"]?></textarea></td>
				</tr>
				</tbody>
				</form>
			</table>
			<? } ?>
		</div>

		<div class="sub_box">
			<div>新規作成</div>
		</div>

<!--■■■■■■■■■■■■■■■■■■■■■■■■■■■-->

	<?}else{?>
		<?if($post_id == "recruit"){?>
			<div class="main_box">
				<table class="recuruit_table">
					<form id="f<?=$recruit_id?>" action="./index.php" method="post" multipart/form-data>
					<input type="hidden" name="post_id" value="recruit">
					<input type="hidden" name="menu_post" value="contents">
					<input type="hidden" name="event_set_id" value="<?=$a1?>">
					<input type="hidden" name="category" value="top">
					<tr>
						<td colspan="2" style="width:60px;"></td>
						<td class="recruit_td3">
							<input type="text" name="event_title" class="recruit_title" value="<?=$recruit_title?>">
							<button id="cov<?=$recruit_id?>" type="button" class="event_set_btn">非表示</button>
							<button id="chg<?=$recruit_id?>" type="button" class="event_set_btn">更新</button>
							<button id="del<?=$recruit_id?>" type="button" class="event_set_btn">削除</button>
							<textarea name="event_contents" class="recruit_contents"><?=$recruit_contents?></textarea>
						</td>
					</tr>
					</form>

					<tbody id="contents_sort" class="list_sort">
						<?foreach($dat as $a1 => $a2){?>
							<tr id="sort_item<?=$a1?>" class="tr sort_item">
								<form id="f<?=$a1?>" action="./index.php" method="post" multipart/form-data>
									<input type="hidden" name="post_id" value="recruit">
									<input type="hidden" name="menu_post" value="contents">
									<input type="hidden" name="event_set_id" value="<?=$a1?>">
									<input type="hidden" name="category" value="list">
									<td class="event_td_1 handle"></td>
									<td class="event_td_2"><input type="text" value="<?=$a2["sort"]?>" class="box_sort" disabled></td>
									<td class="recruit_td3">
										<input type="text" name="event_title" class="recruit_title" value="<?=$a2["title"]?>">
										<button id="cov<?=$a1?>" type="button" class="event_set_btn">非表示</button>
										<button id="chg<?=$a1?>" type="button" class="event_set_btn">更新</button>
										<button id="del<?=$a1?>" type="button" class="event_set_btn">削除</button>
										<textarea name="event_contents" class="recruit_contents"><?=$a2["contents"]?></textarea>
									</td>
								</form>
							</tr>
						<? } ?>
					</tbody>
				</table>
			</div>

		<?}else{?>
			<div class="main_box">
				<form id="page_set" method="post">
					<div class="page_top">
						<span class="event_tag">TITLE</span>
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
