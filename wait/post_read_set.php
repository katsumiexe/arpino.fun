<?
include_once("./library/session.php");
$t=time();
$card=$_POST["card"];
$sql="SELECT * FROM card_data";
$sql.=" WHERE sort='{$card}'";
$sql.=" LIMIT 1";

$res = mysqli_query($mysqli,$sql);
$row = mysqli_fetch_assoc($res);

$bonus=$row["bonus_1"]+$row["bonus_2"]+$row["bonus_3"]+$row["bonus_4"]+$row["bonus_5"];
if($bonus<0){
$bonus="<span class=\"turn_ptb\">{$bonus}</span>";
}else{
$bonus="+".$bonus;

}


$app="<div class=\"turn_name\">{$row["name"]}</div>";
$app.="<img src=\"./img/card/card_{$row["sort"]}.png?d={$t}\" class=\"turn_img\">";
$app.="<div class=\"turn_comm\">{$row["comm"]}</div>";
if($card<2){
$app.="<div class=\"turn_ptc\">{$row["pts"]}</div>";
}else{
$app.="<div class=\"turn_pta\">+{$row["pts"]}/$bonus</div>";
}
echo $app;
exit();
?>

