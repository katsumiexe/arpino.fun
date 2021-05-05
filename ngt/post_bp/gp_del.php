<?
include_once('../library/sql_post.php');
$name		=$_POST["name"];
$sort		=$_POST["sort"];

$sql =" UPDATE wp01_0customer_group SET";
$sql.=" del='1'";
$sql.=" WHERE sort='{$sort}'";
$sql.=" AND cast_id='{$cast_data["id"]}'";
mysqli_query($mysqli,$sql)

$n=0:
$sql =" SELECT sort tag FROM wp01_0customer_group";
$sql.=" WHERE del='0'";
$sql.=" AND cast_id='{$cast_data["id"]}'";
$sql.=" ORDER BY sort ASC";
if($result = mysqli_query($mysqli,$sql)){
	while($row = mysqli_fetch_assoc($result)){

	$sql =" UPDATE wp01_0customer_group SET";
	$sql.=" sort='{$n}'";
	$sql.=" WHERE id='{$row[$id]}'";
	mysqli_query($mysqli,$sql)

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
