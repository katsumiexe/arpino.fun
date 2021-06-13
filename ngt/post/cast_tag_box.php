<?
/*
通常ページ　CAST読み込み
*/
include_once('../library/sql.php');

$sort=array();
$date		=$_POST['date'];

$sql=" SELECT id, genji,ctime FROM wp01_0cast";
$sql.=" WHERE cast_status=0";
$sql.=" AND id>0";
$sql.=" AND genji IS NOT NULL";
$sql.=" ORDER BY cast_sort ASC";
if($result = mysqli_query($mysqli,$sql)){
	while($row = mysqli_fetch_assoc($result)){

		if($day_8 < $row["ctime"] && $admin_config["coming_soon"]==1){
			$row["new"]=1;

		}elseif($day_8 == $row["ctime"] && $admin_config["today_commer"]==1){
			$row["new"]=2;

		}elseif((strtotime($day_8) - strtotime($row["ctime"]))/86400<$admin_config["new_commer_cnt"]){
			$row["new"]=3;
		}


		if (file_exists("../img/profile/{$row["id"]}/0.jpg")) {
			$row["face"]="./img/profile/{$row["id"]}/0.jpg";		

		}else{
			$row["face"]="./img/cast_no_image.jpg";			
		}
		$row["sch"]		="休み";	
		$row["sort"]	=9999;

		$cast_dat[$row["id"]]=$row;
	}
}


$sql=" SELECT stime, etime, cast_id, sort FROM wp01_0schedule AS S";
$sql.=" LEFT JOIN wp01_0sch_table AS T ON S.stime=T.name";
$sql.=" WHERE sche_date='{$date}'";
$sql.=" AND in_out='in'";
$sql.=" ORDER BY S.id ASC, T.sort ASC";

if($result = mysqli_query($mysqli,$sql)){
	while($row = mysqli_fetch_assoc($result)){
		if($row["stime"] && $row["etime"]){
			$cast_dat[$row["cast_id"]]["sch"]="{$row["stime"]} － {$row["etime"]}";
			$cast_dat[$row["cast_id"]]["sort"]=$row["sort"];

		}else{
			$cast_dat[$row["cast_id"]]["sch"]="休み";
			$cast_dat[$row["cast_id"]]["sort"]=9999;
		}
	}
}

asort($sort);

foreach($cast_dat as $b1=> $b2){

	$html.="<a href=\"./person.php?post_id={$b1}\" id=\"i{$b1}\" class=\"main_d_1\">";
	$html.="<img src=\"{$b2["face"]}\" class=\"main_d_1_1\">";
	$html.="<span class=\"main_d_1_2\">";
	$html.="<span class=\"main_b_1_2_h\"></span>";
	$html.="<span class=\"main_b_1_2_f f_tr\"></span>";
	$html.="<span class=\"main_b_1_2_f f_tl\"></span>";
	$html.="<span class=\"main_b_1_2_f f_br\"></span>";
	$html.="<span class=\"main_b_1_2_f f_bl\"></span>";
	$html.="<span class=\"main_d_1_2_name\">{$b2["genji"]}</span>";
	$html.="<span class=\"main_d_1_2_sch\">{$b2["sch"]}</span>";
	$html.="</span>";

	if($b2["new"] == 1){
		$html.="<span class=\"main_b_1_ribbon ribbon1\">近日入店</span>";

	}elseif($b2["new"] == 2){
		$html.="<span class=\"main_b_1_ribbon ribbon2\">本日入店</span>";

	}elseif($b2["new"] == 3){
		$html.="<span class=\"main_b_1_ribbon ribbon3\">新人</span>";
	}
	$html.="</a>";
}

echo $html;
exit();
?>