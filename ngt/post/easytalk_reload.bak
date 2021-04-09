<?
include_once('../library/sql_cast.php');
$c_id	=$_POST['c_id'];
$n=0;

$sql	 ="SELECT nickname,name,face,mail_id,send_date,watch_date,log,img_1 FROM wp01_0castmail AS M";
$sql	.=" LEFT JOIN wp01_0customer AS C ON M.customer_id=C.id";
$sql	.=" WHERE M.customer_id='{$c_id}' AND M.cast_id='{$cast_data["id"]}'";
$sql	.=" AND M.del='0'";
$sql	.=" ORDER BY mail_id DESC";
$sql	.=" LIMIT 10";

if($result = mysqli_query($mysqli,$sql)){
	while($row = mysqli_fetch_assoc($result)){
		$row["log"]=str_replace("\n","<br>",$row["log"]);
		$row["send_date"]=substr(str_replace("-",".",$row["send_date"]),0,16);

		if($row["watch_date"] =='0000-00-00 00:00:00'){
			$row["kidoku"]	="<span class=\"midoku\">未読</span>";
			$row["new"]		="<span class=\"mail_new\">NEW!</span>";
		}else{
			$row["kidoku"]	="<span class=\"kidoku\">既読</span>";
			$row["bg"]		=1;
		}
		$row2[$n]			=$row;
		$n++;
	}
}

$dat=array_reverse($row2);


$sql	 ="UPDATE wp01_0castmail SET";
$sql	.=" watch_date='{$now}'";
$sql	.=" WHERE customer_id='{$c_id}'";
$sql	.=" AND cast_id='{$cast_data["id"]}'";
$sql	.=" AND watch_date='0000-00-00 00:00:00'";
$sql	.=" AND send_flg=2";

mysqli_query($mysqli,$sql);


if($row["face"]){
	$face="./img/cast/{$box_no}/c/{$row["face"]}?t_".time();
}else{
	$face="./img/customer_no_img.jpg?t_".time();
}


for($n=s;$s<$n;$s++){

	if($dat[$s]["send_flg"] == 2){
//	$dat[$n]["border"]="<div class=\"mail_border\">{$dat[$n]["watch_date"]}■{$dat[$n1]["watch_date"]}■{$dat[$n+1]["watch_date"]}■</div>";

if($dat[$s]["watch_date"] =="0000-00-00 00:00:00" && $dat[$s-1]["watch_date"] !="0000-00-00 00:00:00"){
		$html.="<div class=\"mail_border\">----------ここから新着--------------</div>";
}
		$html.="<div class=\"mail_box_a\">";		
		$html.="<div class=\"mail_box_face\">";
		$html.="<img src=\"{$face}\" class=\"mail_box_img\">";
		$html.="</div>";
		$html.="<div class=\"mail_box_log_1\">";
		$html.=$dat[$s]["log"];
		$html.="</div>";
		$html.="<span class=\"mail_box_date_a\">{$dat[$s]["send_date"]}　{$dat[$s]["new"]}</span>";
		$html.="</div>";

	}else{
		$html.="<div class=\"mail_box_b\">";
		$html.="<div class=\"mail_box_log_2 bg{$dat[$s]["bg"]}\">";
		$html.=$dat[$s]["log"];
		$html.="</div>";
		$html.="<span class=\"mail_box_date_b\">{$dat[$s]["kidoku"]}　{$dat[$s]["send_date"]}</span>";
		$html.="</div>";
	}
}

$html.="<div class=\"mail_border\" style=\"padding:0\"></div>";
echo $html;
exit();
?>
