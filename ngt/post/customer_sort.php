<?
include_once('../library/sql_post.php');

$cast_id	=$_POST["cast_id"];
$sel		=$_POST["sel"]+0;
$fil		=$_POST["fil"];
$asc		=$_POST["asc"];
$ext		=$_POST["ext"];
$s=0;


if($fil>0){
	$app1=" AND c_group={$fil}";
}

if($sel==1){
	$app2	=" `date`";
	$app4	=" LEFT JOIN wp01_0cast_log ON id=customer_id";
	$app5	=" ,MAX(`date`) AS log_date"; 

	if($asc==1){
		$app3	.=" DESC";
	}else{
		$app3	.=" ASC";
	}

}elseif($sel==2){
	$app2	=" `fav`";

	if($asc==1){
		$app3	.=" DESC";
	}else{
		$app3	.=" ASC";
	}

}elseif($sel==3){
	$app2	=" `birth_day`";

	if($asc==1){
		$app3	.=" ASC";
	}else{
		$app3	.=" DESC";
	}

}else{
	$app2	=" `id`";

	if($asc==1){
		$app3	.=" ASC";
	}else{
		$app3	.=" DESC";
	}
}


if($asc == 1){
	$order="DESC";
	$select="MAX(`date`)";

}else{
	$order="ASC";
	$select="MIN(`date`)";
}

if($ext){
	$sql="UPDATE wp01_0cast_config SET";
	$sql.=" c_sort_main='{$sel}',";
	$sql.=" c_sort_asc='{$asc}',";
	$sql.=" c_sort_group='{$fil}'";
	$sql.=" WHERE cast_id='{$cast_data["id"]}'";
	mysqli_query($mysqli,$sql);

}else{
	$sql="INSERT INTO wp01_0cast_config ";
	$sql.="(cast_id, c_sort_main, c_sort_asc, c_sort_group)";
	$sql.="VALUES";
	$sql.="('{$cast_data["id"]}','{$sel}','{$asc}','{$fil}')";
	mysqli_query($mysqli,$sql);
}

$sql	 ="SELECT *{$app5} FROM wp01_0customer";
$sql	.=$app4;
$sql	.=" WHERE wp01_0customer.cast_id='{$cast_data["id"]}'";
$sql	.=$app1;
$sql	.=" GROUP BY wp01_0customer.id";
$sql	.=" ORDER BY";
$sql	.=$app2;
$sql	.=$app3;

if($result = mysqli_query($mysqli,$sql)){
	$row = mysqli_fetch_assoc($result);

	$customer[$s]=$row;

	if(!$row["birth_day"] || $row["birth_day"]=="00000000"){
		$customer[$s]["yy"]="----";
		$customer[$s]["mm"]="--";
		$customer[$s]["dd"]="--";
		$customer[$s]["ag"]="--";

	}else{
		$customer[$s]["yy"]=substr($row["birth_day"],0,4);
		$customer[$s]["mm"]=substr($row["birth_day"],4,2);
		$customer[$s]["dd"]=substr($row["birth_day"],6,2);
		$customer[$s]["ag"]= floor(($now_8-$row["birth_day"])/10000);
	}
	$s++;
}



for($n=0;$n<$s;$n++){
	$html.="<div id=\"clist{$customer[$n]["id"]}\" class=\"customer_list\">";
	if($customer[$n]["face"]){
		$html.="<img src=\"./img/cast/{$box_no}/c/{$customer[$n]["face"]}?t_{time()}\" class=\"mail_img\">";
		$html.="<input type=\"hidden\" class=\"customer_hidden_face\" value=\"{$customer[$n]["face"]}\">";
	}else{
		$html.="<img src=\"./img/customer_no_img.jpg?t_{time()}\" class=\"mail_img\">";
	}
		$html.="<div class=\"customer_list_fav\">";

	for($f=1;$f<6;$f++){
		$html.="<span id=\"fav_{$customer[$n]["id"]}_{$f}\" class=\"customer_list_fav_icon";

	if($customer[$n]["fav"]>=$f){
		$html.=" fav_in";
	}
		$html.="\"></span>";
	}
	$html.="</div>";
	$html.="<div class=\"customer_list_name\">{$customer[$n]["name"]} 様</div>";
	$html.="<div class=\"customer_list_nickname\">{$customer[$n]["nickname"]}</div>";
	$html.="<span class=\"mail_al\"></span>";
	$html.="<input type=\"hidden\" class=\"customer_hidden_fav\" value=\"{$customer[$n]["fav"]}\">";
	$html.="<input type=\"hidden\" class=\"customer_hidden_yy\" value=\"{$customer[$n]["yy"]}\">";
	$html.="<input type=\"hidden\" class=\"customer_hidden_mm\" value=\"{$customer[$n]["mm"]}\">";
	$html.="<input type=\"hidden\" class=\"customer_hidden_dd\" value=\"{$customer[$n]["dd"]}\">";
	$html.="<input type=\"hidden\" class=\"customer_hidden_ag\" value=\"{$customer[$n]["ag"]}\">";
	$html.="<input type=\"hidden\" class=\"customer_hidden_group\" value=\"{$customer[$n]["c_group"]}\">";

	$html.="<input type=\"hidden\" class=\"customer_hidden_mail\" value=\"{$customer[$n]["mail"]}\">";
	$html.="<input type=\"hidden\" class=\"customer_hidden_tel\" value=\"{$customer[$n]["tel"]}\">";
	$html.="<input type=\"hidden\" class=\"customer_hidden_twitter\" value=\"{$customer[$n]["twitter"]}\">";
	$html.="<input type=\"hidden\" class=\"customer_hidden_facebook\" value=\"{$customer[$n]["facebook"]}\">";
	$html.="<input type=\"hidden\" class=\"customer_hidden_insta\" value=\"{$customer[$n]["insta"]}\">";
	$html.="<input type=\"hidden\" class=\"customer_hidden_line\" value=\"{$customer[$n]["line"]}\">";
	$html.="<input type=\"hidden\" class=\"customer_hidden_web\" value=\"{$customer[$n]["web"]}\">";
	$html.="</div>";
}

echo $html;
exit();
?>
