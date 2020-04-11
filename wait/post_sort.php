<?
include_once("./library/session.php");
$end=date("Y-m-d H:i:s");

$log_id		=$_POST["log_id"];

$doll		=json_decode($_POST["doll"]);
$persona	=json_decode($_POST["persona"]);
$pts		=json_decode($_POST["pts"]);
$getp		=json_decode($_POST["getp"]);

$doll		=(array)$doll;
$persona	=(array)$persona;
$pts		=(array)$pts;
$getp		=(array)$getp;

arsort($pts);
krsort($doll);

$tmp_rank=1;

$p=0;
$r=0;
$n=0;

foreach($getp as $a1 => $a2){
	$get[$a1][$n]=$a2;
	$n++;
}

foreach($pts as $a1 => $a2){
$order++;

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
			$app.="<td class=\"res_e_1\">{$get[$a1][$d]}</td>";

		}elseif($get[$a1][$d]<0){
			$app.="<td class=\"res_e_2\">{$get[$a1][$d]}</td>";

		}else{
			$app.="<td class=\"res_e_3\">0</td>";
		}
	}
	$app.="</table>";

	$app.="<div class=\"res_f\">{$a2}</div>";
	$app.="</td></tr>";
	$app.="</table>";
}


/*

foreach($pts as $a1 => $a2){
	print($a1."◆".$a2."◆".$persona[$a1]."<br>");
	$list_rank[$p]=$tmp_rank;
	if($list_rank[$p-1] == $list_rank[$p]){
		$list_rank[$p]--;
	}	

	$list_pts[$p]		=int($a2);
	$list_doll[$p]		=$doll[$a1];
	$list_name[$p]		=$doll[$a1];
	$list_persona[$p]	=$persona[$a1];

	$tmp_rank++;
	$p++;
}



*/


/*
$app="<table class=\"table_res\">";
for($s=0;$s<12;$s++){
	$app.="<tr><td class=\"td_res\">";
	$app.="<div class=\"res_a{$list_rank[$s]}\">{$list_rank[$s]}</div>";

	$app.="<img src=\"./img/chr/chr{$list_persona[$s]}.jpg\" class=\"res_b\">";
	$app.="<img src=\"./img/unit/unit{$list_doll[$s]}.png\" class=\"res_c\">";
	$app.="<div class=\"res_d\">{$list_name[$s]}</div>";

	for($d=0;$d<12;$d++){
		if($get[$s][$d]>0){
			$app.="<span class=\"res_e_1\">{$get[$s][$d]}</span>";

		}elseif($get[$s][$d]<0){
			$app.="<span class=\"res_e_2\">{$get[$s][$d]}</span>";

		}else{
			$app.="<span class=\"res_e_3\">0</span>";
		}
	}
	$app.="<div class=\"res_f\">{$list_pts[$d]}</div>";
	$app.="</td></tr>";
}
$app.="</table>";


$sql=" UPDATE log_data SET";
$sql.=" end='{$date}',";
$sql.=" pts_p='{$pts["p"]}',";
$sql.=" pts_a='{$pts["a"]}',";
$sql.=" pts_b='{$pts["b"]}',";
$sql.=" pts_c='{$pts["c"]}',";
$sql.=" pts_d='{$pts["d"]}'";
$sql.=" WHERE id='{$log_id}'";
mysqli_query($mysqli,$sql);

*/


echo $app;

//var_dump($doll);
exit();
?>