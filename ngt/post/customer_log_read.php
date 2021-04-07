<?
include_once('../library/sql_post.php');
$c_id		=$_POST["c_id"];

$sql	 ="SELECT * FROM wp01_0cast_log";
$sql	.=" WHERE cast_id='{$cast_data["id"]}'";
$sql	.=" AND customer_id='{$c_id}'";
$sql	.=" ORDER BY log_id DESC";
$sql	.=" LIMIT 20";

if($result = mysqli_query($mysqli,$sql)){
	while($dat1 = mysqli_fetch_assoc($result)){

		$t_date=substr($dat1["sdate"],0,4)."/".substr($dat1["sdate"],4,2)."/".substr($dat1["sdate"],6,2);
		$s_time=substr($dat1["stime"],0,2).":".substr($dat1["stime"],2,2);
		$e_time=substr($dat1["etime"],0,2).":".substr($dat1["etime"],2,2);

		$dat1["log"]=str_replace("\n","<br>",$dat1["log"]);

		$dat.="<tr id=\"customer_log_td_{$dat1["log_id"]}\"><td class=\"customer_log_td\">";
		$dat.="<div class=\"customer_log_date\"> <span class=\"customer_log_icon\"></span><span class=\"customer_log_date_detail\">{$t_date} {$s_time}-{$e_time}</span>";
		$dat.="<div id=\"l_chg{$dat1["log_id"]}\" class=\"customer_log_chg\"></div>";
		$dat.="<div id=\"l_del{$dat1["log_id"]}\" class=\"customer_log_del\"></div>";
		$dat.="</div>";

		$dat.="<div class=\"customer_log_memo\">";
		$dat.="{$dat1["log"]}";
		$dat.="</div>";
		$dat.="<div class=\"customer_log_list\">";



		$sql	 ="SELECT * FROM wp01_0cast_log_list";
		$sql	.=" WHERE master_id='{$dat1["log_id"]}'";
		$sql	.=" ORDER BY wp01_0cast_log_list.id DESC";

		if($result2 = mysqli_query($mysqli,$sql)){
			while($dat3 = mysqli_fetch_assoc($result2)){
				$dat.="<div class=\"customer_log_item\" style=\"border:1px solid {$dat3["log_color"]}; color:{$dat3["log_color"]};\">";
				$dat.="<span class=\"sel_log_icon_s\">{$dat3["log_icon"]}</span>";
				$dat.="<span class=\"sel_log_comm_s\">{$dat3["log_comm"]}</span>";
				$dat.="<span class=\"sel_log_price_s\">{$dat3["log_price"]}</span>";
				$dat.="</div>";
			}
		}
		$dat.="</div>";
		$dat.="</td></tr>";
	}
}

if(!$dat){
	$dat="<tr><td class=\"customer_memo_td1\" style=\"text-align:center;\"><br>まだ何もありません<br><br></td></tr>";
}


echo $sql;
echo $dat;
exit();
?>
