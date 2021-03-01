<?
/*
mail_hist
*/
include_once('../library/sql_cast.php');
$c_id		=$_POST['c_id'];
$st			=($_POST['pg']+0)*10;
$st=0;
$n=0;


$id_8=substr("00000000".$cast_data["id"],-8);
$id_0	=$_SESSION["id"] % 20;

for($n=0;$n<8;$n++){
	$tmp_id=substr($id_8,$n,1);
	$tmp_dir.=$dec[$id_0][$tmp_id];
}

$sql	 ="SELECT * FROM wp01_0castmail AS M";
$sql	.=" LEFT JOIN wp01_0customer AS C ON M.customer_id=C.id";
$sql	.=" WHERE M.customer_id='{$c_id}' AND M.cast_id='{$cast_data["id"]}'";
$sql	.=" AND M.del='0'";
$sql	.=" ORDER BY mail_id DESC";
$sql	.=" LIMIT {$st},10";

if($result = mysqli_query($mysqli,$sql)){
	$row = mysqli_fetch_assoc($result);
	$row[$n]=$a1;
	$row[$n]["log"]=str_replace("\n","<br>",$row[$n]["log"]);
	$row[$n]["send_date"]=substr(str_replace("-",".",$row[$n]["send_date"]),0,16);

	if($row[$n]["watch_date"] =='0000-00-00 00:00:00'){
		$row[$n]["kidoku"]="<span class=\"midoku\">未読</span>";
		$row[$n]["new"]="<span class=\"mail_new\">NEW!</span>";

	}else{
		$row[$n]["kidoku"]="<span class=\"kidoku\">既読</span>";
		$row[$n]["bg"]=1;
	}

	$row[$n]["stamp"]="./img/cast/".$tmp_dir."/m/".$row[$n]["img_1"].".png";
	$n++;
}


$sql	 ="UPDATE wp01_0castmail SET";
$sql	.=" watch_date='{$now}'";
$sql	.=" WHERE customer_id='{$c_id}'";
$sql	.=" AND cast_id='{$cast_data["id"]}'";
$sql	.=" AND watch_date='0000-00-00 00:00:00'";
$sql	.=" AND send_flg=2";
mysqli_query($mysqli,$sql);

if($a1["face"]){
	$face="./img/cast/".$tmp_dir."/c/".$a1["face"]."?t_".time();
}else{
	$face="./img/customer_no_img.jpg?t_".time();
}


//$html=$tmp_sql;
for($n=0;$n<count($dat);$n++){
	if($dat[$n]["send_flg"] == 2){

if($dat[$n]["watch_date"] =="0000-00-00 00:00:00" && $dat[$n-1]["watch_date"] !="0000-00-00 00:00:00"){
		$html.="<div class=\"mail_border\">----------ここから新着--------------</div>";
}
		$html.="<div class=\"mail_box_a\">";		
		$html.="<div class=\"mail_box_face\">";
		$html.="<img src=\"{$face}\" class=\"mail_box_img\">";
		$html.="</div>";
		$html.="<div class=\"mail_box_log_1\">";
		$html.="<div class=\"mail_box_log_in\">";
		$html.=$dat[$n]["log"];
		$html.="</div>";

		if($dat[$n]["img_1"]){
			$html.="<img src=\"".get_template_directory_uri()."/img/cast/{$tmp_dir}/m/{$dat[$n]["img_1"]}.png\" class=\"mail_box_stamp\">";		
		}

		$html.="</div>";
		$html.="<span class=\"mail_box_date_a\">{$dat[$n]["send_date"]}　{$dat[$n]["new"]}</span>";
		$html.="</div>";

	}else{
		$html.="<div class=\"mail_box_b\">";
		$html.="<div class=\"mail_box_log_2 bg{$dat[$n]["bg"]}\">";
		$html.="<div class=\"mail_box_log_in\">";
		$html.=$dat[$n]["log"];
		$html.="</div>";
		if($dat[$n]["img_1"]){
			$html.="<img src=\"{$dat[$n]["stamp"]}\" class=\"mail_box_stamp\">";		
		}


		$html.="</div>";
		$html.="<span class=\"mail_box_date_b\">{$dat[$n]["kidoku"]}　{$dat[$n]["send_date"]}</span>";
		$html.="</div>";
	}
}
echo $html;
exit();
?>
