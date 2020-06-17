<?
include_once("./library/session.php");
$date=date("Y-m-d H:i:s");

$log_id		=$_POST["log_id"];
$lv			=$_POST["lv"];
$doll		=json_decode($_POST["doll"]);
$persona	=json_decode($_POST["persona"]);
$pts		=json_decode($_POST["pts"]);
$getp		=json_decode($_POST["getp"]);
$getn		=json_decode($_POST["getn"],true);

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

foreach($getp as $a1 => $a2){
	$get[$a2][$a1]=floor($getn[$a1]+0);
}

foreach($pts as $a1 => $a2){
	if($a1 !="l"){
		if($a2 != $tmp_a2){
			$order++;
		}

		if($order == 1){
			$app.="<div class=\"thanks\">";
			$app.="<span class=\"thanks_ttl\">Thanks for Your Playing!</span>";

			if( $a1 =="p"){
				$sql="INSERT INTO score_data(`date`, `unit`, `level`,`score`)";	
				$sql.=" VALUES('{$date}', '{$doll['p']}', '{$lv}','{$pts['p']}')";	
				mysqli_query($mysqli,$sql);
				$tmp_auto=mysqli_insert_id($mysqli);	
				$app.="<span class=\"thanks_tag\">H.N.</span> <input type=\"text\" value=\"名無し王子\" class=\"thanks_name\" maxlength=\"10\">";
				$app.="<input id=\"log_id\" type=\"hidden\" value=\"{$tmp_auto}\">";
				$app.="<div id=\"thanks_set\" class=\"thanks_btn\"></div>";
			}

			$app.="<div id=\"thanks_set\" class=\"thanks_back\"></div>";
			$app.="</div>";
		}

		$tmp_a2=$a2;
		$result=floor($a2+0);
		$app.="<table class=\"table_res\">";
		$app.="<tr><td class=\"td_res\">";
		$app.="<div class=\"res_a{$order}\">{$order}</div>";

		$app.="<img src=\"./img/chr/chr{$persona[$a1]}.jpg\" class=\"res_b\">";
		$app.="<img src=\"./img/unit/unit_{$doll[$a1]}.png\" class=\"res_c\">";
		$app.="<div class=\"res_d\">{$unit[$doll[$a1]]["name"]}</div>";

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
		$app.="<div class=\"res_f\"><span class=\"res_f1\">{$result}</span><span class=\"res_f2\">Pts</span></div>";
		$app.="</td></tr>";
		$app.="</table>";
		$tmp_pts=$a2;
	}
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
