<?
include_once("./library/session.php");
$end=date("Y-m-d H:i:s");

$log_id		=$_POST["log_id"];

$doll		=json_decode($_POST["doll"]);
$persona	=json_decode($_POST["persona"]);
$pts		=json_decode($_POST["pts"]);
$getp		=json_decode($_POST["getp"]);
$getn		=json_decode($_POST["getn"],false);

$doll		=(array)$doll;
$persona	=(array)$persona;
$pts		=(array)$pts;
$getp		=(array)$getp;
$getn		=(array)$getn;

arsort($pts);
krsort($doll);

$tmp_rank=1;

$p=0;
$r=0;
$n=0;

var_dump($getp);
print("<hr>");

var_dump($getn);

foreach($getp as $a1 => $a2){
	$get[$a2][$a1]=$getn[$a1];
//print($a1."■".$a2."■".$getn[$a1]."■<br>\n");

}

foreach($pts as $a1 => $a2){

	if($a2 != $tmp_a2){
		$order++;
	}
	$result=floor($a2);
	$app.="<table class=\"table_res\">";
	$app.="<tr><td class=\"td_res\">";
	$app.="<div class=\"res_a{$order}\">{$order}</div>";

	$app.="<img src=\"./img/chr/chr{$persona[$a1]}.jpg\" class=\"res_b\">";
	$app.="<img src=\"./img/unit/unit_{$doll[$a1]}.png\" class=\"res_c\">";
	$app.="<div class=\"res_d\">{$name[$$a1]}</div>";

	$app.="<table class=\"res_e\">";
	$app.="<tr>";
	for($d=0;$d<6;$d++){
		if($get[$a1][$d]>0){
			$app.="<td class=\"res_e_1\">{$get[$a1][$d]}</td>";

		}elseif($get[$a1][$d]<0){
			$app.="<td class=\"res_e_2\">{$get[$a1][$d]}</td>";

		}else{
			$app.="<td class=\"res_e_3\">0</td>";
		}
	}

	$app.="</tr><tr>";
	for($d=6;$d<12;$d++){
		if($get[$a1][$d]>0){
			$app.="<td class=\"res_e_1\">{floor($get[$a1][$d])}</td>";

		}elseif($get[$a1][$d]<0){
			$app.="<td class=\"res_e_2\">{floor($get[$a1][$d])}</td>";

		}else{
			$app.="<td class=\"res_e_3\">0</td>";
		}
	}
	$app.="</table>";

	$app.="<div class=\"res_f\">{$result}</div>";
	$app.="</td></tr>";
	$app.="</table>";

	$tmp_pts=$a2;
}

$sql=" UPDATE log_data SET";
$sql.=" end='{$date}',";
$sql.=" pts_p='{$pts["p"]}',";
$sql.=" pts_a='{$pts["a"]}',";
$sql.=" pts_b='{$pts["b"]}',";
$sql.=" pts_c='{$pts["c"]}',";
$sql.=" pts_d='{$pts["d"]}'";
$sql.=" WHERE id='{$log_id}'";
mysqli_query($mysqli,$sql);

echo $app;
exit();
?>