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
		if($a2["stime"] && $a2["etime"]){
			$dat[$a1["id"]]["sch"]="{$a2["stime"]}-{$a2["etime"]}";
			$sort[$a1["id"]]=$sch_table["in"][$a2["stime"]];
		}else{
			$dat[$a1["id"]]["sch"]="";
		}
	}

	if(!$dat[$a1["id"]]["sch"]){
		$dat[$a1["id"]]["sch"]="休み";
		$sort[$a1["id"]]=999999;
	}


	if (file_exists(get_template_directory()."/img/page/{$a1["id"]}/1.jpg")) {
		$dat[$a1["id"]]["face"]="{$link}/img/page/{$a1["id"]}/1.jpg";		
	}else{
		$dat[$a1["id"]]["face"]="{$link}/img/page/noimage.jpg";			
	}



}
asort($sort);

foreach($sort as $b1=> $b2){

$html.="<a href=\"{$link}/person/{$b1}\" id=\"i{$b1}\" class=\"main_d_1\">";
$html.="<img src=\"{$dat[$b1]["face"]}\" class=\"main_d_1_1\">";
$html.="<span class=\"main_d_1_2\">";
$html.="<span class=\"main_d_1_2_name\">{$dat[$b1]["genji"]}</span>";
$html.="<span class=\"main_d_1_2_sch\">{$dat[$b1]["sch"]}</span>";
$html.="</span><span class=\"main_d_1_3\"></span></a>";
}
echo $html;
exit();
?>
