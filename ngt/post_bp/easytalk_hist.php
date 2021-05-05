<?
/*
mail_hist
*/

include_once('../library/sql_post.php');
$c_id		=$_POST['c_id'];
$st			=($_POST['pg']+0)*10;
$st			=0;
$n			=0;


$sql	 ="SELECT * FROM wp01_0easytalk AS M";
$sql	.=" LEFT JOIN wp01_0customer AS C ON M.customer_id=C.id";
$sql	.=" WHERE M.customer_id='{$c_id}' AND M.cast_id='{$cast_data["id"]}'";
$sql	.=" AND M.del='0'";
$sql	.=" ORDER BY mail_id DESC";
$sql	.=" LIMIT {$st},10";

if($result = mysqli_query($mysqli,$sql)){
	while($row = mysqli_fetch_assoc($result)){
		$row["log"]=str_replace("\n","<br>",$row["log"]);
		$row["send_date"]=substr(str_replace("-",".",$row["send_date"]),0,16);

		if($row["watch_date"] =='0000-00-00 00:00:00'){
			$row["kidoku"]="<span class=\"midoku\">未読</span>";
			$row["new"]="<span class=\"mail_new\">NEW!</span>";

		}else{
			$row["kidoku"]="<span class=\"kidoku\">既読</span>";
			$row["bg"]=1;
		}

		if($row["img"]){
			$row["stamp"]="<img src=\"./img/cast/{$box_no}/m/{$row["img"]}.png\" class=\"mail_box_stamp\">";
		}
		$dat[]=$row;
		$count_dat++;
	}
}

if($dat[0]["face"]){
	$face="data:image/jpg;base64,{$dat[0]["face"]}";
}else{
	$face="./img/customer_no_image.png?t_".time();
}

for($n=$count_dat-1;$n>-1;$n--){
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
		$html.=$dat[$n]["stamp"];
		$html.="</div>";
		$html.="<span class=\"mail_box_date_a\">{$dat[$n]["send_date"]}　{$dat[$n]["new"]}</span>";
		$html.="</div>";

	}else{
		$html.="<div class=\"mail_box_b\">";
		$html.="<div class=\"mail_box_log_2 bg{$dat[$n]["bg"]}\">";
		$html.="<div class=\"mail_box_log_in\">";
		$html.=$dat[$n]["log"];
		$html.="</div>";
		$html.=$dat[$n]["stamp"];
		$html.="</div>";
		$html.="<span class=\"mail_box_date_b\">{$dat[$n]["kidoku"]}　{$dat[$n]["send_date"]}</span>";
		$html.="</div>";
	}
}

$sql	 ="UPDATE wp01_0easytalk SET";
$sql	.=" watch_date='{$now}'";
$sql	.=" WHERE customer_id='{$c_id}'";
$sql	.=" AND cast_id='{$cast_data["id"]}'";
$sql	.=" AND watch_date='0000-00-00 00:00:00'";
$sql	.=" AND send_flg=2";
mysqli_query($mysqli,$sql);
echo $html;
exit();
?>
