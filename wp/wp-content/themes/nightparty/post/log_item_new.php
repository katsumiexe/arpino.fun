<?
/*
BlogSet
*/

require_once ("./post_inc.php");
require_once ("./inc_code.php");

$cast_id	=$_POST["cast_id"];
$item_name	=$_POST["item_name"];
$item_icon	=$_POST["item_icon"];
$item_color	=$_POST["item_color"];

$price		=$_POST["price"];

$sql ="SELECT MAX(`sort`) AS od FROM wp01_0cast_log_table";
$sql.=" WHERE cast_id='{$cast_id}'";
$res = $wpdb->get_results($sql,ARRAY_A );

foreach($res as $a1){
	$odr=$a1["od"];
}
$odr++;

$sql_log ="INSERT INTO wp01_0cast_log_table(`cast_id`,`item_name`,`item_icon`,`item_color`,`price`,`sort`) VALUES ";
$sql_log.=" ('{$cast_id}','{$item_name}','{$item_icon}','{$item_color}','{$price}','{$odr}')";
$wpdb->query($sql_log);

$dat["sql"]=$sql;
$dat["odr"]=$odr;

$dat["html"]="<tr id=\"i{$odr}\">";
$dat["html"].="<td class=\"log_td_del\"><span class=\"log_td_del_in\"></span></td>";
$dat["html"].="<td class=\"log_td_order\">{$odr}</td>";
$dat["html"].="<td class=\"log_td_color\">";
$dat["html"].="<div class=\"item_color\" style=\"background:{$c_code[$item_color]}\"></div>";
$dat["html"].="<div class=\"color_picker\">";

foreach($c_code as $b1 => $b2){
$dat["html"].="<span cd=\"{$b1}\" class=\"color_picker_list\" style=\"background:{$b2};\"></span>";
}
$dat["html"].="</div>";
$dat["html"].="<input id=\"color_hidden_{$odr}\" class=\"color_hidden\" type=\"hidden\" value=\"{$item_color}\">";
$dat["html"].="</td>";

$dat["html"].="<td class=\"log_td_icon\" style=\"color:{$c_code[$item_color]}\">";
$dat["html"].="<div class=\"item_icon\">{$i_code[$item_icon]}</div>";
$dat["html"].="<div class=\"icon_picker\">";

foreach($i_code as $b1 => $b2){
	$dat["html"].="<span cd=\"{$b1}\" class=\"icon_picker_list\">{$b2}</span>";
}

$dat["html"].="</div>";
$dat["html"].="<input id=\"item_icon_hidden_{$odr}\" type=\"hidden\" value=\"{$item_icon}\">";
$dat["html"].="</td>";
$dat["html"].="<td class=\"log_td_name\"><input id=\"item_name_{$odr}\" type=\"text\" value=\"{$item_name}\" class=\"item_name\"></td>";
$dat["html"].="<td class=\"log_td_price\"><input id=\"item_price_{$odr}\" type=\"text\" value=\"{$price}\" class=\"item_price\"></td>";
$dat["html"].="<td class=\"log_td_handle\"></td></tr>";

echo json_encode($dat);
exit();
?>
