<?
/*
通常ページ　CAST読み込み
*/
include_once('../library/sql.php');
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


	if (file_exists(get_template_directory()."/img/page/{$a1["id"]}/0.jpg")) {
		$dat[$a1["id"]]["face"]="{$link}/img/page/{$a1["id"]}/0.jpg";		
	}else{
		$dat[$a1["id"]]["face"]="{$link}/img/page/noimage.jpg";			
	}

	if($date < $a1["ctime"]){
		$dat[$a1["id"]]["new"]=1;

	}elseif($date == $a1["ctime"]){
		$dat[$a1["id"]]["new"]=2;

	}elseif(strtotime($date) - strtotime($a1["ctime"])<=2592000){
		$dat[$a1["id"]]["new"]=3;
	}


}
asort($sort);

foreach($sort as $b1=> $b2){
$html.="<a href=\"{$link}/person/?cast={$b1}\" id=\"i{$b1}\" class=\"main_d_1\">";
$html.="<img src=\"{$dat[$b1]["face"]}\" class=\"main_d_1_1\">";
$html.="<span class=\"main_d_1_2\">";
$html.="<span class=\"main_b_1_2_h\"></span>";
$html.="<span class=\"main_b_1_2_f f_tr\"></span>";
$html.="<span class=\"main_b_1_2_f f_tl\"></span>";
$html.="<span class=\"main_b_1_2_f f_br\"></span>";
$html.="<span class=\"main_b_1_2_f f_bl\"></span>";
$html.="<span class=\"main_d_1_2_name\">{$dat[$b1]["genji"]}</span>";
$html.="<span class=\"main_d_1_2_sch\">{$dat[$b1]["sch"]}</span>";
	$html.="</span>";

	if($dat[$b1]["new"] == 1){
		$html.="<span class=\"main_b_1_ribbon ribbon1\">近日入店</span>";

	}elseif($dat[$b1]["new"] == 2){
		$html.="<span class=\"main_b_1_ribbon ribbon2\">本日入店</span>";

	}elseif($dat[$b1]["new"] == 3){
		$html.="<span class=\"main_b_1_ribbon ribbon3\">新人</span>";
	}
	$html.="</a>";
}
echo $html;
exit();
?>