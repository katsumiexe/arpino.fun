<?
/*
GpSet
*/

require_once ("./post_inc.php");
require_once ("./inc_code.php");

$cast_id	=$_POST["cast_id"];
$name		=$_POST["item_name"];
$group_id	=$_POST["group_sort"]+1;

$sql	 =" INSERT INTO wp01_0customer_group(`group_id`,`calst_id`,`sort`,`tag`)";
$sql	.=" VALUES('{$group_id}','{$cast_id}','{$group_id}','{$name}')";
$wpdb->query($sql);

$list.="<tr id=\"gp{$group_id}\">";
$list.="<td class=\"log_td_del\"><span class=\"gp_del_in\"></span></td>";
$list.="<td class=\"log_td_order\">{$group_id}</td>";

$list.="<td class=\"log_td_name\">";
$list.="<input id=\"gp_name_{$group_id}\" type=\"text\" value=\"{$name}\" class=\"gp_name\">";
$list.="</td>";
$list.="<td class=\"log_td_handle\"></td>";
$list.="</tr>";

echo $list;
exit();
?>
