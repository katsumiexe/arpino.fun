<?
include_once("./library/session.php");

$cast_id		=$_POST["cast_id"];
$name			=$_POST["name"];
$month			=substr($_POST["month"],0,6);

$last		=date("t",strtotime($_POST["month"]));
$t_month	=substr($_POST["month"],4,2);


$sql ="SELECT * FROM schedule";
$sql.=" WHERE cast_id='{$cast_id}'";
$sql.=" AND sche_date LIKE '{$month}%'";
$sql.=" ORDER BY sche_date ASC";

if($dat_a0 = mysqli_query($mysqli,$sql)){
	while($dat_a1 = mysqli_fetch_assoc($dat_a0)){
		$t_day=substr($dat_a1["sche_date"],-2,2)+0;

		if($dat[$t_day]["stime"] == 2400){
			$dat[$t_day]["stime"]="0000";
		}

		if($dat[$t_day]["etime"] == "0000"){
			$dat[$t_day]["etime"]="2400";
		}


		$dat[$t_day]["stime"]=$dat_a1["stime"];
		$dat[$t_day]["etime"]=$dat_a1["etime"];

		$dat[$t_day]["hour"]=($dat_a1["etime"]-$dat_a1["stime"])/100;
	}
}



	$log ="<form action=\"index.php\" method=\"post\">";

	$log .="<input type=\"hidden\" name=\"set_id\" value=\"{$cast_id}\">";
	$log .="<input type=\"hidden\" name=\"set_month\" value=\"{$month}\">";

	$log .="<div class=\"sch_id\">{$cast_id}</div>";
	$log.="<div class=\"sch_name\">{$name}</div>";
	$log.="<button class=\"sch_set\" type=\"submit\">登録</button>";


	$log.="<table class=\"table\"><tr>";
	$log.="<td class=\"td_id\" style=\"width:30px\">日</td>";
	$log.="<td class=\"td_id\" style=\"width:50px\">IN</td>";
	$log.="<td class=\"td_id\" style=\"width:50px\">OUT</td>";
	$log.="<td class=\"td_id\" style=\"width:50px\">hour</td>";
	$log.="</tr>";

for($n=1;$n<$last+1;$n++){
	$log.="<tr>";
	$log.="<td class=\"td_sch\">{$t_month}/{$n}</td>";
	$log.="<td class=\"td_sch\"><input type=\"text\" name=\"stime[{$n}]\" class=\"box2\" value=\"{$dat[$n]["stime"]}\"></td>";
	$log.="<td class=\"td_sch\"><input type=\"text\" name=\"etime[{$n}]\" class=\"box2\" value=\"{$dat[$n]["etime"]}\"></td>";
	$log.="<td class=\"td_sch\">{$dat[$n]["hour"]}</td>";
	$log.="</tr>";
}
	$log.="</table></form>";


echo($log);
exit();
?>
