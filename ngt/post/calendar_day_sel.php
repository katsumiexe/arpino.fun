<?
include_once('../library/sql_post.php');
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
	if(!$dat["stime"] || !$dat["etime"]){
		$dat["stime"]="休み";
	}
}else{
		$dat["stime"]="休み";
}


//---------------------------------------------------------------
$tmp_w=date("w",strtotime($set_date));
$dat["date"]=substr($set_date,4,2)."月".substr($set_date,6,2)."日[".$week[$tmp_w]."]";

$b_month=substr($set_date,4,4);
$sql	 ="SELECT * FROM wp01_0customer";
$sql	.=" WHERE cast_id='{$cast_data["id"]}'";
$sql	.=" AND birth_day LIKE '%{$b_month}%'";
$sql	.=" AND del='0'";
$sql	.=" ORDER BY customer_id ASC";

if($result = mysqli_query($mysqli,$sql)){
	while($row = mysqli_fetch_assoc($result)){
		$tmp_age=ceil($set_date-$birth_day);
		$dat["birth"].=$row["nickname"]."(".$tmp_age.")<br>";
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
