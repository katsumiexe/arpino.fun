<?
/*
通常ページ　CAST読み込み
*/
require_once ("./post_inc.php");
$now=date("Y-m-d H:i:s",$jst);

$date		=$_POST['date'];

$sql=" SELECT * FROM wp01_0sch_table";
$res0= $wpdb->get_results($sql,ARRAY_A);
foreach($res0 as $a1){
	$sch_table[$a1["in_out"]][$a1["name"]]=$a1["sort"];
}


$sql=" SELECT * FROM wp01_0cast";
$sql.=" WHERE del=0";
$res = $wpdb->get_results($sql,ARRAY_A);

foreach($res as $a1){
	$dat[$a1["id"]]=$a1;

	$sql =" SELECT * FROM wp01_0schedule";
	$sql.=" WHERE sche_date='{$date}'";
	$sql.=" AND cast_id='{$a1["id"]}'";
	$res2 = $wpdb->get_results($sql,ARRAY_A);

	foreach($res2 as $a2){
	if(strlen($a2["stime"])>0 && strlen($a2["etime"])>0){
		$dat[$a1["id"]]["sch"]="{$a2["stime"]}-{$a2["etime"]}";
		$sort[$a1["id"]]=$sch_table["in"][$a2["stime"]];
	}else{
		$dat[$a1["id"]]["sch"]="休み";
		$sort[$a1["id"]]=999999;
	}

	if($a1["face1"] > 0){
		$dat[$a1["id"]]["face"]=get_template_directory_uri()."/img/page/{$a1["id"]}/{$a1["face1"]}.jpg";			
	}else{
		$dat[$a1["id"]]["face"]=get_template_directory_uri()."/img/page/noimage.jpg";			
	}
}
asort($sort);
$link=get_template_directory_uri();

foreach($sort as $b1=> $b2){

$html.="<a href=\"{$link}/person/{$b1}\" id=\"i{$b1}\" class=\"main_b_1\">";
$html.="<img src=\"{$dat[$b1]["face"]}\" class=\"main_b_1_1\">";
$html.="<span class=\"main_b_1_2\">{$dat[$b1]["genji"]}</span>";
$html.="<div class=\"main_b_1_3\">{$dat[$b1]["sch"]}</div>";
$html.="</a>";
}
echo $html;
exit();
?>
