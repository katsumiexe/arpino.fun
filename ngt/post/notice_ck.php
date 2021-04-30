<?
/*
お知らせ見た処理
*/
include_once('../library/sql_post.php');
$n_id	=$_POST["n_id"];


$sql	 ="UPDATE wp01_0notice_ck SET";
$sql	.=" status='2'";
$sql	.=" WHERE cast_id='{$cast_data["id"]}'";
$sql	.=" AND notice_id='{$n_id}'";
mysqli_query($mysqli,$sql);


$sql	 ="SELECT * FROM wp01_0notice_res";
$sql	.=" WHERE del='0'";
$sql	.=" AND notice_id='{$n_id}'";
$sql	.=" AND (target='1' OR write_id='{$cast_data["id"]}')";
$sql	.=" ORDER BY date DESC";

if($result2 = mysqli_query($mysqli,$sql)){
	while($row2 = mysqli_fetch_assoc($result2)){
		$sql	 ="SELECT * FROM wp01_0notice_attarch";
		$sql	.=" WHERE del='0'";
		$sql	.=" AND notice_id='{$row2["id"]}'";
		$sql	.=" AND block='2'";
		$sql	.=" ORDER BY id ASC";

		if($result3 = mysqli_query($mysqli,$sql)){
			while($row3 = mysqli_fetch_assoc($result3)){
				if($row3["type"]== 1){
					$notice_res_img[$row2["id"]]=$row3;

				}else{
					$notice_res_attach[$row2["id"]]=$row3;
				}
			}
		}
		$notice_res[$row["id"]]=$row2;
	}
}

$sql	 ="SELECT * FROM wp01_0notice_attarch";
$sql	.=" WHERE del='0'";
$sql	.=" AND notice_id='{$row["id"]}'";
$sql	.=" AND block='1'";
$sql	.=" ORDER BY id ASC";

if($result2 = mysqli_query($mysqli,$sql)){
	while($row2 = mysqli_fetch_assoc($result2)){
		if($row2["type"]== 1){
			$notice_img[$row["id"]]=$row2;

		}else{
			$notice_attach[$row["id"]]=$row2;
		}
	}
}
$row["log"]=str_replace("\n","<br>",$row["log"]);


?>
