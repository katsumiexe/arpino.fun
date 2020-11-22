<?
/*
mail_hist
*/
require_once ("./post_inc.php");
$c_id	=$_POST['c_id'];
$cast_id	=$_POST['cast_id'];
$now=date("Y-m-d H:i:s",$jst);

$sql ="SELECT * FROM wp01_0encode"; 
$enc0 = $wpdb->get_results($sql,ARRAY_A );
foreach($enc0 as $row){
	$enc[$row["key"]]				=$row["value"];
	$dec[$row["gp"]][$row["value"]]	=$row["key"];
}

$id_8=substr("00000000".$cast_id,-8);
$id_0	=$_SESSION["id"] % 20;

for($n=0;$n<8;$n++){
	$tmp_id=substr($id_8,$n,1);
	$box_no.=$dec[$id_0][$tmp_id];
}



$sql	 ="UPDATE wp01_0castmail SET";
$sql	.=" watch_date='{$now}'";
$sql	.=" WHERE customer_id='{$c_id}'";
$sql	.=" AND cast_id='{$cast_id}'";
$sql	.=" AND watch_date='0000-00-00 00:00:00'";
$sql	.=" AND send_flg=2";
$wpdb->query($sql);

$sql	 ="SELECT * FROM wp01_0castmail AS M";
$sql	.=" LEFT JOIN wp01_0customer AS C ON M.customer_id=C.id";
$sql	.=" WHERE M.customer_id='{$c_id}' AND M.cast_id='{$cast_id}'";
$sql	.=" AND M.del='0'";
$sql	.=" ORDER BY mail_id DESC";
$sql	.=" LIMIT 10";

$res = $wpdb->get_results($sql,ARRAY_A);
//$n=count($res)-1;
$n=0;

foreach($res as $a1){
	$dat[$n]=$a1;
	$dat[$n]["log"]=str_replace("\n","<br>",$dat[$n]["log"]);
	$dat[$n]["send_date"]=str_replace("-",".",$dat[$n]["send_date"]);

	if($dat[$n]["watch_date"] =='0000-00-00 00:00:00'){
		$dat[$n]["kidoku"]="<span class=\"midoku\">未読</span>";
	}else{
		$dat[$n]["kidoku"]="<span class=\"kidoku\">既読</span>";
		$dat[$n]["bg"]=1;
	}

	$n++;
}


if($a1["face"]){
$face=get_template_directory_uri()."/img/cast/".$box_no."/c/".$a1["face"]."?t_".time();
}else{
$face=get_template_directory_uri()."/img/customer_no_img.jpg?t_".time();
}

for($n=0;$n<count($dat);$n++){
	if($dat[$n]["send_flg"] == 2){
		$html.="<div class=\"mail_box_a\">";		
		$html.="<div class=\"mail_box_face\">";
		$html.="<img src=\"{$face}\" class=\"mail_box_img\">";
		$html.="</div>";
		$html.="<div class=\"mail_box_log_1\">";
		$html.=$dat[$n]["log"];
		$html.="</div>";
		$html.="<span class=\"mail_box_date_a\">{$dat[$n]["send_date"]}</span>";
		$html.="</div>";
	}else{
		$html.="<div class=\"mail_box_b\">";
		$html.="<div class=\"mail_box_log_2 bg{$dat[$n]["bg"]}\">";
		$html.=$dat[$n]["log"];
		$html.="</div>";
		$html.="<span class=\"mail_box_date_b\">{$dat[$n]["kidoku"]}　{$dat[$n]["send_date"]}</span>";
		$html.="</div>";
	}
}

echo $html;
exit();
?>
