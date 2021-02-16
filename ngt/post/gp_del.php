<?
/*
Itemchg
*/

require_once ("./post_inc.php");
require_once ("./inc_code.php");

$cast_id	=$_POST["cast_id"];
$name		=$_POST["name"];
$sort		=$_POST["sort"];

$sql =" UPDATE wp01_0customer_group SET";
$sql.=" del='1'";
$sql.=" WHERE sort='{$sort}'";
$sql.=" AND cast_id='{$cast_id}'";
$wpdb->query($sql);
$n=0:

$sql =" SELECT sort tag FROM wp01_0customer_group";
$sql.=" WHERE del='0'";
$sql.=" AND cast_id='{$cast_id}'";
$sql.=" ORDER BY sort ASC";
$res = $wpdb->get_results($sql,ARRAY_A );

foreach($res as $row){
	$sql =" UPDATE wp01_0customer_group SET";
	$sql.=" sort='{$n}'";
	$sql.=" WHERE id='{$row[$id]}'";
	$wpdb->query($sql);

	$html.="<tr id=\"gp{$n}\">";
	$html.="<td class=\"log_td_del\"><span class=\"gp_del_in\"></span></td>";
	$html.="<td class=\"log_td_order\">{$n}</td>";
	$html.="<td class=\"log_td_name\">";
	$html.="<input id=\"gp_name_{$n}\" type=\"text\" value=\"{$row["name"]}\" class=\"gp_name\">";
	$html.="</td>";
	$html.="<td class=\"log_td_handle\"></td>";
	$html.="</tr>";
	$n++;
}
echo $html;
exit();
?>

