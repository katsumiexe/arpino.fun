<?
/*
通常ページ　CAST読み込み
*/
include_once('../library/sql.php');
$date		=$_POST['date'];

$sql=" SELECT C.id, genji, in_out, `name`, T.sort,C.ctime, stime, etime FROM wp01_0cast AS C";
$sql.=" LEFT JOIN wp01_0schedule AS S ON C.id=S.cast_id";
$sql.=" LEFT JOIN wp01_0sch_table AS T ON in_out='in' AND stime=T.name";
$sql.=" WHERE C.cast_status=0";
$sql.=" AND sche_date='{$date}'";
$sql.=" AND C.id>0";
$sql.=" ORDER BY cast_sort ASC";

if($res = mysqli_query($mysqli,$sql)){
	while($a1 = mysqli_fetch_assoc($res)){
		if($a1["stime"] && $a1["etime"]){

			$a1["sch"]="{$a1["stime"]} － {$a1["etime"]}";
			$sort[$a1["id"]]=$a1["stime"];
		}else{
			$a1["sch"]="休み";
			$sort[$a1["id"]]=999999;
		}

		if (file_exists("../img/profile/{$a1["id"]}/0.jpg")) {
			$a1["face"]="./img/profile/{$a1["id"]}/0.jpg";		

		}else{
			$a1["face"]="./img/cast_no_image.jpg";			
		}

		if($day_8 < $a1["ctime"]){
			$a1["new"]=1;

		}elseif($day_8 == $a1["ctime"]){
			$a1["new"]=2;

		}elseif(strtotime($day_8) - strtotime($a1["ctime"])<=2592000){
			$a1["new"]=3;
		}

		$dat[$a1["id"]]=$a1;
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