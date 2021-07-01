<?

if($fil_st){
	$app.="AND view_date>='{$fil_st}'";
}

if($fil_ed){
	$app.="AND view_date>='{$fil_ed}'";
}

if($fil_key){
	$app.="AND log LIKE '%{$fil_key}%'";
}

if($fil_cast){
	$app.="AND P.cast ='{$fil_cast}'";
}

if($fil_tag){
	$app.="AND P.tag ='{$fil_tag}'";
}

$sql	 ="SELECT COUNT(id) AS cnt,blog_id FROM wp01_0posts";
$sql	.=" WHERE status<4";
$sql	.= $app;
$sql	.=" GROUP BY blog_id";
if($result = mysqli_query($mysqli,$sql)){
	while($row = mysqli_fetch_assoc($result)){
		$blog_count[$row["blog_id"]]=$row["cnt"];
	}
}


$sql	 ="SELECT P.id,P.blog_id,P.date, P.view_date, P.title, P.log, P.cast, P.tag, P.img, P.status, C.genji,C.cast_status FROM wp01_0posts AS P";
$sql	.=" LEFT JOIN wp01_0cast AS C ON P.cast=C.id";
$sql	.=" WHERE status<4";
$sql	.=" AND revision=0";

$sql	.=" ORDER BY view_date DESC";
$sql	.=" LIMIT 20";

if($result = mysqli_query($mysqli,$sql)){
	while($res = mysqli_fetch_assoc($result)){
		$res["event_date"]	=substr($res["event_date"],0,10);
		$res["display_date"]	=substr($res["display_date"],0,10);
		if($res["status"] ==0 && $res["display_date"] > date("Y-m-d")){
			$res["status"]=1;
		}
		$dat[$res["id"]]=$res;
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

.head{
	display			:inline-block;
	position		:fixed;
	top				:0;
	left			:180px;
	width			:calc(100vw - 180px);
	height			:50px;
	background		:#0000d0;
	z-index			:10;
}

.foot{
	display			:inline-block;
	position		:fixed;
	bottom			:0;
	left			:180px;
	width			:calc(100vw - 180px);
	height			:30px;
	background		:#00d000;
	z-index:10;

}
.wrap{
	display			:inline-flex;
	margin			:50px 0 30px 0;
	width			:1200px;

}

.icon{
	font-family:at_icon;
}
-->
</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script src="./js/jquery.ui.touch-punch.min.js"></script>
<script src="./js/image.js?_<?=time()?>"></script>
<script>
$(function(){ 
});
</script>
<header class="head">
<input id="sel_contents_0" value="1" type="radio" name="sel_contents" checked="checked"><label id="label_contents_0" for="sel_contents_0" class="sel_contents">イベント</label>
<input id="sel_contents_1" value="2" type="radio" name="sel_contents"><label id="label_contents_1" for="sel_contents_1" class="sel_contents">NEWS</label>
<input id="sel_contents_2" value="3" type="radio" name="sel_contents"><label id="label_contents_2" for="sel_contents_2" class="sel_contents">お知らせ</label>
<input id="sel_contents_3" value="4" type="radio" name="sel_contents"><label id="label_contents_3" for="sel_contents_3" class="sel_contents">SYSTEM</label>
<input id="sel_contents_4" value="5" type="radio" name="sel_contents"><label id="label_contents_4" for="sel_contents_4" class="sel_contents">ACCESS</label>
<input id="sel_contents_5" value="6" type="radio" name="sel_contents"><label id="label_contents_5" for="sel_contents_5" class="sel_contents">REQRUIT</label>
</header>
<div class="wrap">
	<div class="main_box">



	</div>
</div>
<footer class="foot"></footer> 
