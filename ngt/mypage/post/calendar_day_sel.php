<?
include_once('../../library/sql_post.php');
$week[0]="日";
$week[1]="月";
$week[2]="火";
$week[3]="水";
$week[4]="木";
$week[5]="金";
$week[6]="土";

$set_date	=$_POST["set_date"];
$dat=array();
//---------------------------------------------------------------
$sql	 ="SELECT stime,etime FROM wp01_0schedule";
$sql	.=" WHERE cast_id='{$cast_data["id"]}'";
$sql	.=" AND sche_date='{$set_date}'";
$sql	.=" ORDER BY id DESC";
$sql	.=" LIMIT 1";

if($result = mysqli_query($mysqli,$sql)){
	$dat = mysqli_fetch_assoc($result);
	if($dat["stime"] && $dat["etime"]){
		$dat["sche"]="<span class=\"sche_s\">{$dat["stime"]}</span><span class=\"sche_m\">-</span><span class=\"sche_e\">{$dat["etime"]}</span>";
	}else{
		$dat["sche"]="<span class=\"sche_s\">休み</span>";
	}
}else{
		$dat["sche"]="<span class=\"sche_s\">休み</span>";
}



//---------------------------------------------------------------
$tmp_w=date("w",strtotime($set_date));
$dat["date"]=substr($set_date,4,2)."月".substr($set_date,6,2)."日[".$week[$tmp_w]."]";

$b_month=substr($set_date,4,4);

$dat["birth"]="";
$sql	 ="SELECT birth_day,id,name,nickname FROM wp01_0customer";
$sql	.=" WHERE cast_id='{$cast_data["id"]}'";
$sql	.=" AND birth_day LIKE '%{$b_month}'";
$sql	.=" AND del='0'";
$sql	.=" ORDER BY id ASC";

if($result = mysqli_query($mysqli,$sql)){
	while($row = mysqli_fetch_assoc($result)){
		$tmp_age=ceil(($set_date-$row["birth_day"])/10000);
		if(!$row["nickname"]) $row["nickname"]=$row["name"]."様";
		$dat["birth"].="<span id=\"c{$row["id"]}\" class=\"cal_days_birth_in\"><span class=\"days_icon\"></span><span class=\"days_birth\">{$row["nickname"]}({$tmp_age})</span></span><br>";
	}
}

//---------------------------------------------------------------
$sql	 ="SELECT * FROM wp01_0schedule_memo";
$sql	.=" WHERE cast_id='{$cast_data["id"]}'";
$sql	.=" AND date_8='{$set_date}'";
$sql	.=" AND `log` IS NOT NULL";
$sql	.=" LIMIT 1";

if($result = mysqli_query($mysqli,$sql)){
	$row = mysqli_fetch_assoc($result);
	$dat["memo"]=$row["log"];
}
echo json_encode($dat);
exit();
?>
