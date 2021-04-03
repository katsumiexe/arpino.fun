<?
/*
顧客情報読み込み
*/
$c_id=$_POST["c_id"];
include_once('../library/sql_post.php');
$sql	 ="SELECT * FROM wp01_0customer_list";
$sql	 .=" WHERE del=0";
$sql	 .=" AND customer_id='{$c_id}'";
if($result = mysqli_query($mysqli,$sql)){
	while($row = mysqli_fetch_assoc($result)){
		$cus[$row["item"]]=$row["comm"];
	}
}


$sql	 ="SELECT * FROM wp01_0customer_item";
$sql	 .=" WHERE `del`=0";
$sql	 .=" AND `gp`=0";

$dat=$sql;
if($result = mysqli_query($mysqli,$sql)){
	while($row = mysqli_fetch_assoc($result)){

	if($row["style"] == 2){
		$s2[$cus[$dat1["id"]]]=" checked=\"checked\"";

		$dat.="<tr><td class=\"customer_memo_tag\">{$dat1["item_name"]}</td>";
		$dat.="<td class=\"customer_memo_item\">";
		$dat.="<input id=\"m_a\" type=\"radio\" name=\"cus{$dat1["id"]}\" value=\"1\" {$s2[1]} class=\"rd\"><label for=\"m_a\" class=\"cousomer_marrige\">既婚</label>";
		$dat.="<input id=\"m_b\" type=\"radio\" name=\"cus{$dat1["id"]}\" value=\"2\" {$s2[2]} class=\"rd\"><label for=\"m_b\" class=\"cousomer_marrige\">未婚</label>";
		$dat.="<input id=\"m_c\" type=\"radio\" name=\"cus{$dat1["id"]}\" value=\"3\" {$s2[3]} class=\"rd\"><label for=\"m_c\" class=\"cousomer_marrige\">離婚</label>";
		$dat.="</td></tr>";

		
	}elseif($dat1["style"] == 3){
		$s3[$cus[$dat1["id"]]]=" checked=\"checked\"";
		$dat.="<tr><td class=\"customer_memo_tag\">{$dat1["item_name"]}</td>";
		$dat.="<td class=\"customer_memo_item\">";
		$dat.="<input id=\"b_a\" type=\"radio\" name=\"cus{$dat1["id"]}\" value=\"1\" {$s3[1]} class=\"rd\"><label for=\"b_a\" class=\"cousomer_blood\">Ａ</label>";
		$dat.="<input id=\"b_b\" type=\"radio\" name=\"cus{$dat1["id"]}\" value=\"2\" {$s3[2]} class=\"rd\"><label for=\"b_b\" class=\"cousomer_blood\">Ｂ</label>";
		$dat.="<input id=\"b_o\" type=\"radio\" name=\"cus{$dat1["id"]}\" value=\"3\" {$s3[3]} class=\"rd\"><label for=\"b_o\" class=\"cousomer_blood\">Ｏ</label>";
		$dat.="<input id=\"b_ab\" type=\"radio\" name=\"cus{$dat1["id"]}\" value=\"4\" {$s3[4]} class=\"rd\"><label for=\"b_ab\" class=\"cousomer_blood\">AB</label>";
		$dat.="</td></tr>";

	}else{
		$dat.="<tr><td class=\"customer_memo_tag\">{$dat1["item_name"]}</td>";
		$dat.="<td class=\"customer_memo_item\"><input type=\"text\" value=\"{$cus[$dat1["id"]]}\" name=\"cus{$dat1["id"]}\" class=\"item_textbox\"></td></tr>";
	}
}

echo $dat;
exit();
?>
