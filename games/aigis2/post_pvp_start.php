<?
include_once("./library/session.php");

$nick[1]="やわらかロールケーキ";
$nick[2]="いびつなおにぎり";
$nick[3]="具だくさんサンド";
$nick[4]="ハートフルオムライス";
$nick[5]="わんぱくハンバーグ";

$dat["now"]			=date("Y-m-d H:i:s");
$dat["host"]		=$_POST["host"];
$dat["sort"]		=$_POST["sort"];
$dat["name"]		=$_POST["name"];
$dat["unit"]		=str_replace("s","",$_POST["unit"]);
$dat["face"]		=$dat["sort"]+1;

if(!$dat["name"]){
$dat["name"]=$nick[$dat["face"]];
}

$sql	 ="INSERT INTO pvp_data(`date`, `sort`, `host`, `face`,  `name`, `unit`,  `turn`)";
$sql	.=" VALUES('{$dat["now"]}', '{$dat["sort"]}', '{$dat["host"]}', '{$dat["face"]}', '{$dat["name"]}', '{$dat["unit"]}', '0')";
mysqli_query($mysqli,$sql);
$dat["tmp_auto"]=mysqli_insert_id($mysqli);

$dat["sql"]=$sql;
echo json_encode($dat);

exit();
?>
