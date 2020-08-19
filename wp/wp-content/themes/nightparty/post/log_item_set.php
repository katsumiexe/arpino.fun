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

$item_price	=$_POST["item_price"];
$chglist	=$_POST["chglist"];


for($n=0;$n<count($chglist);$n++){
	$tmp=str_replace("i","",$chglist[$n]);
	$sql=" UPDATE wp01_0cast_log_table SET";

	$sql.=" item_name='{$item_name[$tmp]}',";
	$sql.=" item_icon='{$item_icon[$tmp]}',";
	$sql.=" item_color='{$item_color[$tmp]}',";
	$sql.=" price='{$item_price[$tmp]}'";

	$sql.=" WHERE cast_id='{$cast_id}'";
	$sql.=" AND sort='{$n}'";
	$wpdb->query($sql);
	$n1=$n+1;
	$dat["html"].="<tr id=\"i{$n}\">";
	$dat["html"].="<td class=\"log_td_del\"><span class=\"log_td_del_in\"></span></td>";
	$dat["html"].="<td class=\"log_td_order\">{$n1}</td>";
	$dat["html"].="<td class=\"log_td_color\">";
	$dat["html"].="<div class=\"item_color\" style=\"background:{$c_code[$item_color[$tmp]]}\"></div>";
	$dat["html"].="<div class=\"color_picker\">";

	foreach($c_code as $b1 => $b2){
	$dat["html"].="<span cd=\"{$b1}\" class=\"color_picker_list\" style=\"background:{$b2};\"></span>";
	}
	$dat["html"].="</div>";
	$dat["html"].="<input id=\"item_color_hidden_{$n}\" class=\"color_hidden\" type=\"hidden\" value=\"{$item_color[$tmp]}\">";
	$dat["html"].="</td>";

	$dat["html"].="<td class=\"log_td_icon\" style=\"color:{$c_code[$item_color[$tmp]]}\">";
	$dat["html"].="<div class=\"item_icon\">{$i_code[$item_icon[$tmp]]}</div>";
	$dat["html"].="<div class=\"icon_picker\">";

	foreach($i_code as $b1 => $b2){
		$dat["html"].="<span cd=\"{$b1}\" class=\"icon_picker_list\">{$b2}</span>";
	}

	$dat["html"].="</div>";
	$dat["html"].="<input id=\"item_icon_hidden_{$n}\" type=\"hidden\" value=\"{$item_icon[$tmp]}\">";
	$dat["html"].="</td>";
	$dat["html"].="<td class=\"log_td_name\"><input id=\"item_name_{$n}\" type=\"text\" value=\"{$item_name[$tmp]}\" class=\"item_name\"></td>";
	$dat["html"].="<td class=\"log_td_price\"><input id=\"item_price_{$n}\" type=\"text\" value=\"{$item_price[$tmp]}\" class=\"item_price\"></td>";
	$dat["html"].="<td class=\"log_td_handle\"></td></tr>";
}
echo $dat["html"];
exit();
?>
