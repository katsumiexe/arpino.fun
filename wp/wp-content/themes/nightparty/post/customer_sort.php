<?
/*
BlogSet
*/

require_once ("./post_inc.php");
$cast_id	=$_POST["cast_id"];
$sel		=$_POST["sel"]+0;
$fil		=$_POST["fil"];
$asc		=$_POST["asc"];
$ext		=$_POST["ext"];


if($fil>0){
$app=" AND c_group={$fil}";
}
if($sel==1){
	$tmp="`date`, `stime`, `etime`";

}elseif($sel==2){
	$tmp="fav";

}elseif($sel==3){
	$tmp="name";

}elseif($sel==4){
	$tmp="nickname";

}elseif($sel==5){
	$tmp="birth_day";

}else{
	$tmp="id";
}

if($asc ==0){
	$order="DESC";
	$select="MAX(`date`)";
}else{
	$order="ASC";
	$select="MIN(`date`)";
}

if($ext){
	$sql="UPDATE wp01_config SET";
	$sql.=" c_sort_main='{$sel}',";
	$sql.=" c_sort_asc='{$asc}',";
	$sql.=" c_sort_group='{$fil}'";
	$sql.=" WHERE cast_id='{$cast_id}'";
	$wpdb->query($sql);
}else{
	$sql="INSERT INTO wp01_config ";
	$sql.="(cast_id, c_sort_main, c_sort_asc, c_sort_group)";
	$sql.="VALUES";
	$sql.="('{$cast_id}','{$sel}','{$asc}','{$fil}'";
	$wpdb->query($sql);
}

$sql	 ="SELECT *,{$select} FROM wp01_0customer";
$sql	.=" LEFT JOIN wp01_0cast_log USING(cast_id)";
$sql	.=" WHERE cast_id='{$cast_id}'";
$sql	.=" AND wp01_0customer.del='0'";
$sql	.=$app;
$sql	.=" GROUP BY wp01_0customer.id";
$sql	.=" ORDER BY {$tmp} {$order}";

$dat = $wpdb->get_results($sql,ARRAY_A );

$s=0;
foreach($dat as $tmp){
	$customer[$s]=$tmp;

	if(!$tmp["birth_day"] || $tmp["birth_day"]=="0000-00-00"){
		$customer[$s]["yy"]="----";
		$customer[$s]["mm"]="--";
		$customer[$s]["dd"]="--";
		$customer[$s]["ag"]="--";

	}else{
		$customer[$s]["yy"]=substr($tmp["birth_day"],0,4);
		$customer[$s]["mm"]=substr($tmp["birth_day"],5,2);
		$customer[$s]["dd"]=substr($tmp["birth_day"],8,2);
		$customer[$s]["ag"]= floor(($now_ymd-str_replace("-", "", $tmp["birth_day"]))/10000);
	}
	$s++;
}

for($n=0;$n<$s;$n++){
	$html.="<div id=\"clist{$customer[$n]["id"]}\" class=\"customer_list\">";

if($customer[$n]["face"]){
	$html.="<img src=\"{get_template_directory_uri()}/img/cast/{$box_no}/c/{$customer[$n]["face"]}?t_{time()}\" class=\"mail_img\">";
	$html.="<input type=\"hidden\" class=\"customer_hidden_face\" value=\"{$customer[$n]["face"]}\">";
}else{
	$html.="<img src=\"{get_template_directory_uri()}/img/customer_no_img.jpg?t_{time()}\" class=\"mail_img\">";
}
	$html.="<div class=\"customer_list_fav\">";

for($s=1;$s<6;$s++){
	$html.="<span id=\"fav_{$customer[$n]["id"]}_{$s}\" class=\"customer_list_fav_icon";

if($customer[$n]["fav"]>=$s){
	$html.="fav_in";
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