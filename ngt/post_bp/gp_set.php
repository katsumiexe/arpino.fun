<?
include_once('../library/sql_post.php');
$name		=$_POST["name"];
$group_id	=$_POST["sort"];

$sql	 =" INSERT INTO wp01_0customer_group(`group_id`,`cast_id`,`sort`,`tag`)";
$sql	.=" VALUES('1','{$cast_data["id"]}','{$group_id}','{$name}')";
mysqli_query($mysqli,$sql)

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
