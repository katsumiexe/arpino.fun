<?
include_once("./library/session.php");

$end=date("Y-m-d H:i:s");
$log_id		=$_POST["log_id"];
$getpts		=$_POST["getpts"];
$getply		=$_POST["getply"];

$doll		=$_POST["doll"];
//$doll		=json_decode(json_encode($_POST["doll"], true));
$persona	=json_encode(json_decode($_POST["persona"], false));
$pts		=$_POST["pts"];

for($n=0;$n<12;$n++){
	$getlist[$getply[$n]][$n]=$getpts[$n];
}
arsort($pts);

$tmp_rank=1;
$p=0;

print("-----<br>\n");
foreach($doll as $a1 => $a2){
print($a1."□".$a2."<br>\n");

}

print("-----<br>\n");
var_dump($doll);
print("-----<br>\n");

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

for($g=0;$g<12;$g++){
	$get[$getply[0]][$g]=$getpts[$g];
}

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

//echo $app;

//var_dump($doll);
exit();
?>