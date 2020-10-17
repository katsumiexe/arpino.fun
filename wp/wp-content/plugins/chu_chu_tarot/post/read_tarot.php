<?
require_once ("../../../../wp-load.php");
global $wpdb;
$tarot_id	=$_POST["tarot_id"];
$n_r		=$_POST["n_r"];
$gp			=$_POST["gp"];
$s=0;

$position[1]="正";
$position[0]="逆";
$rev[0]		="chu_img_rev";

$sql	 ="SELECT * FROM tarot_group";
$sql	 .=" WHERE group_id='{$gp}'";
$sql	 .=" AND del=0";
$group = $wpdb->get_row($sql,ARRAY_A);

$sql	 ="SELECT sort, oracle_name FROM tarot_oracle";
$sql	 .=" WHERE oracle_id='{$gp}'";
$sql0 = $wpdb->get_results($sql,ARRAY_A);
foreach($sql0 as $a1){
	$ttl[$a1["sort"]]=$a1["oracle_name"];
}

$sql	 ="SELECT * FROM tarot_data";
$sql	 .=" WHERE group_id='{$gp}'";
$sql	 .=" AND(";
$sql	 .="(tarot_id='{$tarot_id[0]}' && n_r='{$n_r[0]}' && result='0')";
$sql	 .=" OR (tarot_id='{$tarot_id[1]}' && n_r='{$n_r[1]}' && result='1')";
$sql	 .=" OR (tarot_id='{$tarot_id[2]}' && n_r='{$n_r[2]}' && result='2')";
$sql	 .=" )";

$sql1 = $wpdb->get_results($sql,ARRAY_A);

//echo $sql;

foreach($sql1 as $a1){
	$dat[$a1["result"]]=str_replace("\n","<br>",$a1["tarot_log"]);
}

$sql	 ="SELECT * FROM tarot_base";
$sql	 .=" WHERE id='{$tarot_id[0]}' OR id='{$tarot_id[1]}' OR id='{$tarot_id[2]}'";
$sql2 = $wpdb->get_results($sql,ARRAY_A);

foreach($sql2 as $a2){
	$dat2[$a2["id"]]=$a2;
	if($n_r[$s]==1){
		$dat2[$a2["id"]]["mean"]=$a2["mean_1"];

	}else{
		$dat2[$a2["id"]]["mean"]=$a2["mean_0"];
	}
	$s++;
}


for($n=0;$n<$group["oracle"];$n++){
$html.="<div class=\"chu_ans\"><img id=\"img-{$n}\" src=\"../../../../wp/wp-content/plugins/chu_chu_tarot/img/cardimg_{$tarot_id[$n]}.jpg\" class=\"chu_ans_img {$rev[$n_r[$n]]}\">";
$html.="<div class=\"chu_ans_ttl\"><span id=\"name_j-{$n}\">{$dat2[$tarot_id[$n]]["name_j"]}</span>/<span id=\"name_e-{$n}\">{$dat2[$tarot_id[$n]]["name_e"]}</span></div>";
$html.="<div class=\"chu_ans_msg\"><span id=\"mean-{$n}\">{$dat2[$tarot_id[$n]]["mean"]}</span></div>";
$html.="<div id=\"log-{$n}\" class=\"chu_ans_comm\">{$dat[$n]}</div>";
$html.="<div id=\"rev-{$n}\" class=\"chu_face f$n_r[$n]\">{$position[$n_r[$n]]}</div></div>";
}

echo $html;
exit();
?>
