<?
include_once("./library/session.php");
$unit_data[1][0]=2;
$unit_data[1][1]=3;
$unit_data[1][2]=7;
$unit_data[1][3]=8;

$unit_data[2][0]=2;
$unit_data[2][1]=4;
$unit_data[2][2]=7;
$unit_data[2][3]=9;

$unit_data[3][0]=2;
$unit_data[3][1]=5;
$unit_data[3][2]=7;
$unit_data[3][3]=10;

$unit_data[4][0]=2;
$unit_data[4][1]=6;
$unit_data[4][2]=7;
$unit_data[4][3]=11;

$unit_data[5][0]=3;
$unit_data[5][1]=4;
$unit_data[5][2]=8;
$unit_data[5][3]=9;

$unit_data[6][0]=3;
$unit_data[6][1]=5;
$unit_data[6][2]=8;
$unit_data[6][3]=10;

$unit_data[7][0]=3;
$unit_data[7][1]=6;
$unit_data[7][2]=8;
$unit_data[7][3]=11;

$unit_data[8][0]=4;
$unit_data[8][1]=5;
$unit_data[8][2]=9;
$unit_data[8][3]=10;

$unit_data[9][0]=4;
$unit_data[9][1]=6;
$unit_data[9][2]=9;
$unit_data[9][3]=11;

$unit_data[10][0]=5;
$unit_data[10][1]=6;
$unit_data[10][2]=10;
$unit_data[10][3]=11;

$now=date("Y-m-d H:i:s");
$host		=$_POST["host"];
$turn		=$_POST["turn"];
$p=0;

$sql	 ="SELECT unit, code, item, card FROM `pvp_data`";
$sql	.=" WHERE host='{$host}'";
$sql	.=" AND turn='{$turn}'";

$dat0 = mysqli_query($mysqli,$sql);	
while($dat1 = mysqli_fetch_assoc($dat0)){
	if(count($dat1)>=5){

		$dat[$dat1["code"]]=$dat1["item"];
	}
}

if($dat){
	arsort($item);
	$card=$dat1["card"];

	foreach($item as $a1 => $a2){
	    $check[$p]	=$a2;
	    $name[$p]	=$a1;
	    $p++;
	} 

	if($check[0] >$check[1]){
	    $win=$name[0];

	}elseif($check[1] >$check[2] && $check[2] >$check[3]){
	    $win=$name[2];

	}elseif($check[1] == $check[2] && $check[2] >$check[3] && $check[3] >$check[4]){
	    $win=$name[3];

	}elseif($check[1] == $check[2] && $check[2] == $check[3] && $check[3] > $check[4]){
	    $win=$name[4];

	}elseif($check[2] == $check[3] && $check[3] > $check[4]){
	    $win=$name[4];

	}else{
	    $win="l";
	    $pts=0;
	}

	if($unit_data[$unit[$win]][0] == $card || $unit_data[$unit[$win]][1] == $card){
		$pts=3;

	}elseif($unit_data[$unit[$win]][2] == $card || $unit_data[$unit[$win]][3] == $card){
		$pts=(-2);

	}elseif($card==0){
		$pts=3.2;
		$ring=2;

	}elseif($card==1){
		$pts=2.1;
		$ring=1;
		
	}elseif($card<7){
		$pts=1;

	}else{
		$pts=2;
	}

	$dat["pts"]=$pts;
	$dat["win"]=$win;
	
	$sql=" UPDATE pvp_data SET";
	$sql.=" pts='{$pts}'";
	$sql.=" WHERE turn='{$turn}'";
	$sql.=" AND host='{$host}'";
	$sql.=" AND code='{$win}'";
	mysqli_query($mysqli,$sql);

	echo json_encode($dat);
}
exit();
?>
