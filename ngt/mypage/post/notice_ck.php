<?
/*
お知らせ見た処理
*/
include_once('../../library/sql_post.php');

$n_id	=$_POST["n_id"];

$sql	 ="UPDATE wp01_0notice_ck SET";
$sql	.=" status='2',";
$sql	.=" view_date='{$now}'";
$sql	.=" WHERE cast_id='{$cast_data["id"]}'";
$sql	.=" AND notice_id='{$n_id}'";
$sql	.=" LIMIT 1";
mysqli_query($mysqli,$sql);	

$sql	 ="SELECT * FROM wp01_0notice";
$sql	.=" WHERE del='0'";
$sql	.=" AND id='{$n_id}'";
$sql	.=" LIMIT 1";

$result	= mysqli_query($mysqli,$sql);
$row	= mysqli_fetch_assoc($result);

$html.="<div class=\"notice_box_p\">";
$html.=str_replace("\n","<br>",$row["log"]);
$html.="</div>";
if($row["img_code"]){
$html.="<img src=\"data:image/jpg;base64,{$row["img_code"]}\" class=\"notice_box_img\">";
}

$sql	 ="SELECT * FROM wp01_0notice_res";
$sql	.=" WHERE del='0'";
$sql	.=" AND (target='1' OR write_id='{$cast_data["id"]}')";
$sql	.=" ORDER BY `date` DESC";

if($result2 = mysqli_query($mysqli,$sql)){
	while($row2 = mysqli_fetch_assoc($result2)){

		$html.="<div class=\"notice_res\">";
		$html.="<p class=\"notice_res_p\">";
		$html.=str_replace("\n","<br>",$row2["log"]);
		$html.="</p>";
		if($row2["img_code"]){
			$html.="<img src=\"data:image/jpg;base64,{$row2["img_code"]}\" class=\"notice_res_img\">";
		}
		$html.="</div>";

		$html.="<div class=\"notice_res_cast\">";
			if(file_exists("../img/profile/{$row2["write_id"]}/0_s.jpg")){
				$html.="<img src=\"../img/profile/{$row2["write_id"]}/0_s.jpg?t_{$day_time}\" class=\"notice_res_face\">";

			}else{
				$html.="<img src=\"../img/cast_no_image.jpg?t_{$day_time}\" class=\"notice_res_face\">";

			}
		$html.="</div>";
	$html.="</div>";
	}
}

echo $html;
exit();
?>
