<?
/*
顧客情報読み込み
*/
ini_set('display_errors',1);

require_once ("../../../../wp-load.php");
global $wpdb;

$c_id=$_POST["c_id"];

$sql	 ="SELECT * FROM wp01_0customer_list";
$sql	 .=" WHERE del=0";
$sql	 .=" AND customer_id='{$c_id}'";
$dat0 = $wpdb->get_results($sql,ARRAY_A );

foreach($dat0 AS $dat1){
	$cas[$dat1["item"]]=$dat1["comm"];
}

$sql	 ="SELECT * FROM wp01_0customer_item";
$sql	 .=" WHERE del=0";
$sql	 .=" AND gp=0";
$dat0 = $wpdb->get_results($sql,ARRAY_A );

foreach($dat0 AS $dat1){

	if($dat1["style"] == 2){
		$s2[$cas[$dat1["id"]]]=" checked=\"checked\"";
		$dat.="<tr><td class=\"customer_memo_tag\">{$dat1["item_name"]}</td>";
		$dat.="<td class=\"customer_memo_item\">";
		$dat.="<input id=\"m_a\" type=\"radio\" name=\"cas[{$dat1["id"]}]\" value=\"1\" {$s2[1]} class=\"rd\"><label for=\"m_a\" class=\"cousomer_marrige\">既婚</label>";
		$dat.="<input id=\"m_b\" type=\"radio\" name=\"cas[{$dat1["id"]}]\" value=\"2\" {$s2[2]} class=\"rd\"><label for=\"m_b\" class=\"cousomer_marrige\">未婚</label>";
		$dat.="<input id=\"m_c\" type=\"radio\" name=\"cas[{$dat1["id"]}]\" value=\"3\" {$s2[3]} class=\"rd\"><label for=\"m_c\" class=\"cousomer_marrige\">離婚</label>";
		$dat.="</td></tr>";
		
	}elseif($dat1["style"] == 3){
		$s3[$cas[$dat1["id"]]]=" checked=\"checked\"";
		$dat.="<tr><td class=\"customer_memo_tag\">{$dat1["item_name"]}</td>";
		$dat.="<td class=\"customer_memo_item\">";
		$dat.="<input id=\"b_a\" type=\"radio\" name=\"cas[{$dat1["id"]}]\" value=\"1\" {$s2[1]} class=\"rd\"><label for=\"b_a\" class=\"cousomer_blood\">Ａ</label>";
		$dat.="<input id=\"b_b\" type=\"radio\" name=\"cas[{$dat1["id"]}]\" value=\"2\" {$s2[2]} class=\"rd\"><label for=\"b_b\" class=\"cousomer_blood\">Ｂ</label>";
		$dat.="<input id=\"b_o\" type=\"radio\" name=\"cas[{$dat1["id"]}]\" value=\"3\" {$s2[3]} class=\"rd\"><label for=\"b_o\" class=\"cousomer_blood\">Ｏ</label>";
		$dat.="<input id=\"b_ab\" type=\"radio\" name=\"cas[{$dat1["id"]}]\" value=\"4\" {$s2[4]} class=\"rd\"><label for=\"b_ab\" class=\"cousomer_blood\">AB</label>";
		$dat.="</td></tr>";

	}else{
		$dat.="<tr><td class=\"customer_memo_tag\">{$dat1["item_name"]}</td>";
		$dat.="<td class=\"customer_memo_item\"><input type=\"text\" value=\"{$cas[$dat1["id"]]}\" name=\"cas[{$dat1["id"]}]\" class=\"item_textbox\"></td></tr>";
	}
}

echo $dat;
exit();
?>
